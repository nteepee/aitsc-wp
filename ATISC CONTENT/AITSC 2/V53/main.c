#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include "pico/stdlib.h"
#include "hardware/uart.h"
#include "hardware/gpio.h"
#include "hardware/pwm.h"

// Configuration
#define IS_TRANSMITTER false     // Set true for transmitter
#define TRANSMITTER_ID 2         // Unique ID for each transmitter
#define UART_ID uart0
#define UART_DISP_ID uart1
#define BAUD_RATE 9600
#define DISP_BAUD_RATE 115200
#define TX_PIN 0
#define RX_PIN 1
#define CTRL_PIN 2
#define DOOR_PIN 22
#define BUZZER_PIN 28
#define NUM_TRANSMITTERS 7

// TDMA Configuration
#define SLOT_DURATION_MS 150        // Fixed time slot per transmitter
#define CYCLE_PERIOD_MS (NUM_TRANSMITTERS * SLOT_DURATION_MS)  // 1050ms total cycle
#define RESPONSE_WINDOW_MS 100      // Time to listen for response in each slot
#define SLOT_GUARD_TIME_MS 20       // OPTIMIZED: Guard time between slots (increased back to 20ms to reduce CPU tight-loop spinning)
#define TRANSMISSION_TIME_MS 5      // Time for request transmission
#define BUFFER_CLEAR_TIME_MS 5      // Time to clear buffers before listening

// Protocol sync pattern for collision-resistant frame synchronization
#define SYNC_BYTE_1 0xF0
#define SYNC_BYTE_2 0xF1

// Global variables
typedef struct {
    uint8_t seat;
    uint8_t belt;
} Status;

Status previous_status[NUM_TRANSMITTERS + 1];
Status current_status[NUM_TRANSMITTERS + 1];
bool buckled_transmitters[NUM_TRANSMITTERS + 1];
uint8_t error_count[NUM_TRANSMITTERS + 1];  // Track errors per transmitter
uint8_t id_response_count[NUM_TRANSMITTERS + 1]; // Count responses per ID (1-7)
uint8_t belt_without_seat_prev[NUM_TRANSMITTERS + 1]; // Track previous belt-without-seat errors to avoid spam
uint8_t seat_no_status_prev[NUM_TRANSMITTERS + 1];    // Track previous seat-without-status errors
uint8_t belt_no_status_prev[NUM_TRANSMITTERS + 1];    // Track previous belt-without-status errors
uint8_t system_errors = 0;              // System error code (0=no errors, 1=duplicate IDs)
bool door_is_open = false;              // Current door state (read once per cycle)
bool door_was_open = true;              // Track door state changes
uint32_t door_close_time = 0;           // Time when door was closed
// ========== SYSTEM ERROR CODES DOCUMENTATION ==========
// Error codes sent to DisplayV9 for logging in error history
// Error Code 0: No errors (default)
// Error Code 1: Duplicate transmitter IDs detected
// DisplayV9 handles error logging and display via addLogEntry() system
// ========== END ERROR CODES DOCUMENTATION ==========
// Buzzer control states (7 bytes RAM, synced from display)
// Default all enabled (1=enabled, 0=disabled) for transmitters 1-7
// Index 0 is unused, indices 1-7 map to transmitter IDs 1-7
uint8_t buzzer_enabled[NUM_TRANSMITTERS + 1] = {0, 1, 1, 1, 1, 1, 1, 1};

// OPTIMIZATION: Status pin tracking - status pins are static after startup
// Capture status pins during first 15 seconds, then use saved values to reduce processing
// Status pins indicate which seat positions are installed/active (doesn't change during operation)
uint8_t current_statuses[NUM_TRANSMITTERS + 1] = {0};     // Current status pins from transmitters
uint8_t startup_status_pins[NUM_TRANSMITTERS + 1] = {0};  // Saved status pins from startup
bool startup_complete = false;  // Flag indicating startup period has ended

// Unified buzzer state system - two independent sources OR'd together
// buzzer_state_display: From DisplayV9 warning overlays (via BUZ: protocol byte 8)
// buzzer_state_seatbelt: From local seat belt monitoring logic
// Final buzzer state = buzzer_state_display OR buzzer_state_seatbelt (1=ON, 0=OFF)
bool buzzer_state_display = false;   // Default: no display alerts (0=OFF)
bool buzzer_state_seatbelt = false;  // Calculated each cycle from seat belt logic

uint pwm_slice_num;
uint pwm_channel;

// OPTIMIZATION: Pre-computed request strings to avoid snprintf() overhead
// Cache for SLOT requests - [transmitter_id][door_state][buzzer_state]
static char slot_request_cache[NUM_TRANSMITTERS + 1][2][2][32];
static bool slot_request_cache_init = false;

void init_slot_request_cache() {
    for (uint8_t id = 1; id <= NUM_TRANSMITTERS; id++) {
        for (uint8_t door = 0; door <= 1; door++) {
            for (uint8_t buzzer = 0; buzzer <= 1; buzzer++) {
                snprintf(slot_request_cache[id][door][buzzer], 32,
                        "SLOT:%d:%d:%d\r\n", id, door, buzzer);
            }
        }
    }
    slot_request_cache_init = true;
}

// Fast lookup for pre-computed request string
const char* get_slot_request(uint8_t id, bool door_state, bool buzzer_state) {
    if (!slot_request_cache_init) {
        init_slot_request_cache();
    }
    return slot_request_cache[id][door_state ? 1 : 0][buzzer_state ? 1 : 0];
}

void transmit_mode() {
    gpio_put(CTRL_PIN, 1);
    sleep_ms(1);
}

void receive_mode() {
    gpio_put(CTRL_PIN, 0);
    sleep_ms(1);
}

// Helper function to set PWM frequency
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

void buzzer_on() {
    pwm_set_freq(2700); // 2700Hz resonant frequency per MLT-8540H datasheet
    pwm_set_enabled(pwm_slice_num, true);
}

void buzzer_off() {
    pwm_set_enabled(pwm_slice_num, false);
}

bool check_duplicate_ids() {
    bool has_duplicates = false;
    int duplicate_count = 0;

    for (int id = 1; id <= NUM_TRANSMITTERS; id++) {
        if (id_response_count[id] > 1) {
            has_duplicates = true;
            duplicate_count++;
        }
    }

    return has_duplicates;
}

void update_system_errors() {
    // Simplified error system - just report duplicate IDs to console
    // DisplayV9 handles error logging and display via error log system
    bool has_duplicates = check_duplicate_ids();

    if (has_duplicates) {
        system_errors = 1; // Send error code 1 to display for logging
    } else {
        system_errors = 0; // No errors detected
    }
}

// Forward declaration
void update_status(uint8_t transmitter_id, uint8_t seat_byte, uint8_t belt_byte, uint8_t statuses);

uint32_t get_current_time_ms() {
    return to_ms_since_boot(get_absolute_time());
}

void wait_until_time(uint32_t target_time_ms) {
    while (get_current_time_ms() < target_time_ms) {
        sleep_us(100);  // Yield CPU briefly to reduce power consumption
        tight_loop_contents();
    }
}

int read_slot_response(uint8_t expected_id, uint32_t timeout_ms) {
    uint32_t start_time = to_ms_since_boot(get_absolute_time());
    uint8_t buffer[128] = {0}; // Even larger buffer for multiple transmitters
    int index = 0;
    int responses_found = 0;
    bool data_started = false;
    uint32_t last_byte_time = 0;

    // Wait for initial data or timeout - use full buffer capacity
    uint32_t elapsed_time;
    while ((elapsed_time = to_ms_since_boot(get_absolute_time()) - start_time) < timeout_ms && index < 128) {
        if (uart_is_readable(UART_ID)) {
            buffer[index++] = uart_getc(UART_ID);
            last_byte_time = elapsed_time;
            data_started = true;
        } else if (data_started) {
            // If we started receiving data but haven't seen any for 50ms, assume all transmissions complete
            // Extended timeout to accommodate progressive delays up to 40ms plus transmission time
            if (elapsed_time - last_byte_time > 50) {
                break;
            }
        }
        sleep_us(50);  // Yield CPU briefly to reduce power consumption
        tight_loop_contents();
    }

    // Clear any remaining stale data after processing
    while (uart_is_readable(UART_ID)) {
        uart_getc(UART_ID);
    }

    if (index < 6) {
        return 0;
    }

    // Process responses - look for collision-resistant sync pattern and expected ID
    for (int i = 0; i <= index - 6; i++) {
        if (buffer[i] == SYNC_BYTE_1 && buffer[i+1] == SYNC_BYTE_2) {
            uint8_t tid = buffer[i+2];
            if (tid >= 1 && tid <= NUM_TRANSMITTERS && tid == expected_id) {
                uint8_t seats = buffer[i+3];
                uint8_t belts = buffer[i+4];
                uint8_t statuses = buffer[i+5];

                // Count this response for duplicate detection
                id_response_count[tid]++;

                // Process unbuckled logic (only for first response to avoid conflicts)
                if (responses_found == 0) {
                    // Filter out inactive seats for buzzer logic (status: 0=active, 1=inactive)
                    // Only active unbuckled seats should trigger the buzzer
                    uint8_t active_seats = ~statuses & 0xF;  // Convert to: 1=active, 0=inactive
                    uint8_t unbuckled = (~seats) & belts & active_seats;  // Only count active unbuckled seats
                    buckled_transmitters[tid] = (unbuckled != 0);
                    // Update status with first response data
                    update_status(tid, seats, belts, statuses);
                }

                responses_found++;

                // Skip entire 6-byte frame
                i += 5;
                // Continue processing to detect all duplicate responses
            }
        }
    }

    return responses_found;
}




// Binary protocol packet structure (32 bytes fixed)
typedef struct __attribute__((packed)) {
    uint8_t sync1;          // 0xAA
    uint8_t sync2;          // 0x55
    uint8_t row;            // 0-6
    uint8_t door;           // 0=closed, 1=open
    uint8_t errors;         // System error code
    // 4 seats x 4 bytes each = 16 bytes
    struct {
        uint8_t color;      // 0=BLACK, 1=RED, 2=LIGHT_GRAY, 3=ORANGE
        uint8_t occupied;   // 0=occupied, 1=unoccupied
        uint8_t buckled;    // 0=unbuckled, 1=buckled
        uint8_t status;     // 0=active, 1=inactive
    } seats[4];             // A, B, C, H
    uint8_t reserved[11];   // Padding to 32 bytes
} BinaryPacket;

// Color determination based on seat state
uint8_t determine_seat_color(bool occupied, bool buckled, bool status_active) {
    // occupied: 0=occupied, 1=unoccupied (inverted)
    // buckled: 0=unbuckled, 1=buckled (after inversion)
    // status_active: 0=active, 1=inactive (inverted)

    if (occupied == 0) {  // Seat occupied
        if (buckled == 1) {
            return 2;  // LIGHT_GRAY - safe state
        } else {
            return 1;  // RED - warning state
        }
    } else {  // Seat unoccupied
        if (buckled == 1) {
            return 3;  // ORANGE - error state (belt buckled but no seat)
        } else {
            return 0;  // BLACK - empty seat
        }
    }
}

void update_status(uint8_t transmitter_id, uint8_t seat_byte, uint8_t belt_byte, uint8_t statuses) {
    if (transmitter_id > NUM_TRANSMITTERS) {
        return;
    }

    // OPTIMIZATION: Use saved status pins after startup to reduce processing overhead
    // Status pins indicate which seat positions are installed (static after startup)
    // Seat occupancy must ALWAYS use live data (changes constantly during operation)
    uint8_t effective_statuses = startup_complete ? startup_status_pins[transmitter_id] : statuses;

    current_status[transmitter_id].seat = seat_byte;
    current_status[transmitter_id].belt = belt_byte;
    current_statuses[transmitter_id] = statuses;  // Store current status pins for startup capture
    Status previous = previous_status[transmitter_id];

    // Calculate errors for this transmitter
    // Example: Count communication errors, sensor failures, etc.
    uint8_t prev_errors = error_count[transmitter_id];
    error_count[transmitter_id] = 0; // Reset error count

    // Check for communication errors (no response would be handled elsewhere)
    // Check for sensor inconsistencies
    // CORRECTED Protocol (based on buzzer logic analysis):
    // Seat occupancy logic: 0=occupied, 1=unoccupied (inverted logic)
    // Belt buckle logic: 0=buckled, 1=unbuckled (INVERTED - contrary to original comment)
    // We want to detect: belt buckled (0) AND seat unoccupied (1)
    uint8_t seat_bits = seat_byte & 0xF;           // Raw seat bits: 0=occupied, 1=unoccupied (ALWAYS LIVE DATA)
    uint8_t belt_bits = belt_byte & 0xF;           // Raw belt bits: 0=buckled, 1=unbuckled (INVERTED)
    uint8_t buckled_belts = ~belt_bits & 0xF;      // Invert to get: 1=buckled, 0=unbuckled
    uint8_t belt_without_seat = buckled_belts & seat_bits; // Buckled belts in unoccupied seats

    // Single shared message buffer for all error/clear messages (saves 640 bytes)
    static char message_buffer[128];

    // Prepare error detection variables
    // seat_bits uses inverted logic: 0=occupied, 1=unoccupied
    uint8_t occupied_seats = ~seat_bits & 0xF;  // Convert to standard logic: 1=occupied, 0=unoccupied
    // FIXED: Status pins are inverted: 0=active, 1=inactive (opposite of original comment)
    uint8_t inactive_status = effective_statuses & 0xF;   // Status pins: 0=active, 1=inactive (uses saved pins after startup)

    // Calculate all three error types
    uint8_t occupied_no_status = occupied_seats & inactive_status; // Occupied seats with INACTIVE status
    uint8_t belt_no_status = buckled_belts & inactive_status; // Buckled belts with INACTIVE status

    // Save old states before updating
    uint8_t old_belt_without_seat = belt_without_seat_prev[transmitter_id];
    uint8_t old_occupied_no_status = seat_no_status_prev[transmitter_id];
    uint8_t old_belt_no_status = belt_no_status_prev[transmitter_id];

    // Update current states
    belt_without_seat_prev[transmitter_id] = belt_without_seat;
    seat_no_status_prev[transmitter_id] = occupied_no_status;
    belt_no_status_prev[transmitter_id] = belt_no_status;

    // OPTIMIZED: Single loop for all error checking (reduces iterations from 24 to 4)
    int display_row = transmitter_id - 1;  // Convert to 0-based display row once

    // OPTIMIZATION: Pre-compute constant parts of error messages
    // Format: "E:R1SA" = Error, Row 1, Seat A, or "C:R1SA" = Clear, Row 1, Seat A
    // Followed by error type code: 1=belt without seat, 2=seat no status, 3=belt no status
    // Example: "E:R2SB:1" = Error on Row 2 Seat B, type 1 (belt buckled but seat not occupied)
    for (int seat = 0; seat < 4; seat++) {
        uint8_t seat_mask = (1 << seat);
        char seat_letter = 'A' + seat;

        // Check ERROR 1: Belt buckled but seat not occupied
        if ((belt_without_seat & seat_mask) && !(old_belt_without_seat & seat_mask)) {
            // New error detected - compact format saves CPU cycles
            error_count[transmitter_id]++;
            message_buffer[0] = 'E'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '1';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        } else if (!(belt_without_seat & seat_mask) && (old_belt_without_seat & seat_mask)) {
            // Error cleared - compact format
            message_buffer[0] = 'C'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '1';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        }

        // Check ERROR 2: Seat occupied but status pin not activated
        if ((occupied_no_status & seat_mask) && !(old_occupied_no_status & seat_mask)) {
            // New error detected - compact format
            error_count[transmitter_id]++;
            message_buffer[0] = 'E'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '2';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        } else if (!(occupied_no_status & seat_mask) && (old_occupied_no_status & seat_mask)) {
            // Error cleared - compact format
            message_buffer[0] = 'C'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '2';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        }

        // Check ERROR 3: Belt buckled but status pin not activated
        if ((belt_no_status & seat_mask) && !(old_belt_no_status & seat_mask)) {
            // New error detected - compact format
            error_count[transmitter_id]++;
            message_buffer[0] = 'E'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '3';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        } else if (!(belt_no_status & seat_mask) && (old_belt_no_status & seat_mask)) {
            // Error cleared - compact format
            message_buffer[0] = 'C'; message_buffer[1] = ':'; message_buffer[2] = 'R';
            message_buffer[3] = '0' + (display_row + 1); message_buffer[4] = 'S';
            message_buffer[5] = seat_letter; message_buffer[6] = ':'; message_buffer[7] = '3';
            message_buffer[8] = '\n'; message_buffer[9] = '\0';
            uart_puts(UART_DISP_ID, message_buffer);
        }
    }

    // Create binary packet with pre-computed visual states
    BinaryPacket packet = {0};
    packet.sync1 = 0xAA;
    packet.sync2 = 0x55;
    packet.row = transmitter_id - 1;  // Convert to 0-based row index
    packet.door = door_is_open;
    packet.errors = system_errors;

    // Process each seat (A, B, C, H)
    for (int i = 0; i < 4; i++) {
        uint8_t seat_occupied = (seat_byte >> i) & 1;      // 0=occupied, 1=unoccupied (ALWAYS LIVE DATA)
        uint8_t belt_buckled_raw = (belt_byte >> i) & 1;   // Protocol: 0=buckled, 1=unbuckled
        uint8_t belt_buckled = !belt_buckled_raw;          // Invert: 1=buckled, 0=unbuckled
        uint8_t status_pin = (effective_statuses >> i) & 1;          // 0=active, 1=inactive (uses saved pins after startup)

        // Pre-compute visual color
        packet.seats[i].color = determine_seat_color(seat_occupied, belt_buckled, status_pin);
        packet.seats[i].occupied = seat_occupied;
        packet.seats[i].buckled = belt_buckled;
        packet.seats[i].status = status_pin;
    }

    // Send binary packet via UART
    uart_write_blocking(UART_DISP_ID, (uint8_t*)&packet, sizeof(BinaryPacket));

    // Update stored values
    previous_status[transmitter_id] = current_status[transmitter_id];
}

void receiver_loop() {
    receive_mode();

    uint32_t cycle_counter = 0;  // Track cycle number for logging
    static uint32_t last_version_print = 0;  // Track last version print time
    uint32_t loop_start_time = get_current_time_ms();  // OPTIMIZATION: Track loop start for duplicate check timeout

    // Display UART message parser for buzzer control
    static char disp_buf[32];
    static int disp_idx = 0;

    // OPTIMIZATION: Cache UART readable state to reduce I/O overhead
    static uint32_t last_disp_uart_check = 0;
    static bool disp_uart_has_data = false;

    while (true) {
        // Version print every 30 seconds
        uint32_t current_time = get_current_time_ms();
        if (current_time - last_version_print >= 30000) {
            printf("Version 112516 - AITSC.au\n");
            last_version_print = current_time;
        }

        cycle_counter++;

        // Parse buzzer control messages from display
        // OPTIMIZATION: Check UART readable state every 10ms instead of every iteration
        // 10ms provides good responsiveness while reducing I/O overhead
        if (current_time - last_disp_uart_check >= 10) {
            disp_uart_has_data = uart_is_readable(UART_DISP_ID);
            last_disp_uart_check = current_time;
        }

        while (disp_uart_has_data) {
            char c = uart_getc(UART_DISP_ID);
            if (c == '\n') {
                disp_buf[disp_idx] = '\0';
                // Check for buzzer control message format "BUZ:11101110" (8-byte protocol: 7 row states + 1 display buzzer state)
                // disp_idx should be 12 for "\n" termination or 13 for "\r\n" termination
                if (strncmp(disp_buf, "BUZ:", 4) == 0 && disp_idx >= 12 && disp_idx <= 13) {
                    // Parse 7 row states (bytes 0-6)
                    for (int i = 0; i < 7; i++) {
                        buzzer_enabled[i + 1] = (disp_buf[4 + i] == '1');
                    }
                    // Parse 8th byte: display buzzer state (1=ON, 0=OFF)
                    buzzer_state_display = (disp_buf[11] == '1');
                }
                disp_idx = 0;
            } else if (disp_idx < 31) {
                disp_buf[disp_idx++] = c;
            }
            // Update cache for next iteration
            disp_uart_has_data = uart_is_readable(UART_DISP_ID);
        }

        // Read door state once per cycle (inverted logic: sensor 0=open, 1=closed)
        door_is_open = !gpio_get(DOOR_PIN);

        // Normal TDMA operation
        uint32_t cycle_start = get_current_time_ms();
        bool any_unbuckled = false;

        // Reset ID response counter for this polling cycle
        memset(id_response_count, 0, sizeof(id_response_count));

        for (uint8_t tid = 1; tid <= NUM_TRANSMITTERS; tid++) {
                uint32_t slot_start = cycle_start + (tid-1) * SLOT_DURATION_MS;

                // Wait for this transmitter's time slot to begin
                wait_until_time(slot_start);

                uint32_t slot_time = get_current_time_ms();

                // Phase 1: Clear any stale data from previous slots/cycles
                while (uart_is_readable(UART_ID)) {
                    uart_getc(UART_ID);
                }

                // Phase 2: Send slot assignment broadcast (with buzzer state)
                // OPTIMIZATION: Use pre-computed request string instead of snprintf
                const char* request = get_slot_request(tid, door_is_open, buzzer_enabled[tid]);

                transmit_mode();
                uart_puts(UART_ID, request);
                uart_tx_wait_blocking(UART_ID);

                // Phase 3: Switch to receive mode with proper timing
                receive_mode();
                sleep_ms(BUFFER_CLEAR_TIME_MS); // Allow mode switching and buffer settling

                // Phase 4: Listen for response with improved timing
                uint32_t listen_start = get_current_time_ms();
                int responses = read_slot_response(tid, RESPONSE_WINDOW_MS);
                uint32_t listen_duration = get_current_time_ms() - listen_start;

                if (responses == 0) {
                    error_count[tid]++;
                }

                // Phase 5: Guard time before next slot
                uint32_t slot_end = slot_start + SLOT_DURATION_MS;
                uint32_t current_time_local = get_current_time_ms();
                if (current_time_local < slot_end) {
                    uint32_t guard_time = slot_end - current_time_local;
                    if (guard_time > 0) {
                        sleep_ms(guard_time);
                    }
                }
            }

        // Track door state changes and timing
        // Reuse current_time variable from above
        current_time = get_current_time_ms();

        if (door_is_open && !door_was_open) {
            // Door just opened
            door_was_open = true;
            door_close_time = 0; // Reset close time
        } else if (!door_is_open && door_was_open) {
            // Door just closed
            door_was_open = false;
            door_close_time = current_time;
        }

        // Buzzer control
        bool door_closed_long_enough = !door_is_open &&
                                       door_close_time > 0 &&
                                       (current_time - door_close_time) > 20000;

        // Check if ANY enabled transmitter has unbuckled seats (for normal warnings)
        bool any_unbuckled_enabled = false;
        for (int i = 1; i <= NUM_TRANSMITTERS; i++) {
            if (buckled_transmitters[i] && buzzer_enabled[i]) {
                any_unbuckled_enabled = true;
                break;
            }
        }

        // Calculate seat belt buzzer state (unbuckled seats + door closed >5s + buzzer enabled)
        buzzer_state_seatbelt = (any_unbuckled_enabled && door_closed_long_enough);

        // Unified buzzer control - OR both independent sources
        // buzzer_state_display: Set by DisplayV9 warning overlays (via UART)
        // buzzer_state_seatbelt: Set by local seat belt monitoring logic
        bool buzzer_state = buzzer_state_display || buzzer_state_seatbelt;

        if (buzzer_state) {
            buzzer_on();
        } else {
            buzzer_off();
        }

        // OPTIMIZATION: Only check for duplicate IDs during first 15 seconds after startup
        // After startup period, duplicate checking is disabled to save CPU cycles
        if ((current_time - loop_start_time) < 15000) {
            update_system_errors();  // Updates system_errors flag sent to display
        } else if (!startup_complete) {
            // OPTIMIZATION: Startup period just ended - capture status pins snapshot
            // Status pins indicate which seats are installed/active (static), save to reduce processing
            for (int i = 1; i <= NUM_TRANSMITTERS; i++) {
                startup_status_pins[i] = current_statuses[i];
            }
            startup_complete = true;  // Switch to using saved status pins
        }

        sleep_ms(100);
    }
}

int main() {
    stdio_uart_init();

    // Initialize UART
    uart_init(UART_ID, BAUD_RATE);
    gpio_set_function(TX_PIN, GPIO_FUNC_UART);
    gpio_set_function(RX_PIN, GPIO_FUNC_UART);

    // Initialize display UART
    uart_init(UART_DISP_ID, DISP_BAUD_RATE);
    gpio_set_function(4, GPIO_FUNC_UART);
    gpio_set_function(5, GPIO_FUNC_UART);

    // Initialize control pin
    gpio_init(CTRL_PIN);
    gpio_set_dir(CTRL_PIN, GPIO_OUT);

    // Initialize door pin
    gpio_init(DOOR_PIN);
    gpio_set_dir(DOOR_PIN, GPIO_IN);

    // Initialize buzzer
    init_buzzer();

    // OPTIMIZATION: Initialize slot request cache at startup to avoid first-cycle latency
    init_slot_request_cache();

    // Initialize status arrays
    memset(previous_status, 0, sizeof(previous_status));
    memset(current_status, 0, sizeof(current_status));
    memset(buckled_transmitters, 0, sizeof(buckled_transmitters));
    memset(error_count, 0, sizeof(error_count));
    memset(id_response_count, 0, sizeof(id_response_count));
    memset(belt_without_seat_prev, 0x00, sizeof(belt_without_seat_prev)); // Initialize to 0x00 (no errors) to prevent false positives
    memset(seat_no_status_prev, 0x00, sizeof(seat_no_status_prev));       // Initialize to 0x00 (no errors) to prevent false positives
    memset(belt_no_status_prev, 0x00, sizeof(belt_no_status_prev));       // Initialize to 0x00 (no errors) to prevent false positives
    memset(current_statuses, 0, sizeof(current_statuses));                 // Initialize current status pins array
    memset(startup_status_pins, 0, sizeof(startup_status_pins));           // Initialize saved status pins array (will be populated during startup)
    system_errors = 0;

    receiver_loop();

    return 0;
}