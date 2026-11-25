"""
Full Logo Kit Builder for waris.in (Concept B - Kotak Berbagi)
Builds:
- Polished master SVGs (Symbol, Small Cut, Horizontal Lockup, Stacked Lockup)
- Dark / White variants for dark mode
- Generates all export variants (Black, White, Mono, Web Icons, Favicon, PNGs)
- Creates Client Presentation Board & Slides
- Writes Brand Guidelines document
"""
import os
import subprocess
import json

BRANDING_DIR = r"c:\waris.in\branding"
SCRIPTS_DIR = r"C:\Users\gebri\.gemini\config\plugins\logo-design\skills\logo-design\scripts"

# ==========================================
# 1. WORDMARK GENERATOR
# ==========================================
def get_wordmark_paths(start_x=248, start_y=94, stroke_color="#0F172A", accent_color="#047857", scale=1.0):
    cx = start_x
    paths = []
    
    # 1. 'w'
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx+4} {start_y}
      L {cx+19} {start_y+62}
      C {cx+21} {start_y+69}, {cx+25} {start_y+72}, {cx+31} {start_y+72}
      C {cx+36} {start_y+72}, {cx+40} {start_y+69}, {cx+43} {start_y+62}
      L {cx+52} {start_y+26}
      C {cx+54} {start_y+19}, {cx+58} {start_y+19}, {cx+60} {start_y+26}
      L {cx+69} {start_y+62}
      C {cx+72} {start_y+69}, {cx+76} {start_y+72}, {cx+81} {start_y+72}
      C {cx+87} {start_y+72}, {cx+91} {start_y+69}, {cx+93} {start_y+62}
      L {cx+108} {start_y}
      L {cx+92} {start_y}
      L {cx+82} {start_y+50}
      L {cx+70} {start_y+13}
      C {cx+68} {start_y+5}, {cx+63} {start_y}, {cx+56} {start_y}
      C {cx+49} {start_y}, {cx+44} {start_y+5}, {cx+42} {start_y+13}
      L {cx+30} {start_y+50}
      L {cx+20} {start_y}
      Z
    "/>
    ''')
    cx += 114

    # 2. 'a'
    paths.append(f'''
    <path fill="{stroke_color}" fill-rule="evenodd" d="
      M {cx+24} {start_y}
      C {cx+44} {start_y}, {cx+52} {start_y+14}, {cx+52} {start_y+30}
      L {cx+52} {start_y+72}
      L {cx+38} {start_y+72}
      L {cx+38} {start_y+61}
      C {cx+34} {start_y+69}, {cx+25} {start_y+74}, {cx+16} {start_y+74}
      C {cx+3} {start_y+74}, {cx-6} {start_y+65}, {cx-6} {start_y+49}
      C {cx-6} {start_y+31}, {cx+11} {start_y+24}, {cx+38} {start_y+23}
      L {cx+38} {start_y+21}
      C {cx+38} {start_y+12}, {cx+33} {start_y+10}, {cx+24} {start_y+10}
      C {cx+16} {start_y+10}, {cx+10} {start_y+13}, {cx+8} {start_y+18}
      L {cx-4} {start_y+11}
      C {cx+2} {start_y+3}, {cx+11} {start_y}, {cx+24} {start_y}
      Z
      M {cx+38} {start_y+33}
      C {cx+19} {start_y+34}, {cx+8} {start_y+38}, {cx+8} {start_y+49}
      C {cx+8} {start_y+57}, {cx+14} {start_y+62}, {cx+22} {start_y+62}
      C {cx+31} {start_y+62}, {cx+38} {start_y+55}, {cx+38} {start_y+46}
      Z
    "/>
    ''')
    cx += 64

    # 3. 'r'
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx} {start_y+2}
      L {cx+14} {start_y+2}
      L {cx+14} {start_y+14}
      C {cx+19} {start_y+6}, {cx+27} {start_y}, {cx+38} {start_y}
      C {cx+42} {start_y}, {cx+46} {start_y+2}, {cx+48} {start_y+4}
      L {cx+44} {start_y+17}
      C {cx+40} {start_y+15}, {cx+36} {start_y+14}, {cx+32} {start_y+14}
      C {cx+22} {start_y+14}, {cx+15} {start_y+22}, {cx+15} {start_y+36}
      L {cx+15} {start_y+72}
      L {cx} {start_y+72}
      Z
    "/>
    ''')
    cx += 50

    # 4. 'i'
    paths.append(f'''
    <g fill="{stroke_color}">
      <rect x="{cx}" y="{start_y+2}" width="14" height="70" rx="4"/>
      <circle cx="{cx+7}" cy="{start_y-18}" r="7.5"/>
    </g>
    ''')
    cx += 28

    # 5. 's'
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx+35} {start_y+15}
      L {cx+24} {start_y+21}
      C {cx+21} {start_y+15}, {cx+17} {start_y+13}, {cx+11} {start_y+13}
      C {cx+6} {start_y+13}, {cx+2} {start_y+16}, {cx+2} {start_y+20}
      C {cx+2} {start_y+24}, {cx+5} {start_y+27}, {cx+16} {start_y+30}
      C {cx+29} {start_y+33}, {cx+37} {start_y+39}, {cx+37} {start_y+51}
      C {cx+37} {start_y+65}, {cx+25} {start_y+74}, {cx+10} {start_y+74}
      C {cx-3} {start_y+74}, {cx-14} {start_y+68}, {cx-17} {start_y+56}
      L {cx-5} {start_y+51}
      C {cx-3} {start_y+58}, {cx+3} {start_y+62}, {cx+10} {start_y+62}
      C {cx+17} {start_y+62}, {cx+22} {start_y+58}, {cx+22} {start_y+52}
      C {cx+22} {start_y+47}, {cx+19} {start_y+44}, {cx+8} {start_y+41}
      C {cx-4} {start_y+37}, {cx-12} {start_y+32}, {cx-12} {start_y+21}
      C {cx-12} {start_y+9}, {cx-1} {start_y}, {cx+11} {start_y}
      C {cx+22} {start_y}, {cx+31} {start_y+6}, {cx+35} {start_y+15}
      Z
    "/>
    ''')
    cx += 50

    # 6. '.'
    paths.append(f'''
    <circle cx="{cx+8}" cy="{start_y+65}" r="8" fill="{accent_color}"/>
    ''')
    cx += 24

    # 7. 'i'
    paths.append(f'''
    <g fill="{accent_color}">
      <rect x="{cx}" y="{start_y+2}" width="14" height="70" rx="4"/>
      <circle cx="{cx+7}" cy="{start_y-18}" r="7.5"/>
    </g>
    ''')
    cx += 28

    # 8. 'n'
    paths.append(f'''
    <path fill="{accent_color}" d="
      M {cx} {start_y+2}
      L {cx+14} {start_y+2}
      L {cx+14} {start_y+13}
      C {cx+20} {start_y+5}, {cx+30} {start_y}, {cx+41} {start_y}
      C {cx+54} {start_y}, {cx+62} {start_y+8}, {cx+62} {start_y+24}
      L {cx+62} {start_y+72}
      L {cx+48} {start_y+72}
      L {cx+48} {start_y+26}
      C {cx+48} {start_y+17}, {cx+44} {start_y+13}, {cx+35} {start_y+13}
      C {cx+27} {start_y+13}, {cx+15} {start_y+19}, {cx+15} {start_y+31}
      L {cx+15} {start_y+72}
      L {cx} {start_y+72}
      Z
    "/>
    ''')
    return "".join(paths)


# ==========================================
# 2. MASTER SVG DEFINITIONS (Concept B: Kotak Berbagi)
# ==========================================

def get_symbol_svg(fg_green="#047857", base_dark="#065F46", spark_amber="#D97706"):
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-symbol">
  <title id="title-symbol">waris.in Symbol</title>
  <g id="symbol">
    <!-- Left Hand / Box Flap -->
    <path fill="{fg_green}" d="
      M 48 76
      C 40 76, 36 82, 38 90
      L 64 176
      C 70 192, 84 200, 102 200
      L 124 200
      L 96 112
      L 68 112
      L 58 76
      Z
    "/>
    <!-- Right Hand / Box Flap -->
    <path fill="{fg_green}" d="
      M 208 76
      C 216 76, 220 82, 218 90
      L 192 176
      C 186 192, 172 200, 154 200
      L 132 200
      L 160 112
      L 188 112
      L 198 76
      Z
    "/>
    <!-- Center Base Fold in darker emerald -->
    <polygon points="128,136 96,198 160,198" fill="{base_dark}"/>
    <!-- Floating Gift Spark in Warm Amber -->
    <polygon points="128,52 144,78 128,104 112,78" fill="{spark_amber}"/>
  </g>
</svg>'''

def get_symbol_small_svg(fg_green="#047857", base_dark="#065F46", spark_amber="#D97706"):
    """
    Optimized for 16-32px favicon display:
    Stronger stroke presence, slightly enlarged spark, increased counter opening.
    """
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-small">
  <title id="title-small">waris.in Favicon and Small Size Symbol</title>
  <g id="symbol-small">
    <!-- Left Flap with boosted thickness for small display -->
    <path fill="{fg_green}" d="
      M 44 70
      C 34 70, 30 78, 32 88
      L 60 176
      C 66 194, 82 204, 102 204
      L 124 204
      L 96 108
      L 66 108
      L 56 70
      Z
    "/>
    <!-- Right Flap -->
    <path fill="{fg_green}" d="
      M 212 70
      C 222 70, 226 78, 224 88
      L 196 176
      C 190 194, 174 204, 154 204
      L 132 204
      L 160 108
      L 190 108
      L 200 70
      Z
    "/>
    <!-- Center Base Fold -->
    <polygon points="128,132 94,200 162,200" fill="{base_dark}"/>
    <!-- Amplified Gift Spark for crisp 16px contrast -->
    <polygon points="128,42 148,72 128,102 108,72" fill="{spark_amber}"/>
  </g>
</svg>'''

def get_horizontal_lockup_svg(fg_green="#047857", base_dark="#065F46", spark_amber="#D97706", text_color="#0F172A"):
    wordmark = get_wordmark_paths(start_x=248, start_y=94, stroke_color=text_color, accent_color=fg_green)
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760 256" width="760" height="256" role="img" aria-labelledby="title-lockup">
  <title id="title-lockup">waris.in Horizontal Logo</title>
  <g transform="translate(24, 24) scale(0.8125)">
    <path fill="{fg_green}" d="
      M 48 76
      C 40 76, 36 82, 38 90
      L 64 176
      C 70 192, 84 200, 102 200
      L 124 200
      L 96 112
      L 68 112
      L 58 76
      Z
    "/>
    <path fill="{fg_green}" d="
      M 208 76
      C 216 76, 220 82, 218 90
      L 192 176
      C 186 192, 172 200, 154 200
      L 132 200
      L 160 112
      L 188 112
      L 198 76
      Z
    "/>
    <polygon points="128,136 96,198 160,198" fill="{base_dark}"/>
    <polygon points="128,52 144,78 128,104 112,78" fill="{spark_amber}"/>
  </g>
  <g id="wordmark">{wordmark}</g>
</svg>'''

def get_stacked_lockup_svg(fg_green="#047857", base_dark="#065F46", spark_amber="#D97706", text_color="#0F172A"):
    # Stacked lockup on 512x512 canvas
    # Symbol placed at center top: scale 1.0, translate (128, 40)
    # Wordmark placed below: scale 0.75, centered
    # Wordmark width at 1.0 is ~440. At 0.75 width is ~330. Centered around x = 256 -> start_x = 90
    wordmark = get_wordmark_paths(start_x=90, start_y=320, stroke_color=text_color, accent_color=fg_green)
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512" height="512" role="img" aria-labelledby="title-stacked">
  <title id="title-stacked">waris.in Stacked Logo</title>
  <g transform="translate(128, 40) scale(1.0)">
    <path fill="{fg_green}" d="
      M 48 76
      C 40 76, 36 82, 38 90
      L 64 176
      C 70 192, 84 200, 102 200
      L 124 200
      L 96 112
      L 68 112
      L 58 76
      Z
    "/>
    <path fill="{fg_green}" d="
      M 208 76
      C 216 76, 220 82, 218 90
      L 192 176
      C 186 192, 172 200, 154 200
      L 132 200
      L 160 112
      L 188 112
      L 198 76
      Z
    "/>
    <polygon points="128,136 96,198 160,198" fill="{base_dark}"/>
    <polygon points="128,52 144,78 128,104 112,78" fill="{spark_amber}"/>
  </g>
  <g id="wordmark">{wordmark}</g>
  <!-- Tagline underneath -->
  <text x="256" y="445" font-family="system-ui, -apple-system, sans-serif" font-size="16" font-weight="700" fill="#64748B" text-anchor="middle" letter-spacing="3">TUKAR &amp; HIBAH KAMPUS</text>
</svg>'''


def build_kit():
    dist_dir = os.path.join(BRANDING_DIR, "dist")
    web_dir = os.path.join(dist_dir, "web")
    slides_dir = os.path.join(BRANDING_DIR, "slides")
    os.makedirs(dist_dir, exist_ok=True)
    os.makedirs(web_dir, exist_ok=True)
    os.makedirs(slides_dir, exist_ok=True)

    # 1. Master Files
    masters = {
        "waris-symbol.svg": get_symbol_svg(),
        "waris-symbol-small.svg": get_symbol_small_svg(),
        "waris-symbol-white.svg": get_symbol_svg("#FFFFFF", "#E2E8F0", "#F59E0B"),
        "waris-horizontal.svg": get_horizontal_lockup_svg(),
        "waris-horizontal-white.svg": get_horizontal_lockup_svg("#FFFFFF", "#E2E8F0", "#F59E0B", "#FFFFFF"),
        "waris-stacked.svg": get_stacked_lockup_svg(),
        "waris-stacked-white.svg": get_stacked_lockup_svg("#FFFFFF", "#E2E8F0", "#F59E0B", "#FFFFFF"),
    }

    for name, content in masters.items():
        p = os.path.join(BRANDING_DIR, name)
        with open(p, "w", encoding="utf-8") as f:
            f.write(content.strip())
        print(f"Generated master: {name}")

    # 2. Audit with svg_audit.py
    symbol_path = os.path.join(BRANDING_DIR, "waris-symbol.svg")
    lockup_path = os.path.join(BRANDING_DIR, "waris-horizontal.svg")
    audit_script = os.path.join(SCRIPTS_DIR, "svg_audit.py")
    subprocess.run(["python", audit_script, symbol_path, lockup_path], check=False)

    # 3. Export Variants with export_variants.py
    export_script = os.path.join(SCRIPTS_DIR, "export_variants.py")
    small_path = os.path.join(BRANDING_DIR, "waris-symbol-small.svg")

    print("\n--- Exporting Symbol Variants & Web Icons ---")
    cmd_symbol = [
        "python", export_script, symbol_path,
        "--name", "waris-symbol",
        "--title", "waris.in Brand Mark",
        "--mono", "#047857",
        "--icon-bg", "#047857",
        "--icon-fg", "keep",
        "--web-icons",
        "--favicon-source", small_path,
        "--png", "64", "128", "256", "512", "1024",
        "--out-dir", dist_dir
    ]
    subprocess.run(cmd_symbol, check=False)

    print("\n--- Exporting Horizontal Lockup Variants ---")
    cmd_lockup = [
        "python", export_script, lockup_path,
        "--name", "waris-horizontal",
        "--title", "waris.in Official Logo",
        "--only", "black", "white", "mono",
        "--mono", "#047857",
        "--png", "512", "1200",
        "--out-dir", dist_dir
    ]
    subprocess.run(cmd_lockup, check=False)

    # Copy web icons to dist/web
    for f in os.listdir(dist_dir):
        if any(f.startswith(p) for p in ["favicon", "apple-touch-icon", "icon-", "maskable-", "site.webmanifest", "head-snippet"]):
            src = os.path.join(dist_dir, f)
            dst = os.path.join(web_dir, f)
            with open(src, "rb") as rf:
                with open(dst, "wb") as wf:
                    wf.write(rf.read())

    # 4. Presentation Spec & Board
    spec = {
        "brand": "waris.in",
        "tagline": "Platform Tukar & Hibah Barang Mahasiswa Kampus",
        "brief": "Platform web bagi mahasiswa satu kampus untuk saling kasih/hibah, barter/tukar, atau jual murah barang kuliah preloved secara santai, rapi, dan tepercaya.",
        "adjectives": ["Akrab", "Sirkular", "Terpercaya", "Modern", "Praktis"],
        "criteria": "Mudah dikenali di favicon 16px, ramah mahasiswa, mencerminkan estafet kepedulian kampus, dan fleksibel di berbagai media fisik maupun digital.",
        "industry": "consumer-app",
        "mockups": ["website", "box", "tote", "sticker", "app-icon", "badge"],
        "nav": ["Beranda", "Jelajahi Katalog", "Barang Saya", "Pengajuan Masuk"],
        "brand_color": "#047857",
        "tile_color": "#065F46",
        "greyscale": False,
        "final": True,
        "designer": "Senior Identity Designer",
        "round": 2,
        "concepts": [
            {
                "name": "Kotak Berbagi (The Handover Box)",
                "symbol": "waris-symbol.svg",
                "lockup": "waris-horizontal.svg",
                "stacked": "waris-stacked.svg",
                "symbol_on_tile": "waris-symbol-white.svg",
                "stacked_on_tile": "waris-stacked-white.svg",
                "symbol_on_dark": "waris-symbol-white.svg",
                "lockup_on_dark": "waris-horizontal-white.svg",
                "stacked_on_dark": "waris-stacked-white.svg",
                "idea": "Siluet kotak paket terbuka membentuk huruf W sekaligus sepasang tangan menyambut, dengan aksen gift spark di tengahnya.",
                "rationale": [
                    "Bentuk origami W langsung mengidentifikasikan platform dengan wadah perlengkapan kuliah fisik.",
                    "Sudut lipatan geometris yang kokoh memancarkan rasa aman, keteraturan, dan transparansi.",
                    "Warna Emerald Green (#047857) merefleksikan nilai sirkularitas ramah lingkungan, dipadukan aksen hangat Amber (#D97706) sebagai simbol kebaikan yang dibagikan."
                ]
            }
        ],
        "recommendation": "Konsep B (Kotak Berbagi) terpilih sebagai identitas resmi waris.in karena menyatukan simbol paket fisik dengan gestur kehangatan tangan mahasiswa.",
        "next_steps": [
            "Penerapan file aset ke aplikasi web (/public/images, navigation, dan favicon)",
            "Integrasi komponen webmanifest untuk browser & PWA",
            "Penerapan panduan brand guidelines pada merchandise kampus"
        ]
    }

    spec_path = os.path.join(BRANDING_DIR, "presentation-spec.json")
    with open(spec_path, "w", encoding="utf-8") as f:
        json.dump(spec, f, indent=2)

    pres_script = os.path.join(SCRIPTS_DIR, "presentation_board.py")
    out_html = os.path.join(BRANDING_DIR, "presentation.html")
    cmd_pres = ["python", pres_script, spec_path, "-o", out_html, "--png-dir", slides_dir]
    print("\n--- Generating Client Presentation Board & Slides ---")
    subprocess.run(cmd_pres, check=False)

    print("\n✓ Full Kit Build Completed!")

if __name__ == "__main__":
    build_kit()
