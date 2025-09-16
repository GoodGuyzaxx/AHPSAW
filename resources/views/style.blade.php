    {{-- cdn datatable css --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    {{-- style css --}}
    <link href="{{ url('backend/css/styles.css') }}" rel="stylesheet" />
    {{-- foontawesome js --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <script src="{{ url('backend/js/dselect.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    {{-- Global Styles (no framework) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .brand span{font-size:1.025rem}


        .nav-actions{display:flex;align-items:center;gap:.5rem}
        .menu-toggle{display:none;background:transparent;border:0;color:var(--text);font-size:1.125rem}


        .menu{display:flex;align-items:center;gap:.375rem;flex-wrap:wrap}
        .menu > li{list-style:none;position:relative}
        .menu-btn{
            padding:.5rem .8rem;border-radius:10px;border:1px solid rgba(255,255,255,.06);
            background:rgba(255,255,255,.03); color:var(--text); font-weight:500; line-height:1;
            transition:all .18s ease; display:flex;align-items:center;gap:.5rem
        }
        .menu-btn:hover{transform:translateY(-1px);box-shadow:0 6px 14px rgba(0,0,0,.25),0 0 0 3px var(--ring)}
        .menu-btn[aria-current="page"]{background:linear-gradient(135deg, rgba(79,70,229,.2), rgba(124,58,237,.25));border-color:rgba(79,70,229,.45)}


        /* DROPDOWN */
        .dropdown{position:relative}
        .dropdown-panel{
            position:absolute;top:110%;left:0;min-width:260px;padding:.5rem;border-radius:12px;
            border:1px solid rgba(255,255,255,.08); background:rgba(10,16,31,.98);
            box-shadow:0 20px 40px rgba(0,0,0,.45); display:none
        }
        .dropdown.open .dropdown-panel{display:block}
        .dd-grid{display:grid;grid-template-columns:1fr 1fr;gap:.375rem}
        .dd-item{display:flex;gap:.6rem;align-items:flex-start;padding:.6rem;border-radius:10px;border:1px solid rgba(255,255,255,.06);background:rgba(255,255,255,.02)}
        .dd-item:hover{border-color:rgba(79,70,229,.5);box-shadow:0 0 0 3px var(--ring)}
        .dd-title{font-weight:600;font-size:.915rem}
        .dd-desc{font-size:.8rem;color:var(--muted);margin-top:2px}
        .dd-kbd{margin-left:auto;font-size:.72rem;color:var(--muted);border:1px solid rgba(255,255,255,.08);padding:.15rem .4rem;border-radius:6px}


        /* AVATAR */
        .avatar{width:34px;height:34px;border-radius:999px;border:2px solid rgba(255,255,255,.1);overflow:hidden}
        .avatar img{width:100%;height:100%;object-fit:cover}
        .profile-menu{position:relative}
        .profile-panel{position:absolute;right:0;top:110%;min-width:220px;background:rgba(10,16,31,.98);border:1px solid rgba(255,255,255,.08);border-radius:12px;display:none;padding:.5rem;box-shadow:0 20px 40px rgba(0,0,0,.45)}
        .profile-menu.open .profile-panel{display:block}
        .profile-item{display:flex;gap:.6rem;align-items:center;padding:.6rem;border-radius:10px;border:1px solid rgba(255,255,255,.06)}
        .profile-item:hover{border-color:rgba(34,197,94,.5);box-shadow:0 0 0 3px rgba(34,197,94,.25)}


        /* CONTENT & FOOTER */
        .container{max-width:1200px;margin:0 auto;padding:1.25rem}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin:1rem 0}
        .kpi{display:grid;grid-template-columns:repeat(4, minmax(0,1fr));gap:1rem}
        .card{background:linear-gradient(180deg, rgba(11,18,36,.9), rgba(11,18,36,.7));border:1px solid rgba(255,255,255,.06);border-radius:16px;padding:1rem}
        .muted{color:var(--muted)}
        .footer{border-top:1px solid rgba(255,255,255,.06);padding:1rem 1.25rem;color:var(--muted);text-align:center}


        /* RESPONSIVE */
        @media (max-width: 980px){
            .menu{display:none;flex-direction:column;align-items:stretch;width:100%}
            .menu.show{display:flex}
            .menu-toggle{display:inline-grid;place-items:center}
            .dd-grid{grid-template-columns:1fr}
            .kpi{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media (max-width: 520px){
            .kpi{grid-template-columns:1fr}
        }
    </style>

