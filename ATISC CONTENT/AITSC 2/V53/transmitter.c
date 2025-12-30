#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include "pico/stdlib.h"
#include "hardware/uart.h"
#include "hardware/gpio.h"
#include "hardware/pwm.h"

// OPTIMIZATION: Use hardware RNG for better collision avoidance
// RP2040 has ROSC (Ring Oscillator) that can generate random bits
static inline uint32_t get_random_delay_ms() {
    // Use lower bits of system timer + gpio states for pseudo-randomness
    // This is fast and good enough for anti-collision timing
    uint32_t random = get_absolute_time() & 0xFF;
    return 10 + (random % 30);  // Returns 10-39ms delay
}

// Configuration
#define IS_TRANSMITTER true
#define UART_ID uart0
#define BAUD_RATE 9600
#define TX_PIN 0
#define RX_PIN 1
#define CTRL_PIN 2
#define BUZZER_PIN 8
#define TRANSMITTER_ID 1

// Seat and belt pins
const uint belt_pins[] = {13, 22, 20, 16};
const uint seat_pins[] = {12, 21, 19, 17};
const uint status_pins[] = {14, 23, 24, 18};
const uint T_pins[] = {10, 9, 7, 3, 4, 5, 6};
#define NUM_SEATS 4

// Protocol sync pattern for collision-resistant frame synchronization
#define SYNC_BYTE_1 0xF0
#define SYNC_BYTE_2 0xF1

// Global variables
bool door_status = false;
bool door_was_open = true;              // Track door state changes
uint32_t door_close_time = 0;           // Time when door was closed
bool buzzer_enabled = true;             // Buzzer control state (default ON, synced from receiver)
uint pwm_slice_num;
uint pwm_channel;
void pwm_set_freq(int freq) {
    uint32_t clock = 125000000; // 125MHz
    uint32_t divider16 = clock / (freq * 4096) + (clock % (freq * 4096) != 0);
    if (divider16 / 16 == 0)
        divider16 = 16;
    uint32_t wrap = clock * 16 / divider16 / freq - 1;
    pwm_set_clkdiv_int_frac(pwm_slice_num, divider16/16, divider16 & 0xF);
    pwm_set_wrap(pwm_slice_num, wrap);
    pwm_set_chan_level(pwm_slice_num, pwm_channel, wrap / 2); // 50% duty
}
void init_buzzer() {
    gpio_set_function(BUZZER_PIN, GPIO_FUNC_PWM);
    pwm_slice_num = pwm_gpio_to_slice_num(BUZZER_PIN);
    pwm_channel = pwm_gpio_to_channel(BUZZER_PIN);
    
    pwm_set_wrap(pwm_slice_num, 12500); // For 100Hz (125MHz / 100 / 100)
    pwm_set_chan_level(pwm_slice_num, pwm_channel, 6250); // 50% duty
    pwm_set_enabled(pwm_slice_num, false); // Start disabled
}

// Optimal frequency for maximum loudness
// Common peaks: 2000Hz or 4000Hz depending on buzzer model (see datasheet page 3)
// For maximum loudness, this should match the resonant frequency of your specific buzzer
#define BUZZER_OPTIMAL_FREQ 4000  // Start with 4kHz (typical peak for PS series)

void buzzer_on() {
    pwm_set_freq(BUZZER_OPTIMAL_FREQ); // Optimized frequency for maximum loudness
    pwm_set_enabled(pwm_slice_num, true);
}

void buzzer_off() {
    pwm_set_enabled(pwm_slice_num, false);
}

uint8_t read_transmitter_id() {
    // Rotary switch pulls corresponding GPIO pin LOW to indicate ID
    for (uint8_t i = 0; i < sizeof(T_pins)/sizeof(T_pins[0]); i++) {
        if (!gpio_get(T_pins[i])) { // Look for LOW pin
            return i+1;  // Return ID 1-7 based on which pin is LOW
        }
    }
    
    return 0; // Invalid/Default ID when no rotary switch pin is active
}

uint8_t read_status(const uint pins[]) {
    uint8_t status = 0;
    for (int i = 0; i < NUM_SEATS; i++) {
        if (gpio_get(pins[i])) {
            status |= (1 << i);
        }
    }
    return status;
}

uint8_t read_belt_status(const uint pins[]) {
    // Belt logic per specification: 0x0=none buckled, 0x1=A buckled, 0x2=B buckled, etc.
    // Set bits for buckled belts, starting from 0x0 baseline
    uint8_t status = 0x0; // Start with all bits clear (no belts buckled)
    for (int i = 0; i < NUM_SEATS; i++) {
        if (gpio_get(pins[i])) { // If belt is buckled (HIGH due to pull-up)
            status |= (1 << i); // Set the bit for this buckled belt
        }
    }
    return status;
}

void transmit_mode() {
    gpio_put(CTRL_PIN, 1);
    sleep_ms(1);
}

void receive_mode() {
    gpio_put(CTRL_PIN, 0);
    sleep_ms(1);
}

void read_complete_message(char* buffer, size_t buffer_size) {
    uint8_t idx = 0;
    absolute_time_t read_start = get_absolute_time();
    bool message_started = false;
    uint32_t last_char_time = 0;
    
    // Read message with improved timing detection
    while (idx < buffer_size - 1 && absolute_time_diff_us(read_start, get_absolute_time()) / 1000 < 100) {
        if (uart_is_readable(UART_ID)) {
            char c = uart_getc(UART_ID);
            buffer[idx++] = c;
            last_char_time = absolute_time_diff_us(read_start, get_absolute_time()) / 1000;
            message_started = true;
            if (c == '\n') break;
        } else if (message_started) {
            // If we started receiving but no new chars for 5ms, assume message complete
            uint32_t current_time = absolute_time_diff_us(read_start, get_absolute_time()) / 1000;
            if (current_time - last_char_time > 5) {
                break;
            }
        }
        sleep_us(50);  // Yield CPU briefly to reduce power consumption
        tight_loop_contents();
    }
    buffer[idx] = '\0';
    
    // Clear any remaining stale data
    while (uart_is_readable(UART_ID)) {
        uart_getc(UART_ID);
    }
}

void send_sensor_data(uint8_t my_id, const char* request_data) {
    // Parse door status and buzzer enable from request
    unsigned slot_id, door, buzzer_val;
    bool previous_door_status = door_status;

    // Require all 3 parameters (enforces current protocol)
    if (sscanf(request_data, "SLOT:%u:%u:%u", &slot_id, &door, &buzzer_val) == 3) {
        door_status = (door == 1);
        buzzer_enabled = (buzzer_val == 1);  // Update buzzer state from receiver

        // Track door state changes and timing
        uint32_t current_time = to_ms_since_boot(get_absolute_time());

        if (door_status && !door_was_open) {
            // Door just opened
            door_was_open = true;
            door_close_time = 0; // Reset close time
        } else if (!door_status && door_was_open) {
            // Door just closed
            door_was_open = false;
            door_close_time = current_time;
        }
    }
    
    // OPTIMIZATION: Use fast random delay for collision avoidance
    // Simpler and faster than complex sensor state calculation
    sleep_ms(get_random_delay_ms());
    
    // Read current sensor states
    uint8_t seats = read_status(seat_pins);
    uint8_t belts = read_status(belt_pins);
    uint8_t statuses = read_status(status_pins);
    // Filter out inactive seats for buzzer logic (status: 0=active, 1=inactive)
    uint8_t active_seats = ~statuses & 0xF;  // Convert to: 1=active, 0=inactive
    uint8_t unbuckled_seats = (~seats) & belts & active_seats;  // Only count active unbuckled seats
    
    // Control local buzzer with door timing and enable state
    uint32_t current_time = to_ms_since_boot(get_absolute_time());
    bool door_closed_long_enough = !door_status &&
                                   door_close_time > 0 &&
                                   (current_time - door_close_time) > 20000;

    if (unbuckled_seats && door_closed_long_enough && buzzer_enabled) {
        buzzer_on();
    } else {
        buzzer_off();
    }
    
    // Prepare response message with collision-resistant frame synchronization
    uint8_t message[6] = {SYNC_BYTE_1, SYNC_BYTE_2, my_id, seats, belts, statuses};

    // Send response with consistent timing
    transmit_mode();
    sleep_ms(1); // Brief stabilization delay
    
    // Send data byte by byte with small delays for reliability
    for (int i = 0; i < sizeof(message); i++) {
        uart_putc_raw(UART_ID, message[i]);
        if (i < sizeof(message) - 1) {
            sleep_us(100); // 100us between bytes
        }
    }
    uart_tx_wait_blocking(UART_ID);

    sleep_ms(2); // Ensure transmission completes
    receive_mode();
}

void transmitter_loop() {
    receive_mode();
    uint8_t my_id = read_transmitter_id();

    // Version print timer - minimal overhead
    static uint32_t last_version_print = 0;

    while (true) {
        // Print version every 30 seconds
        uint32_t current_time = to_ms_since_boot(get_absolute_time());
        if (current_time - last_version_print >= 30000) {
            printf("Version 112516 - AITSC.au\n");
            last_version_print = current_time;
        }

        if (uart_is_readable(UART_ID)) {
            char data[32] = {0};
            read_complete_message(data, sizeof(data));

            // Check if this is my assigned time slot (NEW PROTOCOL)
            uint8_t slot_id;
            if (sscanf(data, "SLOT:%hhu:", &slot_id) == 1) {
                if (my_id == 0) {
                    // Invalid ID - don't respond to any slot assignments
                } else if (slot_id == my_id) {
                    send_sensor_data(my_id, data);
                }
            }
        }

        sleep_ms(5); // Minimal sleep for responsiveness
    }
}

int main() {
    stdio_uart_init();

    // Initialize UART
    uart_init(UART_ID, BAUD_RATE);
    gpio_set_function(TX_PIN, GPIO_FUNC_UART);
    gpio_set_function(RX_PIN, GPIO_FUNC_UART);
    
    // Initialize control pin
    gpio_init(CTRL_PIN);
    gpio_set_dir(CTRL_PIN, GPIO_OUT);
    
    // Initialize seat/belt/status pins
    for (int i = 0; i < NUM_SEATS; i++) {
        gpio_init(seat_pins[i]);
        gpio_set_dir(seat_pins[i], GPIO_IN);
        gpio_pull_up(seat_pins[i]);
        
        gpio_init(belt_pins[i]);
        gpio_set_dir(belt_pins[i], GPIO_IN);
        gpio_pull_up(belt_pins[i]);
        
        if (i < NUM_SEATS) { // status_pins may have different count
            gpio_init(status_pins[i]);
            gpio_set_dir(status_pins[i], GPIO_IN);
            gpio_pull_up(status_pins[i]);
        }
    }

    for (int i = 0; i < sizeof(T_pins)/sizeof(T_pins[0]); i++) {
        gpio_init(T_pins[i]);
        gpio_set_dir(T_pins[i], GPIO_IN);
        gpio_pull_up(T_pins[i]);  // Enable pull-up (active low)
    }
    
    // Initialize buzzer
    init_buzzer();

    transmitter_loop();

    return 0;
}