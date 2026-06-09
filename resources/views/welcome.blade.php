<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LMS SKA7U - Platform pembelajaran digital SMK Negeri 7 Batam. Belajar lebih mudah, terorganisir, dan menyenangkan.">
    <meta name="keywords" content="LMS, SMK Negeri 7 Batam, belajar online, pembelajaran digital, SKA7U">
    <meta name="author" content="SMK Negeri 7 Batam">
    <meta property="og:title" content="LMS SKA7U - SMK Negeri 7 Batam">
    <meta property="og:description" content="Platform pembelajaran digital SMK Negeri 7 Batam.">
    <meta property="og:type" content="website">

    <title>LMS SKA7U - SMK Negeri 7 Batam</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Base ── */
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --maroon:       #7B1C1C;
            --maroon-dark:  #5A1212;
            --maroon-light: #9B2C2C;
            --gold:         #C9960C;
            --gold-light:   #F0BE3D;
            --cream:        #FDF8F0;
            --white:        #FFFFFF;
            --gray-50:      #F9FAFB;
            --gray-100:     #F3F4F6;
            --gray-600:     #4B5563;
            --gray-800:     #1F2937;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--white);
            color: var(--gray-800);
            margin: 0;
            overflow-x: hidden;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 9999px;
        }

        h1, h2, h3, h4, .font-display {
            font-family: 'Poppins', sans-serif;
        }

        /* ── Page-load fade in ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-32px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.92); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }

        .anim-fade-up   { animation: fadeUp   0.7s ease both; }
        .anim-fade-in   { animation: fadeIn   0.6s ease both; }
        .anim-slide-r   { animation: slideRight 0.7s ease both; }
        .anim-scale-in  { animation: scaleIn  0.6s ease both; }
        .float-anim     { animation: floatY   4s ease-in-out infinite; }

        .delay-100 { animation-delay: 0.10s; }
        .delay-200 { animation-delay: 0.20s; }
        .delay-300 { animation-delay: 0.30s; }
        .delay-400 { animation-delay: 0.40s; }
        .delay-500 { animation-delay: 0.50s; }
        .delay-600 { animation-delay: 0.60s; }

        /* ── Scroll-reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── Navbar ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            transition: background 0.3s, box-shadow 0.3s, backdrop-filter 0.3s;
        }
        .navbar.scrolled {
            background: rgba(123, 28, 28, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.18);
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 38px; height: 38px;
            background: rgba(232, 147, 10, 0.18);
            border: 1px solid rgba(232, 147, 10, 0.35);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--white);
            line-height: 1.1;
        }
        .nav-logo-sub {
            font-size: 0.62rem;
            font-weight: 400;
            color: rgba(255,255,255,0.7);
            display: block;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
            margin: 0; padding: 0;
        }
        .nav-links a {
            font-size: 0.88rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--gold-light); }
        .nav-cta {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--maroon-dark) !important;
            font-weight: 600 !important;
            padding: 0.45rem 1.2rem;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s !important;
        }
        .nav-cta:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(201,150,12,0.35);
            color: var(--maroon-dark) !important;
        }
        .mobile-menu-btn {
            display: none;
            background: none; border: none; cursor: pointer;
            color: white; padding: 4px;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            top: 68px; left: 0; right: 0;
            background: rgba(90,18,18,0.97);
            backdrop-filter: blur(12px);
            padding: 1.2rem 1.5rem 1.5rem;
            z-index: 49;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .mobile-menu.open { display: block; }
        .mobile-menu a {
            display: block;
            padding: 0.75rem 0;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: color 0.2s;
        }
        .mobile-menu a:hover { color: var(--gold-light); }
        .mobile-menu a:last-child { border-bottom: none; }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu-btn { display: flex; }
        }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            background-image: url('all-jurusan.jpeg');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.808);
            z-index: 1;
        }
        .hero-bg-circles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .hero-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            background: #f5b504;
        }
        .hero-circle-1 { width: 600px; height: 600px; top: -200px; right: -150px; }
        .hero-circle-2 { width: 300px; height: 300px; bottom: -80px; left: -80px; }
        .hero-circle-3 { width: 180px; height: 180px; top: 30%; left: 40%; opacity: 0.04; }

        .hero-grid-line {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.274) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.274) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 7rem 1.5rem 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(240,190,61,0.15);
            border: 1px solid rgba(240,190,61,0.3);
            color: var(--gold-light);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.3rem 0.8rem;
            border-radius: 100px;
            margin-bottom: 1.2rem;
            letter-spacing: 0.02em;
        }

        .hero-title {
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.15;
            margin: 0 0 1rem;
        }
        .hero-title .highlight {
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .hero-desc {
            font-size: 1.02rem;
            color: rgba(255,255,255,0.72);
            line-height: 1.75;
            margin: 0 0 2rem;
            max-width: 460px;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--maroon-dark);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.75rem 1.8rem;
            border-radius: 10px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none; cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(201,150,12,0.4);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.25);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.75rem 1.8rem;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
            cursor: pointer;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.45);
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 196, 0, 0.479);
        }
        .hero-stat-num {
            font-family: 'Poppins', sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.55);
            margin-top: 0.2rem;
        }

        /* ── Hero visual (right side) ── */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero-card-main {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 1.8rem;
            width: 100%;
            max-width: 340px;
            position: relative;
            z-index: 2;
        }
        .hero-card-accent {
            position: absolute;
            top: -30px; right: -20px;
            background: rgba(255, 255, 255, 0.199);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 1rem 1.2rem;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.8);
            z-index: 3;
        }
        .hero-card-bottom {
            position: absolute;
            bottom: -25px; left: -25px;
            background: rgba(201,150,12,0.199);
            border: 1px solid rgba(201,150,12,0.3);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 0.9rem 1.2rem;
            font-size: 0.8rem;
            color: var(--gold-light);
            z-index: 3;
        }
        .card-course-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .card-course-item:last-child { border-bottom: none; padding-bottom: 0; }
        .course-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .course-title-sm {
            font-size: 0.82rem;
            font-weight: 500;
            color: rgba(255,255,255,0.88);
        }
        .course-meta {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.45);
        }
        .progress-bar-wrap {
            background: rgba(255,255,255,0.1);
            border-radius: 100px;
            height: 4px;
            margin-top: 4px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
        }

        @media (max-width: 768px) {
            .hero-inner {
                grid-template-columns: 1fr;
                padding-top: 6rem;
                text-align: center;
            }
            .hero-desc { margin: 0 auto 2rem; }
            .hero-actions { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-visual { margin-top: 1rem; }
            .hero-card-accent, .hero-card-bottom { display: none; }
        }

        /* ── Section shared ── */
        .section {
            padding: 5rem 1.5rem;
        }
        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.5rem;
        }
        .section-title {
            font-size: clamp(1.7rem, 3vw, 2.3rem);
            font-weight: 700;
            color: var(--gray-800);
            line-height: 1.25;
            margin: 0 0 1rem;
        }
        .section-desc {
            font-size: 1rem;
            color: var(--gray-600);
            line-height: 1.75;
            max-width: 520px;
        }

        /* ── Features ── */
        .features-bg {
            background: var(--gray-50);
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        @media (max-width: 900px) {
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .features-grid { grid-template-columns: 1fr; }
        }

        .feature-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.75rem;
            border: 1px solid #EEE;
            transition: transform 0.25s, box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--maroon), var(--gold));
            opacity: 0;
            transition: opacity 0.25s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
        }
        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0 0 0.5rem;
        }
        .feature-desc {
            font-size: 0.88rem;
            color: var(--gray-600);
            line-height: 1.7;
            margin: 0;
        }

        /* ── How it works (repurposed as info strip) ── */
        .strip {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
            padding: 4rem 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .strip::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }
        .strip-inner {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        @media (max-width: 768px) {
            .strip-inner { grid-template-columns: 1fr; }
        }
        .strip-title {
            font-size: clamp(1.6rem, 2.8vw, 2.1rem);
            font-weight: 700;
            color: var(--white);
            line-height: 1.25;
            margin: 0 0 1rem;
        }
        .strip-desc {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.68);
            line-height: 1.75;
            margin: 0 0 2rem;
        }
        .strip-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .strip-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            padding: 1.1rem 1.3rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: background 0.2s;
        }
        .strip-card:hover { background: rgba(255,255,255,0.1); }
        .strip-card-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: rgba(240,190,61,0.15);
            border: 1px solid rgba(240,190,61,0.25);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .strip-card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--white);
            margin: 0 0 0.25rem;
        }
        .strip-card-desc {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.55);
            margin: 0;
            line-height: 1.6;
        }

        /* ── Glassy info cards ── */
        .glass-section {
            background: var(--cream);
            padding: 5rem 1.5rem;
        }
        .glass-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.2rem;
            margin-top: 3rem;
        }
        @media (max-width: 900px) {
            .glass-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .glass-grid { grid-template-columns: 1fr; }
        }
        .glass-card {
            background: rgba(255,255,255,0.65);
            border: 1px solid rgba(201,150,12,0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 1.8rem 1.5rem;
            text-align: center;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(123,28,28,0.1);
        }
        .glass-num {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--maroon), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 0.4rem;
        }
        .glass-label {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* ── Footer ── */
        footer {
            background: var(--maroon-dark);
            color: rgba(255,255,255,0.75);
            padding: 3.5rem 1.5rem 2rem;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        @media (max-width: 768px) {
            .footer-top { grid-template-columns: 1fr; gap: 2rem; }
        }
        .footer-brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--white);
            margin: 0 0 0.35rem;
        }
        .footer-brand-school {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
            margin: 0 0 1rem;
        }
        .footer-brand-desc {
            font-size: 0.85rem;
            line-height: 1.75;
            color: rgba(255,255,255,0.55);
            margin: 0;
        }
        .footer-heading {
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--white);
            margin: 0 0 1rem;
            letter-spacing: 0.03em;
        }
        .footer-links {
            list-style: none;
            margin: 0; padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .footer-links a {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--gold-light); }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            font-size: 0.84rem;
            color: rgba(255,255,255,0.55);
            margin-bottom: 0.7rem;
        }
        .footer-contact-item svg {
            flex-shrink: 0;
            margin-top: 2px;
            color: var(--gold);
        }
        .footer-bottom {
            padding-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-copy {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.35);
        }

        /* ── Scroll to top ── */
        #scrollTop {
            position: fixed;
            bottom: 1.5rem; right: 1.5rem;
            width: 44px; height: 44px;
            background: var(--gold);
            color: var(--maroon-dark);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            border: none;
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.3s, transform 0.3s;
            z-index: 40;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        #scrollTop.show {
            opacity: 1;
            transform: translateY(0);
        }
        #scrollTop:hover { background: var(--gold-light); }

        /* ── Reduced motion ── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body class="scrollbar-thin">

<!-- ======================== NAVBAR ======================== -->
<nav class="navbar anim-fade-in" id="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <img src="{{ asset('LogoSMKN7Batam.png') }}" alt="Logo SMKN 7 Batam"
                    class="w-8 h-8 object-contain">
            </div>
            <div>
                <span class="nav-logo-text">LMS SKA7U</span>
                <span class="nav-logo-sub">SMK Negeri 7 Batam</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#kontak">Kontak</a></li>
            @auth
                <li><a href="{{ url('/dashboard') }}" class="nav-cta">Dashboard</a></li>
            @else
                <li><a href="{{ route('login') }}" class="nav-cta">Masuk</a></li>
            @endauth
        </ul>

        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="#fitur">Fitur</a>
    <a href="#tentang">Tentang</a>
    <a href="#kontak">Kontak</a>
    @auth
        <a href="{{ url('/dashboard') }}" style="color: var(--gold-light); font-weight: 600;">Dashboard</a>
    @else
        <a href="{{ route('login') }}" style="color: var(--gold-light); font-weight: 600;">Masuk ke LMS</a>
    @endauth
</div>


<!-- ======================== HERO ======================== -->
<section class="hero">
    <div class="hero-bg-circles">
        <div class="hero-circle hero-circle-1"></div>
        <div class="hero-circle hero-circle-2"></div>
        <div class="hero-circle hero-circle-3"></div>
    </div>
    <div class="hero-grid-line"></div>

    <div class="hero-inner">
        <!-- Left -->
        <div>
            <div class="hero-badge anim-fade-in delay-100">
                <!-- Heroicon: sparkles mini -->
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
                </svg>
                Platform Pembelajaran Digital
            </div>
            <h1 class="hero-title anim-fade-up delay-200">
                Belajar Lebih Mudah<br>
                dengan <span class="highlight">LMS SKA7U</span>
            </h1>
            <p class="hero-desc anim-fade-up delay-300">
                Platform pembelajaran digital resmi SMK Negeri 7 Batam. Akses materi, kumpulkan tugas, dan pantau perkembangan belajar kapan saja dan di mana saja.
            </p>
            <div class="hero-actions anim-fade-up delay-400">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                        <!-- Heroicon: arrow-right-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk Sekarang
                    </a>
                @endauth
                <a href="#fitur" class="btn-outline">
                    Pelajari Fitur
                </a>
            </div>

            <div class="hero-stats anim-fade-up delay-500">
                <div>
                    <div class="hero-stat-num">30+</div>
                    <div class="hero-stat-label">Guru Aktif</div>
                </div>
                <div>
                    <div class="hero-stat-num">1.000+</div>
                    <div class="hero-stat-label">Siswa Terdaftar</div>
                </div>
                <div>
                    <div class="hero-stat-num">100+</div>
                    <div class="hero-stat-label">Materi Tersedia</div>
                </div>
            </div>
        </div>

        <!-- Right: Glassy card -->
        <div class="hero-visual anim-scale-in delay-400">
            <div class="hero-card-main float-anim">
                <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1.2rem;">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,var(--gold),var(--gold-light));border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#5A1212" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span style="font-family:'Poppins',sans-serif;font-size:0.9rem;font-weight:600;color:white;">Mata Pelajaran Aktif</span>
                </div>

                <div class="card-course-item">
                    <div class="course-dot" style="background:#F0BE3D;"></div>
                    <div style="flex:1;">
                        <div class="course-title-sm">Pemrograman Web</div>
                        <div class="course-meta">Kelas XI RPL</div>
                        <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:78%;"></div></div>
                    </div>
                    <span style="font-size:0.7rem;color:rgba(255,255,255,0.5);">78%</span>
                </div>

                <div class="card-course-item">
                    <div class="course-dot" style="background:#60A5FA;"></div>
                    <div style="flex:1;">
                        <div class="course-title-sm">Basis Data</div>
                        <div class="course-meta">Kelas XII RPL</div>
                        <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:54%;"></div></div>
                    </div>
                    <span style="font-size:0.7rem;color:rgba(255,255,255,0.5);">54%</span>
                </div>

                <div class="card-course-item">
                    <div class="course-dot" style="background:#34D399;"></div>
                    <div style="flex:1;">
                        <div class="course-title-sm">Matematika</div>
                        <div class="course-meta">Kelas X TKJ</div>
                        <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:91%;"></div></div>
                    </div>
                    <span style="font-size:0.7rem;color:rgba(255,255,255,0.5);">91%</span>
                </div>
            </div>

            <div class="hero-card-accent">
                <div style="display:flex;align-items:center;gap:0.4rem;color:var(--gold-light);font-weight:600;font-size:0.82rem;margin-bottom:0.2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Aktivitas Akademik
                </div>
                <span style="color:rgba(255,255,255,0.6);font-size:0.75rem;">Pantau tugas, kuis, dan progres</span>
            </div>

            <div class="hero-card-bottom">
                <div style="display:flex;align-items:center;gap:0.4rem;font-weight:600;font-size:0.82rem;margin-bottom:0.2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    Jadwal Belajar
                </div>
                <span style="font-size:0.75rem;opacity:0.7;">Tersusun & terorganisir</span>
            </div>
        </div>
    </div>
</section>


<!-- ======================== STATS GLASS ======================== -->
<section class="glass-section" id="tentang">
    <div class="section-inner">
        <div style="text-align:center; margin-bottom:0;">
            <div class="section-label reveal">SMK Negeri 7 Batam</div>
            <h2 class="section-title reveal" style="text-align:center; margin:0 auto 0.5rem;">Sekolah Kejuruan Terbaik di Batam</h2>
            <p class="section-desc reveal" style="margin:0 auto; text-align:center;">LMS SKA7U hadir untuk mendukung proses belajar mengajar yang lebih efisien dan terstruktur di SMK Negeri 7 Batam.</p>
        </div>
        <div class="glass-grid">
            <div class="glass-card reveal">
                <div class="glass-num">30+</div>
                <div class="glass-label">Tenaga Pengajar</div>
            </div>
            <div class="glass-card reveal delay-100">
                <div class="glass-num">1.000+</div>
                <div class="glass-label">Siswa Aktif</div>
            </div>
            <div class="glass-card reveal delay-200">
                <div class="glass-num">6</div>
                <div class="glass-label">Kompetensi Keahlian</div>
            </div>
            <div class="glass-card reveal delay-300">
                <div class="glass-num">100+</div>
                <div class="glass-label">Materi Digital</div>
            </div>
        </div>
    </div>
</section>


<!-- ======================== FEATURES ======================== -->
<section class="section features-bg" id="fitur">
    <div class="section-inner">
        <div style="max-width:520px;">
            <div class="section-label reveal">Fitur Unggulan</div>
            <h2 class="section-title reveal">Semua yang Kamu Butuhkan Ada di Sini</h2>
            <p class="section-desc reveal">Dirancang khusus untuk kebutuhan pembelajaran SMK Negeri 7 Batam agar guru dan siswa dapat berinteraksi lebih efektif.</p>
        </div>

        <div class="features-grid">
            <!-- Card 1 -->
            <div class="feature-card reveal">
                <div class="feature-icon" style="background:#FEF3C7;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#B45309" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="feature-title">Materi Digital</h3>
                <p class="feature-desc">Guru dapat mengunggah materi pelajaran dalam berbagai format. Siswa bisa mengakses kapan saja tanpa batasan waktu.</p>
            </div>

            <!-- Card 2 -->
            <div class="feature-card reveal delay-100">
                <div class="feature-icon" style="background:#FEE2E2;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#B91C1C" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="feature-title">Pengumpulan Tugas & Kuis</h3>
                <p class="feature-desc">Siswa mengumpulkan tugas dan menjawab kuis secara online. Guru dapat langsung memberikan penilaian.</p>
            </div>

            <!-- Card 3 -->
            <div class="feature-card reveal delay-200">
                <div class="feature-icon" style="background:#DCFCE7;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#15803D" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Jadwal Belajar</h3>
                <p class="feature-desc">Jadwal pelajaran tersinkron otomatis sehingga siswa dan guru tidak perlu khawatir melewatkan sesi belajar penting.</p>
            </div>

            <!-- Card 4 -->
            <div class="feature-card reveal">
                <div class="feature-icon" style="background:#EDE9FE;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#6D28D9" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Pantau Aktivitas</h3>
                <p class="feature-desc">Kelola tugas, kuis, dan absensi dalam satu platform. Seluruh aktivitas pembelajaran dapat dipantau secara mudah dan terorganisir.</p>
            </div>

            <!-- Card 5 -->
            <div class="feature-card reveal delay-100">
                <div class="feature-icon" style="background:#DBEAFE;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#1D4ED8" stroke-width="1.8">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                    </svg>
                </div>
                <h3 class="feature-title">Manajemen Kelas</h3>
                <p class="feature-desc">Kelola kelas, mata pelajaran, dan peserta didik dengan lebih terstruktur dalam satu platform.</p>
            </div>

            <!-- Card 6 -->
            <div class="feature-card reveal delay-200">
                <div class="feature-icon" style="background:#FFE4E6;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#BE123C" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Akses Aman</h3>
                <p class="feature-desc">Sistem login berbasis peran memastikan setiap pengguna hanya mengakses data yang sesuai dengan hak akses mereka.</p>
            </div>
        </div>
    </div>
</section>


<!-- ======================== INFO STRIP ======================== -->
<section class="strip">
    <div class="strip-inner">
        <div>
            <div class="section-label" style="color:var(--gold-light);" class="reveal">Untuk Siapa?</div>
            <h2 class="strip-title reveal">Dirancang untuk Seluruh Warga Sekolah</h2>
            <p class="strip-desc reveal">LMS SKA7U melayani kebutuhan guru, siswa, dan tenaga kependidikan SMK Negeri 7 Batam dalam satu platform terpadu.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary reveal" style="display:inline-flex;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary reveal" style="display:inline-flex;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk ke LMS
                </a>
            @endauth
        </div>

        <div class="strip-cards">
            <div class="strip-card reveal">
                <div class="strip-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#F0BE3D" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="strip-card-title">Guru</p>
                    <p class="strip-card-desc">Kelola kelas, unggah materi, beri nilai tugas, dan pantau kuis siswa dari satu tempat.</p>
                </div>
            </div>
            <div class="strip-card reveal delay-100">
                <div class="strip-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#F0BE3D" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="strip-card-title">Siswa</p>
                    <p class="strip-card-desc">Akses materi pelajaran, kumpulkan tugas tepat waktu, dan lihat nilai secara langsung dari dashboard siswa.</p>
                </div>
            </div>
            <div class="strip-card reveal delay-200">
                <div class="strip-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#F0BE3D" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="strip-card-title">Administrasi</p>
                    <p class="strip-card-desc">Kelola data pengguna, kelas, dan jadwal sekolah dari panel administrasi yang mudah digunakan.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ======================== FOOTER ======================== -->
<footer id="kontak">
    <div class="footer-inner">
        <div class="footer-top">
            <!-- Brand -->
            <div>
                <p class="footer-brand-name">LMS SKA7U</p>
                <p class="footer-brand-school">SMK Negeri 7 Batam</p>
                <p class="footer-brand-desc">Platform pembelajaran digital resmi SMK Negeri 7 Batam. Mendukung proses belajar mengajar yang lebih modern, efisien, dan menyenangkan.</p>
            </div>

            <!-- Navigasi -->
            <div>
                <p class="footer-heading">Navigasi</p>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    @auth
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <p class="footer-heading">Kontak Sekolah</p>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Komp. Koperasi Pemko, Batam centre, Belian, Kec. Batam Kota, Kota Batam, Kepulauan Riau, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>smknegeri7batam@gmail.com</span>
                </div>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>0811-7779-492</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} LMS SKA7U - SMK Negeri 7 Batam. Hak cipta dilindungi.</p>
            <p class="footer-copy">Dibuat dengan semangat untuk pendidikan Batam.</p>
        </div>
    </div>
</footer>


<!-- Scroll to top -->
<button id="scrollTop" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
    </svg>
</button>


<script>
    // ── Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
        document.getElementById('scrollTop').classList.toggle('show', window.scrollY > 300);
    }, { passive: true });

    // ── Mobile menu toggle
    const menuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
    });
    // Close menu on link click
    mobileMenu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => mobileMenu.classList.remove('open'));
    });

    // ── Scroll to top
    document.getElementById('scrollTop').addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ── Scroll reveal using IntersectionObserver
    const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach(el => observer.observe(el));

    // ── Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 80;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
            }
        });
    });
</script>

</body>
</html>