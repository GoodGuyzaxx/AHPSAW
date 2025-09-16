<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="Kodinger" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/logo.png') }}" />
    <title>SPK | @yield('title')</title>
    {{-- style --}}
    @include('includes.login.style')
    <style>
        /* Background full page */
        body, html {
            height: 100%;
            margin: 0;
        }

        .auth-wrap {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;

            /* Gradient / background full cover */
            background:
                radial-gradient(1200px 600px at 80% -10%, #312e81 0, transparent 60%),
                radial-gradient(900px 500px at -10% 110%, #0ea5e9 0, transparent 50%),
                linear-gradient(160deg, #0f172a, #1e293b);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        /* Blob dekorasi tetap full cover */
        .blob {
            position: absolute;
            filter: blur(60px);
            opacity: .35;
            animation: float 12s ease-in-out infinite;
            pointer-events: none;
        }
        .blob-1 {
            width: 520px; height: 520px;
            background: #22d3ee;
            top: -120px; right: -120px;
            animation-delay: .5s;
        }
        .blob-2 {
            width: 420px; height: 420px;
            background: #a78bfa;
            bottom: -120px; left: -120px;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) }
            50% { transform: translateY(-18px) }
        }

        :root{
            --bg1:#0f172a;        /* slate-900 */
            --bg2:#1e293b;        /* slate-800 */
            --primary:#6366f1;    /* indigo-500 */
            --primary-700:#4f46e5;
            --muted:#94a3b8;      /* slate-400 */
            --card:#0b1222aa;     /* glass */
            --ring: rgba(99,102,241,.35);
        }

        .auth-wrap{
            min-height: 100vh;
            background:
                radial-gradient(1200px 600px at 80% -10%, #312e81 0, transparent 60%),
                radial-gradient(900px 500px at -10% 110%, #0ea5e9 0, transparent 50%),
                linear-gradient(160deg, var(--bg1), var(--bg2));
            position: relative;
            overflow: hidden;
        }
        .blob{
            position:absolute; filter: blur(60px); opacity:.35;
            animation: float 12s ease-in-out infinite;
            pointer-events:none;
        }
        .blob-1{ width:520px;height:520px; background:#22d3ee; top:-120px; right:-120px; animation-delay: .5s;}
        .blob-2{ width:420px;height:420px; background:#a78bfa; bottom:-120px; left:-120px;}
        @keyframes float{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }

        .auth-card{
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(148,163,184,.15);
            border-radius: 18px;
            box-shadow:
                0 10px 30px rgba(0,0,0,.35),
                inset 0 1px 0 rgba(255,255,255,.03);
            overflow: hidden;
        }

        .auth-left{
            background:
                radial-gradient(80% 80% at 20% 10%, rgba(255,255,255,.08) 0, transparent 60%),
                linear-gradient(180deg, rgba(99,102,241,.25), rgba(99,102,241,.05));
            padding: 36px;
            color: #e5e7eb;
        }
        .brand-badge{
            width: 56px;height:56px;
            display:grid;place-items:center;
            border-radius: 14px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
        }

        .auth-right{
            padding: 36px;
            background: rgba(2,6,23,.6);
            color: #e2e8f0;
        }

        .form-label{ color:#cbd5e1; font-weight:600; }
        .form-control{
            background: rgba(15,23,42,.55) !important;
            border: 1px solid rgba(148,163,184,.25);
            color: #e2e8f0;
            border-radius: 12px;
            padding-left: 42px;
            height: 48px;
            transition: box-shadow .2s, border-color .2s, transform .06s;
        }
        .form-control:focus{
            border-color: var(--primary);
            box-shadow: 0 0 0 6px var(--ring);
            transform: translateY(-1px);
        }
        .input-wrap{ position: relative; }
        .input-icon{
            position:absolute; left:12px; top:50%; transform:translateY(-50%);
            width:22px;height:22px; opacity:.75;
        }
        .btn-primary{
            background: linear-gradient(180deg, var(--primary), var(--primary-700));
            border: none;
            box-shadow: 0 8px 20px rgba(99,102,241,.35);
            border-radius: 12px;
            height: 50px;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .btn-primary:hover{ filter: brightness(1.03); transform: translateY(-1px); }
        .helper{
            color: var(--muted); font-size:.92rem;
        }
        .small-link a{ color:#c7d2fe; text-decoration: underline dotted; }
        .divider{
            display:flex; align-items:center; gap:12px; color:#94a3b8; font-size:.9rem; margin: 18px 0;
        }
        .divider::before,.divider::after{
            content:""; flex:1; height:1px; background: rgba(148,163,184,.25);
        }
        .footer-mini{
            color:#94a3b8; font-size:.85rem; text-align:center; margin-top: 14px;
        }

        /* mobile tweaks */
        @media (max-width: 991.98px){
            .auth-left{ display:none; }
            .auth-right{ padding: 28px; }
        }

        /* ====== Improve input contrast on dark background ====== */
        .auth-right { color:#e6edf7; }

        .form-label { color:#dbe7ff; }

        .input-wrap .form-control{
            background: rgba(255,255,255,.10) !important;      /* lebih terang dari sebelumnya */
            border: 1px solid rgba(203,213,225,.55);            /* slate-300-ish */
            color: #eef5ff !important;                          /* teks utama */
            caret-color: #ffffff;                               /* kursor jelas */
        }
        .input-wrap .form-control:focus{
            border-color:#8aa3ff;                               /* indigo-ish */
            box-shadow: 0 0 0 .35rem rgba(138,163,255,.25);     /* ring lembut */
            background: rgba(255,255,255,.14) !important;
        }

        /* placeholder lebih terang & terbaca */
        .input-wrap .form-control::placeholder{
            color:#c3d2f1;                                      /* kontras & lembut */
            opacity: .95;
        }

        /* icon di dalam input ikut cerah */
        .input-icon{ color:#cfe0ff !important; opacity: .95 !important; }

        /* validasi/error terlihat jelas di dark bg */
        .invalid-feedback{ color:#ffb4b4 !important; }
        .is-invalid{ border-color:#ff7a7a !important; box-shadow: 0 0 0 .25rem rgba(255,122,122,.2) !important; }

        /* tombol lebih kontras */
        .btn-primary{
            background: linear-gradient(180deg, #6c7bff, #4f5dff);
            border:none; color:#fff;
        }
        .btn-primary:hover{ filter:brightness(1.06); }

        /* ====== Handle Chrome autofill (kuning hijau bawaan) ====== */
        input:-webkit-autofill,
        input:-webkit-autofill:focus{
            -webkit-text-fill-color:#eef5ff !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255,255,255,.12) inset !important;
            transition: background-color 9999s ease-out 0s;
            caret-color:#ffffff;
        }

        /* High-contrast fallback untuk user yang butuh kontras tinggi */
        @media (prefers-contrast: more){
            .input-wrap .form-control{
                background:#1f2937 !important;    /* solid gelap */
                border-color:#ffffff !important;
                color:#ffffff !important;
            }
            .input-wrap .form-control::placeholder{ color:#ffffff !important; }
            .input-icon{ color:#ffffff !important; }
        }
    </style>
</head>

<body class="my-login-page">
    {{-- Navbar --}}
{{--    @include('includes.login.navbar')--}}

    {{-- main --}}
    @yield('content')

    {{-- background --}}
{{--    @include('includes.login.background')--}}

    {{-- script --}}
    @include('includes.login.script')
</body>

</html>
