"""
Script to generate 3 logo concepts for waris.in:
Concept A: "The Circular Relay" (Simpul Estafet) - Letterform Loop W
Concept B: "The Handover Box" (Kotak Berbagi) - Open Package / Giving Hands W
Concept C: "The Exchange Arrows" (Panah Barter Kampus) - Dynamic Dual-Arrow W
"""
import math
import os
import subprocess

BRANDING_DIR = os.path.dirname(os.path.abspath(__file__))

# ==========================================
# VECTOR LETTERFORMS FOR WORDMARK "waris.in"
# Base metrics: baseline = 164, x-height top = 92 (height = 72), ascender top = 64
# ==========================================

def get_wordmark_paths(start_x=260, stroke_color="#0F172A", accent_color="#047857"):
    """
    Returns SVG path string for 'waris.in' drawn with clean vector primitives.
    """
    paths = []
    
    # Track cursor x
    cx = start_x
    
    # 1. Letter 'w'
    # Width: 68. 4 diagonal strokes meeting with rounded joins, or geometric arcs
    # Let's make a modern geometric w with smooth rounded vertexes
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx+6} 92
      L {cx+20} 154
      C {cx+22} 162, {cx+26} 164, {cx+31} 164
      C {cx+35} 164, {cx+39} 161, {cx+42} 154
      L {cx+50} 122
      C {cx+52} 115, {cx+55} 115, {cx+57} 122
      L {cx+65} 154
      C {cx+68} 161, {cx+72} 164, {cx+76} 164
      C {cx+81} 164, {cx+85} 162, {cx+87} 154
      L {cx+101} 92
      L {cx+86} 92
      L {cx+77} 142
      L {cx+66} 107
      C {cx+64} 100, {cx+60} 96, {cx+54} 96
      C {cx+48} 96, {cx+44} 100, {cx+42} 107
      L {cx+31} 142
      L {cx+21} 92
      Z
    "/>
    ''')
    cx += 108

    # 2. Letter 'a'
    # Geometric round 'a' with bowl and stem
    # Center of bowl: cx + 24, cy = 128, r = 36
    paths.append(f'''
    <path fill="{stroke_color}" fill-rule="evenodd" d="
      M {cx+24} 92
      C {cx+44} 92, {cx+50} 106, {cx+50} 122
      L {cx+50} 164
      L {cx+36} 164
      L {cx+36} 153
      C {cx+32} 161, {cx+24} 166, {cx+16} 166
      C {cx+4} 166, {cx-6} 157, {cx-6} 142
      C {cx-6} 124, {cx+10} 117, {cx+36} 116
      L {cx+36} 114
      C {cx+36} 105, {cx+32} 103, {cx+24} 103
      C {cx+16} 103, {cx+10} 106, {cx+8} 111
      L {cx-4} 104
      C {cx+2} 96, {cx+11} 92, {cx+24} 92
      Z
      M {cx+36} 126
      C {cx+18} 127, {cx+8} 131, {cx+8} 142
      C {cx+8} 150, {cx+14} 155, {cx+22} 155
      C {cx+31} 155, {cx+36} 148, {cx+36} 139
      Z
    "/>
    ''')
    cx += 62

    # 3. Letter 'r'
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx} 94
      L {cx+14} 94
      L {cx+14} 106
      C {cx+19} 98, {cx+26} 92, {cx+37} 92
      C {cx+41} 92, {cx+45} 94, {cx+47} 96
      L {cx+43} 109
      C {cx+39} 107, {cx+35} 106, {cx+31} 106
      C {cx+22} 106, {cx+15} 114, {cx+15} 128
      L {cx+15} 164
      L {cx} 164
      Z
    "/>
    ''')
    cx += 48

    # 4. Letter 'i'
    paths.append(f'''
    <g fill="{stroke_color}">
      <rect x="{cx}" y="94" width="14" height="70" rx="3"/>
      <circle cx="{cx+7}" cy="75" r="7.5"/>
    </g>
    ''')
    cx += 28

    # 5. Letter 's'
    paths.append(f'''
    <path fill="{stroke_color}" d="
      M {cx+34} 107
      L {cx+23} 113
      C {cx+20} 107, {cx+16} 105, {cx+10} 105
      C {cx+5} 105, {cx+1} 108, {cx+1} 112
      C {cx+1} 116, {cx+4} 119, {cx+15} 122
      C {cx+28} 125, {cx+36} 131, {cx+36} 143
      C {cx+36} 157, {cx+24} 166, {cx+9} 166
      C {cx-4} 166, {cx-15} 160, {cx-18} 148
      L {cx-6} 143
      C {cx-4} 150, {cx+2} 154, {cx+9} 154
      C {cx+16} 154, {cx+21} 150, {cx+21} 144
      C {cx+21} 139, {cx+18} 136, {cx+7} 133
      C {cx-5} 129, {cx-13} 124, {cx-13} 113
      C {cx-13} 101, {cx-2} 92, {cx+10} 92
      C {cx+21} 92, {cx+30} 98, {cx+34} 107
      Z
    "/>
    ''')
    cx += 48

    # 6. Dot '.'
    paths.append(f'''
    <circle cx="{cx+8}" cy="157" r="7.5" fill="{accent_color}"/>
    ''')
    cx += 24

    # 7. Letter 'i' (emerald accent)
    paths.append(f'''
    <g fill="{accent_color}">
      <rect x="{cx}" y="94" width="14" height="70" rx="3"/>
      <circle cx="{cx+7}" cy="75" r="7.5"/>
    </g>
    ''')
    cx += 28

    # 8. Letter 'n' (emerald accent)
    paths.append(f'''
    <path fill="{accent_color}" d="
      M {cx} 94
      L {cx+14} 94
      L {cx+14} 105
      C {cx+20} 97, {cx+29} 92, {cx+40} 92
      C {cx+53} 92, {cx+60} 100, {cx+60} 116
      L {cx+60} 164
      L {cx+46} 164
      L {cx+46} 118
      C {cx+46} 109, {cx+42} 105, {cx+34} 105
      C {cx+26} 105, {cx+15} 111, {cx+15} 123
      L {cx+15} 164
      L {cx} 164
      Z
    "/>
    ''')
    cx += 72

    return "".join(paths)


# ==========================================
# CONCEPT A: THE CIRCULAR RELAY (Simpul Estafet)
# Two continuous interlocking rounded loop ribbons forming a bold 'W'.
# Clean geometric paths with smooth curves, highly scalable.
# ==========================================

def create_concept_a_symbol():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-a">
  <title id="title-a">waris.in - Simpul Estafet (Concept A)</title>
  <!-- Background transparent, symbol centered optically -->
  <g id="symbol-a" fill="#047857">
    <!-- Left Loop Ribbons forming left V of W and relay loop -->
    <path fill-rule="evenodd" d="
      M 48 64
      C 40 64, 32 72, 32 84
      C 32 120, 52 170, 78 198
      C 86 207, 98 207, 106 198
      L 128 174
      L 150 198
      C 158 207, 170 207, 178 198
      C 204 170, 224 120, 224 84
      C 224 72, 216 64, 208 64
      C 198 64, 192 72, 192 82
      C 192 110, 176 150, 156 172
      L 138 152
      C 144 142, 148 130, 148 116
      C 148 94, 139 76, 128 76
      C 117 76, 108 94, 108 116
      C 108 130, 112 142, 118 152
      L 100 172
      C 80 150, 64 110, 64 82
      C 64 72, 58 64, 48 64
      Z
      M 128 98
      C 132 98, 134 106, 134 116
      C 134 126, 131 135, 128 140
      C 125 135, 122 126, 122 116
      C 122 106, 124 98, 128 98
      Z
    "/>
    <!-- Center handover accent node -->
    <circle cx="128" cy="56" r="14" fill="#D97706"/>
  </g>
</svg>'''

def create_concept_a_lockup():
    symbol_inner = '''
    <g transform="translate(24, 24) scale(0.8125)">
      <path fill="#047857" fill-rule="evenodd" d="
        M 48 64
        C 40 64, 32 72, 32 84
        C 32 120, 52 170, 78 198
        C 86 207, 98 207, 106 198
        L 128 174
        L 150 198
        C 158 207, 170 207, 178 198
        C 204 170, 224 120, 224 84
        C 224 72, 216 64, 208 64
        C 198 64, 192 72, 192 82
        C 192 110, 176 150, 156 172
        L 138 152
        C 144 142, 148 130, 148 116
        C 148 94, 139 76, 128 76
        C 117 76, 108 94, 108 116
        C 108 130, 112 142, 118 152
        L 100 172
        C 80 150, 64 110, 64 82
        C 64 72, 58 64, 48 64
        Z
        M 128 98
        C 132 98, 134 106, 134 116
        C 134 126, 131 135, 128 140
        C 125 135, 122 126, 122 116
        C 122 106, 124 98, 128 98
        Z
      "/>
      <circle cx="128" cy="56" r="14" fill="#D97706"/>
    </g>
    '''
    wordmark = get_wordmark_paths(start_x=248, stroke_color="#0F172A", accent_color="#047857")
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760 256" width="760" height="256" role="img" aria-labelledby="title-lockup-a">
  <title id="title-lockup-a">waris.in Lockup - Concept A</title>
  {symbol_inner}
  <g id="wordmark">{wordmark}</g>
</svg>'''


# ==========================================
# CONCEPT B: THE HANDOVER BOX / GIVING HANDS (Kotak Berbagi)
# An open box with dynamic wings folding out into a W silhouette,
# evoking both unboxing goods and open giving hands.
# ==========================================

def create_concept_b_symbol():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-b">
  <title id="title-b">waris.in - Kotak Berbagi (Concept B)</title>
  <g id="symbol-b">
    <!-- Left Wing / Hand / Box flap -->
    <path fill="#047857" d="
      M 40 76
      C 34 76, 28 82, 30 89
      L 58 178
      C 63 194, 78 204, 95 204
      L 120 204
      L 86 102
      C 84 96, 78 92, 71 92
      L 56 92
      C 48 92, 44 86, 44 80
      C 44 76, 42 76, 40 76
      Z
    "/>
    <!-- Right Wing / Hand / Box flap -->
    <path fill="#047857" d="
      M 216 76
      C 222 76, 228 82, 226 89
      L 198 178
      C 193 194, 178 204, 161 204
      L 136 204
      L 170 102
      C 172 96, 178 92, 185 92
      L 200 92
      C 208 92, 212 86, 212 80
      C 212 76, 214 76, 216 76
      Z
    "/>
    <!-- Center Chevron / Base meeting as W valley -->
    <path fill="#065F46" d="
      M 98 196
      L 128 136
      L 158 196
      C 160 200, 157 204, 152 204
      L 104 204
      C 99 204, 96 200, 98 196
      Z
    "/>
    <!-- Gift / Spark / Handover Core Node in warm amber -->
    <path fill="#D97706" d="
      M 128 60
      L 142 82
      L 128 104
      L 114 82
      Z
    "/>
  </g>
</svg>'''

def create_concept_b_lockup():
    symbol_inner = '''
    <g transform="translate(24, 24) scale(0.8125)">
      <path fill="#047857" d="
        M 40 76
        C 34 76, 28 82, 30 89
        L 58 178
        C 63 194, 78 204, 95 204
        L 120 204
        L 86 102
        C 84 96, 78 92, 71 92
        L 56 92
        C 48 92, 44 86, 44 80
        C 44 76, 42 76, 40 76
        Z
      "/>
      <path fill="#047857" d="
        M 216 76
        C 222 76, 228 82, 226 89
        L 198 178
        C 193 194, 178 204, 161 204
        L 136 204
        L 170 102
        C 172 96, 178 92, 185 92
        L 200 92
        C 208 92, 212 86, 212 80
        C 212 76, 214 76, 216 76
        Z
      "/>
      <path fill="#065F46" d="
        M 98 196
        L 128 136
        L 158 196
        C 160 200, 157 204, 152 204
        L 104 204
        C 99 204, 96 200, 98 196
        Z
      "/>
      <path fill="#D97706" d="
        M 128 60
        L 142 82
        L 128 104
        L 114 82
        Z
      "/>
    </g>
    '''
    wordmark = get_wordmark_paths(start_x=248, stroke_color="#0F172A", accent_color="#047857")
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760 256" width="760" height="256" role="img" aria-labelledby="title-lockup-b">
  <title id="title-lockup-b">waris.in Lockup - Concept B</title>
  {symbol_inner}
  <g id="wordmark">{wordmark}</g>
</svg>'''


# ==========================================
# CONCEPT C: THE CAMPUS EXCHANGE ARROWS (Panah Barter Dinamis)
# Two aerodynamic curved chevron arrows interlocking into a bold 'W',
# representing dynamic peer-to-peer exchange, barter & handovers.
# ==========================================

def create_concept_c_symbol():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="256" height="256" role="img" aria-labelledby="title-c">
  <title id="title-c">waris.in - Panah Barter (Concept C)</title>
  <g id="symbol-c">
    <!-- Left Arrow Form: Flowing down and up to center peak -->
    <path fill="#047857" d="
      M 48 72
      L 78 72
      L 96 150
      L 118 96
      C 120 90, 128 86, 134 90
      L 142 96
      L 118 168
      C 114 180, 104 188, 92 188
      C 80 188, 70 180, 66 168
      L 34 92
      C 30 82, 37 72, 48 72
      Z
    "/>
    <!-- Right Arrow Form: Flowing from center peak down and up to right peak with arrowhead geometry -->
    <path fill="#10B981" d="
      M 138 96
      L 156 150
      L 174 72
      L 204 72
      C 215 72, 222 82, 218 92
      L 186 168
      C 182 180, 172 188, 160 188
      C 148 188, 138 180, 134 168
      L 126 142
      L 138 116
      Z
    "/>
    <!-- Dynamic Exchange Arrow Pointer at bottom right -->
    <polygon points="196,176 226,176 211,202" fill="#D97706"/>
  </g>
</svg>'''

def create_concept_c_lockup():
    symbol_inner = '''
    <g transform="translate(24, 24) scale(0.8125)">
      <path fill="#047857" d="
        M 48 72
        L 78 72
        L 96 150
        L 118 96
        C 120 90, 128 86, 134 90
        L 142 96
        L 118 168
        C 114 180, 104 188, 92 188
        C 80 188, 70 180, 66 168
        L 34 92
        C 30 82, 37 72, 48 72
        Z
      "/>
      <path fill="#10B981" d="
        M 138 96
        L 156 150
        L 174 72
        L 204 72
        C 215 72, 222 82, 218 92
        L 186 168
        C 182 180, 172 188, 160 188
        C 148 188, 138 180, 134 168
        L 126 142
        L 138 116
        Z
      "/>
      <polygon points="196,176 226,176 211,202" fill="#D97706"/>
    </g>
    '''
    wordmark = get_wordmark_paths(start_x=248, stroke_color="#0F172A", accent_color="#047857")
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760 256" width="760" height="256" role="img" aria-labelledby="title-lockup-c">
  <title id="title-lockup-c">waris.in Lockup - Concept C</title>
  {symbol_inner}
  <g id="wordmark">{wordmark}</g>
</svg>'''


def main():
    files = {
        "concept-a-symbol.svg": create_concept_a_symbol(),
        "concept-a-lockup.svg": create_concept_a_lockup(),
        "concept-b-symbol.svg": create_concept_b_symbol(),
        "concept-b-lockup.svg": create_concept_b_lockup(),
        "concept-c-symbol.svg": create_concept_c_symbol(),
        "concept-c-lockup.svg": create_concept_c_lockup(),
    }
    for name, content in files.items():
        path = os.path.join(BRANDING_DIR, name)
        with open(path, "w", encoding="utf-8") as f:
            f.write(content.strip())
        print(f"Wrote {path}")

if __name__ == "__main__":
    main()
