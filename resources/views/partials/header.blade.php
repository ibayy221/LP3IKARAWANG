<style>
    /* CSS DASAR */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; }

    /* Fixed header at top */
    header { width: 100%; z-index: 1000; position: fixed; top: 0; left: 0; }

    /* Body offset for fixed header */
    body { padding-top: 130px; }
    @media (max-width: 768px) { body { padding-top: 160px; } }

    /* Layer 1: Top Bar */
    .topbar { background: #009da5; color: white; padding: 8px 0; font-size: 0.95rem; font-weight: 600; }
    .topbar .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; display:flex; justify-content:space-between; align-items:center; gap:1rem; }
    .topbar-left, .topbar-right { display:flex; align-items:center; gap:1rem; }
    .topbar a { color: white; text-decoration: none; display:inline-flex; align-items:center; gap:0.5rem; padding:4px 8px; border-radius:6px; transition: all 0.2s ease; }
    .topbar a:hover { background: rgba(255,255,255,0.15); }
    .topbar a i { font-size: 0.95rem; }
    @media (max-width: 768px) {
        .topbar .container { flex-direction: column; align-items: flex-start; gap: 8px; font-size: 0.85rem; }
        .topbar-right { justify-content: flex-start; }
    }

    /* Layer 2: Mid Header (Logo & Contact) */
    .mid-header { background: #213C72; color: white; padding: 15px 0; }
    .mid-header .container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
    .logo img { max-height: 55px; width: auto; object-fit: contain; }
    .header-contact { display: flex; gap: 30px; }
    .contact-item { display: flex; align-items: center; gap: 10px; }
    .contact-item a { text-decoration: none; color: inherit; }
    .contact-item i { font-size: 1.9rem; color: #00a8e8; }
    .contact-text strong { display: block; font-size: 0.85rem; margin-bottom: 2px; }
    .contact-text span { font-size: 0.75rem; opacity: 0.85; display: block; }
    @media (max-width: 992px) {
        .header-contact { gap: 20px; }
        .contact-item i { font-size: 1.5rem; }
    }
    @media (max-width: 768px) {
        .header-contact { flex-direction: column; gap: 12px; font-size: 0.8rem; }
        .contact-item i { font-size: 1.3rem; }
    }

    /* Layer 3: Nav Utama (Sticky saat scroll) */
    nav { 
        background: white; 
        border-bottom: 1px solid #eee; 
        position: sticky; 
        top: 0; 
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    nav.scrolled { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .nav-container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; }

    /* Nav Links */
    .nav-links { display: flex; list-style: none; align-items: center; }
    .nav-links a { 
        color: #333; 
        text-decoration: none; 
        padding: 1rem 1.2rem; 
        display: block; 
        font-size: 0.9rem; 
        font-weight: 600; 
        position: relative;
        transition: color 0.3s ease;
    }
    .nav-links a:hover { 
        color: #1e3c72; 
        background: transparent;
    }
    .nav-links a:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #009da5, #1e3c72);
        transform: translateX(-50%);
        transition: width 0.3s ease;
    }
    .nav-links a:hover:after {
        width: 70%;
    }

    /* Dropdown */
    .dropdown { position: relative; }
    .dropdown-content {
        position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
        background: linear-gradient(135deg, #043158 0%, #1a5a6f 100%); 
        min-width: 240px; 
        display: none; 
        z-index: 1000;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        animation: dropdownSlide 0.3s ease;
    }
    @keyframes dropdownSlide {
        from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
    .dropdown:hover .dropdown-content { display: block; }
    .dropdown-content a { 
        color: white !important; 
        font-size: 0.85rem; 
        padding: 12px 20px; 
        border-bottom: 1px solid rgba(255,255,255,0.08);
        transition: all 0.25s ease;
        display: block;
    }
    .dropdown-content a:last-child { border-bottom: none; }
    .dropdown-content a:hover { 
        background: rgba(255,255,255,0.1);
        padding-left: 24px;
    }
    .dropdown-content a.akademik-item { display: flex; gap: 12px; flex-direction: column; }
    .dropdown-content a.akademik-item .ak-prefix { color: #fff; font-weight: 700; font-size: 0.8rem; }
    .dropdown-content a.akademik-item .ak-prefix:first-child { color: #00d4ff; font-weight: 800; letter-spacing: 0.5px; }
    .dropdown-content a.akademik-item .ak-prefix:last-child { color: #b0e0e6; font-size: 0.75rem; font-weight: 500; }

    /* Auth Buttons */
    .nav-auth { display:flex; gap:10px; align-items:center; }
    .login-btn { 
        background: transparent !important; 
        color: #1e3c72 !important; 
        padding: 0.55rem 1rem !important;
        border-radius: 18px !important; 
        font-weight: 600 !important; 
        border: 1px solid #1e3c72 !important;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .login-btn:hover { background: #f0f5ff !important; }
    .register-btn {
        background: #004269 !important; 
        color: white !important; 
        padding: 0.6rem 1.2rem !important;
        border-radius: 20px !important; 
        font-weight: 600 !important; 
        font-size: 0.9rem !important;
        text-decoration: none;
        animation: registerPulse 2s ease-in-out infinite;
    }
    @keyframes registerPulse {
        0%, 100% { box-shadow: 0 4px 15px rgba(0, 66, 105, 0.3); }
        50% { box-shadow: 0 6px 25px rgba(0, 66, 105, 0.6); }
    }

    @media (max-width: 768px) { 
        .nav-links a { padding: 0.8rem 0.9rem; font-size: 0.85rem; }
        .login-btn, .register-btn { padding: 0.45rem 0.8rem !important; font-size: 0.8rem !important; }
    }
</style>

<header>
    <div class="topbar">
        <div class="container">
            <div class="topbar-left"><a href="{{ route('virtual') }}">Virtual</a></div>
            <div class="topbar-right">
                <a href="{{ route('student') }}">E | Student</a>
                <a href="{{ route('akademik') }}">E | Akademik</a>
                <a href="{{ route('lecture') }}">E | Lecture</a>
            </div>
        </div>
    </div>

    <div class="mid-header">
        <div class="container">
            <div class="logo">
                <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang">
                <img src="{{ asset('storage/image/global.png') }}" alt="Global">
            </div>
            <div class="header-contact">
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="contact-text">
                        <strong>0851-1770-4112</strong>
                        <span>Hubungi Wa Kami</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-text">
                        <strong>karawang@lp3i.id</strong>
                        <span>Email Resmi</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fab fa-instagram"></i>
                    <a href="https://www.instagram.com/lp3ikarawang" target="_blank" class="contact-text" style="text-decoration: none; color: inherit;">
                        <strong>@lp3ikarawang</strong>
                        <span>Follow Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <nav id="mainNav">
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="dropdown">
                    <a href="{{ route('sambutan') }}">Profil</a>
                    <div class="dropdown-content">
                        <a href="{{ route('sambutan') }}">Sambutan</a>
                        <a href="{{ route('sejarah') }}">Sejarah & Visi Misi</a>
                        <a href="{{ route('struktur') }}">Struktur Organisasi</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="{{ route('ais') }}">Akademik</a>
                    <div class="dropdown-content">
                        <a href="{{ route('ais') }}" class="akademik-item"><span class="ak-prefix">AIS</span><span class="ak-prefix">Accounting Information System</span></a>
                        <a href="{{ route('ase') }}" class="akademik-item"><span class="ak-prefix">ASE</span><span class="ak-prefix">Application Software Engineering</span></a>
                        <a href="{{ route('oaa') }}" class="akademik-item"><span class="ak-prefix">OAA</span><span class="ak-prefix">Office Administration</span></a>
                    </div>
                </li>
                <li><a href="{{ route('penempatan') }}">Pusat Karir</a></li>
            </ul>

            <div class="nav-auth">
                <a href="{{ route('pendaftar.login') }}" class="login-btn">Login</a>
                <a href="{{ route('mahasiswa.create') }}" class="register-btn"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
            </div>
        </div>
    </nav>
</header>
