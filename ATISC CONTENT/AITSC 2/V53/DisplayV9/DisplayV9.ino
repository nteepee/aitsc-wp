#include <Arduino.h>

// lvgl libraries
#include <lvgl.h>
#include "ui.h"
#include <HardwareSerial.h>
#include <EEPROM.h>

// Color constants to reduce duplication
#define COLOR_DARK_GRAY    0x323232
#define COLOR_LIGHT_GRAY   0xFAFAFA
#define COLOR_RED          0xEC1E45
#define COLOR_WHITE        0xFEFEFE
#define COLOR_BLACK        0x000000
#define COLOR_ORANGE       0xFFA500

// Material Design button constants - Rounded style (Material Design 3)
#define MD_BUTTON_RADIUS_SM    20   // Small buttons: pill-shaped (for 40px height buttons)
#define MD_BUTTON_RADIUS_LG    40   // Large buttons: highly rounded (for 80px height buttons)
#define MD_BUTTON_HEIGHT_SM    40   // Standard button height
#define MD_BUTTON_HEIGHT_LG    80   // Large button height (menu tiles)
#define MD_BUTTON_BORDER_WIDTH 2    // Outlined button border width
#define MD_BUTTON_MIN_WIDTH    64   // Minimum touch target width
#define MD_PRESSED_OPACITY     31   // Pressed state overlay (0.12 * 255 = ~31)

// Material Design typography constants (using Montserrat font family)
#define MD_TEXT_HEADLINE       &lv_font_montserrat_28  // Screen titles (Material Design Headline)
#define MD_TEXT_TITLE_LARGE    &lv_font_montserrat_28  // Section titles
#define MD_TEXT_TITLE_MEDIUM   &lv_font_montserrat_20  // Subsection titles
#define MD_TEXT_BODY_LARGE     &lv_font_montserrat_20  // Main content text
#define MD_TEXT_BODY_MEDIUM    &lv_font_montserrat_18  // Secondary/supporting text
#define MD_TEXT_LABEL_LARGE    &lv_font_montserrat_18  // Button labels and UI elements

// EEPROM Memory Layout Configuration
// Total: 1249 bytes
// 0-6:     Buzzer states (7 bytes)
// 7-8:     Error log metadata (logIndex, logCount) (2 bytes)
// 9-1248:  Error log entries (20 entries × 62 bytes each = 1240 bytes)
#define EEPROM_SIZE 1249
#define BUZZER_EEPROM_ADDR 0
#define ERROR_LOG_METADATA_ADDR 7
#define ERROR_LOG_DATA_ADDR 9
#define ERROR_LOG_ENTRY_SIZE 62  // 60 bytes message + 1 byte acknowledged flag + 1 byte resetCount

HardwareSerial SerialPort(2);

#include <Arduino_GFX_Library.h>
#define TFT_BL 2
#define GFX_BL DF_GFX_BL  // default backlight pin, you may replace DF_GFX_BL to actual backlight pin

/* More dev device declaration: https://github.com/moononournation/Arduino_GFX/wiki/Dev-Device-Declaration */
#if defined(DISPLAY_DEV_KIT)
Arduino_GFX *gfx = create_default_Arduino_GFX();
#else  /* !defined(DISPLAY_DEV_KIT) */

Arduino_ESP32RGBPanel *bus = new Arduino_ESP32RGBPanel(
  GFX_NOT_DEFINED /* CS */, GFX_NOT_DEFINED /* SCK */, GFX_NOT_DEFINED /* SDA */,
  40 /* DE */, 41 /* VSYNC */, 39 /* HSYNC */, 42 /* PCLK */,
  45 /* R0 */, 48 /* R1 */, 47 /* R2 */, 21 /* R3 */, 14 /* R4 */,
  5 /* G0 */, 6 /* G1 */, 7 /* G2 */, 15 /* G3 */, 16 /* G4 */, 4 /* G5 */,
  8 /* B0 */, 3 /* B1 */, 46 /* B2 */, 9 /* B3 */, 1 /* B4 */
);
// option 1:
// ST7262 IPS LCD 800x480
Arduino_RPi_DPI_RGBPanel *gfx = new Arduino_RPi_DPI_RGBPanel(
  bus,
  800 /* width */, 0 /* hsync_polarity */, 8 /* hsync_front_porch */, 4 /* hsync_pulse_width */, 8 /* hsync_back_porch */,
  480 /* height */, 0 /* vsync_polarity */, 8 /* vsync_front_porch */, 4 /* vsync_pulse_width */, 12 /* vsync_back_porch */,
  1 /* pclk_active_neg */, 16000000 /* prefer_speed */, true /* auto_flush */);
#endif /* !defined(DISPLAY_DEV_KIT) */
/*******************************************************************************
 * End of Arduino_GFX setting
 ******************************************************************************/

/*******************************************************************************
 * Please config the touch panel in touch.h
 ******************************************************************************/
#include "touch.h"
#include "bus4x4logo.c"

/* Change to your screen resolution */
static uint32_t screenWidth;
static uint32_t screenHeight;
static lv_disp_draw_buf_t draw_buf;
static lv_color_t *disp_draw_buf;
static lv_disp_drv_t disp_drv;

/* Display flushing */
void my_disp_flush(lv_disp_drv_t *disp, const lv_area_t *area, lv_color_t *color_p) {
  uint32_t w = (area->x2 - area->x1 + 1);
  uint32_t h = (area->y2 - area->y1 + 1);

#if (LV_COLOR_16_SWAP != 0)
  gfx->draw16bitBeRGBBitmap(area->x1, area->y1, (uint16_t *)&color_p->full, w, h);
#else
  gfx->draw16bitRGBBitmap(area->x1, area->y1, (uint16_t *)&color_p->full, w, h);
#endif

  lv_disp_flush_ready(disp);
}

void my_touchpad_read(lv_indev_drv_t *indev_driver, lv_indev_data_t *data) {
  if (touch_has_signal()) {
    if (touch_touched()) {
      data->state = LV_INDEV_STATE_PR;

      /*Set the coordinates*/
      data->point.x = touch_last_x;
      data->point.y = touch_last_y;
    } else if (touch_released()) {
      data->state = LV_INDEV_STATE_REL;
    }
  } else {
    data->state = LV_INDEV_STATE_REL;
  }
}
// Binary protocol packet structure (must match main.c)
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

// Protocol constants
#define DATA_LENGTH 7
#define SEAT_DATA_LENGTH 12
bool dataArray[DATA_LENGTH];
bool seatDataArray[SEAT_DATA_LENGTH];
unsigned long row_timer[7];
int seat_timeout = 10000;
uint8_t processingRow;
// OPTIMIZATION: Dirty flag for timeout checking - only check when timeouts possible
static uint32_t last_timeout_check = 0;

// Inline helper functions for active transmitter detection
// Consolidates repeated logic across multiple functions for efficiency and maintainability
inline bool isRowActive(uint8_t row_index, uint32_t current_time) {
  return (row_timer[row_index] > 0 &&
          (current_time - row_timer[row_index] < seat_timeout));
}

inline bool isRowInactive(uint8_t row_index, uint32_t current_time) {
  return (current_time - row_timer[row_index] >= seat_timeout);
}

uint8_t buckledSeats, unbuckledSeats;
lv_obj_t *ui_seatContainers[7];
lv_obj_t *seat_rows_container[7][4];
lv_obj_t *seat_rows_lebels_container[7][4];
lv_obj_t *seat_columns_container[7][4];

// OPTIMIZATION: Pre-computed seat labels - eliminates character arithmetic in bolck_processing()
static const char* seat_labels[7][4] = {
  {"1A", "1B", "1C", "1D"},
  {"2A", "2B", "2C", "2D"},
  {"3A", "3B", "3C", "3D"},
  {"4A", "4B", "4C", "4D"},
  {"5A", "5B", "5C", "5D"},
  {"6A", "6B", "6C", "6D"},
  {"7A", "7B", "7C", "7D"}
};

// Cached position arrays to eliminate recalculation
// Even spacing: Row 1 to Row 7 = 529px total, 6 gaps = ~88px each
static const lv_coord_t x_positions_7seat[] = {-194, -106, -18, 70, 158, 246, 335};
static const lv_coord_t x_positions_7seat_adjusted[][4] = {
  {-194, -106, -18, 70},    // H row adjustments (even spacing)
  {-283, -194, -18, 70},    // A row adjustments (even spacing)
  {-194, -106, -18, 70},    // B row adjustments (even spacing)
  {-194, -106, -18, 70}     // C row adjustments (even spacing)
};
static const lv_coord_t x_positions_4seat[][4] = {
  {-55, 33, 120, 207},     // H row
  {-146, 32, 119, 206},    // A row
  {-55, 32, 119, 206},     // B row
  {-57, 32, 119, 206}      // C row
};
static const lv_coord_t y_positions_right[] = {114, -27, -97, 43}; // A, B, C, H
static const lv_coord_t y_positions_left[] = {-97, 43, 114, -27};  // A, B, C, H
static const lv_coord_t y_positions_right_h[] = {114, 43, -27, -97}; // A, B, C, H for right when visible
static const lv_coord_t y_positions_left_h[] = {-97, -27, 43, 114};  // A, B, C, H for left when visible

int doorFlag = 0;
bool toggleSide = false;
bool leftActive;
bool rightActive = true;
bool toggleLayout = false;

String errorText = "0";

bool is_seven_seater, is_four_seater;
// Error tracking removed - all handled by main.c

// Forward declarations
void bolck_processing();
void updateSideInfo();
void handleSystemMonitoring();
bool processSerialStream(Stream &stream, char* buffer, uint8_t bufferSize, uint8_t &bufferIndex, bool isMainPort);
void cleanupErrorOverlays();
void duplicateErrorResetButtonCallback(lv_event_t *e);
void duplicateErrorConfirmButtonCallback(lv_event_t *e);  // New: Confirm button callback
void showWarningOverlay();  // New: Show warning overlay for all errors/warnings
void updatePriority2ErrorList();  // Update error list with un-acknowledged errors from error log
void checkForBuzzerOffErrors();  // Check for active rows with disabled buzzers
void detectLayoutOneTime();
void processBinaryData(BinaryPacket *pkt);
void toggleBuzzerState(uint8_t row);

// Error Logging System - Core Data Structures
#define MAX_LOG_ENTRIES 20  // Persistent error history for lifetime of system use
#define LOG_ENTRY_LENGTH 60  // Optimized: reduced from 80 to save memory

struct LogEntry {
  char message[LOG_ENTRY_LENGTH];
  bool acknowledged;
  uint8_t resetCount;  // Track acknowledgment resets per session (max 1)
};

// Global log buffer and management variables
LogEntry errorLog[MAX_LOG_ENTRIES];
uint8_t logIndex = 0;
uint8_t logCount = 0;

// Warning overlay (used for all errors/warnings, not just duplicate errors)
lv_obj_t *ui_DuplicateErrorOverlay = NULL;
lv_obj_t *ui_DuplicateErrorLabel = NULL;
lv_obj_t *ui_DuplicateErrorConfirmButton = NULL;  // New: Confirm button to dismiss overlay
lv_obj_t *ui_DuplicateErrorConfirmLabel = NULL;   // New: Label for confirm button
lv_obj_t *ui_DuplicateErrorResetButton = NULL;
lv_obj_t *ui_DuplicateErrorResetLabel = NULL;
lv_obj_t *ui_ErrorLogLinkLabel = NULL;            // Clickable link to error log (Priority 2 only)
lv_obj_t *ui_ErrorListLabel = NULL;               // Error list display (Priority 2 only)

// Global flag for UI reset requests
bool uiResetRequested = false;
bool duplicateErrorActive = false;
uint8_t duplicateErrorRow = 0;
uint32_t duplicateErrorShowTime = 0;      // Time when overlay was first shown
bool dataPaused = false;                      // Data pause for both duplicate row and seat errors
// OPTIMIZATION 3: Bit-packed duplicate error state (6 bytes saved)
uint8_t duplicateErrorBits = 0;  // Replace 7-byte array with 1-byte bit field

// Simple bit manipulation macros - no built-in dependencies
#define SET_DUPLICATE_ERROR(row)     (duplicateErrorBits |= (1 << (row)))
#define CLEAR_DUPLICATE_ERROR(row)   (duplicateErrorBits &= ~(1 << (row)))
#define HAS_DUPLICATE_ERROR(row)     ((duplicateErrorBits & (1 << (row))) != 0)
#define CLEAR_ALL_DUPLICATE_ERRORS() (duplicateErrorBits = 0)
#define HAS_ANY_DUPLICATE_ERROR()    (duplicateErrorBits != 0)
struct Seat {
  uint8_t number;  // Seat name
  bool buckled;    // Whether the seatbelt is buckled
  bool taken;      // Whether the seat is occupied
  bool visable;
};

Seat seats[7][4];

// Previous state tracking for change detection
bool prevSeatDataArray[7][SEAT_DATA_LENGTH];
bool prevDataArrayValid[7] = { false }; // Track if previous data is valid
uint8_t prevBuckledSeats = 0;
uint8_t prevUnbuckledSeats = 0;
bool sideInfoNeedsUpdate = false;

// Buzzer control states (7 bytes RAM, persistent in EEPROM)
// Default all ON (1=enabled, 0=disabled) for rows 1-7
uint8_t buzzer_states[7] = {1, 1, 1, 1, 1, 1, 1};

// Display buzzer state (1 byte RAM, synced to main.c via BUZ: protocol byte 8)
// Controls buzzer from DisplayV9 warning overlays independently of seat belt logic
// false = Buzzer OFF (0), true = Buzzer ON (1)
bool buzzer_state_display = false;  // Default: no display alerts (OFF)

// Startup synchronization for buzzer state
bool startup_sync_active = false;
uint32_t last_buzzer_broadcast = 0;
uint32_t startup_complete_time = 0;

void create_seat_containers(void) {
  lv_obj_t* containers[] = {ui_seatContainer1H, ui_seatContainer2H, ui_seatContainer3H, ui_seatContainer4H, ui_seatContainer5H, ui_seatContainer6H, ui_seatContainer7H};
  for(int i = 0; i < 7; i++) {
    ui_seatContainers[i] = containers[i];
  }
}

void initialize_seat_rows(void) {
  lv_obj_t* rows[][4] = {
    {ui_seatGUI1A, ui_seatGUI1B, ui_seatGUI1C, ui_seatGUI1H},
    {ui_seatGUI2A, ui_seatGUI2B, ui_seatGUI2C, ui_seatGUI2H},
    {ui_seatGUI3A, ui_seatGUI3B, ui_seatGUI3C, ui_seatGUI3H},
    {ui_seatGUI4A, ui_seatGUI4B, ui_seatGUI4C, ui_seatGUI4H},
    {ui_seatGUI5A, ui_seatGUI5B, ui_seatGUI5C, ui_seatGUI5H},
    {ui_seatGUI6A, ui_seatGUI6B, ui_seatGUI6C, ui_seatGUI6H},
    {ui_seatGUI7A, ui_seatGUI7B, ui_seatGUI7C, ui_seatGUI7H}
  };
  for(int i = 0; i < 7; i++) {
    for(int j = 0; j < 4; j++) {
      seat_rows_container[i][j] = rows[i][j];
    }
  }
}

void seven_seat_config() {
  for(int i = 0; i < 7; i++) {
    if(i < 4) {
      lv_obj_set_x(seat_columns_container[i][3], x_positions_7seat_adjusted[0][i]); // H
      lv_obj_set_x(seat_columns_container[i][0], x_positions_7seat_adjusted[1][i]); // A
      lv_obj_set_x(seat_columns_container[i][1], x_positions_7seat_adjusted[2][i]); // B
      lv_obj_set_x(seat_columns_container[i][2], x_positions_7seat_adjusted[3][i]); // C
    } else {
      lv_obj_set_x(seat_columns_container[i][3], x_positions_7seat[i]); // H
      lv_obj_set_x(seat_columns_container[i][0], x_positions_7seat[i]); // A
      lv_obj_set_x(seat_columns_container[i][1], x_positions_7seat[i]); // B
      lv_obj_set_x(seat_columns_container[i][2], x_positions_7seat[i]); // C
    }
  }
  lv_obj_set_x(ui_seatContainerDriver, -284);
  lv_obj_set_y(ui_seatContainerDriver, -96);
  lv_obj_set_x(ui_Image3, -351);
  lv_obj_set_x(ui_Door, -107);
}

void four_seat_config() {
  for(int i = 0; i < 4; i++) {
    lv_obj_set_x(seat_columns_container[i][3], x_positions_4seat[0][i]); // H
    lv_obj_set_x(seat_columns_container[i][0], x_positions_4seat[1][i]); // A
    lv_obj_set_x(seat_columns_container[i][1], x_positions_4seat[2][i]); // B
    lv_obj_set_x(seat_columns_container[i][2], x_positions_4seat[3][i]); // C
  }
  lv_obj_set_x(ui_seatContainerDriver, -146);
  lv_obj_set_y(ui_seatContainerDriver, -96);
  lv_obj_set_x(ui_Image3, -215);
  lv_obj_set_x(ui_Door, -57);
}
void initialize_seat_columns() {
  lv_obj_t* columns[][4] = {
    {ui_seatContainer1A, ui_seatContainer1B, ui_seatContainer1C, ui_seatContainer1H},
    {ui_seatContainer2A, ui_seatContainer2B, ui_seatContainer2C, ui_seatContainer2H},
    {ui_seatContainer3A, ui_seatContainer3B, ui_seatContainer3C, ui_seatContainer3H},
    {ui_seatContainer4A, ui_seatContainer4B, ui_seatContainer4C, ui_seatContainer4H},
    {ui_seatContainer5A, ui_seatContainer5B, ui_seatContainer5C, ui_seatContainer5H},
    {ui_seatContainer6A, ui_seatContainer6B, ui_seatContainer6C, ui_seatContainer6H},
    {ui_seatContainer7A, ui_seatContainer7B, ui_seatContainer7C, ui_seatContainer7H}
  };
  for(int i = 0; i < 7; i++) {
    for(int j = 0; j < 4; j++) {
      seat_columns_container[i][j] = columns[i][j];
    }
  }
}

void toggleRight() {
  const lv_coord_t* positions = y_positions_right;

  for (int i = 0; i < 7; i++) {
    for (int j = 0; j < 4; j++) {
      lv_obj_set_y(seat_columns_container[i][j], positions[j]);
    }
  }

  lv_obj_set_y(ui_seatContainerDriver, -98);
  lv_obj_set_y(ui_Image3, -21);
  lv_obj_set_y(ui_Door, 225);

  leftActive = false;
  rightActive = true;
  bolck_processing();
}

void toggleLeft() {
  const lv_coord_t* positions = y_positions_left;

  for (int i = 0; i < 7; i++) {
    for (int j = 0; j < 4; j++) {
      lv_obj_set_y(seat_columns_container[i][j], positions[j]);
    }
  }

  lv_obj_set_y(ui_seatContainerDriver, 114);
  lv_obj_set_y(ui_Image3, 188);
  lv_obj_set_y(ui_Door, -61);

  leftActive = true;
  rightActive = false;
  bolck_processing();
}

void make_seven_seater() {
  is_seven_seater = true;
  is_four_seater = false;
  // Reset change detection for rows 5-7 to force visual update
  prevDataArrayValid[4] = false;
  prevDataArrayValid[5] = false;
  prevDataArrayValid[6] = false;
  // Switch to 7-seater LVGL outlines
  setObjectVisibility(ui_RedOutline7Full, true);
  setObjectVisibility(ui_RedOutline4Full, false);
  // PNG images are now NULL - no action needed
  setSeatsVisibility(0, 7, true);  // Show all 7 rows
  bolck_processing();
  seven_seat_config();
}
void make_four_seater() {
  is_seven_seater = false;
  is_four_seater = true;
  // Reset change detection for rows 5-7 when hiding them
  prevDataArrayValid[4] = false;
  prevDataArrayValid[5] = false;
  prevDataArrayValid[6] = false;
  // Switch to 4-seater LVGL outlines
  setObjectVisibility(ui_RedOutline4Full, true);
  setObjectVisibility(ui_RedOutline7Full, false);
  // PNG images are now NULL - no action needed

  // Hide seats from row 5 to 7, show seats from row 1 to 4
  setSeatsVisibility(4, 7, false);  // Hide rows 5-7
  setSeatsVisibility(0, 4, true);   // Show rows 1-4
  four_seat_config();
  bolck_processing();
}

// Error Logging System - Core Functions
void addLogEntry(const char *message) {
  // Check for duplicate - O(n) scan through existing log entries using circular buffer indexing
  for (uint8_t i = 0; i < logCount; i++) {
    int idx = (logIndex - logCount + i + MAX_LOG_ENTRIES) % MAX_LOG_ENTRIES;
    if (strcmp(errorLog[idx].message, message) == 0) {
      // Reset acknowledged state if reset limit not reached (max 1 per session)
      if (errorLog[idx].resetCount < 1) {
        errorLog[idx].acknowledged = false;
        errorLog[idx].resetCount++;
        saveErrorLogToEEPROM();
        updateLogDisplay();
        updateAllWarningIcons();
      }
      return;  // Skip duplicate
    }
  }

  // Add new log entry with un-acknowledged state and zero reset count
  strncpy(errorLog[logIndex].message, message, LOG_ENTRY_LENGTH - 1);
  errorLog[logIndex].message[LOG_ENTRY_LENGTH - 1] = '\0';
  errorLog[logIndex].acknowledged = false;
  errorLog[logIndex].resetCount = 0;

  logIndex = (logIndex + 1) % MAX_LOG_ENTRIES;
  if (logCount < MAX_LOG_ENTRIES) logCount++;

  // Save error log to EEPROM for persistence
  saveErrorLogToEEPROM();

  updateLogDisplay();
  updateAllWarningIcons();
}

// ========== EEPROM PERSISTENT ERROR LOG FUNCTIONS ==========

// Validate EEPROM error log data integrity
bool validateErrorLogEEPROM() {
  // Read metadata
  uint8_t storedIndex = EEPROM.read(ERROR_LOG_METADATA_ADDR);
  uint8_t storedCount = EEPROM.read(ERROR_LOG_METADATA_ADDR + 1);

  // Validate metadata ranges
  if (storedIndex >= MAX_LOG_ENTRIES || storedCount > MAX_LOG_ENTRIES) {
    return false;
  }

  // Check for magic byte pattern in first entry to verify initialization
  // If first byte is 0xFF (erased flash), EEPROM is not initialized
  uint8_t firstByte = EEPROM.read(ERROR_LOG_DATA_ADDR);
  if (storedCount == 0 && firstByte == 0xFF) {
    return false;  // Uninitialized EEPROM
  }

  return true;
}

// Save error log to EEPROM for persistence across power cycles
void saveErrorLogToEEPROM() {
  // Write metadata (logIndex and logCount)
  EEPROM.write(ERROR_LOG_METADATA_ADDR, logIndex);
  EEPROM.write(ERROR_LOG_METADATA_ADDR + 1, logCount);

  // Write all log entries
  for (uint8_t i = 0; i < MAX_LOG_ENTRIES; i++) {
    uint16_t entryAddr = ERROR_LOG_DATA_ADDR + (i * ERROR_LOG_ENTRY_SIZE);

    // Write message (60 bytes)
    for (uint8_t j = 0; j < LOG_ENTRY_LENGTH; j++) {
      EEPROM.write(entryAddr + j, errorLog[i].message[j]);
    }

    // Write acknowledged flag (1 byte)
    EEPROM.write(entryAddr + LOG_ENTRY_LENGTH, errorLog[i].acknowledged ? 1 : 0);

    // Write resetCount (1 byte)
    EEPROM.write(entryAddr + LOG_ENTRY_LENGTH + 1, errorLog[i].resetCount);
  }

  // Commit changes to flash
  EEPROM.commit();
}

// Load error log from EEPROM on startup
void loadErrorLogFromEEPROM() {
  // Validate EEPROM data before loading
  if (!validateErrorLogEEPROM()) {
    // EEPROM not initialized or corrupted - start with empty log
    logIndex = 0;
    logCount = 0;
    for (uint8_t i = 0; i < MAX_LOG_ENTRIES; i++) {
      errorLog[i].message[0] = '\0';
      errorLog[i].acknowledged = false;
      errorLog[i].resetCount = 0;
    }
    // Save initial empty state to EEPROM
    saveErrorLogToEEPROM();
    return;
  }

  // Read metadata
  logIndex = EEPROM.read(ERROR_LOG_METADATA_ADDR);
  logCount = EEPROM.read(ERROR_LOG_METADATA_ADDR + 1);

  // Read all log entries
  for (uint8_t i = 0; i < MAX_LOG_ENTRIES; i++) {
    uint16_t entryAddr = ERROR_LOG_DATA_ADDR + (i * ERROR_LOG_ENTRY_SIZE);

    // Read message (60 bytes)
    for (uint8_t j = 0; j < LOG_ENTRY_LENGTH; j++) {
      errorLog[i].message[j] = EEPROM.read(entryAddr + j);
    }
    errorLog[i].message[LOG_ENTRY_LENGTH - 1] = '\0';  // Ensure null termination

    // Read acknowledged flag (1 byte)
    errorLog[i].acknowledged = (EEPROM.read(entryAddr + LOG_ENTRY_LENGTH) == 1);

    // Always initialize resetCount to 0 on system startup (fresh session)
    errorLog[i].resetCount = 0;
  }
}

// ========== END EEPROM FUNCTIONS ==========

// REMOVED: logSeatError function - all error detection moved to main.c
// This eliminates redundant error processing and reduces display controller load
// main.c now handles all error detection and sends ERROR: messages via UART

// Remove specific error message from log buffer
void removeSpecificError(const char* errorMessage) {
  int startIndex = (logCount < MAX_LOG_ENTRIES) ? 0 : logIndex;

  for (int i = 0; i < logCount; i++) {
    int idx = (startIndex + i) % MAX_LOG_ENTRIES;

    // Check if this log entry exactly matches the error message we want to remove
    if (strcmp(errorLog[idx].message, errorMessage) == 0) {
      // Clear the message
      errorLog[idx].message[0] = '\0';

      // Save to EEPROM for persistence
      saveErrorLogToEEPROM();

      // Update warning icons immediately after removing error
      updateAllWarningIcons();

      break; // Remove only the first matching error
    }
  }
}

// checkSeatErrorResolution() removed - error resolution now handled by main.c
// main.c sends CLEAR: messages when errors resolve
// Display only needs to log the CLEAR messages (handled in processReceivedData)

// PRIORITY 5 OPTIMIZATION: Batched LVGL Updates
// Queue structure for pending visual updates to eliminate screen rippling
#define MAX_VISUAL_UPDATES 28  // 7 rows × 4 seats = 28 max updates per cycle

struct VisualUpdate {
  uint8_t row;
  uint8_t seatNumber;
  uint32_t bgColor;
  uint32_t textColor;
};

VisualUpdate visualUpdateQueue[MAX_VISUAL_UPDATES];
uint8_t visualUpdateCount = 0;

// OPTIMIZATION 2: Consolidated seat visual styling function
// Modified to queue updates instead of applying immediately
void setSeatVisualState(uint8_t row, uint8_t seatNumber, uint32_t bgColor, uint32_t textColor) {
  // Bounds checking for safety (max 7 rows, 4 seats)
  if (row >= 7 || seatNumber >= 4) return;

  // Queue the visual update instead of applying immediately
  if (visualUpdateCount < MAX_VISUAL_UPDATES) {
    visualUpdateQueue[visualUpdateCount].row = row;
    visualUpdateQueue[visualUpdateCount].seatNumber = seatNumber;
    visualUpdateQueue[visualUpdateCount].bgColor = bgColor;
    visualUpdateQueue[visualUpdateCount].textColor = textColor;
    visualUpdateCount++;
  }
}

// Apply all queued visual updates in a single batch
void flushVisualUpdates() {
  if (visualUpdateCount == 0) return;

  // Apply all queued updates
  for (uint8_t i = 0; i < visualUpdateCount; i++) {
    VisualUpdate *update = &visualUpdateQueue[i];

    lv_obj_set_style_bg_color(
      seat_rows_container[update->row][update->seatNumber],
      lv_color_hex(update->bgColor),
      LV_PART_MAIN | LV_STATE_DEFAULT
    );

    lv_obj_set_style_text_color(
      seat_rows_lebels_container[update->row][update->seatNumber],
      lv_color_hex(update->textColor),
      LV_PART_MAIN | LV_STATE_DEFAULT
    );
  }

  // Clear the queue
  visualUpdateCount = 0;
}

// OPTIMIZATION 3: Helper function for finding first duplicate error
uint8_t findFirstDuplicateError(void) {
  for (int i = 0; i < 7; i++) {
    if (HAS_DUPLICATE_ERROR(i)) return i;
  }
  return 7; // No errors found
}

// Clear all error log entries and reset to initial state
void clearAllErrors() {
  // Clear all error messages
  for (uint8_t i = 0; i < MAX_LOG_ENTRIES; i++) {
    errorLog[i].message[0] = '\0';
    errorLog[i].acknowledged = false;
    errorLog[i].resetCount = 0;
  }

  // Reset log management variables
  logIndex = 0;
  logCount = 0;

  // Save cleared state to EEPROM for persistence
  saveErrorLogToEEPROM();

  // Update display and warning icons
  updateLogDisplay();
  updateAllWarningIcons();
}

// Simplified log display update (matches warning overlay simplicity)
void updateLogDisplay() {
  if (ui_LogTextArea == NULL) {
    return;
  }

  // Count unique errors (non-empty messages)
  uint8_t errorCount = 0;
  for (uint8_t i = 0; i < logCount && i < MAX_LOG_ENTRIES; i++) {
    if (errorLog[i].message[0] != '\0') {
      errorCount++;
    }
  }

  // Update error counter label
  if (ui_LogCounterLabel != NULL) {
    static char counterText[20];
    snprintf(counterText, sizeof(counterText), "Errors: %d", errorCount);
    lv_label_set_text(ui_LogCounterLabel, counterText);
  }

  // No errors - show simple message
  if (errorCount == 0) {
    lv_label_set_text(ui_LogTextArea, "No errors exist");
    return;
  }

  // Build simple error list - no timestamps, no circular buffer complexity
  static char logText[1600];  // Increased to support 20 entries (20 × 60 chars + newlines ≈ 1280 bytes)
  int offset = 0;

  for (uint8_t i = 0; i < logCount && i < MAX_LOG_ENTRIES; i++) {
    if (errorLog[i].message[0] != '\0') {
      offset += snprintf(logText + offset, sizeof(logText) - offset, "%s\n", errorLog[i].message);
      if (offset >= sizeof(logText) - 80) break;  // Safety check
    }
  }

  lv_label_set_text(ui_LogTextArea, logText);
}

// Unified warning management system
void updateAllWarningIcons() {
  // Count non-empty log entries
  bool hasErrors = false;
  for (int i = 0; i < logCount; i++) {
    if (errorLog[i].message[0] != '\0') {
      hasErrors = true;
      break;
    }
  }

  // Main screen: Show warning overlay instead of warning icon
  if (hasErrors) {
    // Show warning overlay (session check handled inside function)
    showWarningOverlay();
  }

  // Update menu screen warning icon (ui_LogTabWarningIcon)
  setObjectVisibility(ui_LogTabWarningIcon, hasErrors);
}

// OPTIMIZATION: Cache door state to prevent redundant LVGL updates
void updateDoorDisplay() {
  static int lastDoorFlag = -1;

  // Early exit if state unchanged
  if (doorFlag == lastDoorFlag) {
    return;
  }

  lastDoorFlag = doorFlag;

  if (doorFlag == 0) {
    lv_obj_set_style_bg_color(ui_DoorBG, lv_color_hex(COLOR_WHITE), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_label_set_text(ui_DoorStatusLabel, "CLOSE");
    lv_obj_set_style_bg_color(ui_Door, lv_color_hex(COLOR_WHITE), LV_PART_MAIN | LV_STATE_DEFAULT);
  } else {
    lv_obj_set_style_bg_color(ui_DoorBG, lv_color_hex(COLOR_RED), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_label_set_text(ui_DoorStatusLabel, "OPEN");
    lv_obj_set_style_bg_color(ui_Door, lv_color_hex(COLOR_RED), LV_PART_MAIN | LV_STATE_DEFAULT);
  }
}

void createDuplicateErrorOverlay() {
  if (ui_DuplicateErrorOverlay != NULL) {
    return;  // Already created
  }

  // Create overlay container - fullscreen 800x480px
  ui_DuplicateErrorOverlay = lv_obj_create(ui_Screen1);
  lv_obj_set_size(ui_DuplicateErrorOverlay, 800, 480);                                                           // Fullscreen (800x480px)
  lv_obj_align(ui_DuplicateErrorOverlay, LV_ALIGN_CENTER, 0, 0);                                                 // Center on screen
  lv_obj_set_style_bg_color(ui_DuplicateErrorOverlay, lv_color_hex(COLOR_ORANGE), LV_PART_MAIN | LV_STATE_DEFAULT);  // Yellow-orange
  lv_obj_set_style_bg_opa(ui_DuplicateErrorOverlay, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_set_style_border_width(ui_DuplicateErrorOverlay, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_set_style_radius(ui_DuplicateErrorOverlay, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_set_style_pad_all(ui_DuplicateErrorOverlay, 0, LV_PART_MAIN | LV_STATE_DEFAULT);

  // Create label for error text
  ui_DuplicateErrorLabel = lv_label_create(ui_DuplicateErrorOverlay);
  lv_label_set_text(ui_DuplicateErrorLabel, "Warning Message");
  lv_obj_set_style_text_color(ui_DuplicateErrorLabel, lv_color_hex(COLOR_BLACK), LV_PART_MAIN | LV_STATE_DEFAULT);  // Black text
  lv_obj_set_style_text_font(ui_DuplicateErrorLabel, &lv_font_montserrat_38, LV_PART_MAIN | LV_STATE_DEFAULT);   // Bold large font
  lv_obj_align(ui_DuplicateErrorLabel, LV_ALIGN_CENTER, 0, -100);                                                // Center text, positioned higher on fullscreen

  // Create label for error list (Priority 2 only)
  ui_ErrorListLabel = lv_label_create(ui_DuplicateErrorOverlay);
  lv_label_set_text(ui_ErrorListLabel, "");
  lv_obj_set_style_text_color(ui_ErrorListLabel, lv_color_hex(COLOR_BLACK), LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_set_style_text_font(ui_ErrorListLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);        // Same font as error log link
  lv_obj_set_width(ui_ErrorListLabel, 760);                                                                       // Allow wrapping for long lists
  lv_label_set_long_mode(ui_ErrorListLabel, LV_LABEL_LONG_WRAP);                                                 // Enable text wrapping
  lv_obj_set_style_text_align(ui_ErrorListLabel, LV_TEXT_ALIGN_CENTER, LV_PART_MAIN | LV_STATE_DEFAULT);         // Center-aligned
  lv_obj_align(ui_ErrorListLabel, LV_ALIGN_CENTER, 0, 0);                                                         // Center position between main text and buttons
  lv_obj_add_flag(ui_ErrorListLabel, LV_OBJ_FLAG_HIDDEN);                                                         // Initially hidden

  // Create confirm button - positioned at bottom of fullscreen overlay
  ui_DuplicateErrorConfirmButton = createOverlayButton(ui_DuplicateErrorOverlay, "I Agree", 580, 420, 100, 40, duplicateErrorConfirmButtonCallback);
  ui_DuplicateErrorConfirmLabel = lv_obj_get_child(ui_DuplicateErrorConfirmButton, 0);  // Get the label created by helper

  // Create reset button - positioned at bottom-right of fullscreen overlay
  ui_DuplicateErrorResetButton = createOverlayButton(ui_DuplicateErrorOverlay, "Reset", 700, 420, 80, 40, duplicateErrorResetButtonCallback);
  ui_DuplicateErrorResetLabel = lv_obj_get_child(ui_DuplicateErrorResetButton, 0);  // Get the label created by helper

  // Initially hide the overlay
  lv_obj_add_flag(ui_DuplicateErrorOverlay, LV_OBJ_FLAG_HIDDEN);
}

void showDuplicateErrorOverlay(uint8_t rowNumber) {
  createDuplicateErrorOverlay();

  // Update the error message to simple generic message
  lv_label_set_text(ui_DuplicateErrorLabel, "Duplicate Row Detected");

  // Show the overlay
  lv_obj_clear_flag(ui_DuplicateErrorOverlay, LV_OBJ_FLAG_HIDDEN);

  // Set overlay state - only update show time if not already active
  if (!duplicateErrorActive) {
    duplicateErrorShowTime = millis();
  }
  duplicateErrorActive = true;
  duplicateErrorRow = rowNumber;
}

void hideDuplicateErrorOverlay() {
  if (ui_DuplicateErrorOverlay != NULL) {
    lv_obj_add_flag(ui_DuplicateErrorOverlay, LV_OBJ_FLAG_HIDDEN);
  }
  duplicateErrorActive = false;

  // Turn off display buzzer (buzzer should stop in main.c)
  buzzer_state_display = false;
  sendBuzzerStatesToMainC();
}

// ==================== UNIFIED HELPER FUNCTIONS ====================
// Helper function to set object visibility (consolidated NULL check + flag setting)
inline void setObjectVisibility(lv_obj_t* obj, bool visible) {
  if (obj == NULL) return;
  if (visible) {
    lv_obj_clear_flag(obj, LV_OBJ_FLAG_HIDDEN);
  } else {
    lv_obj_add_flag(obj, LV_OBJ_FLAG_HIDDEN);
  }
}

// Helper function to create styled button for overlay (Material Design Rounded Filled style)
lv_obj_t* createOverlayButton(lv_obj_t* parent, const char* text, int x, int y, int width, int height, void (*callback)(lv_event_t*)) {
  lv_obj_t* btn = lv_btn_create(parent);
  lv_obj_set_size(btn, width, height);
  lv_obj_set_pos(btn, x, y);

  // Material Design Rounded Filled button style
  lv_obj_set_style_bg_color(btn, lv_color_hex(COLOR_LIGHT_GRAY), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light background
  lv_obj_set_style_bg_opa(btn, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_set_style_border_width(btn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No border for Filled buttons
  lv_obj_set_style_radius(btn, MD_BUTTON_RADIUS_SM, LV_PART_MAIN | LV_STATE_DEFAULT);  // 20px pill-shaped
  lv_obj_set_style_shadow_width(btn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation (performance)

  // Pressed state: slightly darker
  lv_obj_set_style_bg_opa(btn, 220, LV_PART_MAIN | LV_STATE_PRESSED);

  // Create label for button
  lv_obj_t* label = lv_label_create(btn);
  lv_label_set_text(label, text);
  lv_obj_set_style_text_color(label, lv_color_hex(COLOR_DARK_GRAY), LV_PART_MAIN | LV_STATE_DEFAULT);  // Dark text on light bg
  lv_obj_set_style_text_font(label, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);
  lv_obj_center(label);

  // Register event callback
  if (callback != NULL) {
    lv_obj_add_event_cb(btn, callback, LV_EVENT_CLICKED, NULL);
  }

  return btn;
}

// Helper function to batch set seats visibility (reduces loop overhead)
void setSeatsVisibility(int startRow, int endRow, bool visible) {
  for (int i = startRow; i < endRow; i++) {
    for (int j = 0; j < 4; j++) {
      setObjectVisibility(seat_columns_container[i][j], visible);
    }
  }
}

// Helper function to set button visibility based on error type
void setOverlayButtons(bool showReset, bool showConfirm) {
  setObjectVisibility(ui_DuplicateErrorResetButton, showReset);
  setObjectVisibility(ui_DuplicateErrorConfirmButton, showConfirm);
}

// Helper function to activate overlay and set state
void activateOverlay() {
  lv_obj_clear_flag(ui_DuplicateErrorOverlay, LV_OBJ_FLAG_HIDDEN);
  if (!duplicateErrorActive) {
    duplicateErrorShowTime = millis();
  }
  duplicateErrorActive = true;
  dataPaused = true;
  buzzer_state_display = true;
  sendBuzzerStatesToMainC();
}

// Update Priority 2 error list with un-acknowledged errors from error log
void updatePriority2ErrorList() {
  // Only update if the error list label exists
  if (ui_ErrorListLabel == NULL) {
    return;
  }

  static char errorListText[400];  // Buffer for error list
  int offset = 0;

  // Iterate through error log and build list of un-acknowledged errors only
  // This now includes all priority 2 errors: seat errors AND buzzer-off errors
  for (int i = 0; i < logCount && i < MAX_LOG_ENTRIES; i++) {
    int idx = (logIndex - logCount + i + MAX_LOG_ENTRIES) % MAX_LOG_ENTRIES;

    // Skip empty messages or acknowledged errors
    if (errorLog[idx].message[0] == '\0' || errorLog[idx].acknowledged) continue;

    // Add bullet point and message
    int written = snprintf(errorListText + offset, sizeof(errorListText) - offset,
                          "\u2022 %s\n", errorLog[idx].message);

    if (written > 0) {
      offset += written;
    }

    // Stop if buffer nearly full
    if (offset >= sizeof(errorListText) - 80) break;
  }

  // Set the error list text and show it
  lv_label_set_text(ui_ErrorListLabel, errorListText);
  setObjectVisibility(ui_ErrorListLabel, true);
}

// Check for active transmitters with disabled buzzers and add to error log
void checkForBuzzerOffErrors() {
  uint32_t current_time = millis();
  for (int i = 0; i < 7; i++) {
    bool row_active = isRowActive(i, current_time);
    bool buzzer_disabled = (buzzer_states[i] == 0);

    if (row_active && buzzer_disabled) {
      char errorMsg[64];
      snprintf(errorMsg, sizeof(errorMsg), "Row %d Buzzer is off", i + 1);
      addLogEntry(errorMsg);
    }
  }
}

// Show warning overlay with priority-based static message system
void showWarningOverlay() {
  // PRIORITY 1: Check for duplicate row errors FIRST
  // This ensures duplicate errors ALWAYS override seat errors, regardless of arrival order
  bool hasDuplicateError = HAS_ANY_DUPLICATE_ERROR();

  if (hasDuplicateError) {
    createDuplicateErrorOverlay();
    lv_label_set_text(ui_DuplicateErrorLabel, "Duplicate Row Detected");
    setOverlayButtons(true, false);  // Show Reset only

    // Hide error details for Priority 1
    setObjectVisibility(ui_ErrorLogLinkLabel, false);
    setObjectVisibility(ui_ErrorListLabel, false);

    activateOverlay();
    return;
  }

  // PRIORITY 2: Check for un-acknowledged seat errors
  bool hasUnacknowledgedErrors = false;
  for (int i = 0; i < logCount; i++) {
    if (errorLog[i].message[0] != '\0' && !errorLog[i].acknowledged) {
      hasUnacknowledgedErrors = true;
      break;
    }
  }

  // If overlay already exists and there are un-acknowledged errors, update and show it
  if (ui_DuplicateErrorOverlay != NULL && hasUnacknowledgedErrors && ui_ErrorListLabel != NULL) {
    updatePriority2ErrorList();
    activateOverlay();  // Make sure it's visible
    return;
  }

  // If no overlay exists yet and there are un-acknowledged errors, create and show it
  if (hasUnacknowledgedErrors) {
    createDuplicateErrorOverlay();
    lv_label_set_text(ui_DuplicateErrorLabel, "System errors detected.\nYou are using an unsafe system");
    setOverlayButtons(false, true);  // Show Confirm only

    // Show error details for Priority 2
    if (ui_ErrorLogLinkLabel == NULL) {
      ui_ErrorLogLinkLabel = lv_label_create(ui_DuplicateErrorOverlay);
      lv_label_set_text(ui_ErrorLogLinkLabel, "*View the error log to see all errors.\n*Resolve all errors before using the system");
      lv_obj_set_style_text_color(ui_ErrorLogLinkLabel, lv_color_hex(COLOR_BLACK), LV_PART_MAIN | LV_STATE_DEFAULT);
      lv_obj_set_style_text_font(ui_ErrorLogLinkLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);
      lv_obj_set_pos(ui_ErrorLogLinkLabel, 20, 420);
    }
    setObjectVisibility(ui_ErrorLogLinkLabel, true);

    updatePriority2ErrorList();
    activateOverlay();
  }
}

void cleanupErrorOverlays() {
  // Cleanup warning overlay if it exists
  if (ui_DuplicateErrorOverlay != NULL) {
    lv_obj_del(ui_DuplicateErrorOverlay);
    ui_DuplicateErrorOverlay = NULL;
    ui_DuplicateErrorLabel = NULL;
    ui_DuplicateErrorConfirmButton = NULL;
    ui_DuplicateErrorConfirmLabel = NULL;
    ui_DuplicateErrorResetButton = NULL;
    ui_DuplicateErrorResetLabel = NULL;
    ui_ErrorLogLinkLabel = NULL;  // Cleanup new link label
    ui_ErrorListLabel = NULL;     // Cleanup error list label
    duplicateErrorActive = false;
  }
}

void updateDuplicateErrorOverlay() {
  // Show overlay for any duplicate error - overlay persists until manual reset
  int firstErrorRow = -1;
  if (HAS_ANY_DUPLICATE_ERROR()) {  // OPTIMIZATION 3: Use bit checking
    firstErrorRow = findFirstDuplicateError() + 1;  // Convert to 1-based
  }

  if (firstErrorRow != -1) {
    if (!duplicateErrorActive || duplicateErrorRow != firstErrorRow) {
      showDuplicateErrorOverlay(firstErrorRow);
    }
  }
}

void duplicateErrorResetButtonCallback(lv_event_t *e) {
  static bool confirmReset = false;
  static uint32_t confirmTime = 0;

  if(lv_event_get_code(e) != LV_EVENT_CLICKED) return;

  uint32_t currentTime = millis();

  // Check timeout and reset if needed (3 seconds)
  if (confirmReset && (currentTime - confirmTime > 3000)) {
    confirmReset = false;
  }

  if (!confirmReset) {
    // First click - show confirmation
    if (ui_DuplicateErrorResetLabel) {
      lv_label_set_text(ui_DuplicateErrorResetLabel, "Confirm");
      lv_obj_set_style_bg_color(ui_DuplicateErrorResetButton, lv_color_hex(COLOR_RED), LV_PART_MAIN);
      lv_obj_set_style_text_color(ui_DuplicateErrorResetLabel, lv_color_hex(COLOR_WHITE), LV_PART_MAIN);
    }
    confirmReset = true;
    confirmTime = currentTime;
  } else {
    // Second click - trigger system reset
    uiResetRequested = true;
    confirmReset = false;
  }
}

// Confirm/Acknowledge button callback - clears data pause and hides overlay (seat errors only)
void duplicateErrorConfirmButtonCallback(lv_event_t *e) {
  if(lv_event_get_code(e) != LV_EVENT_CLICKED) return;

  // Clear data pause flag to resume data processing (this button only shown for seat errors)
  dataPaused = false;

  // Force display refresh to show accurate current data immediately
  forceDisplayRefresh();

  // Mark all un-acknowledged errors as acknowledged (using circular buffer indexing)
  for (int i = 0; i < logCount; i++) {
    int idx = (logIndex - logCount + i + MAX_LOG_ENTRIES) % MAX_LOG_ENTRIES;
    if (!errorLog[idx].acknowledged) {
      errorLog[idx].acknowledged = true;
    }
  }

  // Save acknowledged state to EEPROM for persistence
  saveErrorLogToEEPROM();

  // Hide the warning overlay
  hideDuplicateErrorOverlay();
}

// performSafeDisplayReset removed - both reset buttons now use hard reset via uiResetRequested flag

void initialize_seat_rows_labels(void) {
  lv_obj_t* labels[][4] = {
    {ui_Label1A, ui_Label1B, ui_Label1C, ui_Label1H},
    {ui_Label2A, ui_Label2B, ui_Label2C, ui_Label2H},
    {ui_Label3A, ui_Label3B, ui_Label3C, ui_Label3H},
    {ui_Label4A, ui_Label4B, ui_Label4C, ui_Label4H},
    {ui_Label5A, ui_Label5B, ui_Label5C, ui_Label5H},
    {ui_Label6A, ui_Label6B, ui_Label6C, ui_Label6H},
    {ui_Label7A, ui_Label7B, ui_Label7C, ui_Label7H}
  };
  for(int i = 0; i < 7; i++) {
    for(int j = 0; j < 4; j++) {
      seat_rows_lebels_container[i][j] = labels[i][j];
    }
  }
}

// One-time layout detection performed after startup delay
// Implements the refactor described in LAYOUT_DETECTION_REFACTOR.md
void detectLayoutOneTime() {
  uint32_t current_time = millis();

  // Check if rows 5-7 (indices 4-6) have received data during startup
  bool rows_5_7_active = false;

  for (int i = 4; i < 7; i++) {
    // Check if this row received data (row_timer > 0 and within timeout)
    if (isRowActive(i, current_time)) {
      rows_5_7_active = true;
    }
  }

  // Decision logic: If any of rows 5-7 active -> 7-seater, otherwise -> 4-seater
  if (rows_5_7_active) {
    if (!is_seven_seater) {
      make_seven_seater();
    }
  } else {
    // Already initialized to 4-seater in setup(), no action needed
    if (!is_four_seater) {
      make_four_seater();
    }
  }
}

// Send complete buzzer state array to main.c via UART (extended 8-byte protocol)
// Format: "BUZ:11101110\n" (7 row states + 1 display buzzer state)
void sendBuzzerStatesToMainC() {
  char buzzer_msg[32];
  snprintf(buzzer_msg, 32, "BUZ:%d%d%d%d%d%d%d%d\n",
    buzzer_states[0], buzzer_states[1], buzzer_states[2], buzzer_states[3],
    buzzer_states[4], buzzer_states[5], buzzer_states[6],
    buzzer_state_display ? 1 : 0);  // 8th byte: display buzzer state (1=ON, 0=OFF)
  SerialPort.print(buzzer_msg);
}

// Toggle buzzer state for a specific row and send update to receiver
void toggleBuzzerState(uint8_t row) {
  if (row >= 7) return; // Bounds check

  // Toggle the state
  buzzer_states[row] = !buzzer_states[row];

  // Save to EEPROM
  EEPROM.write(BUZZER_EEPROM_ADDR + row, buzzer_states[row]);
  EEPROM.commit();

  // If buzzer was turned ON, acknowledge any related "Buzzer is off" errors
  if (buzzer_states[row] == 1) {
    char targetMsg[64];
    snprintf(targetMsg, sizeof(targetMsg), "Row %d Buzzer is off", row + 1);

    bool errorAcknowledged = false;
    // Find and acknowledge matching error
    for (int i = 0; i < logCount; i++) {
      if (strcmp(errorLog[i].message, targetMsg) == 0) {
        errorLog[i].acknowledged = true;
        errorAcknowledged = true;
      }
    }

    // Save to EEPROM if error was acknowledged
    if (errorAcknowledged) {
      saveErrorLogToEEPROM();
    }
  }

  // Send update to receiver via UART (using unified function)
  sendBuzzerStatesToMainC();

}

// Buzzer Toggle Button Event Handler (C++ implementation for LVGL)
extern "C" void ui_event_BuzzerToggle(lv_event_t * e) {
  lv_obj_t * btn = lv_event_get_target(e);
  lv_event_code_t event_code = lv_event_get_code(e);
  if(event_code == LV_EVENT_CLICKED) {
    // Get row number from button user data
    uint8_t row = (uint8_t)(uintptr_t)lv_obj_get_user_data(btn);
    toggleBuzzerState(row);

    // Update only the clicked button's appearance (no screen refresh needed)
    lv_label_set_text(btn, buzzer_states[row] ? " ON " : " OFF ");
    lv_obj_set_style_bg_color(btn,
      buzzer_states[row] ? lv_color_hex(0x00AA00) : lv_color_hex(0xCC0000),
      LV_PART_MAIN | LV_STATE_DEFAULT);
  }
}

void setup() {
  Serial.begin(115200);
  SerialPort.begin(115200, SERIAL_8N1, 18, 17);

  delay(1000);  // Wait for serial to initialize

  delay(10);

  // Init Display
  gfx->begin();
#ifdef TFT_BL
  pinMode(TFT_BL, OUTPUT);
  digitalWrite(TFT_BL, HIGH);
  ledcSetup(0, 5000, 10);
  ledcAttachPin(TFT_BL, 0);
  ledcWrite(0, 1023); /* Screen brightness can be modified by adjusting this parameter. (0-1023) */
#endif
  delay(500);

  // Loading screen with centered bus4x4 logo
  int logoX = (800 - 300) / 2;  // Center horizontally (800px wide display, 300px logo)
  int logoY = (480 - 59) / 2;   // Center vertically (480px tall display, 59px logo)

  // Use LVGL approach - access via struct and cast to uint16_t for Arduino GFX
  extern const lv_img_dsc_t logo_300px;  // Clean identifier for struct access

  for (int i = 0; i < 4; i++) {
    gfx->fillScreen(BLACK);
    gfx->draw16bitRGBBitmap(logoX, logoY, (uint16_t *)logo_300px.data, 300, 59);

    // Draw loading text with progressive dots below the logo
    gfx->setTextColor(WHITE);
    gfx->setTextSize(2);
    gfx->setCursor(320, logoY + 80);  // Position text below the logo
    gfx->print("Loading");
    for (int j = 0; j <= i; j++) {
      gfx->print(".");
    }

    delay(500);
  }
  lv_init();

  // Init touch device
  pinMode(TOUCH_GT911_RST, OUTPUT);
  digitalWrite(TOUCH_GT911_RST, LOW);
  delay(10);
  digitalWrite(TOUCH_GT911_RST, HIGH);
  delay(10);
  touch_init();
  screenWidth = gfx->width();
  screenHeight = gfx->height();
  // Increased buffer from 60 to 120 lines to reduce refresh frequency and minimize RGB display timing conflicts
  disp_draw_buf = (lv_color_t *)heap_caps_malloc(screenWidth * 120 * sizeof(lv_color_t), MALLOC_CAP_INTERNAL);
  if (!disp_draw_buf) {
    // Fallback to DMA-capable memory if internal SRAM is exhausted
    disp_draw_buf = (lv_color_t *)heap_caps_malloc(screenWidth * 120 * sizeof(lv_color_t), MALLOC_CAP_DMA);
  }

  if (!disp_draw_buf) {
    return; // Cannot proceed without display buffer
  } else {
    lv_disp_draw_buf_init(&draw_buf, disp_draw_buf, NULL, screenWidth * 120);  // 120 lines buffer

    /* Initialize the display */
    lv_disp_drv_init(&disp_drv);
    /* Change the following line to your display resolution */
    disp_drv.hor_res = screenWidth;
    disp_drv.ver_res = screenHeight;
    disp_drv.flush_cb = my_disp_flush;
    disp_drv.draw_buf = &draw_buf;
    lv_disp_drv_register(&disp_drv);

    /* Initialize the (dummy) input device driver */
    static lv_indev_drv_t indev_drv;
    lv_indev_drv_init(&indev_drv);
    indev_drv.type = LV_INDEV_TYPE_POINTER;
    indev_drv.read_cb = my_touchpad_read;
    lv_indev_drv_register(&indev_drv);
    ui_init();
  }
  create_seat_containers();
  initialize_seat_rows();
  initialize_seat_rows_labels();
  initialize_seat_columns();
  uint8_t numberAssignment = 0;
  for (int i = 0; i < 7; i++) {
    for (int j = 0; j < 4; j++) {
      seats[i][j].number = ++numberAssignment;
      seats[i][j].buckled = false;
      seats[i][j].taken = false;
      seats[i][j].visable = (j != 3); // H block initially hidden
    }
    dataArray[i] = false;
  }
  // Initialize error logging system (log data loaded from EEPROM later)
  CLEAR_ALL_DUPLICATE_ERRORS();  // OPTIMIZATION 3: Initialize bit field
  duplicateErrorShowTime = 0;

  // Initialize previous state tracking
  memset(prevDataArrayValid, false, sizeof(prevDataArrayValid));
  buckledSeats = 0;
  unbuckledSeats = 0;
  prevBuckledSeats = 0;
  prevUnbuckledSeats = 0;
  sideInfoNeedsUpdate = true; // Initial update needed

  // Initialize display with correct seat count values (0,0) instead of hardcoded placeholders
  lv_label_set_text(ui_BuckledSeatsLabel, "0");    // Force buckled count to 0
  lv_label_set_text(ui_UnuckledSeatsLabel, "0");    // Force unbuckled count to 0

  // Initialize progress bar to show white (empty vehicle) instead of half-red half-white
  lv_slider_set_range(ui_occupancySlider, 0, 1);
  lv_slider_set_value(ui_occupancySlider, 1, LV_ANIM_OFF);
  lv_obj_set_style_bg_color(ui_occupancySlider, lv_color_hex(COLOR_WHITE), LV_PART_MAIN | LV_STATE_DEFAULT);

  // Initialize row_timer array to prevent false positives in auto-switch logic
  for (int i = 0; i < 7; i++) {
    row_timer[i] = 0;  // Set to 0 so all rows appear inactive initially
  }

  toggleRight();
  make_four_seater();
  last_timeout_check = millis();  // Initialize timeout check timer
  for (int i = 0; i < 7; i++) {
    lv_obj_add_flag(ui_seatContainers[i], LV_OBJ_FLAG_HIDDEN);
  }

  // Initialize EEPROM and load persistent data
  EEPROM.begin(EEPROM_SIZE);

  // Load buzzer states
  EEPROM.readBytes(BUZZER_EEPROM_ADDR, buzzer_states, 7);

  // Validate EEPROM data (ensure values are 0 or 1)
  bool eeprom_valid = true;
  for (int i = 0; i < 7; i++) {
    if (buzzer_states[i] != 0 && buzzer_states[i] != 1) {
      eeprom_valid = false;
      break;
    }
  }

  // If EEPROM invalid, initialize to all enabled
  if (!eeprom_valid) {
    for (int i = 0; i < 7; i++) {
      buzzer_states[i] = 1;
    }
    EEPROM.writeBytes(BUZZER_EEPROM_ADDR, buzzer_states, 7);
    EEPROM.commit();
  }

  // Load error log from EEPROM for persistence across power cycles
  loadErrorLogFromEEPROM();

  // Send initial buzzer states to receiver (using unified 8-byte protocol)
  sendBuzzerStatesToMainC();

  // Initialize startup synchronization for reliable buzzer state delivery
  // Re-broadcast every 5 seconds for 15 seconds to ensure receiver gets the state
  startup_sync_active = true;
  startup_complete_time = millis() + 15000;  // 15 seconds from now
  last_buzzer_broadcast = millis();

  // Wait for initial timeout period to allow data collection
  while (millis() < seat_timeout) {
    // Process incoming serial data during startup delay
    processSerialNonBlocking();
    delay(1); // Small delay to prevent watchdog timeout
  }

  // Perform one-time layout detection after startup delay
  detectLayoutOneTime();

  // Force display update to detect seat errors after duplicate row checking
  forceDisplayRefresh();

  // Check for any errors logged during startup and show overlay if needed
  updateAllWarningIcons();
}


// printMemoryUsage() function removed - memory monitoring not needed

// Hybrid packet reception - handles both binary packets and text messages
// OPTIMIZATION: Changed textBuffer to char array to avoid String heap allocation
bool processBinaryPacket(Stream &stream, char* textBuffer, uint8_t textBufferSize, uint8_t &textIndex) {
  static uint8_t packet_buffer[32];
  static uint8_t packet_index = 0;
  static bool synced = false;

  while (stream.available()) {
    uint8_t byte = stream.read();

    // Check if this looks like text (ASCII printable or newline)
    // FIX: Added parentheses to fix operator precedence - prevents binary data from corrupting text buffer
    if (!synced && packet_index == 0 && ((byte >= 0x20 && byte <= 0x7E) || byte == '\n' || byte == '\r')) {
      // This is text data - handle as char buffer
      if (byte == '\n') {
        if (textIndex > 0) {
          textBuffer[textIndex] = '\0';  // Null-terminate
          processReceivedData(textBuffer);
          textIndex = 0;  // Reset buffer
        }
      } else if (byte != '\r' && textIndex < textBufferSize - 1) {
        textBuffer[textIndex++] = (char)byte;
      }
      continue;
    }

    if (!synced) {
      // Look for sync pattern 0xAA 0x55
      if (packet_index == 0 && byte == 0xAA) {
        packet_buffer[0] = byte;
        packet_index = 1;
      } else if (packet_index == 1 && byte == 0x55) {
        packet_buffer[1] = byte;
        packet_index = 2;
        synced = true;
      } else {
        packet_index = 0;
      }
    } else {
      // Receiving packet data
      packet_buffer[packet_index++] = byte;

      if (packet_index >= 32) {
        // Full packet received
        BinaryPacket *pkt = (BinaryPacket*)packet_buffer;
        processBinaryData(pkt);

        // Reset for next packet
        packet_index = 0;
        synced = false;
        return true;
      }
    }
  }
  return false;
}

// OPTIMIZATION: Changed to use char buffer instead of String
bool processSerialStream(Stream &stream, char* buffer, uint8_t bufferSize, uint8_t &bufferIndex, bool isMainPort) {
  // Handle hybrid binary/text packets from main port
  if (isMainPort) {
    return processBinaryPacket(stream, buffer, bufferSize, bufferIndex);
  }

  // Handle text commands from USB (for debugging)
  int processCount = 0;
  while (stream.available() && processCount < 10) {
    char c = stream.read();
    if (c == '\n') {
      bufferIndex = 0;  // Reset buffer
      return true;
    } else if (bufferIndex < bufferSize - 1) {
      buffer[bufferIndex++] = c;
    }
    processCount++;
  }
  return false;
}

void processSerialNonBlocking() {
  // OPTIMIZATION: Use char buffers instead of String
  static char portData[64] = "";
  static uint8_t portDataIndex = 0;
  static char usbData[64] = "";
  static uint8_t usbDataIndex = 0;
  static unsigned long lastProcessTime = 0;

  if (millis() - lastProcessTime < 20) return;

  if (processSerialStream(SerialPort, portData, sizeof(portData), portDataIndex, true) ||
      processSerialStream(Serial, usbData, sizeof(usbData), usbDataIndex, false)) {
    lastProcessTime = millis();
  }
}

//////////////
void loop() {
  // Version print every 30 seconds (minimal processing cost)
  static uint32_t last_version_print = 0;
  if (millis() - last_version_print >= 30000) {
    Serial.println("Version 112516 - AITSC.au");
    last_version_print = millis();
  }

  // Handle UI reset requests from reset buttons
  if (uiResetRequested) {
    delay(100); // Small delay before restart
    ESP.restart();
  }

  // Startup synchronization: Re-broadcast buzzer state periodically for 15 seconds
  // This ensures the receiver gets the saved state even if it starts later
  if (startup_sync_active) {
    uint32_t current_time = millis();

    // Check if startup sync period is complete
    if (current_time >= startup_complete_time) {
      startup_sync_active = false;
    } else {
      // OPTIMIZED: Re-broadcast every 5 seconds during startup sync period (reduced from 2s)
      if (current_time - last_buzzer_broadcast >= 5000) {
        sendBuzzerStatesToMainC();  // Using unified 8-byte protocol with alert ack state
        last_buzzer_broadcast = current_time;
      }
    }
  }

  // OPTIMIZED: Rate-limit serial processing to reduce polling overhead
  static uint32_t last_serial_check = 0;
  uint32_t current_time = millis();
  if (current_time - last_serial_check >= 20) {  // Check every 20ms for reduced overhead
    processSerialNonBlocking();
    last_serial_check = current_time;
  }

  handleSystemMonitoring();

  // Periodic buzzer-off error checking (every 10 seconds)
  static uint32_t last_buzzer_check = 0;
  if (current_time - last_buzzer_check >= 10000) {
    checkForBuzzerOffErrors();
    showWarningOverlay();  // Show overlay if new un-acknowledged errors were added
    last_buzzer_check = current_time;
  }

  if (toggleSide) {
    if (rightActive) {
      toggleLeft();
      toggleSide = false;
    } else {
      toggleRight();
      toggleSide = false;
    }
  }

  if (toggleLayout) {
    if (is_seven_seater) {
      make_four_seater();
      toggleLayout = false;
    } else {
      make_seven_seater();
      toggleLayout = false;
    }
  }

  // One-time layout detection removed from loop
  // Detection now happens once after startup delay (see setup())

  // Cache millis() at start of loop for reuse
  static uint32_t last_tick = 0;
  static uint32_t loop_start_time = millis();  // Track loop start for timeout optimization
  uint32_t current_tick = millis();

  // OPTIMIZATION: Only check row timeouts during first 15 seconds (startup period)
  // After initialization, rows remain in their detected state permanently
  // This eliminates ongoing overhead - rows don't change after startup
  if ((current_tick - loop_start_time) < 15000) {
    if (current_tick - last_timeout_check >= 1000) {
      for (int i = 0; i < 7; i++) {
        if (isRowInactive(i, current_tick)) {
          for (int j = 0; j < 4; j++) {
            lv_obj_add_flag(seat_columns_container[i][j], LV_OBJ_FLAG_HIDDEN);
          }
        }
      }
      last_timeout_check = current_tick;
    }
  }

  // Update side info only when needed (when passenger counts changed)
  if (sideInfoNeedsUpdate) {
    updateSideInfo();
    sideInfoNeedsUpdate = false;
  }
  if (current_tick - last_tick >= 300) {  // 500ms works safely. leave it at 300ms for now.
    lv_timer_handler();
    last_tick = current_tick;
  }

  // OPTIMIZATION: Duplicate error overlay updated directly when error detected in processBinaryData()
  // No need for continuous checking in loop - overlay shown immediately on error, cleared on reset
  // Removed: updateDuplicateErrorOverlay();

  // Error timeout handling removed - all handled by main.c

  // OPTIMIZATION 4: Unified warning icon management
  // Note: Warning icons now updated by updateAllWarningIcons() via log system

  // Screen change detection for cleanup
  static lv_obj_t* last_screen = NULL;
  lv_obj_t* current_screen = lv_scr_act();
  if (last_screen != current_screen) {
    if (last_screen != NULL && current_screen == ui_Screen1) {
      // Returning to main screen from another screen, cleanup overlays
      cleanupErrorOverlays();

      // IMMEDIATELY re-show warning overlay if unacknowledged errors exist
      // This prevents the flicker when returning from menu screens
      updateAllWarningIcons();  // This calls showWarningOverlay() internally
    }
    last_screen = current_screen;
  }
}


// Binary data processing - directly render pre-computed visual states
void processBinaryData(BinaryPacket *pkt) {
  processingRow = pkt->row;

  if (processingRow < 0 || processingRow > 6) {
    return;
  }

  // CRITICAL: Always update row timer FIRST, even when data is paused
  // This ensures buzzer check can detect active rows even when error overlay is shown
  row_timer[processingRow] = millis();

  // Data pause for all errors - stop processing (but timer is still updated above)
  if (dataPaused) {
    return;
  }

  // Update door flag
  doorFlag = pkt->door;

  // Handle error codes - check for duplicate transmitter
  // OPTIMIZED: Direct integer comparison instead of String allocation
  bool hasAnyErrors = false;
  if (pkt->errors != 0) {
    if (pkt->errors == 1) {
      // Duplicate transmitter detected
      if (!HAS_DUPLICATE_ERROR(processingRow)) {
        addLogEntry("Duplicate Row Detected");
        SET_DUPLICATE_ERROR(processingRow);
        dataPaused = true;  // Pause data for duplicate errors
        hasAnyErrors = true;
      }
    }
  }

  // Check for seat hardware errors (same logic as main.c)
  for (int seatNum = 0; seatNum < 4; seatNum++) {
    char seatLetter = 'A' + seatNum;
    bool occupied = (pkt->seats[seatNum].occupied == 0);    // 0=occupied, 1=unoccupied
    bool buckled = (pkt->seats[seatNum].buckled == 1);      // 1=buckled, 0=unbuckled
    bool statusActive = (pkt->seats[seatNum].status == 0);  // 0=active, 1=inactive

    // ERROR 1: Belt buckled but seat NOT occupied
    if (buckled && !occupied) {
      char errorMsg[64];
      snprintf(errorMsg, sizeof(errorMsg), "Row %d Seat %c belt buckled but seat not occupied",
               processingRow + 1, seatLetter);
      addLogEntry(errorMsg);
      hasAnyErrors = true;
    }

    // ERROR 2: Seat occupied but status pin NOT activated
    if (occupied && !statusActive) {
      char errorMsg[64];
      snprintf(errorMsg, sizeof(errorMsg), "Row %d Seat %c occupied but status pin not activated",
               processingRow + 1, seatLetter);
      addLogEntry(errorMsg);
      hasAnyErrors = true;
    }

    // ERROR 3: Belt buckled but status pin NOT activated
    if (buckled && !statusActive) {
      char errorMsg[64];
      snprintf(errorMsg, sizeof(errorMsg), "Row %d Seat %c belt buckled but status pin not activated",
               processingRow + 1, seatLetter);
      addLogEntry(errorMsg);
      hasAnyErrors = true;
    }
  }

  // Show warning overlay if any errors detected (priority logic inside function)
  // Note: row_timer is updated at the start of processBinaryData(), before dataPaused check
  if (hasAnyErrors) {
    showWarningOverlay();
  }

  // Update seatDataArray for compatibility with existing code
  for (int i = 0; i < 4; i++) {
    int baseIdx = i * 3;
    seatDataArray[baseIdx] = pkt->seats[i].occupied;     // 0=occupied, 1=unoccupied
    seatDataArray[baseIdx + 1] = pkt->seats[i].buckled;  // 1=buckled, 0=unbuckled
    seatDataArray[baseIdx + 2] = pkt->seats[i].status;   // 0=active, 1=inactive
  }

  // Check if data changed
  bool dataChanged = hasRowDataChanged(processingRow);
  if (!dataChanged) {
    return;
  }

  // Process each seat with pre-computed colors
  for (int seatNum = 0; seatNum < 4; seatNum++) {
    // Calculate new seat state before updating
    bool newVisible = (pkt->seats[seatNum].status == 0);  // 0=active, 1=inactive
    bool newTaken = (pkt->seats[seatNum].occupied == 0);   // 0=occupied, 1=unoccupied
    bool newBuckled = (pkt->seats[seatNum].buckled == 1);  // 1=buckled, 0=unbuckled

    // OPTIMIZATION: Update counts incrementally before changing state
    updateSeatCount(processingRow, seatNum, newTaken, newBuckled, newVisible);

    // Handle visibility based on status pin
    if (pkt->seats[seatNum].status == 1) {  // Inactive
      lv_obj_add_flag(seat_columns_container[processingRow][seatNum], LV_OBJ_FLAG_HIDDEN);
      seats[processingRow][seatNum].visable = false;
      if (seatNum == 3) {
        dataArray[processingRow] = false;
        bolck_processing();
      }
    } else {  // Active
      lv_obj_clear_flag(seat_columns_container[processingRow][seatNum], LV_OBJ_FLAG_HIDDEN);
      seats[processingRow][seatNum].visable = true;
      if (seatNum == 3) {
        dataArray[processingRow] = true;
        bolck_processing();
      }
    }

    // Update seat state
    seats[processingRow][seatNum].taken = newTaken;
    seats[processingRow][seatNum].buckled = newBuckled;

    // Apply pre-computed color directly (no interpretation needed!)
    uint32_t bgColor, textColor;
    switch (pkt->seats[seatNum].color) {
      case 0:  // BLACK - empty seat
        bgColor = COLOR_BLACK;
        textColor = COLOR_LIGHT_GRAY;
        break;
      case 1:  // RED - occupied+unbuckled warning
        bgColor = COLOR_RED;
        textColor = COLOR_LIGHT_GRAY;
        break;
      case 2:  // LIGHT_GRAY - occupied+buckled safe
        bgColor = COLOR_LIGHT_GRAY;
        textColor = COLOR_DARK_GRAY;
        break;
      case 3:  // ORANGE - error state
        bgColor = COLOR_ORANGE;
        textColor = COLOR_LIGHT_GRAY;
        break;
      default:
        bgColor = COLOR_BLACK;
        textColor = COLOR_LIGHT_GRAY;
        break;
    }

    setSeatVisualState(processingRow, seatNum, bgColor, textColor);
  }

  // Save state and flush visual updates
  saveRowState(processingRow);
  flushVisualUpdates();
  sideInfoNeedsUpdate = true;
}






// Legacy text protocol handler - now only handles ERROR/CLEAR messages
// Helper function to expand compact error format to human-readable message
// Compact format: "E:R1SA:1\n" (9 bytes + newline)
// Expanded format: "Row 1 Seat A belt buckled but seat not occupied"
void expandCompactError(const char* compact, char* expanded, size_t maxLen) {
  // CRITICAL: Always initialize output buffer to prevent gibberish on early return
  expanded[0] = '\0';

  // Parse compact format directly - don't use strlen() on UART data!
  // Format positions: E:R{row}S{seat}:{type}
  // Example:          E:R1SA:1\n
  // Positions:        0123456789

  int row = compact[3] - '0';       // Extract row number (position 3)
  char seat = compact[5];            // Extract seat letter (position 5: A/B/C/D)
  int errorType = compact[7] - '0';  // Extract error type (position 7: 1/2/3)

  // Validate extracted values before using them
  if (row < 1 || row > 7 || errorType < 1 || errorType > 3) {
    snprintf(expanded, maxLen, "Invalid error format");
    return;
  }

  // Build human-readable message based on error type
  const char* errorMessages[] = {
    "",  // Index 0 unused
    "belt buckled but seat not occupied",      // Type 1
    "occupied but status pin not activated",   // Type 2
    "belt buckled but status pin not activated" // Type 3
  };

  snprintf(expanded, maxLen, "Row %d Seat %c %s", row, seat, errorMessages[errorType]);
}

// Seat data now processed via binary protocol in processBinaryData()
// OPTIMIZATION: Changed to use char* instead of String to avoid heap allocation
void processReceivedData(const char* input) {
  // Skip leading whitespace
  while (*input == ' ' || *input == '\t' || *input == '\r' || *input == '\n') {
    input++;
  }

  // Handle COMPACT ERROR format from optimized main.c (format: "E:R2SB:1")
  if (input[0] == 'E' && input[1] == ':' && input[2] == 'R') {
    char expandedMessage[128];
    expandCompactError(input, expandedMessage, sizeof(expandedMessage));
    addLogEntry(expandedMessage);

    // Show warning overlay if there are un-acknowledged errors
    showWarningOverlay();
    return;
  }

  // Handle COMPACT CLEAR format from optimized main.c (format: "C:R2SB:1")
  // NOTE: Clear messages are received but NOT removed from error log
  // This ensures errors remain in the history even if they auto-resolve before user acknowledgment
  // Errors can only be cleared via "Display Reset" button for complete historical record
  if (input[0] == 'C' && input[1] == ':' && input[2] == 'R') {
    char expandedMessage[128];
    expandCompactError(input, expandedMessage, sizeof(expandedMessage));
    // removeSpecificError(expandedMessage);  // Commented out to preserve error history
    return;
  }

  // Unknown format - should never happen (only E:/C: error messages and binary packets expected)
}


// Check if seat data has changed for the given row
bool hasRowDataChanged(uint8_t row) {
  if (!prevDataArrayValid[row]) {
    return true; // First time receiving data for this row
  }

  // Compare current seatDataArray with previous state
  for (int i = 0; i < SEAT_DATA_LENGTH; i++) {
    if (seatDataArray[i] != prevSeatDataArray[row][i]) {
      return true; // Data has changed
    }
  }
  return false; // No changes detected
}

// Save current seat data as previous state
void saveRowState(uint8_t row) {
  for (int i = 0; i < SEAT_DATA_LENGTH; i++) {
    prevSeatDataArray[row][i] = seatDataArray[i];
  }
  prevDataArrayValid[row] = true;
}

// Force display to refresh on next data packet by invalidating all row states
void forceDisplayRefresh() {
  for (int i = 0; i < 7; i++) {
    prevDataArrayValid[i] = false;
  }
}

// OPTIMIZATION: Incremental seat count update - O(1) instead of O(n)
// Updates global buckled/unbuckled counters based on state change
void updateSeatCount(uint8_t row, uint8_t seatNum, bool newTaken, bool newBuckled, bool visible) {
  // Get previous state
  bool wasTaken = seats[row][seatNum].taken;
  bool wasBuckled = seats[row][seatNum].buckled;
  bool wasVisible = seats[row][seatNum].visable;

  // Calculate old contribution to counts
  bool wasCountedBuckled = (wasTaken && wasBuckled && wasVisible);
  bool wasCountedUnbuckled = (wasTaken && !wasBuckled && wasVisible);

  // Calculate new contribution to counts
  bool nowCountedBuckled = (newTaken && newBuckled && visible);
  bool nowCountedUnbuckled = (newTaken && !newBuckled && visible);

  // Update counters incrementally
  if (wasCountedBuckled && !nowCountedBuckled && buckledSeats > 0) {
    buckledSeats--;
  } else if (!wasCountedBuckled && nowCountedBuckled) {
    buckledSeats++;
  }

  if (wasCountedUnbuckled && !nowCountedUnbuckled && unbuckledSeats > 0) {
    unbuckledSeats--;
  } else if (!wasCountedUnbuckled && nowCountedUnbuckled) {
    unbuckledSeats++;
  }
}

// process_row_information() removed - fully replaced by processBinaryData()
// Old function interpreted sensor data and determined colors (redundant)
// New binary protocol receives pre-computed colors from main.c

// OPTIMIZATION: Updates the side panel using incrementally maintained counts
// Counts are now updated in O(1) by updateSeatCount() instead of O(n) recalculation
void updateSideInfo() {
  // Check if passenger counts have changed
  if (buckledSeats == prevBuckledSeats && unbuckledSeats == prevUnbuckledSeats) {
    // No change in passenger counts - skip UI updates
    return;
  }

  // Update previous state trackers
  prevBuckledSeats = buckledSeats;
  prevUnbuckledSeats = unbuckledSeats;

  // OPTIMIZATION: Use static char buffers instead of String allocation for numeric display
  // Maximum 2 digits + null terminator for seat counts (0-28 possible)
  static char buckledBuf[4];
  static char unbuckledBuf[4];

  itoa(buckledSeats, buckledBuf, 10);
  itoa(unbuckledSeats, unbuckledBuf, 10);

  // Update the numeric displays with current counts
  lv_label_set_text(ui_BuckledSeatsLabel, buckledBuf);    // Display buckled count
  lv_label_set_text(ui_UnuckledSeatsLabel, unbuckledBuf); // Display unbuckled count

  // Calculate total occupied seats and update the progress bar (slider)
  uint8_t occ_seats = buckledSeats + unbuckledSeats;
  if (occ_seats > 0) {
    // Set slider range from 0 to total occupied seats
    lv_slider_set_range(ui_occupancySlider, 0, occ_seats);
    // Set slider value to show ratio of buckled seats (progress bar effect)
    lv_slider_set_value(ui_occupancySlider, buckledSeats, LV_ANIM_OFF);
    // Set normal red background for occupied seats
    lv_obj_set_style_bg_color(ui_occupancySlider, lv_color_hex(COLOR_RED), LV_PART_MAIN | LV_STATE_DEFAULT);
  } else {
    // If all unoccupied, make the entire progress bar white
    lv_slider_set_range(ui_occupancySlider, 0, 1);
    lv_slider_set_value(ui_occupancySlider, 1, LV_ANIM_OFF);
    lv_obj_set_style_bg_color(ui_occupancySlider, lv_color_hex(COLOR_WHITE), LV_PART_MAIN | LV_STATE_DEFAULT);
  }
  
  // Update background colors based on safety status
  // Red background (0xEC1E45) indicates danger/warning, White (0xFEFEFE) indicates safe/normal

  // Unbuckled seats indicator: Red if no buckled seats (all unsafe), White if some are buckled
  lv_obj_set_style_bg_color(ui_UnbuckledBG, lv_color_hex(buckledSeats == 0 ? COLOR_RED : COLOR_WHITE), LV_PART_MAIN | LV_STATE_DEFAULT);

  // Buckled seats indicator: White if no unbuckled seats (all safe), Red if some are unbuckled
  lv_obj_set_style_bg_color(ui_BuckledBG, lv_color_hex(unbuckledSeats == 0 ? COLOR_WHITE : COLOR_RED), LV_PART_MAIN | LV_STATE_DEFAULT);
  if (unbuckledSeats == 0 && buckledSeats == occ_seats) {
    // All passengers buckled - show white LVGL overlay
    if (is_four_seater) {
      lv_obj_clear_flag(ui_WhiteOutline4Full, LV_OBJ_FLAG_HIDDEN);
      lv_obj_add_flag(ui_WhiteOutline7Full, LV_OBJ_FLAG_HIDDEN);
    } else if (is_seven_seater) {
      lv_obj_clear_flag(ui_WhiteOutline7Full, LV_OBJ_FLAG_HIDDEN);
      lv_obj_add_flag(ui_WhiteOutline4Full, LV_OBJ_FLAG_HIDDEN);
    }
  } else {
    // Not all buckled - hide white overlays to show red outline
    lv_obj_add_flag(ui_WhiteOutline4Full, LV_OBJ_FLAG_HIDDEN);
    lv_obj_add_flag(ui_WhiteOutline7Full, LV_OBJ_FLAG_HIDDEN);
  }
}
// OPTIMIZATION: Use pre-computed seat labels instead of runtime character arithmetic
void bolck_processing() {
  // Select position arrays once based on rightActive flag to avoid repeated ternary evaluations
  const lv_coord_t* y_pos = rightActive ? y_positions_right : y_positions_left;
  const lv_coord_t* y_pos_h = rightActive ? y_positions_right_h : y_positions_left_h;

  for (int i = 0; i < 7; i++) {
    if (!dataArray[i]) {
      lv_obj_add_flag(ui_seatContainers[i], LV_OBJ_FLAG_HIDDEN);
      seats[i][3].visable = false;

      for (int j = 0; j < 4; j++) {
        if (j < 3) {
          lv_label_set_text(seat_rows_lebels_container[i][j], seat_labels[i][j]);
        } else {
          lv_label_set_text(seat_rows_lebels_container[i][j], "");
        }
        lv_obj_set_y(seat_columns_container[i][j], y_pos[j]);
      }
    } else {
      seats[i][3].visable = true;
      lv_obj_clear_flag(ui_seatContainers[i], LV_OBJ_FLAG_HIDDEN);

      for (int j = 0; j < 4; j++) {
        lv_label_set_text(seat_rows_lebels_container[i][j], seat_labels[i][j]);
        lv_obj_set_y(seat_columns_container[i][j], y_pos_h[j]);
      }
    }
  }
  sideInfoNeedsUpdate = true; // Mark that side info needs updating after layout change
}

void handleSystemMonitoring() {
  static bool firstConnection = true;
  static uint32_t lastDataTime = 0;
  static uint32_t communicationTimeoutWarned = 0;
  static int previousDoorFlag = -1;

  uint32_t currentTime = millis();
  
  // Communication monitoring
  if (SerialPort.available()) {
    if (firstConnection) {
      firstConnection = false;
    }
    lastDataTime = currentTime;
    if (communicationTimeoutWarned > 0) {
      communicationTimeoutWarned = 0;
    }
  } else if (lastDataTime > 0 && currentTime - lastDataTime > 30000 && communicationTimeoutWarned == 0) {
    communicationTimeoutWarned = currentTime;
  }

  // Door status monitoring and muted label logic
  static uint32_t doorCloseTime = 0;
  static bool wasDoorOpen = true;
  static uint32_t lastMutedUpdate = 0;
  
  // Track door state changes
  if (previousDoorFlag != doorFlag) {
    updateDoorDisplay();  // Update display when door status changes or on first data

    if (doorFlag == 1 && !wasDoorOpen) {
      // Door just opened
      wasDoorOpen = true;
      doorCloseTime = 0;
      lv_obj_add_flag(ui_MutedLabel, LV_OBJ_FLAG_HIDDEN);  // Hide muted label
    } else if (doorFlag == 0 && wasDoorOpen) {
      // Door just closed
      wasDoorOpen = false;
      doorCloseTime = currentTime;
    }
  }
  previousDoorFlag = doorFlag;
  
  // Update muted label countdown during buzzer delay (20 seconds after door closes)
  if (doorFlag == 0 && doorCloseTime > 0) {
    uint32_t timeSinceClosed = currentTime - doorCloseTime;
    if (timeSinceClosed < 20000) {
      // OPTIMIZATION: Use static buffer instead of String allocation for countdown
      static char mutedText[12]; // "Loading [20]" max 11 chars + null
      uint32_t remainingSeconds = (20000 - timeSinceClosed + 999) / 1000; // Round up
      snprintf(mutedText, sizeof(mutedText), "Loading %lu", remainingSeconds);
      lv_label_set_text(ui_MutedLabel, mutedText);
      lv_obj_clear_flag(ui_MutedLabel, LV_OBJ_FLAG_HIDDEN);  // Show muted label

      // Update every 500ms to avoid too frequent updates
      if (currentTime - lastMutedUpdate > 500) {
        lastMutedUpdate = currentTime;
      }
    } else {
      // Muted period ended - hide label
      lv_obj_add_flag(ui_MutedLabel, LV_OBJ_FLAG_HIDDEN);
    }
  } else {
    // Door is open or no close time recorded - hide muted label
    lv_obj_add_flag(ui_MutedLabel, LV_OBJ_FLAG_HIDDEN);
  }

  // Memory monitoring removed - not needed
}