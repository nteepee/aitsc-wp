// Memory-efficient Info Screen implementation for DisplayV9
// Replaces heavy tabview with simple individual screens
// LVGL version: 8.3.11

#include "ui.h"

// Helper function to create standardized back button (Material Design Rounded Text button)
static lv_obj_t* create_back_button(lv_obj_t* parent, void (*event_cb)(lv_event_t*))
{
    lv_obj_t* backBtn = lv_btn_create(parent);
    lv_obj_set_size(backBtn, 80, 40);
    lv_obj_set_pos(backBtn, 10, 10);
    lv_obj_set_style_bg_opa(backBtn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Transparent bg
    lv_obj_set_style_border_width(backBtn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_radius(backBtn, 20, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 20px pill shape
    lv_obj_set_style_shadow_width(backBtn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state: subtle opacity overlay
    lv_obj_set_style_bg_opa(backBtn, 31, LV_PART_MAIN | LV_STATE_PRESSED);  // 0.12 opacity overlay
    lv_obj_set_style_bg_color(backBtn, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_PRESSED);

    lv_obj_add_event_cb(backBtn, event_cb, LV_EVENT_CLICKED, NULL);

    lv_obj_t* backLabel = lv_label_create(backBtn);
    lv_label_set_text(backLabel, "< Back");
    lv_obj_set_style_text_color(backLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light text on dark bg
    lv_obj_set_style_text_font(backLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large
    lv_obj_center(backLabel);

    return backBtn;
}

// Helper function to create standardized menu button (Material Design Rounded Outlined style)
static lv_obj_t* create_menu_button(lv_obj_t* parent, const char* label_text,
                                     int x, int y, int width, int height,
                                     void (*event_cb)(lv_event_t*))
{
    lv_obj_t* btn = lv_btn_create(parent);
    lv_obj_set_size(btn, width, height);
    lv_obj_set_pos(btn, x, y);

    // Material Design Rounded Outlined button style
    lv_obj_set_style_bg_opa(btn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // Transparent bg
    lv_obj_set_style_border_color(btn, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light border
    lv_obj_set_style_border_width(btn, 2, LV_PART_MAIN | LV_STATE_DEFAULT);  // 2px border
    lv_obj_set_style_radius(btn, 40, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 40px highly rounded
    lv_obj_set_style_shadow_width(btn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state: subtle background overlay
    lv_obj_set_style_bg_opa(btn, 31, LV_PART_MAIN | LV_STATE_PRESSED);  // 0.12 opacity overlay
    lv_obj_set_style_bg_color(btn, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_PRESSED);

    lv_obj_add_event_cb(btn, event_cb, LV_EVENT_CLICKED, NULL);

    lv_obj_t* label = lv_label_create(btn);
    lv_label_set_text(label, label_text);
    lv_obj_set_style_text_font(label, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large (14sp)
    lv_obj_set_style_text_color(label, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light text
    lv_obj_center(label);

    return btn;
}

// Menu screen with navigation buttons
void ui_InfoScreen_screen_init(void)
{
    // Create main menu screen
    ui_InfoScreen = lv_obj_create(NULL);
    lv_obj_clear_flag(ui_InfoScreen, LV_OBJ_FLAG_SCROLLABLE);
    lv_obj_set_style_bg_color(ui_InfoScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_InfoScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Create back button (top-left)
    ui_InfoBackButton = create_back_button(ui_InfoScreen, ui_event_InfoBackButton);

    // Create navigation buttons (3x2 grid with Display Reset button)
    const int btn_width = 160;
    const int btn_height = 80;
    const int btn_spacing = 40;
    const int start_x = (800 - (2 * btn_width + btn_spacing)) / 2;
    const int start_y = 120;

    // About button
    create_menu_button(ui_InfoScreen, "About",
        start_x + btn_width + btn_spacing, start_y + btn_height + btn_spacing,
        btn_width, btn_height,
        ui_event_AboutButton);

    // Log button with warning icon (Material Design Rounded Outlined style)
    lv_obj_t * logBtn = lv_btn_create(ui_InfoScreen);
    lv_obj_set_size(logBtn, btn_width, btn_height);
    lv_obj_set_pos(logBtn, start_x + btn_width + btn_spacing, start_y);

    // Material Design Rounded Outlined button style
    lv_obj_set_style_bg_opa(logBtn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // Transparent bg
    lv_obj_set_style_border_color(logBtn, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light border
    lv_obj_set_style_border_width(logBtn, 2, LV_PART_MAIN | LV_STATE_DEFAULT);  // 2px border
    lv_obj_set_style_radius(logBtn, 40, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 40px highly rounded
    lv_obj_set_style_shadow_width(logBtn, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state
    lv_obj_set_style_bg_opa(logBtn, 31, LV_PART_MAIN | LV_STATE_PRESSED);  // 0.12 opacity overlay
    lv_obj_set_style_bg_color(logBtn, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_PRESSED);

    lv_obj_add_event_cb(logBtn, ui_event_LogButton, LV_EVENT_CLICKED, NULL);

    lv_obj_t * logLabel = lv_label_create(logBtn);
    lv_label_set_text(logLabel, "Log");
    lv_obj_set_style_text_font(logLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large (14sp)
    lv_obj_set_style_text_color(logLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light text
    lv_obj_center(logLabel);

    // Log warning icon
    ui_LogTabWarningIcon = lv_obj_create(logBtn);
    lv_obj_set_size(ui_LogTabWarningIcon, 36, 36);
    lv_obj_set_pos(ui_LogTabWarningIcon, btn_width - 70, 12);
    lv_obj_set_style_radius(ui_LogTabWarningIcon, 36, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_color(ui_LogTabWarningIcon, lv_color_hex(0xFFA500), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_border_width(ui_LogTabWarningIcon, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_add_flag(ui_LogTabWarningIcon, LV_OBJ_FLAG_HIDDEN);
    lv_obj_clear_flag(ui_LogTabWarningIcon, LV_OBJ_FLAG_CLICKABLE);

    lv_obj_t * exclamation = lv_label_create(ui_LogTabWarningIcon);
    lv_label_set_text(exclamation, "!");
    lv_obj_set_style_text_font(exclamation, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_color(exclamation, lv_color_hex(0x000000), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_center(exclamation);

    // Help button
    create_menu_button(ui_InfoScreen, "Help",
        start_x, start_y + btn_height + btn_spacing,
        btn_width, btn_height,
        ui_event_HelpButton);

    // Drive Type button
    create_menu_button(ui_InfoScreen, "Drive Type",
        start_x, start_y,
        btn_width, btn_height,
        ui_event_DriveTypeButton);

    // Row settings button (positioned under About button)
    create_menu_button(ui_InfoScreen, "Row\nsettings",
        start_x + btn_width + btn_spacing, start_y + (btn_height + btn_spacing) * 2,
        btn_width, btn_height,
        ui_event_BuzzerControlButton);

    // Display Reset button (Material Design Rounded Filled button - critical action)
    // Access external variables from DisplayV9.ino
    extern lv_obj_t *ui_DuplicateErrorResetButton;
    extern lv_obj_t *ui_DuplicateErrorResetLabel;

    ui_DuplicateErrorResetButton = lv_btn_create(ui_InfoScreen);
    lv_obj_set_size(ui_DuplicateErrorResetButton, btn_width, btn_height);
    lv_obj_set_pos(ui_DuplicateErrorResetButton, start_x, start_y + (btn_height + btn_spacing) * 2);

    // Material Design Rounded Filled button style (critical action variant)
    lv_obj_set_style_bg_color(ui_DuplicateErrorResetButton, lv_color_hex(0xEC1E45), LV_PART_MAIN | LV_STATE_DEFAULT);  // Red for critical action
    lv_obj_set_style_bg_opa(ui_DuplicateErrorResetButton, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_border_width(ui_DuplicateErrorResetButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_radius(ui_DuplicateErrorResetButton, 40, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 40px highly rounded
    lv_obj_set_style_shadow_width(ui_DuplicateErrorResetButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state
    lv_obj_set_style_bg_opa(ui_DuplicateErrorResetButton, 220, LV_PART_MAIN | LV_STATE_PRESSED);  // Slightly darker when pressed

    lv_obj_add_event_cb(ui_DuplicateErrorResetButton, ui_event_DuplicateErrorResetButton, LV_EVENT_CLICKED, NULL);

    ui_DuplicateErrorResetLabel = lv_label_create(ui_DuplicateErrorResetButton);
    lv_label_set_text(ui_DuplicateErrorResetLabel, "Display Reset");
    lv_obj_set_style_text_font(ui_DuplicateErrorResetLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large (14sp)
    lv_obj_set_style_text_color(ui_DuplicateErrorResetLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light text on red bg
    lv_obj_center(ui_DuplicateErrorResetLabel);

    // Update warning icons to reflect current log state when screen initializes
    updateAllWarningIcons();
}

// Individual screen implementations for memory efficiency

// About Screen
void ui_AboutScreen_screen_init(void)
{
    ui_AboutScreen = lv_obj_create(NULL);
    lv_obj_clear_flag(ui_AboutScreen, LV_OBJ_FLAG_SCROLLABLE);
    lv_obj_set_style_bg_color(ui_AboutScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_AboutScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Back button
    create_back_button(ui_AboutScreen, ui_event_BackToMenu);

    // Title (Material Design: Headline - 22sp)
    lv_obj_t * titleLabel = lv_label_create(ui_AboutScreen);
    lv_label_set_text(titleLabel, "About");
    lv_obj_set_style_text_color(titleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(titleLabel, &lv_font_montserrat_28, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Headline
    lv_obj_set_pos(titleLabel, 50, 60);

    // About content (Material Design: Body Large - 16sp)
    lv_obj_t * aboutLabel = lv_label_create(ui_AboutScreen);
    lv_label_set_text(aboutLabel, "Passenger Monitoring System\nfor the Bus 4x4 Go Kit\n\nBus4x4\n\nThe preferred supplier of comfortable,\nsafe, cost-effective and reliable\n4WD Buses in Australia and globally\n\nThe Global Leader in 4x4 Conversions.\n1300 287 494\nenquiries@bus4x4.com.au\nwww.bus4x4.com.au");
    lv_obj_set_style_text_color(aboutLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(aboutLabel, &lv_font_montserrat_20, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Large
    lv_obj_set_pos(aboutLabel, 50, 100);
}

// Log Screen - Simplified to match warning overlay architecture
void ui_LogScreen_screen_init(void)
{
    // Create screen with scrolling enabled for viewing all 20 error entries
    ui_LogScreen = lv_obj_create(NULL);
    lv_obj_set_style_bg_color(ui_LogScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_LogScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Back button
    create_back_button(ui_LogScreen, ui_event_BackToMenu);

    // Title (Material Design: Headline - 22sp)
    lv_obj_t * titleLabel = lv_label_create(ui_LogScreen);
    lv_label_set_text(titleLabel, "Error Log");
    lv_obj_set_style_text_color(titleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(titleLabel, &lv_font_montserrat_28, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Headline
    lv_obj_set_pos(titleLabel, 50, 60);

    // Error counter label (Material Design: Body Medium - 14sp)
    ui_LogCounterLabel = lv_label_create(ui_LogScreen);
    lv_label_set_text(ui_LogCounterLabel, "Errors: 0");
    lv_obj_set_pos(ui_LogCounterLabel, 50, 95);
    lv_obj_set_style_text_color(ui_LogCounterLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(ui_LogCounterLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Medium

    // Log content (Material Design: Body Medium - 14sp)
    ui_LogTextArea = lv_label_create(ui_LogScreen);
    lv_obj_set_size(ui_LogTextArea, 760, 350);
    lv_obj_set_pos(ui_LogTextArea, 20, 120);
    lv_obj_set_style_text_color(ui_LogTextArea, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(ui_LogTextArea, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Medium
    lv_label_set_long_mode(ui_LogTextArea, LV_LABEL_LONG_WRAP);  // Simple text wrapping

    // Clear button (Secret developer button - invisible but functional)
    ui_ClearLogButton = lv_btn_create(ui_LogScreen);
    lv_obj_set_size(ui_ClearLogButton, 100, 40);
    lv_obj_set_pos(ui_ClearLogButton, 690, 10);

    // Make button completely invisible
    lv_obj_set_style_bg_opa(ui_ClearLogButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // Fully transparent background
    lv_obj_set_style_border_width(ui_ClearLogButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No border
    lv_obj_set_style_shadow_width(ui_ClearLogButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No shadow

    // Keep invisible even when pressed (no visual feedback)
    lv_obj_set_style_bg_opa(ui_ClearLogButton, 0, LV_PART_MAIN | LV_STATE_PRESSED);

    lv_obj_add_event_cb(ui_ClearLogButton, ui_event_ClearLogButton, LV_EVENT_CLICKED, NULL);

    lv_obj_t * clearLabel = lv_label_create(ui_ClearLogButton);
    lv_label_set_text(clearLabel, "Clear");
    lv_obj_set_style_text_font(clearLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_opa(clearLabel, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // Make text invisible
    lv_obj_center(clearLabel);

    // Populate using simplified updateLogDisplay() function
    updateLogDisplay();
}

// Help Screen
void ui_HelpScreen_screen_init(void)
{
    ui_HelpScreen = lv_obj_create(NULL);
    lv_obj_clear_flag(ui_HelpScreen, LV_OBJ_FLAG_SCROLLABLE);
    lv_obj_set_style_bg_color(ui_HelpScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_HelpScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Back button
    create_back_button(ui_HelpScreen, ui_event_BackToMenu);

    // Title (Material Design: Headline - 22sp)
    lv_obj_t * titleLabel = lv_label_create(ui_HelpScreen);
    lv_label_set_text(titleLabel, "Help");
    lv_obj_set_style_text_color(titleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(titleLabel, &lv_font_montserrat_28, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Headline
    lv_obj_set_pos(titleLabel, 50, 60);

    // Help content (Material Design: Body Medium - 14sp for better readability)
    lv_obj_t * helpLabel = lv_label_create(ui_HelpScreen);
    lv_label_set_text(helpLabel, "Troubleshooting:\n\n- Refer to manual for troubleshooting\n- Check error log for system messages\n\nColour Codes:\n- White: Occupied + Buckled (Compliant)\n- Red: Occupied + Unbuckled (Warning)\n- Black: Empty seat\n- Orange: Belt/Status Error\n\nEmail: contact@AITSC.au");
    lv_obj_set_style_text_color(helpLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(helpLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Medium
    lv_obj_set_pos(helpLabel, 50, 100);
}

// Drive Type Screen
void ui_DriveTypeScreen_screen_init(void)
{
    ui_DriveTypeScreen = lv_obj_create(NULL);
    lv_obj_clear_flag(ui_DriveTypeScreen, LV_OBJ_FLAG_SCROLLABLE);
    lv_obj_set_style_bg_color(ui_DriveTypeScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_DriveTypeScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Back button
    create_back_button(ui_DriveTypeScreen, ui_event_BackToMenu);

    // Title (Material Design: Headline - 22sp)
    lv_obj_t * titleLabel = lv_label_create(ui_DriveTypeScreen);
    lv_label_set_text(titleLabel, "Select Drive Type");
    lv_obj_set_style_text_color(titleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(titleLabel, &lv_font_montserrat_28, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Headline
    lv_obj_set_pos(titleLabel, 50, 60);

    // LHD Button (Material Design Rounded Filled button - unselected state)
    ui_LHDButton = lv_btn_create(ui_DriveTypeScreen);
    lv_obj_set_size(ui_LHDButton, 200, 80);
    lv_obj_set_pos(ui_LHDButton, 150, 150);
    lv_obj_set_style_radius(ui_LHDButton, 40, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 40px highly rounded
    lv_obj_set_style_bg_color(ui_LHDButton, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Unselected: light
    lv_obj_set_style_bg_opa(ui_LHDButton, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_border_width(ui_LHDButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_shadow_width(ui_LHDButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state
    lv_obj_set_style_bg_opa(ui_LHDButton, 220, LV_PART_MAIN | LV_STATE_PRESSED);  // Slightly darker when pressed

    lv_obj_add_event_cb(ui_LHDButton, ui_event_LHDButton, LV_EVENT_CLICKED, NULL);

    lv_obj_t * lhdLabel = lv_label_create(ui_LHDButton);
    lv_label_set_text(lhdLabel, "L\nLeft-Hand\nDrive");
    lv_obj_set_style_text_color(lhdLabel, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);  // Dark text
    lv_obj_set_style_text_font(lhdLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large
    lv_obj_center(lhdLabel);

    // RHD Button (Material Design Rounded Filled button - selected state)
    ui_RHDButton = lv_btn_create(ui_DriveTypeScreen);
    lv_obj_set_size(ui_RHDButton, 200, 80);
    lv_obj_set_pos(ui_RHDButton, 450, 150);
    lv_obj_set_style_radius(ui_RHDButton, 40, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 40px highly rounded
    lv_obj_set_style_bg_color(ui_RHDButton, lv_color_hex(0xEC1E45), LV_PART_MAIN | LV_STATE_DEFAULT);  // Selected: red
    lv_obj_set_style_bg_opa(ui_RHDButton, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_border_width(ui_RHDButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_shadow_width(ui_RHDButton, 0, LV_PART_MAIN | LV_STATE_DEFAULT);  // No elevation

    // Pressed state
    lv_obj_set_style_bg_opa(ui_RHDButton, 220, LV_PART_MAIN | LV_STATE_PRESSED);  // Slightly darker when pressed

    lv_obj_add_event_cb(ui_RHDButton, ui_event_RHDButton, LV_EVENT_CLICKED, NULL);

    lv_obj_t * rhdLabel = lv_label_create(ui_RHDButton);
    lv_label_set_text(rhdLabel, "R\nRight-Hand\nDrive");
    lv_obj_set_style_text_color(rhdLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);  // Light text
    lv_obj_set_style_text_font(rhdLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large
    lv_obj_center(rhdLabel);
}

// Row settings Screen - Simple list of toggle buttons for rows 1-7
void ui_BuzzerControlScreen_screen_init(void)
{
    // Access buzzer_states array from DisplayV9.ino
    extern uint8_t buzzer_states[7];
    extern unsigned long row_timer[7];
    extern int seat_timeout;

    ui_BuzzerControlScreen = lv_obj_create(NULL);
    lv_obj_clear_flag(ui_BuzzerControlScreen, LV_OBJ_FLAG_SCROLLABLE);
    lv_obj_set_style_bg_color(ui_BuzzerControlScreen, lv_color_hex(0x323232), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_bg_opa(ui_BuzzerControlScreen, 255, LV_PART_MAIN | LV_STATE_DEFAULT);

    // Back button
    create_back_button(ui_BuzzerControlScreen, ui_event_BackToMenu);

    // Title (Material Design: Headline - 22sp)
    lv_obj_t * titleLabel = lv_label_create(ui_BuzzerControlScreen);
    lv_label_set_text(titleLabel, "Row settings");
    lv_obj_set_style_text_color(titleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
    lv_obj_set_style_text_font(titleLabel, &lv_font_montserrat_28, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Headline
    lv_obj_set_pos(titleLabel, 50, 60);

    // Create row labels in a vertical list - only show active rows (transmitters sending data)
    const int start_x = 50;
    const int start_y = 140;
    const int spacing = 45;

    uint32_t current_time = millis();
    int display_row = 0;  // Track vertical position for active rows only

    for (int i = 0; i < 7; i++) {
        // Check if row is active (same pattern as detectLayoutOneTime)
        if (row_timer[i] > 0 && (current_time - row_timer[i] < seat_timeout)) {
            // Row label (non-clickable text)
            char row_text[16];
            snprintf(row_text, 16, "Row %d:", i + 1);

            lv_obj_t * rowLabel = lv_label_create(ui_BuzzerControlScreen);
            lv_label_set_text(rowLabel, row_text);
            lv_obj_set_pos(rowLabel, start_x, start_y + display_row * spacing);
            lv_obj_set_style_text_font(rowLabel, &lv_font_montserrat_20, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Large
            lv_obj_set_style_text_color(rowLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);

            // "Buzzer" label (Material Design: Body Large - 16sp)
            lv_obj_t * buzzerLabel = lv_label_create(ui_BuzzerControlScreen);
            lv_label_set_text(buzzerLabel, "Buzzer");
            lv_obj_set_pos(buzzerLabel, start_x + 130, start_y + display_row * spacing);
            lv_obj_set_style_text_font(buzzerLabel, &lv_font_montserrat_20, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Body Large
            lv_obj_set_style_text_color(buzzerLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);

            // Button-styled toggle label (ON/OFF) - Material Design Rounded pill-shaped
            lv_obj_t * toggleLabel = lv_label_create(ui_BuzzerControlScreen);
            lv_label_set_text(toggleLabel, buzzer_states[i] ? " ON " : " OFF ");
            lv_obj_set_pos(toggleLabel, start_x + 230, start_y + display_row * spacing - 5);
            lv_obj_set_style_text_font(toggleLabel, &lv_font_montserrat_18, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design: Label Large

            // Material Design Rounded button styling (pill-shaped)
            lv_obj_set_style_bg_opa(toggleLabel, 255, LV_PART_MAIN | LV_STATE_DEFAULT);
            lv_obj_set_style_bg_color(toggleLabel,
                buzzer_states[i] ? lv_color_hex(0x00AA00) : lv_color_hex(0xCC0000),
                LV_PART_MAIN | LV_STATE_DEFAULT);
            lv_obj_set_style_text_color(toggleLabel, lv_color_hex(0xFAFAFA), LV_PART_MAIN | LV_STATE_DEFAULT);
            lv_obj_set_style_radius(toggleLabel, 20, LV_PART_MAIN | LV_STATE_DEFAULT);  // Material Design Rounded: 20px pill-shaped
            lv_obj_set_style_pad_all(toggleLabel, 8, LV_PART_MAIN | LV_STATE_DEFAULT);

            // Make toggle clickable
            lv_obj_add_flag(toggleLabel, LV_OBJ_FLAG_CLICKABLE);
            lv_obj_set_user_data(toggleLabel, (void*)(uintptr_t)i);
            lv_obj_add_event_cb(toggleLabel, ui_event_BuzzerToggle, LV_EVENT_CLICKED, NULL);

            display_row++;  // Increment position counter only for active rows
        }
    }
}