from PIL import Image
import os

# Paths
source_path = "/Applications/MAMP/htdocs/aitsc-wp/ATISC CONTENT/AITSC 2/Logo/logo-a---blue.png"
dest_dir = "/Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/aitsc-pro-theme/assets/images/brand"
dest_filename = "bg-pattern-logo.png"

# Ensure destination directory exists
if not os.path.exists(dest_dir):
    os.makedirs(dest_dir)

output_path = os.path.join(dest_dir, dest_filename)

print(f"Processing: {source_path}")

try:
    # Open image
    img = Image.open(source_path).convert("RGBA")
    
    # Create a new image for the processed outcome (same size)
    new_img = Image.new("RGBA", img.size)
    datas = img.getdata()
    
    new_data = []
    for item in datas:
        # item is (r, g, b, a)
        # If the pixel is not transparent (alpha > 0), make it white/grey with low opacity
        if item[3] > 0:
            # Color: White (255, 255, 255)
            # Opacity: 5% (approx 13/255) for subtle background pattern
            new_data.append((255, 255, 255, 13)) 
        else:
            new_data.append((0, 0, 0, 0)) # Transparent
            
    new_img.putdata(new_data)
    
    # Save the processed single tile
    new_img.save(output_path, "PNG")
    print(f"Success! Created {output_path}")
    
    # Optional: We could tile it here, but CSS 'background-repeat' is more efficient.
    # The user asked to "turn it into bg pattern", which usually means the asset itself 
    # should be ready to repeat. The single logo repeating is the standard way.
    
except Exception as e:
    print(f"Error: {e}")
