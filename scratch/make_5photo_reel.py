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
PHOTO_DURATION = 4.0   # 4 seconds per photo -> 5 photos = 20 seconds total (< 30s)
CROSSFADE_DURATION = 0.5

def load_image(img_input):
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

def build_slideshow_video(photo_sources, audio_path, output_mp4):
    temp_raw_video = output_mp4.replace('.mp4', '_raw.mp4')
    
    print(f"Loading {len(photo_sources)} images...")
    images = [load_image(p) for p in photo_sources]

    fourcc = cv2.VideoWriter_fourcc(*'mp4v')
    out = cv2.VideoWriter(temp_raw_video, fourcc, FPS, (WIDTH, HEIGHT))

    frames_per_photo = int(FPS * PHOTO_DURATION)
    frames_crossfade = int(FPS * CROSSFADE_DURATION)

    # Render each photo clip with Ken Burns
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

    # Assemble with crossfades
    assembled_frames = []
    for idx in range(len(photo_clips)):
        current_clip = photo_clips[idx]
        if idx == 0:
            # First clip up to start of crossfade
            assembled_frames.extend(current_clip[:-frames_crossfade])
        else:
            # Crossfade between previous tail and current head
            prev_clip = photo_clips[idx - 1]
            for cf in range(frames_crossfade):
                alpha = cf / float(frames_crossfade)
                prev_frame = prev_clip[-frames_crossfade + cf]
                curr_frame = current_clip[cf]
                blended = cv2.addWeighted(prev_frame, 1.0 - alpha, curr_frame, alpha, 0)
                assembled_frames.append(blended)
            
            if idx == len(photo_clips) - 1:
                # Last clip all the way to the end
                assembled_frames.extend(current_clip[frames_crossfade:])
            else:
                assembled_frames.extend(current_clip[frames_crossfade:-frames_crossfade])

    # Write all frames
    for frame_rgb in assembled_frames:
        frame_bgr = cv2.cvtColor(frame_rgb, cv2.COLOR_RGB2BGR)
        out.write(frame_bgr)
    out.release()

    total_duration = len(assembled_frames) / float(FPS)
    print(f"Raw video written: {len(assembled_frames)} frames ({total_duration:.1f}s)")

    # Mux with background audio using ffmpeg
    fadeout_start = max(0, total_duration - 1.5)
    cmd = [
        FFMPEG_EXE, '-y',
        '-i', temp_raw_video,
        '-ss', '0', '-t', str(total_duration),
        '-i', audio_path,
        '-c:v', 'libx264',
        '-pix_fmt', 'yuv420p',
        '-c:a', 'aac',
        '-b:a', '128k',
        '-af', f'afade=t=in:ss=0:d=0.5,afade=t=out:st={fadeout_start:.2f}:d=1.5',
        '-shortest',
        output_mp4
    ]

    print("Running FFmpeg audio/video muxing...")
    res = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
    if res.returncode != 0:
        print("FFmpeg error:", res.stderr)
        raise RuntimeError("FFmpeg muxing failed")

    if os.path.exists(temp_raw_video):
        os.remove(temp_raw_video)

    print(f"Final Reel created: {output_mp4} ({os.path.getsize(output_mp4)} bytes, duration: {total_duration:.1f}s)")

if __name__ == '__main__':
    sources = [
        'public/assets/images/service_quad.jpg',
        'public/assets/images/service_buggy.jpg',
        'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=1600&q=85',
        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&h=1600&q=85',
        'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&h=1600&q=85'
    ]
    audio = 'scratch/desert_city.mp3'
    dst = 'scratch/test_5photo_quad_reel.mp4'
    build_slideshow_video(sources, audio, dst)
