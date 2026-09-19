import urllib.request
import re
import json

headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"}
url = "https://www.pexels.com/search/videos/beach/?orientation=portrait"
req = urllib.request.Request(url, headers=headers)
try:
    html = urllib.request.urlopen(req, timeout=10).read().decode("utf-8")
    urls = re.findall(r"https://videos\.pexels\.com/video-files/[^\s\"'\\]+", html)
    print("Found direct video URLs:", len(urls))
    for u in list(set(urls))[:10]:
        print("  ->", u)
except Exception as e:
    print("Error:", e)
