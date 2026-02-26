<style>
  /* Minimal header for pendaftar dashboard pages (logo + contact only) */
  header.pendaftar-header { position: fixed; top: 0; left: 0; right: 0; z-index: 1200; background: #213C72; color: #fff; }
  body { padding-top: 96px; }

  .pendaftar-header .container { max-width: 1400px; margin: 0 auto; padding: 14px 2rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
  .pendaftar-logo { display: flex; align-items: center; gap: 10px; }
  .pendaftar-logo img { max-height: 50px; width: auto; object-fit: contain; }

  .pendaftar-contact { display: flex; align-items: center; justify-content: flex-end; gap: 26px; flex-wrap: wrap; }
  .pendaftar-contact-item { display: flex; align-items: center; gap: 10px; }
  .pendaftar-contact-item a { text-decoration: none; color: inherit; }
  .pendaftar-contact-icon { width: 18px; height: 18px; flex: none; color: #00a8e8; }
  .pendaftar-contact-text strong { display: block; font-size: 0.85rem; margin-bottom: 2px; }
  .pendaftar-contact-text span { display: block; font-size: 0.75rem; opacity: 0.85; }

  @media (max-width: 768px) {
    body { padding-top: 144px; }
    .pendaftar-header .container { flex-direction: column; align-items: flex-start; gap: 12px; }
    .pendaftar-contact { justify-content: flex-start; gap: 14px; }
  }
</style>

<header class="pendaftar-header">
  <div class="container">
    <div class="pendaftar-logo">
      <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang">
      <img src="{{ asset('storage/image/global.png') }}" alt="Global">
    </div>

    <div class="pendaftar-contact">
      <div class="pendaftar-contact-item">
        <svg class="pendaftar-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.13.98.38 1.93.73 2.84a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.24-1.24a2 2 0 0 1 2.11-.45c.91.35 1.86.6 2.84.73A2 2 0 0 1 22 16.92z" />
        </svg>
        <a class="pendaftar-contact-text" href="tel:085117704112">
          <strong>0851-1770-4112</strong>
          <span>Hubungi WA Kami</span>
        </a>
      </div>

      <div class="pendaftar-contact-item">
        <svg class="pendaftar-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4 4h16v16H4z" opacity="0" />
          <path d="M4 6h16v12H4z" />
          <path d="m4 7 8 6 8-6" />
        </svg>
        <a class="pendaftar-contact-text" href="mailto:karawang@lp3i.id">
          <strong>karawang@lp3i.id</strong>
          <span>Email Resmi</span>
        </a>
      </div>

      <div class="pendaftar-contact-item">
        <svg class="pendaftar-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="7" y="7" width="10" height="10" rx="3" />
          <path d="M16.5 7.5h.01" />
          <path d="M12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
        </svg>
        <a class="pendaftar-contact-text" href="https://www.instagram.com/lp3ikarawang" target="_blank" rel="noopener">
          <strong>LP3I Karawang</strong>
          <span>Follow Instagram</span>
        </a>
      </div>
    </div>
  </div>
</header>
