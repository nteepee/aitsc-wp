# Bus4x4 Seatbelt Monitoring System - Hardware Specification

## System Overview
A distributed seatbelt monitoring system for 4-seater and 7-seater buses using TDMA communication protocol.

## Hardware Components List

### Main Controller
- **1x Raspberry Pi Pico** (RP2350A microcontroller)
- **1x RS485 transceiver module** (MAX485 or similar)
- **1x Door sensor input** (12V high, 0V grounded switch)
- **1x PWM buzzer** (2200Hz, 12V rated)
- **1x PCB** (custom controller board)
- **1x Enclosure** (IP65 rated)

### Transmitter Units (Quantity: 1-7 units)
- **7x Raspberry Pi Pico** (RP2350A microcontroller)
- **7x RS485 transceiver modules**
- **7x Rotary switches** (7-position for ID selection)
- **28x Seat occupancy sensors** (4 per transmitter)
- **28x Seatbelt buckle sensors** (4 per transmitter)
- **28x Status validation sensors** (4 per transmitter)
- **7x Local PWM buzzers** (2000Hz, 12V rated)
- **7x PCBs** (custom transmitter boards)
- **7x Enclosures** (IP65 rated)

### Display Unit
- **1x ESP32 microcontroller** (dual-core with PSRAM)
- **1x 800×480 TFT LCD display** (RGB parallel interface)
- **1x GT911 capacitive touch controller**
- **1x Display PCB** (custom board with connectors)
- **1x Display enclosure** (IP65 rated with viewing window)

### Communication Network
- **1x RS485 network cable** (twisted pair, shielded)
- **2x 120Ω termination resistors** (bus termination)
- **Multiple automotive connectors** (sealed, weatherproof)
- **Wiring harness** (automotive grade)

### Power System
- **1x DC-DC converter** (12V/24V to 5V, 20W capacity)
- **1x Power distribution board** (fused outputs)
- **Power cables** (automotive grade)

## Main Controller Unit

### Hardware Platform
- **Microcontroller**: Raspberry Pi Pico (RP2350A)
- **Communication**: RS485 transceiver for bus network
- **Control Pin**: GPIO2 for RS485 transmit/receive switching

### Pin Configuration
- **UART0**: Primary communication bus
  - TX Pin: GPIO0
  - RX Pin: GPIO1
  - Baud Rate: 9600
- **UART1**: Display communication
  - TX Pin: GPIO4
  - RX Pin: GPIO5
  - Baud Rate: 115200
- **Door Sensor**: GPIO22 (pull-up enabled)
- **Buzzer Output**: GPIO28 (PWM controlled, 2200Hz)

### Power Requirements
- **Voltage**: 5V DC input
- **Current**: Approximately 200mA during operation

## Transmitter Units (Up to 7 units)

### Hardware Platform
- **Microcontroller**: Raspberry Pi Pico (RP2350A)
- **Communication**: RS485 transceiver (shared bus with main controller)
- **ID Selection**: 7-position rotary switch

### Sensor Inputs (per transmitter)
- **Seat Sensors**: 4 channels (GPIO12, 21, 19, 17)
  - Logic: 0V = occupied, 3.3V = unoccupied
  - Pull-up resistors enabled
- **Belt Sensors**: 4 channels (GPIO13, 22, 20, 16)
  - Logic: 3.3V = buckled, 0V = unbuckled
  - Pull-up resistors enabled
- **Status Sensors**: 4 channels (GPIO14, 23, 24, 18)
  - Additional validation inputs
  - Pull-up resistors enabled

### ID Switch Configuration
- **Switch Pins**: GPIO3, 4, 5, 6, 7, 9, 10 (positions 1-7)
- **Logic**: Active low (selected position pulls pin to ground)
- **Pull-up**: Enabled on all switch pins
- **Default**: ID = 0 when no switch position selected

### Local Buzzer
- **Pin**: GPIO8 (PWM controlled)
- **Frequency**: 2000Hz
- **Control**: Synchronized with main controller

### Power Requirements
- **Voltage**: 5V DC input
- **Current**: Approximately 150mA per unit during operation

## Display Unit (DisplayV9)

### Hardware Platform
- **Microcontroller**: ESP32 (dual-core)
- **Display**: 800×480 pixel TFT LCD with RGB parallel interface
- **Touch**: GT911 capacitive touch controller
- **Memory**: PSRAM for graphics buffering

### Display Interface
- **Type**: RGB parallel TFT
- **Resolution**: 800×480 pixels
- **Color Depth**: 16-bit (65536 colors)
- **Backlight**: PWM controlled LED backlight (GPIO2)

### Pin Configuration
#### RGB Data Lines
- **Red**: GPIO45, 48, 47, 21, 14 (R0-R4)
- **Green**: GPIO5, 6, 7, 15, 16, 4 (G0-G5)
- **Blue**: GPIO8, 3, 46, 9, 1 (B0-B4)

#### Control Signals
- **HSYNC**: GPIO39
- **VSYNC**: GPIO41
- **DE**: GPIO40
- **PCLK**: GPIO42

#### Touch Interface
- **SDA**: Not specified (I2C)
- **SCL**: Not specified (I2C)
- **Reset**: TOUCH_GT911_RST pin
- **Interrupt**: Touch interrupt handling

### Communication
- **Serial Port 2**: GPIO17 (RX), GPIO18 (TX)
- **Baud Rate**: 115200
- **Protocol**: Receives formatted data from main controller

### Memory Specifications
- **Display Buffer**: 96KB LVGL buffer (60 lines × 800 pixels × 2 bytes)
- **Allocation**: Internal SRAM preferred, DMA fallback
- **Graphics Library**: LVGL 8.3.11

### Power Requirements
- **Voltage**: 5V DC input
- **Current**: Approximately 800mA during operation (including display backlight)

## Network Communication

### Physical Layer
- **Standard**: RS485 differential signaling
- **Topology**: Multi-drop bus (1 controller + up to 7 transmitters)
- **Cable**: Twisted pair with ground reference
- **Termination**: 120Ω termination resistors at bus ends

### Protocol
- **Type**: TDMA (Time Division Multiple Access)
- **Slot Duration**: 150ms per transmitter
- **Total Cycle**: 1050ms (7 × 150ms)
- **Baud Rate**: 9600 bits/second
- **Frame Format**: Collision-resistant sync pattern (0xF0 0xF1)

## Power Distribution

### System Power Requirements
- **Main Controller**: 5V @ 200mA
- **Transmitters**: 5V @ 150mA each (up to 7 units = 1050mA max)
- **Display Unit**: 5V @ 800mA
- **Total Maximum**: 5V @ 2050mA (approximately 10W)

### Recommended Power Supply
- **Type**: Switching power supply
- **Input**: 12V or 24V DC (vehicle power)
- **Output**: 5V DC regulated
- **Capacity**: Minimum 15W (recommended 20W for margin)

## Environmental Specifications

### Operating Conditions
- **Temperature**: -20°C to +70°C
- **Humidity**: 10% to 90% non-condensing
- **Vibration**: Automotive grade (suitable for vehicle mounting)
- **Protection**: IP65 rated enclosures recommended

### Installation Requirements
- **Mounting**: Secure mechanical mounting for all units
- **Cabling**: Automotive-grade wiring harnesses
- **Connectors**: Sealed automotive connectors for harsh environments
- **EMI/EMC**: Compliance with automotive electromagnetic standards

## System Scalability

### Configuration Options
- **4-Seater Mode**: Uses transmitters 1-4 only
- **7-Seater Mode**: Uses all transmitters 1-7
- **Dynamic Switching**: Automatic detection based on active transmitters

### Expansion Capability
- **Maximum Transmitters**: 7 units (limited by TDMA cycle timing)
- **Sensors per Transmitter**: 4 seats, 4 belts, 4 status inputs
- **Total Monitoring Capacity**: 28 seats maximum (7 × 4 seats)