import cv2
import numpy as np
from PIL import Image, ImageEnhance
import os

def create_vertical_reel(image_path, output_path, duration_sec=6, fps=30, width=720, height=1280):
    img = Image.open(image_path).convert('RGB')
    orig_w, orig_h = img.size

    # Ratio vertical cible : 9:16
    target_ratio = width / height  # 0.5625

    # Découper ou ajuster l'image pour couvrir 9:16
    img_ratio = orig_w / orig_h
    if img_ratio > target_ratio:
        # Plus large -> couper les côtés ou zoomer au centre
        crop_h = orig_h
        crop_w = int(orig_h * target_ratio)
        x_offset = (orig_w - crop_w) // 2
        base_crop = img.crop((x_offset, 0, x_offset + crop_w, crop_h))
    else:
        # Plus haut -> couper haut/bas
        crop_w = orig_w
        crop_h = int(orig_w / target_ratio)
        y_offset = (orig_h - crop_h) // 2
        base_crop = img.crop((0, y_offset, crop_w, y_offset + crop_h))

    base_crop = base_crop.resize((width, height), Image.Resampling.LANCZOS)
    
    # Préparer le VideoWriter OpenCV
    # FourCC pour MP4
    fourcc = cv2.VideoWriter_fourcc(*'mp4v')
    out = cv2.VideoWriter(output_path, fourcc, fps, (width, height))
    
    total_frames = int(duration_sec * fps)
    
    # Effet Ken Burns (zoom progressif de 1.0x à 1.12x)
    for i in range(total_frames):
        t = i / float(total_frames)
        # Zoom sinusoidal fluide
        scale = 1.0 + 0.12 * (1 - np.cos(t * np.pi)) / 2.0
        
        # Dimensions zoomées
        new_w = int(width * scale)
        new_h = int(height * scale)
        
        # Resize et recadrage centré
        frame_img = base_crop.resize((new_w, new_h), Image.Resampling.BILINEAR)
        x1 = (new_w - width) // 2
        y1 = (new_h - height) // 2
        frame_crop = frame_img.crop((x1, y1, x1 + width, y1 + height))
        
        # Convertir en BGR pour OpenCV
        frame_cv = cv2.cvtColor(np.array(frame_crop), cv2.COLOR_RGB2BGR)
        out.write(frame_cv)
        
    out.release()
    print(f"✅ Vertical 9:16 reel generated: {output_path} ({width}x{height}, {duration_sec}s, {os.path.getsize(output_path)} bytes)")

if __name__ == '__main__':
    src = 'public/assets/images/service_quad.jpg'
    dst = 'scratch/test_reel_quad_9_16.mp4'
    create_vertical_reel(src, dst)
