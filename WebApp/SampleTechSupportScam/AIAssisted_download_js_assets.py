import urllib.request
import os
from urllib.parse import urlparse


urls = [
    "https://code.jquery.com/jquery-1.4.4.min.js",
    "https://newppscriptlink418.pages.dev/12dgdur.js",
    "https://newppscriptlink418.pages.dev/11gfdjuef.js",
    "https://newppscriptlink418.pages.dev/09sgsgsfr.js",
    "https://newppscriptlink418.pages.dev/13dugfjdf.js",
    "https://newppscriptlink418.pages.dev/08dgsg3d.js",
    "https://newppscriptlink418.pages.dev/07sdgsg4.js",
    "https://newppscriptlink418.pages.dev/06hshs.js",
    "https://newppscriptlink418.pages.dev/05sdghdf.js",
    "https://newppscriptlink418.pages.dev/04shesc1.js",
    "https://newppscriptlink418.pages.dev/03fgsskryeivh.js",
    "https://newppscriptlink418.pages.dev/02dgdsg3d.js",
    "https://newppscriptlink418.pages.dev/01d1fgshfddfg.js"]

save_dir = os.path.join(os.path.expanduser("~"), "Downloads", "assets")
os.makedirs(save_dir, exist_ok=True)

headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124.0 Safari/537.36"
}

for url in urls:
    filename = os.path.basename(urlparse(url).path)
    save_path = os.path.join(save_dir, filename)
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req) as res:
            with open(save_path, "wb") as f:
                f.write(res.read())
        print(f"OK  {filename}")
    except Exception as e:
        print(f"NG  {filename}: {e}")

print(f"\n saved in : {save_dir}")


save_dir = os.path.join(os.path.expanduser("~"), "Downloads", "assets","js")
os.makedirs(save_dir, exist_ok=True)

headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124.0 Safari/537.36"
}

for url in urls:
    filename = os.path.basename(urlparse(url).path)
    save_path = os.path.join(save_dir, filename)
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req) as res:
            with open(save_path, "wb") as f:
                f.write(res.read())
        print(f"OK  {filename}")
    except Exception as e:
        print(f"NG  {filename}: {e}")

print(f"\n saved in : {save_dir}")
