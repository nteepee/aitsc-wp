#!/usr/bin/env python3
"""
Quick script to move all image data from program flash to PSRAM
This will save ~1.5-2MB of program memory
"""

import os
import re

# List of image files to modify
image_files = [
    "DisplayV9/ui_img_bus7_png.c",
    "DisplayV9/ui_img_sbus1_png.c",
    "DisplayV9/ui_img_stearing_png.c",
    "DisplayV9/ui_img_top4_png.c",
    "DisplayV9/ui_img_wh_bg_bus_png.c",
    "DisplayV9/ui_img_wh_bg_sbus_png.c"
]

def fix_image_file(filepath):
    """Move image data to PSRAM section"""
    try:
        with open(filepath, 'r') as f:
            content = f.read()

        # Pattern to match image data declaration
        pattern = r'const LV_ATTRIBUTE_MEM_ALIGN uint8_t (ui_img_\w+_data)\[\] = \{'
        replacement = r'const LV_ATTRIBUTE_MEM_ALIGN uint8_t \1[] __attribute__((section(".psram_data"))) = {'

        # Apply the fix
        new_content = re.sub(pattern, replacement, content)

        # Also add comment about PSRAM storage
        new_content = new_content.replace(
            "// IMAGE DATA: assets/",
            "// IMAGE DATA: assets/",
        )
        new_content = new_content.replace(
            "// IMAGE DATA: assets/",
            "// IMAGE DATA (PSRAM): assets/"
        )

        # Write back the modified content
        with open(filepath, 'w') as f:
            f.write(new_content)

        print(f"✅ Fixed {filepath}")
        return True

    except Exception as e:
        print(f"❌ Error fixing {filepath}: {e}")
        return False

def main():
    print("🚀 Moving image data from program flash to PSRAM...")
    success_count = 0

    for img_file in image_files:
        if os.path.exists(img_file):
            if fix_image_file(img_file):
                success_count += 1
        else:
            print(f"⚠️  File not found: {img_file}")

    print(f"\n🎉 Successfully modified {success_count}/{len(image_files)} image files")
    print("💾 This should save ~1.5-2MB of program flash memory!")
    print("\n📋 Next steps:")
    print("1. Add compiler optimization flags: -Os -ffunction-sections -fdata-sections -Wl,--gc-sections")
    print("2. Configure LVGL to disable unused widgets (see MEMORY_OPTIMIZATION.md)")
    print("3. Remove debug Serial.println() statements")

if __name__ == "__main__":
    main()