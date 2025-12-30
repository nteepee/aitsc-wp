cmake_minimum_required(VERSION 3.16)

# Must be BEFORE project()
include(pico_sdk_import.cmake)

project(my_project C CXX ASM)

# Init SDK
pico_sdk_init()

# Receiver executable (from main.c)
add_executable(receiver
    main.c
)

# stdio (won't wait for USB)
pico_enable_stdio_usb(receiver 1)
pico_enable_stdio_uart(receiver 1)

# libs your code needs
target_link_libraries(receiver
    pico_stdlib
    hardware_uart
    hardware_pwm
)

# produce .elf/.bin/.uf2 (uses picotool under the hood)
pico_add_extra_outputs(receiver)

# Transmitter executable (from transmitter.c)
add_executable(transmitter
    transmitter.c
)

# stdio (won't wait for USB)
pico_enable_stdio_usb(transmitter 1)
pico_enable_stdio_uart(transmitter 1)

# libs your code needs
target_link_libraries(transmitter
    pico_stdlib
    hardware_uart
    hardware_pwm
)

# produce .elf/.bin/.uf2 (uses picotool under the hood)
pico_add_extra_outputs(transmitter)
