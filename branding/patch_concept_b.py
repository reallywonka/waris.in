"""
Ultra-clean pass for Concept B and final adjustments.
"""
import os
import re

BRANDING_DIR = r"c:\waris.in\branding"

# Load refine_concepts.py content
with open(os.path.join(BRANDING_DIR, "refine_concepts.py"), "r", encoding="utf-8") as f:
    code = f.read()

# Replace concept_b definition with ultra-clean origami box
clean_concept_b = '''def concept_b():
    symbol = \'\'\'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-b">
  <title id="title-b">waris.in - Kotak Berbagi (Concept B)</title>
  <g id="symbol-b">
    <!-- Clean Origami Open Box / Giving Hands W -->
    <path fill="#047857" d="
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
    <path fill="#047857" d="
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
    <polygon points="128,136 96,198 160,198" fill="#065F46"/>
    <!-- Floating Gift Spark in Warm Amber -->
    <polygon points="128,52 144,78 128,104 112,78" fill="#D97706"/>
  </g>
</svg>\'\'\'

    lockup = f\'\'\'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760 256" width="760" height="256" role="img" aria-labelledby="title-lockup-b">
  <title id="title-lockup-b">waris.in Lockup - Concept B</title>
  <g transform="translate(24, 24) scale(0.8125)">
    <path fill="#047857" d="
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
    <path fill="#047857" d="
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
    <polygon points="128,136 96,198 160,198" fill="#065F46"/>
    <polygon points="128,52 144,78 128,104 112,78" fill="#D97706"/>
  </g>
  <g id="wordmark">{get_wordmark_paths(start_x=248, stroke_color="#0F172A", accent_color="#047857")}</g>
</svg>\'\'\'
    return symbol, lockup
'''

# Replace old concept_b
pattern = r"def concept_b\(\):.*?(?=def concept_c\(\):)"
new_code = re.sub(pattern, clean_concept_b + "\n\n", code, flags=re.DOTALL)

with open(os.path.join(BRANDING_DIR, "refine_concepts.py"), "w", encoding="utf-8") as f:
    f.write(new_code)

print("Updated refine_concepts.py with clean Concept B")
