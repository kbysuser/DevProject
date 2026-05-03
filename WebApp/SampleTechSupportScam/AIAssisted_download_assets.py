import urllib.request
import os
from urllib.parse import urlparse

urls = [
    "https://newppscriptlink418.pages.dev/fesbg.png",
    "https://newppscriptlink418.pages.dev/bx1.png",
    "https://newppscriptlink418.pages.dev/web1.png",
    "https://newppscriptlink418.pages.dev/img01df.png",
    "https://newppscriptlink418.pages.dev/winlo.png",
    "https://newppscriptlink418.pages.dev/dm.png",
    "https://newppscriptlink418.pages.dev/cs.png",
    "https://newppscriptlink418.pages.dev/re.gif",
]

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
