# Unified PCB Design Brief
## Bus4x4 Seatbelt Monitoring System - Main Controller + Display Integration

**Project:** Bus4x4 V48 Seatbelt Monitoring System
**Date:** 2025-10-15
**Manufacturer:** JLCPCB (PCB fabrication + assembly)
**Assembly Level:** Full PCBA (customer will connect LCD separately)

---

## 1. Executive Summary

Design a unified PCB that combines the current **Main Controller** (RP2350 running main.c) and **Display Controller** (ESP32 running DisplayV9.ino) into a single board. The PCB will be manufactured and assembled by JLCPCB, then shipped for final LCD connection.

**Current System:**
- 2 separate PCBs (Main Controller + Display) in one enclosure
- UART cable connecting them
- External LCD panel connection

**Target Design:**
- Single unified PCB with both controllers
- UART connection via PCB traces (eliminates cable)
- Direct LCD connector for Winstar WF50FSWAGDNN0
- JLCPCB-compatible components and assembly

---

## 2. LCD Display Specifications

**Selected Display:** Winstar WF50FSWAGDNN0

| Specification | Value |
|--------------|-------|
| **Size** | 5.0 inch diagonal |
| **Resolution** | 800 × 480 pixels |
| **Display Type** | IPS TFT LCD (wide viewing angle) |
| **Interface** | RGB 24-bit parallel interface |
| **Driver IC** | ST7262 |
| **Brightness** | 1000 nits (outdoor sunlight readable) |
| **Contrast Ratio** | 1000:1 (typical) |
| **Viewing Angle** | 80° (L/R/U/D) |
| **Operating Temp** | -30°C to +80°C |
| **Storage Temp** | -30°C to +80°C |
| **Built-in Touch** | **NO** (requires separate touch panel) |
| **Control Board** | None (raw LCD module) |

**CRITICAL NOTE:**
This display does NOT include a touch panel. Current system uses GT911 capacitive touch controller. Options:
1. **Add capacitive touch overlay** (recommended) - Source compatible 5" capacitive touch panel
2. **Add resistive touch overlay** - Lower cost, less accurate
3. **Operate without touch** - Modify firmware to remove touch functionality

---

## 3. System Architecture

### 3.1 Current System (2 PCBs)
```
[Transmitter PCBs (×7)]
         ↓ RS485 bus
[Main Controller PCB - RP2350]
         ↓ UART cable (GPIO4/5)
[Display PCB - ESP32]
         ↓ 40-pin cable
[LCD Panel - 800×480]
```

### 3.2 Unified Design (1 PCB)
```
[Transmitter PCBs (×7)]
         ↓ RS485 bus
┌────────────────────────────────────────────┐
│  [Unified PCB]                             │
│  ┌──────────────┐   UART   ┌────────────┐ │
│  │   RP2350     │─────────→│   ESP32    │ │
│  │ Main Control │  traces  │  Display   │ │
│  └──────────────┘          └────────────┘ │
│        ↑                         ↓         │
│    RS485, Door,              LCD Connector │
│    Buzzer, Power                           │
└────────────────────────────────────────────┘
         ↓ 40-pin connector
[LCD Panel - Winstar WF50FSWAGDNN0]
```

### 3.3 Data Flow
```
Seat/Belt Sensors
    ↓
Transmitter.c (RP2350 × 7 units)
    ↓ RS485 @ 9600 baud (TDMA protocol)
Main.c (RP2350 on unified PCB)
    ↓ UART @ 115200 baud (binary protocol)
DisplayV9.ino (ESP32 on unified PCB)
    ↓ 24-bit RGB parallel + control signals
LCD Display (Winstar WF50FSWAGDNN0)
```

---

## 4. Hardware Requirements

### 4.1 Primary Components

| Component | Specification | Notes |
|-----------|--------------|-------|
| **Main MCU** | RP2350A or RP2350B | Use **Raspberry Pi Pico 2** module for easier design |
| **Display MCU** | ESP32-S3-WROOM-1-N8R8 | 8MB Flash + 8MB PSRAM (required for LVGL) |
| **RS485 Transceiver** | MAX485, SN65HVD72, or equivalent | Auto-direction preferred |
| **Power Supply** | 12V/24V to 5V buck converter | ≥3A output (total system draw ~2A) |
| **3.3V Regulators** | LM1117-3.3 or AMS1117-3.3 | Separate for RP2350 and ESP32 |
| **LCD Connector** | 40-pin FPC/FFC connector (0.5mm pitch) | Match WF50FSWAGDNN0 connector |
| **Touch Connector** | 6-pin FPC connector (if adding touch) | For GT911 or compatible |

### 4.2 Peripheral Components

| Peripheral | Specification | Connection |
|-----------|--------------|-----------|
| **Door Sensor Input** | 12V tolerant input with voltage divider | RP2350 GPIO22 |
| **Buzzer Driver** | PWM output (2200Hz, 12V) | RP2350 GPIO28 via MOSFET |
| **RS485 Termination** | 120Ω resistor (optional, switchable) | Across A/B lines |
| **Status LEDs** | Power, RS485 activity, etc. | Optional debug indicators |

---

## 5. JLCPCB Manufacturing Requirements

### 5.1 PCB Specifications

| Parameter | Specification |
|-----------|--------------|
| **Board Size** | ~120mm × 180mm (estimate, adjust for display connector) |
| **Layers** | **4 layers** (recommended for clean power/ground planes) |
| **Thickness** | 1.6mm standard |
| **Copper Weight** | 1oz (35μm) standard, 2oz for power traces |
| **Surface Finish** | ENIG (gold) preferred for connector reliability |
| **Solder Mask** | Green standard (or black for professional look) |
| **Silkscreen** | White standard |
| **Min Trace/Space** | 6mil/6mil (standard JLCPCB capability) |

### 5.2 Component Selection Guidelines

**CRITICAL:** Use only JLCPCB-stocked components to minimize cost and lead time.

1. **Search components on JLCPCB parts library** before finalizing design
2. **Prefer "Basic Parts"** (free assembly, no extended fees)
3. **Use "Extended Parts"** when necessary (small fee per part type)
4. **Avoid non-stocked parts** (requires sourcing, high fees, delays)

**Recommended Component Sources:**
- RP2350: Use **Raspberry Pi Pico 2 module** (may need to source separately and hand-solder)
- ESP32-S3: **ESP32-S3-WROOM-1-N8R8** (check JLCPCB stock)
- Passives: Prefer 0603 or 0805 size (easier assembly, lower cost)
- Connectors: Verify JLCPCB has exact part numbers

### 5.3 Design for Assembly (DFA)

- **Top side assembly only** (if possible) - reduces cost
- **Avoid components on bottom** unless necessary
- **Minimum component spacing:** 0.5mm (JLCPCB standard)
- **Fiducial marks:** Add 3× fiducials (2mm circles) for automated assembly
- **Tooling holes:** Add 4× mounting holes (3mm diameter) for assembly fixtures
- **Component orientation:** Maintain consistent orientation for polarized parts

---

## 6. Pinout Mappings

### 6.1 RP2350 (Main Controller) Pinout

#### UART0 - RS485 Communication
| GPIO | Function | Connection |
|------|----------|------------|
| GPIO0 | UART0 TX | RS485 transceiver DI (Data In) |
| GPIO1 | UART0 RX | RS485 transceiver RO (Receiver Out) |
| GPIO2 | RS485 Control | RS485 transceiver DE/RE (Direction control) |

#### UART1 - Display Communication (to ESP32)
| GPIO | Function | Connection |
|------|----------|------------|
| GPIO4 | UART1 TX | ESP32 GPIO17 (RX) |
| GPIO5 | UART1 RX | ESP32 GPIO18 (TX) |

**Note:** These UART connections are PCB traces (no external cable).

#### Peripherals
| GPIO | Function | Connection |
|------|----------|------------|
| GPIO22 | Door Sensor Input | 12V sensor via voltage divider (pull-up enabled) |
| GPIO28 | Buzzer PWM | PWM output to MOSFET driver (2200Hz) |

#### Power
| Pin | Function |
|-----|----------|
| VSYS | 5V input from buck converter |
| GND | Common ground |
| 3V3_EN | Pull high (enable internal 3.3V regulator) |

### 6.2 ESP32-S3 (Display Controller) Pinout

#### UART Communication (from RP2350)
| GPIO | Function | Connection |
|------|----------|------------|
| GPIO17 | UART RX | RP2350 GPIO4 (TX) via PCB trace |
| GPIO18 | UART TX | RP2350 GPIO5 (RX) via PCB trace |

#### RGB LCD Interface (24-bit parallel)
**Red Channel (5 bits)**
| GPIO | Signal | LCD Pin |
|------|--------|---------|
| GPIO45 | R0 | LCD_R0 |
| GPIO48 | R1 | LCD_R1 |
| GPIO47 | R2 | LCD_R2 |
| GPIO21 | R3 | LCD_R3 |
| GPIO14 | R4 | LCD_R4 |

**Green Channel (6 bits)**
| GPIO | Signal | LCD Pin |
|------|--------|---------|
| GPIO5 | G0 | LCD_G0 |
| GPIO6 | G1 | LCD_G1 |
| GPIO7 | G2 | LCD_G2 |
| GPIO15 | G3 | LCD_G3 |
| GPIO16 | G4 | LCD_G4 |
| GPIO4 | G5 | LCD_G5 |

**Blue Channel (5 bits)**
| GPIO | Signal | LCD Pin |
|------|--------|---------|
| GPIO8 | B0 | LCD_B0 |
| GPIO3 | B1 | LCD_B1 |
| GPIO46 | B2 | LCD_B2 |
| GPIO9 | B3 | LCD_B3 |
| GPIO1 | B4 | LCD_B4 |

**Control Signals**
| GPIO | Signal | LCD Pin | Function |
|------|--------|---------|----------|
| GPIO39 | HSYNC | LCD_HSYNC | Horizontal sync |
| GPIO41 | VSYNC | LCD_VSYNC | Vertical sync |
| GPIO40 | DE | LCD_DE | Data enable |
| GPIO42 | PCLK | LCD_PCLK | Pixel clock (33MHz typical) |
| GPIO2 | BL_PWM | LCD_BL | Backlight PWM control |

#### Touch Controller Interface (I2C - GT911)
**Note:** Touch panel not included with WF50FSWAGDNN0 - requires separate overlay

| GPIO | Signal | Touch Pin | Function |
|------|--------|-----------|----------|
| GPIO10 | I2C_SDA | Touch SDA | I2C data |
| GPIO11 | I2C_SCL | Touch SCL | I2C clock |
| GPIO12 | TOUCH_RST | Touch RESET | Reset signal |
| GPIO13 | TOUCH_INT | Touch INT | Interrupt signal |

#### Power
| Pin | Function |
|-----|----------|
| 5V | 5V input from buck converter |
| GND | Common ground |
| 3V3 | Use dedicated 3.3V regulator (do not share with RP2350) |

---

## 7. Design Considerations

### 7.1 PCB Layout Zones (Top to Bottom)

```
┌──────────────────────────────────────────────┐
│  POWER INPUT ZONE                            │
│  - 12V/24V input connector                   │
│  - 5V buck converter (hot area)              │
│  - Input protection (TVS, fuse)              │
├──────────────────────────────────────────────┤
│  MAIN CONTROLLER ZONE                        │
│  - RP2350 (Pico 2 module)                    │
│  - RS485 transceiver                         │
│  - Door sensor input conditioning            │
│  - Buzzer driver (MOSFET + protection)       │
├──────────────────────────────────────────────┤
│  INTERCONNECT ZONE                           │
│  - UART traces (RP2350 ↔ ESP32)             │
│  - Keep traces short, controlled impedance   │
├──────────────────────────────────────────────┤
│  DISPLAY CONTROLLER ZONE                     │
│  - ESP32-S3 module                           │
│  - PSRAM (if not integrated)                 │
│  - Decoupling capacitors                     │
├──────────────────────────────────────────────┤
│  LCD INTERFACE ZONE                          │
│  - 40-pin FPC connector for LCD              │
│  - Touch controller (GT911 if used)          │
│  - 6-pin FPC connector for touch panel       │
│  - Backlight driver circuit                  │
└──────────────────────────────────────────────┘
```

### 7.2 Critical Layout Guidelines

#### Power Distribution
- **Separate 3.3V regulators** for RP2350 and ESP32 (avoid cross-talk)
- **Star-ground topology** at 5V regulator output
- **Ferrite beads** on 3.3V supplies to isolate noise
- **Bulk capacitors** (100μF+) near power input
- **Decoupling capacitors** (100nF + 10μF) at every IC power pin

#### Grounding Strategy
- **Layer 2:** Solid ground plane (no splits)
- **Layer 3:** Power plane (3.3V, 5V zones)
- **Ground stitching vias:** Every 5mm around high-speed signals
- **Separate analog ground zone** for touch controller (if used)

#### Signal Integrity

**RS485 Bus:**
- Differential pair routing (controlled impedance 120Ω)
- Keep traces short from transceiver to connector
- TVS diodes on A/B lines for ESD protection
- Common-mode choke for EMI filtering

**RGB Display Signals:**
- **Critical:** RGB data + control signals are high-speed (33MHz pixel clock)
- Length-matched traces within each color group (±5mm tolerance)
- Route away from switching power supply
- Controlled impedance 50Ω single-ended
- Ground plane underneath (no voids)
- Series termination resistors (22-33Ω) on data lines

**UART Traces (RP2350 ↔ ESP32):**
- Keep traces < 100mm if possible
- Route on single layer (avoid vias)
- 50Ω controlled impedance
- Ground plane underneath

**Touch I2C:**
- Slow-speed signal (100kHz or 400kHz)
- Keep traces < 50mm
- Pull-up resistors near touch controller (2.2kΩ typical)

#### Thermal Management
- **5V Buck Converter:** Likely needs heatsink or copper pour for thermal relief
  - Target: ≤3A output, ~85% efficiency
  - Input power: ~15W (12V @ 1.25A or 24V @ 0.63A)
  - Dissipation: ~2.5W (heatsink recommended)
- **ESP32-S3:** Can run warm under load (PSRAM + display refresh)
  - Add thermal vias under module
  - Copper pour on top and bottom layers
- **Backlight Driver:** May dissipate 1-2W depending on backlight current
  - Check WF50FSWAGDNN0 backlight specs (likely 6 LEDs in series)

### 7.3 Component Placement Strategy

1. **5V Buck Converter:** Top-left corner (near power input)
2. **RP2350 (Pico 2):** Upper-middle area (near RS485 connector)
3. **ESP32-S3:** Center area (equidistant from RP2350 and LCD connector)
4. **LCD Connector:** Bottom edge (customer will connect LCD here)
5. **RS485 Connector:** Left or top edge (vehicle wiring harness)
6. **Door/Buzzer Connectors:** Left edge (near RP2350)

---

## 8. Bill of Materials (BOM) - JLCPCB Compatible

**Note:** Verify all part numbers in JLCPCB parts library before finalizing.

### 8.1 Main Components

| Ref | Component | Part Number | Qty | Type | Notes |
|-----|-----------|-------------|-----|------|-------|
| U1 | RP2350 | Raspberry Pi Pico 2 | 1 | Module | May need separate sourcing |
| U2 | ESP32-S3 | ESP32-S3-WROOM-1-N8R8 | 1 | Module | Verify JLCPCB stock |
| U3 | RS485 Transceiver | MAX485ESA+ | 1 | IC | SOIC-8 package |
| U4 | 5V Buck Converter | MP2315S or similar | 1 | IC | ≥3A output |
| U5 | 3.3V LDO (RP2350) | AMS1117-3.3 | 1 | IC | SOT-223 |
| U6 | 3.3V LDO (ESP32) | AMS1117-3.3 | 1 | IC | SOT-223 |
| U7 | Touch Controller | GT911 | 1 | IC | **Optional** if touch not used |

### 8.2 Power Components

| Ref | Component | Value | Qty | Package | Notes |
|-----|-----------|-------|-----|---------|-------|
| C1-C4 | Bulk Capacitor | 100μF, 25V | 4 | 1210 | Ceramic or tantalum |
| C5-C20 | Decoupling Cap | 100nF, 50V | 16 | 0603 | X7R ceramic |
| C21-C24 | Decoupling Cap | 10μF, 16V | 4 | 0805 | X7R ceramic |
| L1 | Ferrite Bead | 600Ω @ 100MHz | 1 | 0805 | Power supply filter |
| L2, L3 | Ferrite Bead | 600Ω @ 100MHz | 2 | 0603 | 3.3V supply isolation |

### 8.3 Protection & Interface

| Ref | Component | Value | Qty | Package | Notes |
|-----|-----------|-------|-----|---------|-------|
| D1 | TVS Diode | SMBJ15A | 1 | SMB | 12V input protection |
| D2, D3 | TVS Diode Array | SP3012 | 2 | SOT-23-6 | RS485 A/B protection |
| R1, R2 | Voltage Divider | 10kΩ | 2 | 0603 | Door sensor input |
| R3 | RS485 Termination | 120Ω | 1 | 0603 | Switchable via jumper |
| Q1 | N-Channel MOSFET | 2N7002 | 1 | SOT-23 | Buzzer driver |

### 8.4 Connectors

| Ref | Component | Specification | Qty | Notes |
|-----|-----------|--------------|-----|-------|
| J1 | Power Input | Screw terminal 2-pin | 1 | 12V/24V input |
| J2 | RS485 | Screw terminal 3-pin | 1 | A, B, GND |
| J3 | Door Sensor | JST-XH 2-pin | 1 | 12V sensor input |
| J4 | Buzzer Output | JST-XH 2-pin | 1 | 12V buzzer |
| J5 | LCD Connector | 40-pin FPC 0.5mm pitch | 1 | Match WF50FSWAGDNN0 |
| J6 | Touch Connector | 6-pin FPC 0.5mm pitch | 1 | **Optional** |

### 8.5 Miscellaneous

| Ref | Component | Specification | Qty | Notes |
|-----|-----------|--------------|-----|-------|
| SW1 | Reset Button (RP2350) | Tactile 6×6mm | 1 | Optional |
| SW2 | Reset Button (ESP32) | Tactile 6×6mm | 1 | Optional |
| SW3 | Boot Button (ESP32) | Tactile 6×6mm | 1 | For firmware updates |
| LED1 | Power LED | Green 0603 | 1 | Optional |
| LED2 | Status LED | Red 0603 | 1 | Optional |

---

## 9. Design Deliverables

### 9.1 Required Files from Engineer

**For JLCPCB Submission:**

1. **Gerber Files** (RS-274X format)
   - All layers: Top/Bottom copper, silkscreen, soldermask, edge cuts
   - Drill files (Excellon format)

2. **Bill of Materials (BOM)** - CSV format
   - Columns: Designator, Comment, Footprint, LCSC Part Number
   - Match JLCPCB template exactly

3. **Pick-and-Place File (CPL)** - CSV format
   - Columns: Designator, Mid X, Mid Y, Layer, Rotation
   - Use JLCPCB coordinate system (origin at bottom-left)

4. **Assembly Drawing** - PDF
   - Top view with component designators
   - Critical component orientations marked

5. **Schematic** - PDF
   - Full schematic with all connections
   - For reference and debugging

### 9.2 Documentation Required

1. **Design Review Document**
   - Component selection justification
   - JLCPCB stock status for all components
   - Any deviations from this brief

2. **Testing Procedure**
   - Power-on sequence
   - Initial bring-up tests
   - Signal verification points

3. **Assembly Notes**
   - Customer assembly steps (LCD connection)
   - Touch panel installation (if applicable)
   - Firmware upload procedure

### 9.3 Optional (Recommended)

- **3D STEP file** - For mechanical fit verification
- **Source CAD files** - KiCad, Altium, EAGLE (for future modifications)
- **Simulation results** - Power integrity, signal integrity analysis

---

## 10. Manufacturing & Assembly Process

### 10.1 JLCPCB Ordering Process

1. **Upload Gerbers** → JLCPCB website
2. **Select PCB Options:**
   - 4-layer board
   - 1.6mm thickness
   - ENIG surface finish
   - Confirm price/lead time
3. **Enable Assembly Service:**
   - Select "SMT Assembly"
   - Upload BOM + CPL files
   - Review component placement
4. **Review & Confirm:**
   - Check DFM analysis
   - Confirm component substitutions (if any)
   - Approve assembly drawing
5. **Place Order**
   - Typical lead time: 5-7 days (PCB) + 3-5 days (assembly)
   - Shipping: 5-15 days depending on method

### 10.2 Customer Assembly (Post-Delivery)

**What arrives from JLCPCB:**
- Fully assembled PCB with RP2350 + ESP32 + all SMT components
- Ready for LCD connection

**Customer steps:**
1. **Visual Inspection**
   - Check for shipping damage
   - Verify component placement
   - Look for solder bridges (rare with JLCPCB)

2. **Power Test (NO LCD connected yet)**
   - Connect 12V power supply
   - Measure 5V rail (should be 4.9-5.1V)
   - Measure 3.3V rails (should be 3.25-3.35V)
   - Check for excessive heat

3. **Firmware Upload**
   - RP2350: Upload `main.c` compiled binary via USB
   - ESP32: Upload `DisplayV9.ino` via USB or UART

4. **Connect LCD Display**
   - Align 40-pin FFC cable with connector (check pin 1 orientation)
   - Insert LCD cable into J5
   - Lock connector latch

5. **Connect Touch Panel (if used)**
   - Connect 6-pin touch cable to J6
   - Verify GT911 I2C address (0x5D or 0x14)

6. **Final System Test**
   - Power on with LCD connected
   - Verify display output
   - Test touch functionality (if applicable)
   - Connect to transmitter network

---

## 11. Important Notes & Considerations

### 11.1 Touch Panel CRITICAL DECISION

**The Winstar WF50FSWAGDNN0 does NOT include a touch panel.**

Current firmware (DisplayV9.ino) expects GT911 capacitive touch controller. You have three options:

**Option 1: Add Capacitive Touch Overlay (Recommended)**
- Source a 5" capacitive touch panel (800×480 active area)
- Must include GT911 controller IC
- Connect via 6-pin FPC cable to J6 connector
- **Action Required:** Find compatible touch panel part number

**Option 2: Add Resistive Touch Overlay**
- Lower cost than capacitive
- Less accurate, requires pressure
- Different controller IC (XPT2046 or similar)
- **Requires firmware modifications** to DisplayV9.ino

**Option 3: No Touch (Display Only)**
- Use display for monitoring only (no user input)
- **Requires firmware modifications** to remove touch code
- Simpler design, lower cost

**Recommendation:** Determine touch requirement BEFORE finalizing PCB design. If using capacitive touch, ensure GT911 controller circuit and connector are included on PCB.

### 11.2 Raspberry Pi Pico 2 Module Sourcing

The RP2350A/B chip is relatively new. Options:

1. **Use Pico 2 module** (easier) - Design PCB with castellated pads for Pico 2
2. **Use bare RP2350 chip** (advanced) - Requires proper QSPI flash, crystal, power sequencing
3. **Hand-solder Pico 2** - JLCPCB assembles everything else, you solder Pico 2 later

**Recommendation:** Option 1 or 3 - Use Pico 2 module for reliability.

### 11.3 ESP32-S3 PSRAM Requirement

Current DisplayV9.ino code uses PSRAM for LVGL graphics buffer (96KB). **You MUST use ESP32-S3 variant with PSRAM** (e.g., ESP32-S3-WROOM-1-N8R8).

- N8R8 = 8MB Flash + 8MB PSRAM
- Do NOT use ESP32-S3 without PSRAM (will not work)

### 11.4 Backlight Driver Circuit

The WF50FSWAGDNN0 backlight specifications need to be verified from datasheet. Typical requirements:

- Voltage: 12V or 21V (6× LEDs in series)
- Current: 20-100mA (depends on LED configuration)
- Control: PWM dimming via ESP32 GPIO2

**Engineer must design:**
- Current-limiting circuit (constant current driver or resistor)
- PWM-controlled switch (MOSFET or dedicated LED driver IC)
- Protection diode

### 11.5 EMI/EMC Considerations

This system operates in vehicle environment with high EMI:

**Recommended protection:**
- Input TVS diode on 12V power (SMBJ15A or similar)
- Common-mode choke on RS485 lines
- Ferrite beads on all power supply outputs
- RC filters on long cable connections (door sensor, buzzer)

**PCB design:**
- Keep high-speed signals (RGB, PCLK) away from board edges
- Use ground stitching vias around LCD connector
- Add ground pour on top layer (flood fill with thermal relief)

### 11.6 Testing & Bring-Up

**Critical tests before full system integration:**

1. **Power test** (no LCD connected):
   - Verify all voltage rails
   - Check current draw (should be < 500mA idle)

2. **Communication test**:
   - RP2350 ↔ ESP32 UART loopback
   - RS485 transceiver loopback
   - Verify baud rates (9600 RS485, 115200 display)

3. **Display test**:
   - Connect LCD without touch
   - Verify backlight control
   - Check RGB output (test pattern)
   - Verify timing signals (HSYNC, VSYNC, PCLK)

4. **Touch test** (if applicable):
   - I2C scan for GT911 (0x5D or 0x14)
   - Read touch coordinates
   - Verify interrupt signal

5. **Full system test**:
   - Connect to transmitter network
   - Verify RS485 communication
   - Check door sensor input
   - Test buzzer output

---

## 12. Cost Estimation

**JLCPCB Pricing (Estimated):**

| Item | Quantity | Unit Cost | Total |
|------|----------|-----------|-------|
| PCB Fabrication (4-layer) | 5 pcs | $15 | $75 |
| SMT Assembly | 5 pcs | $20 | $100 |
| Component Cost | - | - | $80-120 |
| Shipping (DHL Express) | 1 | $40 | $40 |
| **Total** | - | - | **$295-335** |

**Notes:**
- Price for 5 assembled boards (JLCPCB minimum)
- "Extended Parts" add ~$3 per unique part type
- Non-stocked parts add significant cost and delay
- Raspberry Pi Pico 2 may need separate sourcing

**Additional Costs (Customer):**
- Winstar WF50FSWAGDNN0 display: $40-60 (MOQ 1)
- Capacitive touch panel (if used): $20-40 (MOQ 1)
- FFC cables (40-pin + 6-pin): $5-10
- Enclosure: $20-50 (depends on material/IP rating)

---

## 13. Timeline Estimate

| Phase | Duration | Notes |
|-------|----------|-------|
| **Schematic Design** | 3-5 days | Component selection, verification |
| **PCB Layout** | 5-7 days | 4-layer routing, DFM checks |
| **BOM/CPL Preparation** | 1-2 days | JLCPCB format, part verification |
| **Design Review** | 1-2 days | Client approval |
| **JLCPCB Manufacturing** | 5-7 days | PCB + assembly |
| **Shipping** | 5-15 days | Depends on shipping method |
| **Customer Assembly** | 1 day | LCD connection, firmware upload |
| **Testing & Debug** | 2-3 days | System integration, troubleshooting |
| **Total** | **23-41 days** | ~3-6 weeks from start to working unit |

---

## 14. Success Criteria

The design will be considered successful when:

- [ ] PCB fits within enclosure constraints
- [ ] All JLCPCB assembly checks pass (DFM, component availability)
- [ ] Power consumption ≤ 2A @ 5V under full load
- [ ] RP2350 ↔ ESP32 UART communication verified at 115200 baud
- [ ] RS485 communication with transmitter network functional
- [ ] LCD displays correctly at 800×480 resolution
- [ ] Touch input functional (if implemented)
- [ ] Buzzer output drives 12V buzzer at 2200Hz
- [ ] Door sensor input reads correctly
- [ ] No thermal issues (all components < 70°C ambient + 30°C rise)
- [ ] EMI/EMC performance acceptable (no interference with vehicle systems)

---

## 15. Contact & Support

**Project Lead:** [Your Name]
**Firmware Repository:** C:\AITSC\Bus4x4\V48
**Version:** V48 (current), targeting V49 (unified PCB)

**Key Files:**
- Main Controller: `main.c` (RP2350)
- Display Controller: `DisplayV9/DisplayV9.ino` (ESP32)
- Hardware Spec: `hardware-specification.md`
- Schematics: `receiver_buzzer.PDF`, `Transmitter_buzzer.pdf`

**Questions?**
- Component selection clarifications
- JLCPCB part availability issues
- Firmware compatibility concerns
- Mechanical constraints

Please reach out before making major design decisions.

---

**END OF DOCUMENT**

*Generated: 2025-10-15*
*Target: JLCPCB Manufacturing*
*Status: Ready for Engineering*
