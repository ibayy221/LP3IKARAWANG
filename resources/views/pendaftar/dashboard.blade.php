<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard Pendaftar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root{--basic:#004269;--adv:#40826D}
    .btn-basic{background:linear-gradient(90deg,var(--basic),var(--adv));box-shadow:0 6px 12px rgba(0,0,0,0.08)}
    .accent-color{color:var(--basic)}
    .card-accent{border-left:4px solid var(--adv)}
    /* Caret/button animation */
    #akunCaret{transition:transform .2s ease;transform-origin:center}
    .caret-rotated{transform:rotate(180deg)}
    .btn-basic{transition:transform .18s ease,box-shadow .18s ease}
    .btn-basic:hover{transform:translateY(-3px);box-shadow:0 12px 20px rgba(0,0,0,0.12)}
  </style>
  </style>
</head>
<body class="text-slate-800" style="background:var(--basic);">
  <div class="max-w-6xl mx-auto p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">
      <!-- Sidebar -->
      <aside class="bg-white rounded-xl border p-5 shadow-sm sticky top-6">
        <div class="flex items-center gap-3 mb-4">
          <svg class="w-8 h-8 accent-color" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 11c2.761 0 5-2.239 5-5S14.761 1 12 1 7 3.239 7 6s2.239 5 5 5zM3 21a9 9 0 0118 0"/></svg>
          <div>
            <div class="text-sm text-slate-400">Halo</div>
            <div class="font-semibold">{{ Auth::user()->name ?? 'Pendaftar' }}</div>
          </div>
        </div>

        <nav class="space-y-2 text-sm">
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="{{ route('pendaftar.dashboard') }}">
            <span class="text-slate-600">Dashboard</span>
          </a>
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="{{ route('pendaftar.biodata.show') }}">
            <span class="text-slate-600">Biodata</span>
          </a>
          <div class="relative">
            <button id="akunToggle" class="w-full text-left px-3 py-2 rounded-md hover:bg-slate-50 flex items-center gap-2">
              <svg class="w-4 h-4 text-[#004269]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM4 20c0-2.761 3.582-5 8-5s8 2.239 8 5v1H4v-1z"/></svg>
              <span class="font-medium">Akun Saya</span>
              <svg id="akunCaret" class="w-3 h-3 ml-auto text-slate-400 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
            </button>
            <div id="akunMenu" class="mt-2 bg-white border rounded shadow-sm" style="display:none;">
              <a class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50" href="{{ route('pendaftar.akun.email') }}">✉️ Ubah Email</a>
              <a class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50" href="{{ route('pendaftar.akun.password') }}">🔒 Ubah Password</a>
              <a class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50" href="{{ route('pendaftar.akun.phone') }}">📱 Ubah Nomor Telepon</a>
              <a class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50" href="{{ route('pendaftar.akun.whatsapp') }}">💬 Ubah WhatsApp</a>
            </div>
          </div>
        </nav>

        {{-- <div class="mt-4 pt-4 border-t text-xs text-slate-500">
          Butuh bantuan? <br>
          <a class="text-[#004269] hover:underline" href="mailto:admissions@lp3i.ac.id">admissions@lp3i.ac.id</a>
        </div> --}}
      </aside>

      <!-- Main -->
      <main class="space-y-6">
        {{-- Status header removed per request --}}

        {{-- PROGRESS TRACKER --}}
        <div class="bg-white rounded-xl border p-5 shadow-sm">
          <div class="mb-4 text-sm text-slate-600">Progres pendaftaran</div>
          <div class="flex items-center gap-4">
            @php
              // Order: Pendaftaran -> Pembayaran -> Verifikasi -> Selesai
              // Map to computed step variables: $step1 (Pendaftaran), $step2 (Pembayaran), $step3 (Verifikasi), $step4 (Selesai)
              $steps = [
                ['label'=>'Pendaftaran','status'=> $step1 ?? 'completed'],
                ['label'=>'Pembayaran','status'=> $step2 ?? 'inactive'],
                ['label'=>'Menunggu Verifikasi','status'=> $step3 ?? 'inactive'],
                ['label'=>'Selesai','status'=> $step4 ?? 'inactive'],
              ];
            @endphp

            <div class="flex items-center w-full">
              @foreach($steps as $i => $s)
                <div class="flex items-center w-full">
                  <div class="flex flex-col items-center w-24 sm:w-32">
                    @php
                      $status = $s['status'];
                      $isCompleted = $status === 'completed';
                      $isActive = $status === 'active';
                      $isRejected = $status === 'rejected';
                      $dotBg = $isCompleted ? 'bg-green-500' : ($isActive ? 'bg-amber-400' : ($isRejected ? 'bg-red-500' : 'bg-slate-200'));
                      $dotTxt = $isCompleted ? 'text-white' : ($isActive ? 'text-white' : 'text-slate-600');
                    @endphp

                    <div class="flex items-center justify-center rounded-full w-10 h-10 {{ $dotBg }} {{ $dotTxt }}">
                      @if($isCompleted)
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      @else
                        <span class="text-sm font-semibold">{{ $i + 1 }}</span>
                      @endif
                    </div>

                    <div class="mt-3 text-xs text-slate-600 text-center">{{ $s['label'] }}</div>
                  </div>

                  @if(!$loop->last)
                    <div class="flex-1 h-0.5 mx-3 rounded bg-slate-200" >
                      @if($isCompleted && ($steps[$i+1]['status'] === 'completed' || $steps[$i+1]['status'] === 'active'))
                        <div class="h-0.5 rounded bg-green-400 w-full"></div>
                      @endif
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          </div>

          <div class="mt-4 text-sm text-slate-500">
            <div>Progres pendaftaran akan diperbarui oleh Staff LP3I karawang.</div>
          </div>
        </div>

        {{-- DETAILS + ACTIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div class="lg:col-span-2 bg-white rounded-xl border p-5 shadow-sm">
            <h3 class="text-sm font-semibold mb-3">Detail Pendaftar</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-slate-700">
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Nomor NIPD</dt><dd class="font-medium mt-1">{{ $calon->nipd ?? ($calon->id ?? '-') }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Nama</dt><dd class="font-medium mt-1">{{ $calon->nama_mhs ?? '-' }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Bidang Keahlian</dt><dd class="font-medium mt-1">{{ $calon->jurusan ?? '-' }}</dd></div>
              {{-- Payment method and created date removed per request --}}
            </dl>
          </div>

          <aside class="bg-white rounded-xl border p-5 shadow-sm">
            <h3 class="text-sm font-semibold mb-3">Aksi</h3>
            <div class="space-y-3">
              @if(($payment ?? 'unpaid') === 'unpaid')
                <a href="{{ route('pendaftar.payment.show') }}" class="block text-center w-full btn-basic text-white px-4 py-2 rounded-md font-semibold">Bayar Sekarang</a>
              @else
                <a href="{{ route('pendaftar.receipt') }}" class="block text-center w-full btn-basic text-white px-4 py-2 rounded-md font-semibold" target="_blank">Download Kuitansi</a>
              @endif
            </div>
          </aside>
        </div>
      </main>
    </div>
  </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    const t = document.getElementById('akunToggle');
    const m = document.getElementById('akunMenu');
    if (t && m) {
      t.addEventListener('click', function(){
        const isHidden = m.style.display === 'none' || m.style.display === '' ? true : (m.style.display === 'none');
        m.style.display = isHidden ? 'block' : 'none';
        const caret = document.getElementById('akunCaret'); if (caret) caret.classList.toggle('caret-rotated');
      });
    }
  });
</script>
</html>