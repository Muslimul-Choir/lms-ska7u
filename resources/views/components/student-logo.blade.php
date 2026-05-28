<svg {{ $attributes->merge(['class' => 'w-8 h-8']) }} viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="slShield" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#8B1A2E"/>
      <stop offset="100%" stop-color="#2D0810"/>
    </linearGradient>
    <linearGradient id="slGold" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F5C842"/>
      <stop offset="50%" stop-color="#E8930A"/>
      <stop offset="100%" stop-color="#C47A05"/>
    </linearGradient>
    <linearGradient id="slGlow" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" stop-color="#ffffff" stop-opacity="0.18"/>
      <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
    </linearGradient>
    <filter id="slShadow" x="-10%" y="-10%" width="120%" height="130%">
      <feDropShadow dx="0" dy="3" stdDeviation="4" flood-color="#2D0810" flood-opacity="0.4"/>
    </filter>
  </defs>

  <!-- Shield body -->
  <path d="M60 6 C88 14 98 22 98 52 C98 78 82 96 60 108 C38 96 22 78 22 52 C22 22 32 14 60 6 Z"
        fill="url(#slShield)" filter="url(#slShadow)"/>

  <!-- Shield inner glow overlay -->
  <path d="M60 10 C86 17 95 24 95 52 C95 76 80 93 60 104 C40 93 25 76 25 52 C25 24 34 17 60 10 Z"
        fill="url(#slGlow)"/>

  <!-- Shield border -->
  <path d="M60 6 C88 14 98 22 98 52 C98 78 82 96 60 108 C38 96 22 78 22 52 C22 22 32 14 60 6 Z"
        fill="none" stroke="url(#slGold)" stroke-width="3" stroke-linejoin="round"/>

  <!-- Graduation cap board (mortarboard) -->
  <polygon points="60,30 88,42 60,54 32,42" fill="#ffffff" opacity="0.95"/>

  <!-- Cap top (square) -->
  <rect x="51" y="22" width="18" height="18" rx="2" fill="url(#slGold)" transform="rotate(45 60 31)"/>

  <!-- Cap stem + tassel -->
  <line x1="60" y1="30" x2="60" y2="22" stroke="url(#slGold)" stroke-width="2.5" stroke-linecap="round"/>
  <line x1="82" y1="42" x2="82" y2="56" stroke="url(#slGold)" stroke-width="2.5" stroke-linecap="round"/>
  <circle cx="82" cy="58" r="3" fill="url(#slGold)"/>
  <line x1="82" y1="58" x2="78" y2="64" stroke="url(#slGold)" stroke-width="1.5" stroke-linecap="round"/>
  <line x1="82" y1="58" x2="86" y2="64" stroke="url(#slGold)" stroke-width="1.5" stroke-linecap="round"/>

  <!-- Diploma scroll -->
  <rect x="38" y="62" width="44" height="28" rx="5" fill="url(#slGold)" opacity="0.9"/>
  <rect x="41" y="65" width="38" height="22" rx="3" fill="#fff" opacity="0.25"/>
  <!-- Scroll lines -->
  <line x1="46" y1="72" x2="74" y2="72" stroke="#fff" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
  <line x1="46" y1="78" x2="74" y2="78" stroke="#fff" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
  <line x1="46" y1="84" x2="64" y2="84" stroke="#fff" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
  <!-- Ribbon -->
  <rect x="56" y="60" width="8" height="32" rx="2" fill="#8B1A2E" opacity="0.6"/>

  <!-- Stars top corners -->
  <path d="M38 20 L39.2 23.5 L43 24.5 L39.2 25.5 L38 29 L36.8 25.5 L33 24.5 L36.8 23.5 Z" fill="url(#slGold)" opacity="0.8"/>
  <path d="M82 20 L83.2 23.5 L87 24.5 L83.2 25.5 L82 29 L80.8 25.5 L77 24.5 L80.8 23.5 Z" fill="url(#slGold)" opacity="0.8"/>
</svg>
