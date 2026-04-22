<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صحتي – مستشفى طبي متكامل</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ══════════════════════════════════════════
           RESET & CSS VARIABLES
        ══════════════════════════════════════════ */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --sky:    #d6ecf5;
            --blue:   #1a5f7a;
            --teal:   #2d8fa5;
            --mint:   #3ecf8e;
            --dark:   #0e2a38;
            --light:  #f0f8fc;
            --card:   rgba(255,255,255,0.78);
            --glass:  rgba(255,255,255,0.5);
            --shadow: 0 8px 40px rgba(26,95,122,0.12);
            --shadow-lg: 0 20px 60px rgba(26,95,122,0.2);
            --radius: 20px;
            --font-ar: 'Cairo', 'Tajawal', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-ar);
            background: linear-gradient(160deg, #e4f3fb 0%, #cce8f4 45%, #b5ddf0 100%);
            min-height: 100vh;
            color: var(--dark);
            overflow-x: hidden;
        }

        body::after {
            content: '';
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.025'/%3E%3C/svg%3E");
        }

        /* ══════════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════════ */
        nav {
            position: sticky; top: 0; z-index: 200;
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            background: rgba(220,240,250,0.75);
            border-bottom: 1px solid rgba(255,255,255,0.6);
            height: 70px;
            padding: 0 6%;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 24px rgba(26,95,122,0.08);
        }

        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: var(--blue);
            font-size: 1.45rem; font-weight: 900; letter-spacing: -0.5px;
        }
        .nav-logo .logo-icon {
            width: 38px; height: 38px; background: var(--blue);
            border-radius: 12px; display: grid; place-items: center;
            color: white; font-size: 1rem;
            box-shadow: 0 4px 14px rgba(26,95,122,0.35);
        }

        .nav-center {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.5);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 50px;
            padding: .3rem .5rem; gap: 0;
        }
        .nav-center a {
            font-size: .88rem; font-weight: 600; color: var(--dark);
            text-decoration: none; padding: .45rem 1.1rem;
            border-radius: 50px; transition: all .2s;
            white-space: nowrap;
        }
        .nav-center a:hover,
        .nav-center a.active { background: var(--blue); color: white; }

        .btn-nav {
            background: var(--dark); color: white;
            text-decoration: none; border-radius: 50px;
            padding: .55rem 1.5rem; font-size: .88rem; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
            transition: all .25s;
            box-shadow: 0 4px 16px rgba(14,42,56,0.3);
        }
        .btn-nav .dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--mint); animation: pulse-dot 2s infinite;
        }
        .btn-nav:hover { background: var(--blue); transform: translateY(-1px); }

        @keyframes pulse-dot {
            0%,100% { box-shadow: 0 0 0 0 rgba(62,207,142,0.5); }
            50%      { box-shadow: 0 0 0 7px rgba(62,207,142,0); }
        }

        /* ══════════════════════════════════════════
           HERO
        ══════════════════════════════════════════ */
        .hero {
            position: relative; z-index: 1;
            padding: 5rem 6% 4rem;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 4rem; align-items: center;
            min-height: calc(100vh - 70px);
        }

        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--card); backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.85);
            border-radius: 50px; padding: .4rem 1.1rem;
            font-size: .82rem; font-weight: 700; color: var(--blue);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }
        .hero-tag .pulse {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--mint); animation: pulse-dot 2s infinite;
        }

        .hero h1 {
            font-size: clamp(3.2rem, 6.5vw, 6rem);
            font-weight: 900; line-height: 1.05;
            color: var(--dark); letter-spacing: -2px;
            margin-bottom: 1.3rem;
        }
        .hero h1 em {
            font-style: normal; color: var(--teal);
        }

        .hero-desc {
            font-size: 1rem; color: #456; line-height: 1.85;
            max-width: 420px; margin-bottom: 2.2rem; font-weight: 400;
        }
        .hero-desc strong { color: var(--dark); font-weight: 700; }

        .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }

        .btn-primary {
            background: var(--blue); color: white;
            text-decoration: none; border-radius: 50px;
            padding: .9rem 2.2rem; font-size: .95rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 28px rgba(26,95,122,0.35);
            transition: all .25s;
        }
        .btn-primary:hover { background: var(--teal); transform: translateY(-2px); box-shadow: 0 14px 36px rgba(26,95,122,0.4); }

        .btn-outline {
            background: transparent; color: var(--blue);
            border: 2px solid var(--blue);
            text-decoration: none; border-radius: 50px;
            padding: .88rem 2rem; font-size: .95rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all .25s;
        }
        .btn-outline:hover { background: var(--blue); color: white; }

        .hero-stats {
            display: flex; gap: 1rem; margin-top: 2.8rem; flex-wrap: wrap;
        }
        .stat-chip {
            background: var(--card); backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 18px; padding: .75rem 1.3rem;
            display: flex; align-items: center; gap: 12px;
            box-shadow: var(--shadow);
        }
        .stat-chip .s-icon {
            width: 36px; height: 36px; border-radius: 12px;
            background: linear-gradient(135deg, rgba(45,143,165,.15), rgba(26,95,122,.08));
            display: grid; place-items: center; font-size: 1rem;
        }
        .stat-chip .s-num {
            font-size: 1.35rem; font-weight: 900; color: var(--blue); line-height: 1;
        }
        .stat-chip .s-lbl { font-size: .72rem; color: #778; margin-top: 2px; }

        /* HERO VISUAL */
        .hero-visual {
            position: relative; display: flex; justify-content: center; align-items: center;
        }
        .hero-img-frame {
            width: 100%; max-width: 460px;
            border-radius: 28px; overflow: hidden;
            aspect-ratio: 3/4;
            box-shadow: var(--shadow-lg), 0 0 0 6px rgba(255,255,255,.45);
            position: relative;
        }
        .hero-img-frame img {
            width: 100%; height: 100%; object-fit: cover;
            mix-blend-mode: luminosity; opacity: .88;
        }
        .hero-img-frame::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(14,42,56,.5) 0%, transparent 55%);
        }

        .float-card {
            position: absolute;
            background: rgba(255,255,255,0.93);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.97);
            border-radius: 18px; padding: .85rem 1.3rem;
            box-shadow: 0 8px 32px rgba(26,95,122,0.18);
            white-space: nowrap;
        }
        .fc-right { top: 12%; left: -10%; animation: fc-float 4s ease-in-out infinite; }
        .fc-left  { bottom: 10%; right: -10%; animation: fc-float 4s ease-in-out infinite .9s; }
        .fc-num   { font-size: 1.45rem; font-weight: 900; color: var(--blue); line-height: 1; }
        .fc-lbl   { font-size: .7rem; font-weight: 600; color: #778; text-transform: uppercase; letter-spacing: 1px; }

        @keyframes fc-float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-10px); }
        }

        /* ══════════════════════════════════════════
           SHARED SECTION
        ══════════════════════════════════════════ */
        .section { padding: 5rem 6%; position: relative; z-index: 1; }

        .label-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--mint), #25b874);
            color: white; border-radius: 50px;
            padding: .3rem 1rem; font-size: .75rem; font-weight: 800;
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: .8rem;
        }

        .sec-title {
            font-size: clamp(1.7rem, 3vw, 2.6rem);
            font-weight: 900; color: var(--dark); line-height: 1.2;
            margin-bottom: .7rem; letter-spacing: -0.5px;
        }

        .sec-sub {
            font-size: .95rem; color: #567; line-height: 1.85; max-width: 540px;
        }

        .row-between {
            display: flex; justify-content: space-between;
            align-items: flex-end; gap: 1rem; flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        /* ══════════════════════════════════════════
           DEPARTMENTS
        ══════════════════════════════════════════ */
        .dept-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.4rem;
        }

        .dept-card {
            background: var(--card);
            backdrop-filter: blur(14px);
            border: 1.5px solid rgba(255,255,255,0.92);
            border-radius: var(--radius);
            padding: 1.4rem 1.3rem 1.3rem;
            text-decoration: none; color: inherit;
            display: flex; flex-direction: column; gap: .85rem;
            box-shadow: var(--shadow);
            position: relative; overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .dept-card::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(45,143,165,.08) 0%, transparent 60%);
            opacity: 0; transition: opacity .3s;
        }
        .dept-card:hover { transform: translateY(-7px); box-shadow: var(--shadow-lg); }
        .dept-card:hover::before { opacity: 1; }

        .dept-card .arrow-wrap {
            position: absolute; top: 1.1rem; left: 1.1rem;
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--mint); color: white;
            display: grid; place-items: center; font-size: .78rem;
            transition: transform .25s; z-index: 1;
        }
        .dept-card:hover .arrow-wrap { transform: rotate(-45deg); }

        .dept-img {
            width: 100%; height: 115px; border-radius: 13px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--sky), #a8d8ea);
        }
        .dept-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .4s ease;
        }
        .dept-card:hover .dept-img img { transform: scale(1.06); }

        .dept-name { font-size: 1rem; font-weight: 800; color: var(--dark); }
        .dept-count {
            font-size: .78rem; color: var(--teal); font-weight: 600;
            display: flex; align-items: center; gap: 5px;
        }

        .dept-card.dark {
            background: linear-gradient(145deg, var(--blue) 0%, var(--dark) 100%);
            border-color: transparent;
        }
        .dept-card.dark .dept-name { color: white; }
        .dept-card.dark .dept-count { color: var(--mint); }
        .dept-card.dark .arrow-wrap { background: white; color: var(--blue); }

        /* ══════════════════════════════════════════
           SERVICES
        ══════════════════════════════════════════ */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.4rem;
        }

        .svc-card {
            border-radius: var(--radius); overflow: hidden;
            position: relative; aspect-ratio: 4/3;
            box-shadow: var(--shadow-lg);
            transition: transform .35s ease;
        }
        .svc-card:hover { transform: scale(1.025); }

        .svc-card img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .svc-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(14,42,56,.82) 0%, rgba(14,42,56,.08) 55%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 1.5rem;
        }
        .svc-title { font-size: 1.1rem; font-weight: 800; color: white; margin-bottom: .3rem; }
        .svc-sub   { font-size: .78rem; color: rgba(255,255,255,.72); }

        .svc-btn {
            position: absolute; top: 1rem; left: 1rem;
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,.2); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.3);
            color: white; display: grid; place-items: center;
            font-size: .85rem; text-decoration: none;
            transition: background .25s;
        }
        .svc-card:hover .svc-btn { background: var(--mint); }

        /* ══════════════════════════════════════════
           DOCTORS
        ══════════════════════════════════════════ */
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(215px, 1fr));
            gap: 1.4rem;
        }

        .doc-card {
            background: var(--card);
            backdrop-filter: blur(14px);
            border: 1.5px solid rgba(255,255,255,0.92);
            border-radius: var(--radius); overflow: hidden;
            text-decoration: none; color: inherit;
            box-shadow: var(--shadow);
            transition: transform .3s, box-shadow .3s;
        }
        .doc-card:hover { transform: translateY(-7px); box-shadow: var(--shadow-lg); }

        .doc-photo {
            width: 100%; aspect-ratio: 1; overflow: hidden;
            background: linear-gradient(135deg, var(--sky), #a8d8ea);
            position: relative;
        }
        .doc-photo img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .4s;
        }
        .doc-card:hover .doc-photo img { transform: scale(1.05); }

        .doc-dept-badge {
            position: absolute; bottom: .8rem; right: .8rem;
            background: rgba(255,255,255,.92); backdrop-filter: blur(8px);
            border-radius: 50px; padding: .2rem .8rem;
            font-size: .72rem; font-weight: 700; color: var(--teal);
        }

        .doc-body { padding: 1.2rem 1rem; }
        .doc-name { font-size: 1rem; font-weight: 800; color: var(--dark); margin-bottom: .2rem; }
        .doc-spec { font-size: .8rem; color: var(--teal); font-weight: 600; margin-bottom: .5rem; }
        .doc-info-row { display: flex; align-items: center; gap: 5px; font-size: .75rem; color: #778; }
        .doc-stars { display: flex; gap: 2px; margin-top: .5rem; align-items: center; }
        .doc-stars i { color: #f59e0b; font-size: .72rem; }
        .doc-stars span { font-size: .72rem; color: #778; margin-left: 4px; }

        /* ══════════════════════════════════════════
           ABOUT
        ══════════════════════════════════════════ */
        .about-wrap {
            background: var(--card); backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255,255,255,.92);
            border-radius: 28px; padding: 3.5rem;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 4rem; align-items: center;
            box-shadow: var(--shadow-lg);
        }

        .about-gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .8rem;
        }
        .ag-main {
            grid-column: 1 / -1;
            border-radius: 18px; overflow: hidden;
            height: 200px; position: relative;
        }
        .ag-main img { width: 100%; height: 100%; object-fit: cover; }

        .ag-sm { border-radius: 13px; overflow: hidden; height: 120px; }
        .ag-sm img { width: 100%; height: 100%; object-fit: cover; }

        .about-founded {
            position: absolute; bottom: .8rem; right: .8rem;
            background: rgba(255,255,255,.93); backdrop-filter: blur(10px);
            border-radius: 14px; padding: .75rem 1.1rem;
        }
        .af-label { font-size: .68rem; color: var(--teal); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .af-date  { font-size: 1.1rem; font-weight: 900; color: var(--dark); }

        .about-tagline {
            font-size: 1.2rem; font-weight: 800; color: var(--blue);
            margin: .5rem 0 1rem; line-height: 1.5;
        }

        .about-phone {
            display: flex; align-items: center; gap: 10px; margin-top: 1.8rem;
        }
        .ph-icon {
            width: 44px; height: 44px; border-radius: 14px;
            background: var(--sky); color: var(--blue);
            display: grid; place-items: center; font-size: 1rem;
            flex-shrink: 0;
        }
        .ph-label { font-size: .72rem; color: #778; }
        .ph-num   { font-size: .95rem; font-weight: 800; color: var(--blue); }

        /* ══════════════════════════════════════════
           METRICS
        ══════════════════════════════════════════ */
        .metrics {
            background: linear-gradient(135deg, var(--dark) 0%, var(--blue) 100%);
            border-radius: 24px; padding: 2.8rem 2rem;
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 1rem; text-align: center;
            box-shadow: 0 24px 70px rgba(14,42,56,.35);
            position: relative; overflow: hidden;
        }
        .metrics::before {
            content: '';
            position: absolute; top: -60%; right: -15%;
            width: 420px; height: 420px; border-radius: 50%;
            background: rgba(62,207,142,.07); pointer-events: none;
        }
        .metric-item { position: relative; z-index: 1; }
        .metric-item + .metric-item {
            border-right: 1px solid rgba(255,255,255,.1);
        }
        .m-val { font-size: 2.4rem; font-weight: 900; color: white; line-height: 1; }
        .m-val span { color: var(--mint); }
        .m-lbl { font-size: .82rem; color: rgba(255,255,255,.55); margin-top: .5rem; }

        /* ══════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════ */
        footer {
            background: var(--dark); color: rgba(255,255,255,.65);
            padding: 4rem 6% 2rem; margin-top: 5rem;
            position: relative; z-index: 1;
        }

        .footer-top {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem; padding-bottom: 3rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .fb-logo {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.4rem; font-weight: 900; color: white; margin-bottom: 1rem;
        }
        .fb-logo .icon {
            width: 34px; height: 34px; background: var(--teal);
            border-radius: 10px; display: grid; place-items: center;
            color: white; font-size: .9rem;
        }
        .footer-brand p { font-size: .85rem; line-height: 1.85; max-width: 240px; }

        .footer-social { display: flex; gap: .6rem; margin-top: 1.2rem; }
        .footer-social a {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.6); text-decoration: none;
            display: grid; place-items: center; font-size: .85rem;
            transition: all .2s;
        }
        .footer-social a:hover { background: var(--teal); color: white; }

        .footer-col h4 {
            font-size: .82rem; font-weight: 800; color: white;
            text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 1.2rem;
        }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: .65rem; }
        .footer-col ul li a {
            color: rgba(255,255,255,.55); text-decoration: none;
            font-size: .85rem; transition: color .2s;
            display: flex; align-items: center; gap: 6px;
        }
        .footer-col ul li a::before {
            content: '←'; font-size: .68rem; color: var(--mint);
            transition: transform .2s;
        }
        .footer-col ul li a:hover { color: white; }
        .footer-col ul li a:hover::before { transform: translateX(-3px); }

        .footer-bottom {
            padding-top: 1.5rem;
            display: flex; justify-content: space-between; align-items: center;
            font-size: .8rem; flex-wrap: wrap; gap: .8rem;
        }
        .footer-bottom span { color: rgba(255,255,255,.4); }
        .footer-bottom .heart { color: var(--mint); }

        /* ══════════════════════════════════════════
           SCROLL REVEAL
        ══════════════════════════════════════════ */
        .reveal {
            opacity: 0; transform: translateY(32px);
            transition: opacity .65s ease, transform .65s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ══════════════════════════════════════════
           EMPTY STATE
        ══════════════════════════════════════════ */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center; padding: 4rem; color: #89a;
        }
        .empty-state i { font-size: 3rem; display: block; margin-bottom: 1rem; opacity: .4; }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .hero { grid-template-columns: 1fr; min-height: auto; padding-top: 3rem; }
            .hero-visual { display: none; }
            .about-wrap { grid-template-columns: 1fr; }
            .services-grid { grid-template-columns: 1fr 1fr; }
            .metrics { grid-template-columns: repeat(2, 1fr); }
            .footer-top { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 700px) {
            nav { padding: 0 4%; }
            .nav-center { display: none; }
            .section { padding: 3.5rem 4%; }
            .hero { padding: 2.5rem 4% 3rem; }
            .hero h1 { font-size: 2.8rem; }
            .services-grid { grid-template-columns: 1fr; }
            .metrics { grid-template-columns: 1fr 1fr; gap: 1.5rem; }
            .footer-top { grid-template-columns: 1fr; gap: 2rem; }
        }
    </style>
</head>
<body>

{{-- ════════════════════ NAVBAR ════════════════════ --}}
<nav>
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        نوفيكا
    </a>

    <div class="nav-center">
        <a href="{{ route('home') }}" class="active">الرئيسية</a>
        <a href="{{ route('about') }}">من نحن</a>
        <a href="{{ route('departments.index') }}">الأقسام</a>
        <a href="{{ route('doctors.index') }}">الأطباء</a>
        <a href="{{ route('contact') }}">اتصل بنا</a>
    </div>

    <a href="{{ route('contact') }}" class="btn-nav">
        <span class="dot"></span>
        احجز موعدك
    </a>
</nav>

{{-- ════════════════════ HERO ════════════════════ --}}
<section class="hero">
    <div class="hero-text">
        <div class="hero-tag">
            <span class="pulse"></span>
            علاج سريع ومتقدم
        </div>
        <h1>رعاية<br><em>ذكية</em><br>متكاملة</h1>
        <p class="hero-desc">
            <strong>نوفيكا</strong> وجهتك للحصول على علاج عالمي المستوى مع
            <strong>أطباء متخصصين</strong> وتشخيص دقيق تحت سقف واحد.
        </p>
        <div class="hero-btns">
            <a href="{{ route('departments.index') }}" class="btn-primary">
                استكشف أقسامنا <i class="fa-solid fa-arrow-left"></i>
            </a>
            <a href="{{ route('doctors.index') }}" class="btn-outline">
                <i class="fa-solid fa-user-doctor"></i> تعرف على أطبائنا
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-chip">
                <div class="s-icon">🏆</div>
                <div>
                    <div class="s-num">490</div>
                    <div class="s-lbl">جائزة طبية</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="s-icon">📅</div>
                <div>
                    <div class="s-num">22</div>
                    <div class="s-lbl">عام من التميز</div>
                </div>
            </div>
            <div class="stat-chip">
                <div class="s-icon">🫁</div>
                <div>
                    <div class="s-num">6700</div>
                    <div class="s-lbl">حالة شُفيت</div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-img-frame">
            <img src="https://i.pinimg.com/736x/92/16/68/9216680f7fc62d03dc2f9b8d76704c32.jpg" alt="طبيبة روان">
        </div>
        <div class="float-card fc-right">
            <div class="fc-num">{{ $departments->count() }}</div>
            <div class="fc-lbl">قسم طبي</div>
        </div>
        <div class="float-card fc-left">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:1.3rem">🩺</span>
                <div>
                    <div class="fc-num">{{ $doctors->count() }}+</div>
                    <div class="fc-lbl">متخصص</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════ DEPARTMENTS ════════════════════ --}}
<section class="section reveal">
    <div class="row-between">
        <div>
            <div class="label-badge">تخصصاتنا</div>
            <h2 class="sec-title">أقسامنا الطبية</h2>
            <p class="sec-sub">اكتشف أقسامنا المجهزة بأحدث التقنيات وأفضل الكوادر الطبية المتخصصة.</p>
        </div>
        <a href="{{ route('departments.index') }}" class="btn-outline">عرض الكل ←</a>
    </div>

    <div class="dept-grid">
        @php
            $deptImages = [
                'https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?w=400&q=70',
                'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&q=70',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&q=70',
                'https://images.unsplash.com/photo-1551884831-bbf3cdc6469e?w=400&q=70',
                'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=400&q=70',
                'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=400&q=70',
                'https://images.unsplash.com/photo-1607619056574-7b8d3ee536b2?w=400&q=70',
                'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&q=70',
            ];
        @endphp

        @forelse ($departments as $i => $dept)
            <a href="{{ route('departments.show', $dept->id) }}"
               class="dept-card {{ $i === 3 ? 'dark' : '' }}">

                <div class="arrow-wrap"><i class="fa-solid fa-arrow-left"></i></div>

                <div class="dept-img">
                    <img
                        src="{{ $deptImages[$i % count($deptImages)] }}"
                        alt="{{ $dept->name }}"
                        loading="lazy"
                    >
                </div>

                <div class="dept-name">{{ $dept->name }}</div>
                <div class="dept-count">
                    <i class="fa-solid fa-user-doctor"></i>
php                    {{ $dept->doctors_count }}
                    {{ $dept->doctors_count == 1 ? 'طبيب' : 'أطباء' }}
                </div>
            </a>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-folder-open"></i>
                لا توجد أقسام متاحة حالياً
            </div>
        @endforelse
    </div>
</section>

{{-- ════════════════════ SERVICES ════════════════════ --}}
<section class="section reveal">
    <div class="row-between">
        <div>
            <div class="label-badge">خدماتنا المميزة</div>
            <h2 class="sec-title">نقدم رعاية استثنائية</h2>
        </div>
    </div>

    <div class="services-grid">
        <div class="svc-card">
            <img src="https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?w=700&q=80" alt="صحة المخ">
            <div class="svc-overlay">
                <div class="svc-title">فحص صحة المخ</div>
                <div class="svc-sub">تشخيص دقيق بأحدث الأجهزة</div>
            </div>
            <a href="{{ route('departments.index') }}" class="svc-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <div class="svc-card">
            <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=700&q=80" alt="وظائف الكبد">
            <div class="svc-overlay">
                <div class="svc-title">اختبار وظائف الكبد</div>
                <div class="svc-sub">تحاليل شاملة ودقيقة</div>
            </div>
            <a href="{{ route('departments.index') }}" class="svc-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <div class="svc-card">
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=700&q=80" alt="صحة الكلى">
            <div class="svc-overlay">
                <div class="svc-title">مسح صحة الكلى</div>
                <div class="svc-sub">تصوير متقدم بالموجات فوق الصوتية</div>
            </div>
            <a href="{{ route('departments.index') }}" class="svc-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════ DOCTORS ════════════════════ --}}
<section class="section reveal">
    <div class="row-between">
        <div>
            <div class="label-badge">فريقنا الطبي</div>
            <h2 class="sec-title">أطباؤنا المتخصصون</h2>
            <p class="sec-sub">نخبة من أفضل الأطباء المعتمدين ذوي الخبرة الدولية والمحلية.</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="btn-outline">جميع الأطباء ←</a>
    </div>

    <div class="doctors-grid">
        @php
            $docPhotos = [
                'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&q=75',
                'https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400&q=75',
                'https://images.unsplash.com/photo-1537368910025-700350fe46c7?w=400&q=75',
                'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=75',
                'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&q=75',
                'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?w=400&q=75',
            ];
        @endphp

        @forelse ($doctors as $i => $doctor)
            <a href="{{ route('doctors.show', $doctor->id) }}" class="doc-card">
                <div class="doc-photo">
                    @if($doctor->user?->avatar)
                        <img src="{{ asset('storage/' . $doctor->user->avatar) }}" alt="{{ $doctor->user?->name }}" loading="lazy">
                    @else
                        <img src="{{ $docPhotos[$i % count($docPhotos)] }}" alt="{{ $doctor->user?->name }}" loading="lazy">
                    @endif
                    @if($doctor->department)
                        <span class="doc-dept-badge">{{ $doctor->department->name }}</span>
                    @endif
                </div>
                <div class="doc-body">
                    <div class="doc-name">د. {{ $doctor->user?->name ?? 'غير محدد' }}</div>
                    <div class="doc-spec">{{ $doctor->specialization?->name ?? 'طب عام' }}</div>
                    @if($doctor->department)
                        <div class="doc-info-row">
                            <i class="fa-solid fa-hospital" style="color:var(--teal)"></i>
                            {{ $doctor->department->name }}
                        </div>
                    @endif
                    <div class="doc-stars">
                        <span>4.8</span>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-user-doctor"></i>
                لا يوجد أطباء متاحون حالياً
            </div>
        @endforelse
    </div>
</section>

{{-- ════════════════════ ABOUT ════════════════════ --}}
<section class="section reveal">
    <div class="about-wrap">
        <div class="about-gallery">
            <div class="ag-main">
                <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=800&q=80" alt="مستشفى نوفيكا">
                <div class="about-founded">
                    <div class="af-label"><i class="fa-solid fa-plus"></i> نوفيكا منذ</div>
                    <div class="af-date">28 / 10 / 2003</div>
                </div>
            </div>
            <div class="ag-sm">
                <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=400&q=75" alt="غرفة عمليات" loading="lazy">
            </div>
            <div class="ag-sm">
                <img src="https://images.unsplash.com/photo-1579684453423-f84349ef60b0?w=400&q=75" alt="مختبر" loading="lazy">
            </div>
        </div>

        <div>
            <div class="label-badge">من نحن</div>
            <h2 class="sec-title">مستشفى نوفيكا الطبي</h2>
            <p class="about-tagline">ملتزمون بصحتك وراحتك في كل خطوة</p>
            <p class="sec-sub">
                نجمع بين الخبرة السريرية المتقدمة والتكنولوجيا الطبية الحديثة ونهج يضع المريض في المقام الأول،
                لضمان التشخيص الدقيق والعلاج الفعّال. منذ تأسيسنا عام 2003، نفخر بخدمة أكثر من 20 مليون مريض
                حول العالم بمعدل رضا يبلغ 95%.
            </p>
            <div style="margin-top:1.8rem">
                <a href="{{ route('about') }}" class="btn-primary">
                    اعرف أكثر <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="about-phone">
                <div class="ph-icon"><i class="fa-solid fa-phone"></i></div>
                <div>
                    <div class="ph-label">للاستفسارات</div>
                    <div class="ph-num">+8801616876080</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════ METRICS ════════════════════ --}}
<section class="section reveal">
    <div class="metrics">
        <div class="metric-item">
            <div class="m-val">250<span>م$</span></div>
            <div class="m-lbl">تمويل رعاية صحية</div>
        </div>
        <div class="metric-item">
            <div class="m-val">20<span>م+</span></div>
            <div class="m-lbl">مريض تمت خدمته</div>
        </div>
        <div class="metric-item">
            <div class="m-val">95<span>%</span></div>
            <div class="m-lbl">نسبة رضا المرضى</div>
        </div>
        <div class="metric-item">
            <div class="m-val">200<span>+</span></div>
            <div class="m-lbl">كادر طبي متخصص</div>
        </div>
    </div>
</section>

{{-- ════════════════════ FOOTER ════════════════════ --}}
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div class="fb-logo">
                <div class="icon"><i class="fa-solid fa-heart-pulse"></i></div>
                نوفيكا
            </div>
            <p>شريكك الطبي الموثوق، نقدم رعاية صحية عالمية منذ عام 2003. جودة الرعاية لكل مريض في كل يوم.</p>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>روابط سريعة</h4>
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('about') }}">من نحن</a></li>
                <li><a href="{{ route('departments.index') }}">الأقسام</a></li>
                <li><a href="{{ route('doctors.index') }}">الأطباء</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>خدماتنا</h4>
            <ul>
                <li><a href="{{ route('departments.index') }}">طوارئ طبية</a></li>
                <li><a href="{{ route('departments.index') }}"> المخ</a></li>
                <li><a href="{{ route('departments.index') }}"> قسم الطب الباطني</a></li>
                <li><a href="{{ route('departments.index') }}">تحاليل مختبرية</a></li>
                 <li><a href="{{ route('departments.index') }}">طوارئ طبية</a></li>
                <li><a href="{{ route('departments.index') }}"> وحدة العناية المركزة (ICU)</a></li>
                <li><a href="{{ route('departments.index') }}"> وحدة العناية المركزة لحديثي الولادة (NICU)</a></li>
                <li><a href="{{ route('departments.index') }}">قسم الجراحة العامة وجراحات المناظير </a></li>
                 <li><a href="{{ route('departments.index') }}"> قسم طب الأطفال</a></li>
                <li><a href="{{ route('departments.index') }}">قسم النساء والتوليد </a></li>
                <li><a href="{{ route('departments.index') }}"> قسم العظام والمفاصل</a></li>
                <li><a href="{{ route('departments.index') }}"> قسم جراحة المخ والأعصاب</a></li>
                 <li><a href="{{ route('departments.index') }}"> قسم الأنف والأذن والحنجرة</a></li>
                <li><a href="{{ route('departments.index') }}"> قسم الجلدية</a></li>
                <li><a href="{{ route('departments.index') }}">أمراض القلب</a></li>
                <li><a href="{{ route('departments.index') }}"> قسم طب العيون</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>تواصل معنا</h4>
            <ul>
                <li><a href="tel:+8801616876080">+8801616876080</a></li>
                <li><a href="mailto:info@nuvica.com">rawan@nuvica.com</a></li>
                <li><a href="{{ route('contact') }}">نموذج التواصل</a></li>
                <li><a href="{{ route('contact') }}">احجز موعداً</a></li>
                
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <span>© {{ date('Y') }} صحتي الطبي. جميع الحقوق محفوظة.</span>
        <span>صُنع بـ <span class="heart">♥</span> لرعاية أفضل</span>
    </div>
</footer>

<script>
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>

</body>
</html>