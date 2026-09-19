import cv2
import numpy as np
from PIL import Image
import urllib.request
import os

WIDTH = 720
HEIGHT = 1280
FPS = 25
DURATION = 5  # 5 seconds
TOTAL_FRAMES = FPS * DURATION

def make_vertical_reel_from_image(img_input, output_path):
    if isinstance(img_input, str) and img_input.startswith("http"):
        req = urllib.request.Request(img_input, headers={"User-Agent": "Mozilla/5.0"})
        with urllib.request.urlopen(req, timeout=15) as resp:
            img = Image.open(resp).convert("RGB")
    else:
        img = Image.open(img_input).convert("RGB")

    orig_w, orig_h = img.size
    target_ratio = WIDTH / HEIGHT  # 0.5625

    img_ratio = orig_w / orig_h
    if img_ratio > target_ratio:
        crop_h = orig_h
        crop_w = int(orig_h * target_ratio)
        x_offset = (orig_w - crop_w) // 2
        base_crop = img.crop((x_offset, 0, x_offset + crop_w, crop_h))
    else:
        crop_w = orig_w
        crop_h = int(orig_w / target_ratio)
        y_offset = (orig_h - crop_h) // 2
        base_crop = img.crop((0, y_offset, crop_w, y_offset + crop_h))

    base_crop = base_crop.resize((WIDTH, HEIGHT), Image.Resampling.LANCZOS)

    # Convert PIL Image to OpenCV array
    base_np = np.array(base_crop)

    # OpenCV VideoWriter (MP4)
    fourcc = cv2.VideoWriter_fourcc(*'mp4v')
    out = cv2.VideoWriter(output_path, fourcc, FPS, (WIDTH, HEIGHT))

    for i in range(TOTAL_FRAMES):
        t = i / float(TOTAL_FRAMES)
        scale = 1.0 + 0.10 * (1 - np.cos(t * np.pi)) / 2.0
        new_w = int(WIDTH * scale)
        new_h = int(HEIGHT * scale)

        # Fast resize
        frame_resized = cv2.resize(base_np, (new_w, new_h), interpolation=cv2.INTER_LINEAR)
        x1 = (new_w - WIDTH) // 2
        y1 = (new_h - HEIGHT) // 2
        frame_crop = frame_resized[y1:y1 + HEIGHT, x1:x1 + WIDTH]

        # Convert RGB to BGR
        frame_bgr = cv2.cvtColor(frame_crop, cv2.COLOR_RGB2BGR)
        out.write(frame_bgr)

    out.release()
    print("Generated:", output_path, "Size:", os.path.getsize(output_path))

if __name__ == '__main__':
    out_dir = 'public/assets/videos/reels'
    os.makedirs(out_dir, exist_ok=True)

    sources = {
        'desert_quad.mp4': 'public/assets/images/service_quad.jpg',
        'beach_lagoon.mp4': 'public/assets/images/service_kitesurf.jpg',
        'kitesurf_water.mp4': 'public/assets/images/service_jetski.jpg',
        'sunset_camels.mp4': 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=1200&q=85',
        'patrimoine_village.mp4': 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&h=1200&q=85'
    }

    for name, src in sources.items():
        out_file = os.path.join(out_dir, name)
        print("Rendering vertical 9:16 reel:", name, "from", src)
        make_vertical_reel_from_image(src, out_file)
    print("ALL 5 VERTICAL REELS COMPLETED SUCCESSFULLY!")
