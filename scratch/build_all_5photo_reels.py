import os
import subprocess
import urllib.request
import cv2
import numpy as np
from PIL import Image
import imageio_ffmpeg

FFMPEG_EXE = imageio_ffmpeg.get_ffmpeg_exe()
WIDTH = 720
HEIGHT = 1280
FPS = 25
PHOTO_DURATION = 4.2   # ~4.2s per photo -> 5 photos = ~20s (< 30s)
CROSSFADE_DURATION = 0.5

def load_and_crop(img_input):
    if isinstance(img_input, str) and img_input.startswith("http"):
        req = urllib.request.Request(img_input, headers={"User-Agent": "Mozilla/5.0"})
        with urllib.request.urlopen(req, timeout=15) as resp:
            img = Image.open(resp).convert("RGB")
    else:
        img = Image.open(img_input).convert("RGB")

    orig_w, orig_h = img.size
    target_ratio = WIDTH / HEIGHT

    img_ratio = orig_w / orig_h
    if img_ratio > target_ratio:
        crop_h = orig_h
        crop_w = int(orig_h * target_ratio)
        x_offset = (orig_w - crop_w) // 2
        base = img.crop((x_offset, 0, x_offset + crop_w, crop_h))
    else:
        crop_w = orig_w
        crop_h = int(orig_w / target_ratio)
        y_offset = (orig_h - crop_h) // 2
        base = img.crop((0, y_offset, crop_w, y_offset + crop_h))

    base = base.resize((WIDTH, HEIGHT), Image.Resampling.LANCZOS)
    return np.array(base)

def render_slideshow(sources, audio_file, output_mp4):
    temp_raw = output_mp4.replace('.mp4', '_temp.mp4')
    print(f"Loading {len(sources)} photos for {os.path.basename(output_mp4)}...")
    images = [load_and_crop(s) for s in sources]

    fourcc = cv2.VideoWriter_fourcc(*'mp4v')
    out = cv2.VideoWriter(temp_raw, fourcc, FPS, (WIDTH, HEIGHT))

    frames_per_photo = int(FPS * PHOTO_DURATION)
    frames_crossfade = int(FPS * CROSSFADE_DURATION)

    photo_clips = []
    for idx, img_np in enumerate(images):
        clip_frames = []
        zoom_in = (idx % 2 == 0)
        for f in range(frames_per_photo):
            t = f / float(frames_per_photo)
            if zoom_in:
                scale = 1.0 + 0.08 * (1 - np.cos(t * np.pi)) / 2.0
            else:
                scale = 1.08 - 0.08 * (1 - np.cos(t * np.pi)) / 2.0

            new_w = int(WIDTH * scale)
            new_h = int(HEIGHT * scale)
            frame_resized = cv2.resize(img_np, (new_w, new_h), interpolation=cv2.INTER_LINEAR)
            x1 = (new_w - WIDTH) // 2
            y1 = (new_h - HEIGHT) // 2
            frame_crop = frame_resized[y1:y1 + HEIGHT, x1:x1 + WIDTH]
            clip_frames.append(frame_crop)
        photo_clips.append(clip_frames)

    assembled_frames = []
    for idx in range(len(photo_clips)):
        current_clip = photo_clips[idx]
        if idx == 0:
            assembled_frames.extend(current_clip[:-frames_crossfade])
        else:
            prev_clip = photo_clips[idx - 1]
            for cf in range(frames_crossfade):
                alpha = cf / float(frames_crossfade)
                prev_frame = prev_clip[-frames_crossfade + cf]
                curr_frame = current_clip[cf]
                blended = cv2.addWeighted(prev_frame, 1.0 - alpha, curr_frame, alpha, 0)
                assembled_frames.append(blended)
            
            if idx == len(photo_clips) - 1:
                assembled_frames.extend(current_clip[frames_crossfade:])
            else:
                assembled_frames.extend(current_clip[frames_crossfade:-frames_crossfade])

    for frame_rgb in assembled_frames:
        frame_bgr = cv2.cvtColor(frame_rgb, cv2.COLOR_RGB2BGR)
        out.write(frame_bgr)
    out.release()

    total_duration = len(assembled_frames) / float(FPS)
    fadeout_start = max(0, total_duration - 1.5)

    cmd = [
        FFMPEG_EXE, '-y',
        '-i', temp_raw,
        '-ss', '0', '-t', str(total_duration),
        '-i', audio_file,
        '-c:v', 'libx264',
        '-pix_fmt', 'yuv420p',
        '-c:a', 'aac',
        '-b:a', '128k',
        '-af', f'afade=t=in:ss=0:d=0.5,afade=t=out:st={fadeout_start:.2f}:d=1.5',
        '-shortest',
        output_mp4
    ]

    res = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
    if res.returncode != 0:
        raise RuntimeError(f"FFmpeg error: {res.stderr}")

    if os.path.exists(temp_raw):
        os.remove(temp_raw)

    print(f"SUCCESS: {os.path.basename(output_mp4)} ({total_duration:.1f}s, {os.path.getsize(output_mp4)} bytes)")

if __name__ == '__main__':
    out_dir = 'public/assets/videos/reels'
    os.makedirs(out_dir, exist_ok=True)

    audio_desert = 'scratch/desert_city.mp3'
    audio_lounge = 'scratch/lounge_music.mp3'

    themes = {
        'desert_quad.mp4': {
            'audio': audio_desert,
            'photos': [
                'public/assets/images/service_quad.jpg',
                'public/assets/images/service_buggy.jpg',
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&h=1600&q=85'
            ]
        },
        'beach_lagoon.mp4': {
            'audio': audio_lounge,
            'photos': [
                'public/assets/images/service_kitesurf.jpg',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1497206365907-f5e630693df0?auto=format&fit=crop&w=1200&h=1600&q=85',
                'public/assets/images/service_jetski.jpg'
            ]
        },
        'kitesurf_water.mp4': {
            'audio': audio_lounge,
            'photos': [
                'public/assets/images/service_jetski.jpg',
                'public/assets/images/service_kitesurf.jpg',
                'public/assets/images/service_plongee.jpg',
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&h=1600&q=85',
                'public/assets/images/service_bateau_pirate.jpg'
            ]
        },
        'sunset_camels.mp4': {
            'audio': audio_desert,
            'photos': [
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&h=1600&q=85',
                'public/assets/images/service_quad.jpg'
            ]
        },
        'patrimoine_village.mp4': {
            'audio': audio_desert,
            'photos': [
                'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1528728329032-2972f65dfb3f?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=1200&h=1600&q=85',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&h=1600&q=85'
            ]
        }
    }

    for filename, cfg in themes.items():
        dst = os.path.join(out_dir, filename)
        render_slideshow(cfg['photos'], cfg['audio'], dst)

    print("ALL 5 SLIDESHOW REELS (5 PHOTOS + MUSIC) RENDERED SUCCESSFULLY!")
