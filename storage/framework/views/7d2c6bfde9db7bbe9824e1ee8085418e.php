<footer class="lp3i-footer">
  <div class="lp3i-footer-main">
    <div class="lp3i-footer-col logo-col">
      <div class="logo">
                <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I Karawang"><br>
                <br>
                <img src="<?php echo e(asset('storage/image/global.png')); ?>" alt="Global">
                 <div class="footer-contact-desc">Cepat Tepat Kerja.</div>
        </div>
    </div>
    <div class="lp3i-footer-col nav-col">
      <div class="footer-title">Telusuri</div>
      <ul class="footer-nav-list">
        <li><a href="/">Home</a></li>
        <li><a href="<?php echo e(route('sambutan')); ?>">Profil</a></li>
        <li><a href="<?php echo e(route('ais')); ?>">Akademik</a></li>
        <li><a href="<?php echo e(route('penempatan')); ?>">Pusat Karir</a></li>
      </ul>
    </div>
    <div class="lp3i-footer-col nav-col">
      <div class="footer-title">Layanan Digital</div>
      <ul class="footer-nav-list">
        <li><a href="<?php echo e(route('student')); ?>">E | Student</a></li>
        <li><a href="<?php echo e(route('akademik')); ?>">E | Akademik</a></li>
        <li><a href="<?php echo e(route('lecture')); ?>">E | Lecture</a></li>
        <li><a href="<?php echo e(route('lecture')); ?>">E | Carrier Hub</a></li>
      </ul>
    </div>
    <div class="lp3i-footer-col address-col">
      <div class="footer-title">Kontak & Info</div>
      <div class="footer-contact-item"><i class="fas fa-phone-alt"></i> <a href="https://wa.me/6285117704112" target="_blank" style="color:#fff;text-decoration:none;">0851-1770-4112</a></div>
      <div class="footer-contact-item"><i class="fas fa-envelope"></i> <a href="mailto:karawang@lp3i.id" style="color:#fff;text-decoration:none;">karawang@lp3i.id</a></div>
      <div class="footer-contact-item"><i class="fab fa-instagram"></i> <a href="https://www.instagram.com/lp3ikarawang" target="_blank" style="color:#fff;">@lp3ikarawang</a></div>
      <div class="footer-contact-desc">Hubungi kami.</div>
    </div>
  </div>
  <div class="lp3i-footer-bottom">
    <hr>
    <div class="lp3i-footer-copyright center-copyright">
      <span>&copy; <?php echo e(date('Y')); ?> LP3I College. All rights reserved.</span>
    </div>
  </div>
</footer>
<style>
     .logo img { max-height: 55px; width: auto; object-fit: contain; }
.lp3i-footer {
  background: linear-gradient(120deg, #213C72);
  color: #fff;
  font-family: 'Poppins', Arial, sans-serif;
  margin-top: 48px;
  letter-spacing: 0.01em;
  box-shadow: 0 -2px 16px rgba(0,0,0,0.08);
}
.lp3i-footer-main {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 12px 16px 12px;
  align-items: flex-start;
}
.lp3i-footer-col {
  flex: 1 1 260px;
  min-width: 220px;
  margin-bottom: 24px;
  max-width: 100%;
}
/* Logo area */
.footer-logos {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 18px;
  margin-bottom: 8px;
}
.footer-logo-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-decoration: none;
  gap: 6px;
}
.lp3i-footer-logo-img {
  width: 70px;
  height: 70px;
  object-fit: contain;
  background: #fff;
  border-radius: 18px;
  padding: 10px 18px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}
.footer-logo-label {
  color: #fff;
  font-size: 1.05rem;
  font-weight: 600;
  letter-spacing: 0.03em;
  text-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.footer-title {
  font-size: 1.2rem;
  font-weight: 700;
  margin-bottom: 14px;
  color: #ffd700;
  letter-spacing: 0.02em;
  text-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.footer-nav-list {
  list-style: none;
  padding-left: 0;
  margin: 0;
}
.footer-nav-list li {
  margin-bottom: 10px;
}
.footer-nav-list li a {
  color: #fff;
  text-decoration: none;
  font-size: 1.08rem;
  font-weight: 500;
  padding: 4px 0;
  border-bottom: 2px solid transparent;
  transition: color 0.2s, border-bottom 0.2s;
}
.footer-nav-list li a:hover {
  color: #ffd700;
  border-bottom: 2px solid #ffd700;
}
.footer-contact-item {
  margin-bottom: 10px;
  font-size: 1.08rem;
  display: flex;
  align-items: center;
  gap: 10px;
}
.footer-contact-item a {
  color: #fff;
  text-decoration: none;
  transition: color 0.2s;
}
.footer-contact-item a:hover {
  color: #ffd700;
}
.footer-contact-desc {
  margin-top: 10px;
  font-size: 0.98rem;
  color: #e0e0e0;
  font-style: italic;
}
.lp3i-footer-bottom {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px 18px 24px;
}
.lp3i-footer-bottom hr {
  border: none;
  border-top: 1px solid #21759b;
  margin-bottom: 12px;
}
/* Copyright center */
.lp3i-footer-copyright {
  text-align: center;
  font-size: 1rem;
  color: #e0e0e0;
  width: 100%;
}
@media (max-width: 900px) {
  .lp3i-footer-main {
    flex-direction: column;
    align-items: stretch;
    gap: 32px;
  }
  .lp3i-footer-bottom {
    text-align: center;
  }
  .lp3i-footer-copyright {
    text-align: center;
  }
}
/* Footer grid: 4 columns on desktop, wrap on mobile */
.lp3i-footer-main {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 12px 16px 12px;
  align-items: flex-start;
}
.lp3i-footer-col {
  min-width: 0;
  margin-bottom: 10px;
  max-width: 100%;
}
@media (max-width: 1100px) {
  .lp3i-footer-main {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}
@media (max-width: 700px) {
  .lp3i-footer-main {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}
</style>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/layouts/footer.blade.php ENDPATH**/ ?>