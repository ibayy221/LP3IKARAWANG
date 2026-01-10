@php $user = Auth::user(); $name = $user->name ?? ($user->nama ?? ($user->nama_mhs ?? 'Calon Mahasiswa')); $avatar = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0D4C6B&color=fff&rounded=true'; @endphp

<aside class="pendaftar-sidebar">
  <div class="sidebar-inner">
    <div class="profile">
      <img class="avatar" src="{{ $avatar }}" alt="avatar">
      <div class="profile-name">{{ $name }}</div>
      <div class="profile-sub">LP3I College<br>Kampus Karawang</div>
    </div>

    <nav class="side-nav">
      <a href="{{ route('pendaftar.dashboard') }}" class="nav-item">🏠 Beranda</a>
      <a href="{{ route('mahasiswa.create') }}" class="nav-item">📝 Registrasi Pendaftaran</a>
      <a href="#" class="nav-item">🧾 Isi Biodata</a>
      <div class="nav-item dropdown-akun" style="padding:0">
        <button class="btn-dropdown" type="button">👤 Akun Saya ▾</button>
        <div class="dropdown-list" style="display:none;margin-top:.4rem;padding:.4rem;background:rgba(255,255,255,0.03);border-radius:8px">
          <a href="{{ route('pendaftar.akun.email') ?? route('akun.email') }}" class="nav-sub">✉️ Ubah Email</a>
          <a href="{{ route('pendaftar.akun.password') ?? route('akun.password') }}" class="nav-sub">🔒 Ubah Password</a>
          <a href="{{ route('pendaftar.akun.phone') ?? route('akun.phone') }}" class="nav-sub">📱 Ubah Nomor Telepon</a>
          <a href="{{ route('pendaftar.akun.whatsapp') ?? route('akun.whatsapp') }}" class="nav-sub">💬 Ubah WhatsApp</a>
        </div>
      </div>
      <form method="POST" action="{{ route('pendaftar.logout') }}" style="margin:0;padding:0">
        @csrf
        <button type="submit" class="nav-item btn-link">🚪 Keluar</button>
      </form>
    </nav>

    <div class="contact">
      <div class="contact-note">Bila ada yang ingin diketahui lebih lanjut dapat menghubungi kami langsung di:</div>
      <div class="contact-item">📞 0267 411286</div>
      <div class="contact-item">📍 Jl. Tarumanegara, Komplek Karawang Hijau Blok B.4-6</div>
      <div class="contact-item">💬 +62 812 9078 0050</div>
    </div>
  </div>
</aside>

<style>
  .pendaftar-sidebar{background:linear-gradient(180deg,#042435,#07374a);color:#e6f7fb;padding:1.4rem;border-radius:12px}
  .pendaftar-sidebar .sidebar-inner{display:flex;flex-direction:column;gap:1rem}
  .pendaftar-sidebar .profile{display:flex;flex-direction:column;align-items:center;text-align:center}
  .pendaftar-sidebar .avatar{width:84px;height:84px;border-radius:999px;border:3px solid rgba(255,255,255,0.08)}
  @media (min-width:801px){ .pendaftar-sidebar{position:sticky;top:84px} }
  .pendaftar-sidebar .profile-name{font-weight:700;margin-top:.5rem}
  .pendaftar-sidebar .profile-sub{font-size:.85rem;color:rgba(255,255,255,0.8);margin-top:.2rem}
  .side-nav{display:flex;flex-direction:column;gap:.45rem;margin-top:6px}
  .nav-item{display:block;padding:.5rem .6rem;border-radius:8px;color:#dff6f9;text-decoration:none}
  .nav-item:hover{background:rgba(255,255,255,0.03)}
  .btn-dropdown{background:transparent;border:none;color:inherit;padding:.47rem .6rem;width:100%;text-align:left;font-weight:600;cursor:pointer}
  .dropdown-list a.nav-sub{display:block;padding:.4rem .5rem;border-radius:6px;color:#dff6f9;text-decoration:none;margin-top:.2rem}
  .dropdown-list a.nav-sub:hover{background:rgba(255,255,255,0.02)}
  .btn-link{background:transparent;border:none;color:inherit;padding:.5rem .6rem;text-align:left;width:100%}
  .contact{margin-top:auto;font-size:.9rem;color:rgba(255,255,255,0.85)}
  .contact-note{font-size:.85rem;margin-bottom:.5rem}
  .contact-item{margin-top:.35rem}

  @media (max-width:800px){
    .pendaftar-sidebar{padding:.9rem;border-radius:10px}
    .pendaftar-sidebar .avatar{width:72px;height:72px}
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.dropdown-akun .btn-dropdown').forEach(btn => {
      btn.addEventListener('click', function(){
        const list = this.parentElement.querySelector('.dropdown-list');
        if (!list) return;
        list.style.display = list.style.display === 'none' ? 'block' : 'none';
      });
    });
  });
</script>