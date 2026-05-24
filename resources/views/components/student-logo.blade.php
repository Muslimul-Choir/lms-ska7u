<svg {{ $attributes->merge(['class' => 'w-8 h-8', 'viewBox' => '0 0 100 100', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="studLogoShieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#7a1a2e" />
      <stop offset="100%" stop-color="#400813" />
    </linearGradient>
    <linearGradient id="studLogoGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#fbbf24" />
      <stop offset="50%" stop-color="#d4a017" />
      <stop offset="100%" stop-color="#a17508" />
    </linearGradient>
  </defs>
  <!-- Outer Shield -->
  <path d="M50 5 C75 12 85 18 85 45 C85 68 70 84 50 93 C30 84 15 68 15 45 C15 18 25 12 50 5 Z" fill="url(#studLogoShieldGrad)" stroke="url(#studLogoGoldGrad)" stroke-width="4.5" stroke-linejoin="round" />
  
  <!-- Star on top -->
  <path d="M50 14 L52.2 20 L58.5 22 L52.2 24 L50 30 L47.8 24 L41.5 22 L47.8 20 Z" fill="url(#studLogoGoldGrad)" />

  <!-- Graduation Cap -->
  <path d="M50 33 L72 40 L50 47 L28 40 Z" fill="#ffffff" />
  <path d="M37 43.5 V51 C37 54.5 43 56.5 50 56.5 C57 56.5 63 54.5 63 51 V43.5" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />
  <!-- Tassel -->
  <path d="M61 40 L65 48 L65 54" fill="none" stroke="url(#studLogoGoldGrad)" stroke-width="2" stroke-linecap="round" />
  <circle cx="65" cy="55" r="1.5" fill="url(#studLogoGoldGrad)" />

  <!-- Open Book at the bottom -->
  <path d="M30 65 C38 61 46 62 50 64 C54 62 62 61 70 65 V78 C62 74 54 75 50 77 C46 75 38 74 30 78 V65 Z" fill="url(#studLogoGoldGrad)" />
  <path d="M50 64 V77" stroke="#400813" stroke-width="1.5" />
</svg>
