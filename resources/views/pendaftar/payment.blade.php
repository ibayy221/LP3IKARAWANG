<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pembayaran Pendaftaran</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
    body{font-family:'Poppins',Arial,sans-serif;padding:calc(190px + 2rem) 2rem 2rem;background:linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.14) 28%, rgba(64,130,109,0.03) 48%, #f6f9fc 100%);color:#0f172a}
    .container{max-width:920px;margin:0 auto}
    /* prominent top banner to make page feel indigo-dominant */
    .heading{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding:1rem;border-radius:12px;background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff;box-shadow:0 12px 36px rgba(2,6,23,0.12)}
    .heading .title{font-size:1.15rem;font-weight:700}
    .heading .subtitle{opacity:.95;font-weight:500;color:rgba(255,255,255,0.92)}

    /* card with left accent to reduce large white area */
    .card{position:relative;padding:1.2rem;background:#fff;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.08);border:1px solid rgba(230,238,246,1);overflow:visible}
    .card::before{content:'';position:absolute;left:-6px;top:12px;bottom:12px;width:8px;border-radius:8px;background:linear-gradient(180deg,var(--basic),var(--adv));box-shadow:0 6px 18px rgba(0,66,105,0.08)}

    .btn-primary{background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff;border:none;padding:.6rem 1rem;border-radius:10px;font-weight:700;min-width:140px;height:44px;display:inline-flex;align-items:center;justify-content:center}
    .btn-plain{background:transparent;border:1px solid rgba(255,255,255,0.12);padding:.45rem .8rem;border-radius:10px;min-width:120px;height:44px;display:inline-flex;align-items:center;justify-content:center;color:#fff}
    .heading .back-btn{min-width:96px;height:36px;padding:.28rem .6rem;font-size:0.92rem;border-radius:8px;background:rgba(255,255,255,0.08);color:#fff;border:1px solid rgba(255,255,255,0.12);box-shadow:none}

    .method{padding:.8rem;border-radius:8px;border:1px dashed rgba(255,255,255,0.06);margin-bottom:.8rem;background:rgba(255,255,255,0.02);color:#fff}
    .form-input{width:100%;padding:.6rem;border-radius:10px;border:2px solid rgba(2,6,23,0.08);margin-top:.35rem;background:rgba(255,255,255,0.95)}
    .bank-info{padding:1rem;border-radius:10px;border:1px solid rgba(255,255,255,0.06);background:linear-gradient(90deg, rgba(0,66,105,0.06), rgba(64,130,109,0.03));margin-bottom:1rem;color:#072534}
    .bank-info strong{color:#072534}
    .meta-info{margin-bottom:.6rem;padding:.6rem;border-radius:8px;background:linear-gradient(90deg,rgba(255,255,255,0.03),rgba(255,255,255,0.02));border:1px solid rgba(255,255,255,0.04);color:#f8fbfc}
    .form-grid{display:grid;grid-template-columns:1fr;gap:.6rem;margin-bottom:.6rem}
    .form-grid label{display:block;padding:.65rem 0;border-bottom:2px solid rgba(2,6,23,0.06);color:#13323f}
    .form-grid label:last-child{border-bottom:none}
    #uploadMessage{padding:.6rem;border-radius:8px}
    @media (max-width:800px){body{padding:calc(210px + 1rem) 1rem 1rem}.heading{flex-direction:column;align-items:flex-start;gap:.6rem}}
  </style>
</head>
<body>
  @include('partials.header')
  <div class="container">
    <div class="heading">
      <div>
        <h2 style="margin:0">Pembayaran Pendaftaran</h2>
        <div style="color:#ffffff;font-size:.95rem">Untuk: <strong>{{ $calon->nama_mhs }}</strong></div>
      </div>
      <div><a class="btn-plain back-btn" href="{{ route('pendaftar.dashboard') }}">Kembali</a></div>
    </div>

    <div class="card">
      <div class="meta-info">Silakan pilih metode pembayaran</div>
      <div class="meta-info" style="font-weight:700">Nominal: <strong>Rp {{ number_format($calon->payment_amount ?? 350000,0,',','.') }}</strong></div>

      <!-- Bank info box -->
      <div class="bank-info">
        <div style="font-weight:800;color:var(--basic);font-size:1rem">Bank BNI</div>
        <div style="color:#334155;margin-top:6px">No Rekening: <strong>5051 2000 05</strong></div>
        <div style="color:#334155">Atas Nama: <strong>LP3I Karawang</strong></div>
        <div style="color:#334155;margin-top:6px">Nominal: <strong>Rp {{ number_format($calon->payment_amount ?? 350000,0,',','.') }}</strong></div>
      </div>

      @php
        $now = \Carbon\Carbon::now();
        $expired = false;
        if (!empty($expiresAt) && $now->greaterThan($expiresAt)) $expired = true;
      @endphp

      <!-- Success modal (hidden by default) -->
      <div id="successModal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;z-index:1200">
        <div style="background:rgba(2,6,23,0.4);position:absolute;inset:0"></div>
        <div style="position:relative;max-width:480px;margin:0 auto;background:#fff;border-radius:12px;padding:1.2rem;z-index:1210;text-align:center;box-shadow:0 12px 40px rgba(2,6,23,0.12)">
          <h3 style="margin:0 0 .5rem">Pembayaran Berhasil</h3>
          <p style="margin:0;color:#475569">Bukti pembayaran berhasil diunggah. Anda akan diarahkan ke dashboard.</p>
        </div>
      </div>

      @if($expired)
        <div style="padding:1rem;border-radius:10px;border:1px solid rgba(255,0,0,0.08);background:#fff6f6;color:#9b1c1c;margin-bottom:1rem">Masa pembayaran telah berakhir. Silakan hubungi admin untuk bantuan.</div>
      @else
        <div id="uploadMessage" role="status" aria-live="polite" style="display:none;margin-bottom:.8rem;padding:.6rem;border-radius:8px"></div>
        <form id="uploadForm" method="POST" action="{{ route('pendaftar.payment.upload') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="method" value="BNI">
          <input type="hidden" name="transfer_date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
          <div class="form-grid">
            <label style="font-size:.95rem;color:#334155">Nama Lengkap Pendaftar
              <input type="text" name="sender_name" required class="form-input" value="{{ old('sender_name', $calon->nama_mhs) }}" />
            </label>

            <label style="font-size:.95rem;color:#334155">Bank Asal Pengirim
              <input type="text" name="bank_origin" required class="form-input" placeholder="Contoh: BCA, Mandiri, BNI" value="{{ old('bank_origin') }}" />
            </label>

            <label style="font-size:.95rem;color:#334155">Nama Pemilik Rekening di Struk
              <input type="text" name="account_name" required class="form-input" value="{{ old('account_name') }}" />
            </label>

            <label style="font-size:.95rem;color:#334155">Tanggal Transfer
              <div id="transferDateDisplay" style="width:100%;padding:.6rem;border-radius:10px;border:1px solid #e6eef6;margin-top:.3rem;background:#fff;color:#0f172a">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            </label>

            <label style="font-size:.95rem;color:#334155">Upload Bukti Transfer (jpg, jpeg, png, max 2MB)
              <input type="file" name="proof_file" accept="image/*" required style="display:block;margin-top:.4rem" />
            </label>
          </div>

          <div style="display:flex;gap:.8rem;align-items:center;flex-wrap:wrap;margin-top:.6rem">
            <button id="uploadBtn" class="btn-primary" type="button">Kirim</button>
            <a class="btn-plain" href="{{ route('pendaftar.dashboard') }}">Batal</a>
          </div>
        </form>
      @endif

  
      <script>
        (function(){
          const methods = document.querySelectorAll('#methods .method');
          const input = document.getElementById('selected_method');
          const payBtn = document.getElementById('payBtn');
          methods.forEach(m => {
            m.addEventListener('click', function(){
              methods.forEach(x=> x.style.boxShadow='');
              this.style.boxShadow = '0 6px 18px rgba(3,53,72,0.08)';
              const method = this.getAttribute('data-method');
              input.value = method;
              payBtn.disabled = false;
            });
          });
        })();
      </script>
      <script>
        (function(){
          const form = document.getElementById('uploadForm');
          const btn = document.getElementById('uploadBtn');
          if (!form || !btn) return;
          const calonName = {!! json_encode($calon->nama_mhs ?? '') !!};
          const amount = {!! json_encode($calon->payment_amount ?? 350000) !!};
          btn.addEventListener('click', async function(){
            const sender = form.querySelector('[name=sender_name]').value.trim();
            const bank = form.querySelector('[name=bank_origin]').value.trim();
            const account = form.querySelector('[name=account_name]').value.trim();
            const transferDate = form.querySelector('[name=transfer_date]').value;
            const fileInput = form.querySelector('[name=proof_file]');
            if (!sender || !bank || !account || !fileInput || !fileInput.files.length) {
              showMessage('Lengkapi semua kolom dan unggah file bukti transfer terlebih dahulu.', 'error');
              return;
            }

            const displayDate = document.getElementById('transferDateDisplay') ? document.getElementById('transferDateDisplay').innerText : transferDate;
            const message = `Halo Admin LP3I Karawang.%0A%0ASaya mengunggah bukti pembayaran pendaftaran.%0ANama Pendaftar: ${sender}%0ANama Calon: ${calonName}%0ABank Asal: ${bank}%0ANama Pemilik Rekening: ${account}%0ATanggal Transfer: ${displayDate}%0ANominal: Rp ${new Intl.NumberFormat('id-ID').format(amount)}%0A%0ATerima kasih.`;

            // open WhatsApp in a new tab
            const waUrl = `https://wa.me/6285891602476?text=${message}`;
            window.open(waUrl, '_blank');

            // then upload the form via AJAX (so file is saved server-side)
            btn.disabled = true;
            const origText = btn.innerText;
            btn.innerText = 'Mengunggah...';
          try {
            const fd = new FormData(form);
            const res = await fetch(form.action, {
              method: 'POST',
              body: fd,
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
              },
              credentials: 'same-origin'
            });
            if (res.ok) {
              const data = await res.json().catch(()=>null);
              const redirect = data && data.redirect ? data.redirect : '{{ route('pendaftar.dashboard') }}';
              // show success modal then redirect
              showSuccessModal(() => { window.location.href = redirect; });
            } else if (res.status === 422) {
              const err = await res.json().catch(()=>null);
              let msg = 'Validasi gagal.';
              if (err && err.errors) {
                msg = Object.values(err.errors).flat().join('\n');
              }
              showMessage(msg, 'error');
              btn.disabled = false;
              btn.innerText = origText;
            } else {
              // try to read server response for debugging
              const bodyText = await res.text().catch(()=>null);
              console.error('Upload failed', res.status, bodyText);
              let userMsg = 'Terjadi kesalahan saat mengunggah. Silakan coba lagi.';
              if (bodyText) {
                // show short snippet
                userMsg = `Terjadi kesalahan saat mengunggah (status ${res.status}).`; 
              }
              showMessage(userMsg, 'error');
              btn.disabled = false;
              btn.innerText = origText;
            }
            } catch (err) {
              console.error(err);
              showMessage('Gagal mengunggah bukti. Periksa koneksi Anda.', 'error');
              btn.disabled = false;
              btn.innerText = origText;
            }
          });

        function showMessage(text, type='info'){
          const el = document.getElementById('uploadMessage');
          if (!el) return;
          el.style.display = 'block';
          el.style.border = type === 'error' ? '1px solid rgba(220,38,38,0.12)' : '1px solid rgba(2,6,23,0.06)';
          el.style.background = type === 'error' ? '#fff6f6' : '#f8fafc';
          el.style.color = type === 'error' ? '#9b1c1c' : '#0f172a';
          el.innerText = text;
          setTimeout(()=>{ try{ el.style.display='none'; }catch(e){} }, 8000);
        }
        function showSuccessModal(cb){
          const m = document.getElementById('successModal');
          if (!m) { cb && cb(); return; }
          m.style.display = 'flex';
          // redirect after short delay
          setTimeout(()=>{
            m.style.display = 'none';
            try{ cb && cb(); }catch(e){}
          }, 1600);
        }
        })();
      </script>
    </div>
  </div>
</body>
</html>