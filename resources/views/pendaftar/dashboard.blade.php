<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard Pendaftar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-slate-800">
  <div class="max-w-6xl mx-auto p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">
      <!-- Sidebar -->
      <aside class="bg-white rounded-xl border p-5 shadow-sm sticky top-6">
        <div class="flex items-center gap-3 mb-4">
          <svg class="w-8 h-8 text-[#004269]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 11c2.761 0 5-2.239 5-5S14.761 1 12 1 7 3.239 7 6s2.239 5 5 5zM3 21a9 9 0 0118 0"/></svg>
          <div>
            <div class="text-sm text-slate-400">Halo</div>
            <div class="font-semibold">{{ Auth::user()->name ?? 'Pendaftar' }}</div>
          </div>
        </div>

        <nav class="space-y-2 text-sm">
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="{{ route('pendaftar.dashboard') }}">
            <span class="text-slate-600">Dashboard</span>
          </a>
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="{{ route('pendaftar.payment.show') }}">
            <span class="text-slate-600">Pembayaran</span>
          </a>
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="#">
            <span class="text-slate-600">Dokumen</span>
          </a>
        </nav>

        <div class="mt-4 pt-4 border-t text-xs text-slate-500">
          Butuh bantuan? <br>
          <a class="text-[#004269] hover:underline" href="mailto:admissions@lp3i.ac.id">admissions@lp3i.ac.id</a>
        </div>
      </aside>

      <!-- Main -->
      <main class="space-y-6">
        {{-- STATUS HEADER --}}
        <div class="bg-white rounded-xl border p-5 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <div>
            <h1 class="text-lg md:text-xl font-semibold text-slate-800">Status Pendaftaran</h1>
            <div class="text-sm text-slate-500 mt-1">Nomor Pendaftaran: <span class="font-medium">{{ $calon->nipd ?? ($calon->id ?? '-') }}</span></div>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-sm text-slate-500 hidden sm:inline">Tanggal: <span class="font-medium text-slate-800">{{ $calon->created_at ? $calon->created_at->format('d M Y') : now()->format('d M Y') }}</span></div>
            @if(($payment ?? 'unpaid') === 'unpaid')
              <a href="{{ route('pendaftar.payment.show') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#004269] to-[#009DA5] hover:from-[#003352] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-md">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Bayar Pendaftaran
              </a>
            @else
              <span class="inline-flex items-center gap-2 text-sm text-slate-600 px-3 py-2 rounded-full bg-slate-50 border">Pembayaran: <strong class="ml-1 text-slate-800">{{ ucfirst($payment) }}</strong></span>
            @endif
          </div>
        </div>

        {{-- PROGRESS TRACKER --}}
        <div class="bg-white rounded-xl border p-5 shadow-sm">
          <div class="mb-4 text-sm text-slate-600">Progres pendaftaran</div>
          <div class="flex items-center gap-4">
            @php
              $steps = [
                ['label'=>'Pendaftaran','status'=> $step1 ?? 'completed'],
                ['label'=>'Verifikasi','status'=> $step2 ?? 'inactive'],
                ['label'=>'Pembayaran','status'=> $step3 ?? 'inactive'],
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
            @if(($payment ?? 'unpaid') === 'unpaid')
              <div>Biaya: <strong>Rp {{ number_format($amount ?? 350000,0,',','.') }}</strong></div>
            @elseif(($verif ?? 'pending') === 'pending')
              <div>Menunggu verifikasi admin. Anda akan diberitahu melalui email setelah diverifikasi.</div>
            @elseif(($verif ?? '') === 'rejected')
              <div class="text-red-600">Pendaftaran ditolak. Silakan hubungi admin: <a class="underline" href="mailto:admissions@lp3i.ac.id">admissions@lp3i.ac.id</a></div>
            @else
              <div class="text-green-600">Pendaftaran lengkap. Terima kasih!</div>
            @endif
          </div>
        </div>

        {{-- DETAILS + ACTIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div class="lg:col-span-2 bg-white rounded-xl border p-5 shadow-sm">
            <h3 class="text-sm font-semibold mb-3">Detail Pendaftar</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-slate-700">
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Nomor Pendaftaran</dt><dd class="font-medium mt-1">{{ $calon->nipd ?? ($calon->id ?? '-') }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Nama</dt><dd class="font-medium mt-1">{{ $calon->nama_mhs ?? '-' }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Jurusan</dt><dd class="font-medium mt-1">{{ $calon->jurusan ?? '-' }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Sumber</dt><dd class="font-medium mt-1">{{ $calon->sumber_pendaftaran ?? '-' }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Metode Pembayaran</dt><dd class="font-medium mt-1">{{ $calon->payment_method ?? '-' }}</dd></div>
              <div class="p-3 bg-slate-50 rounded"><dt class="text-xs text-slate-400">Tanggal Daftar</dt><dd class="font-medium mt-1">{{ $calon->created_at ? $calon->created_at->format('d M Y') : '-' }}</dd></div>
            </dl>
          </div>

          <aside class="bg-white rounded-xl border p-5 shadow-sm">
            <h3 class="text-sm font-semibold mb-3">Aksi Cepat</h3>
            <div class="space-y-3">
              @if(($payment ?? 'unpaid') === 'unpaid')
                <a href="{{ route('pendaftar.payment.show') }}" class="block text-center w-full bg-gradient-to-r from-[#004269] to-[#009DA5] hover:from-[#003352] text-white px-4 py-2 rounded-md font-semibold">Bayar Sekarang</a>
              @else
                <a href="#" class="block text-center w-full border border-slate-200 px-4 py-2 rounded-md text-sm">Cetak Bukti</a>
              @endif

              <a href="#" class="block w-full text-center px-4 py-2 rounded-md bg-slate-100 text-sm">Lihat Detail Pendaftaran</a>
              <a href="mailto:admissions@lp3i.ac.id" class="block w-full text-center px-4 py-2 rounded-md bg-slate-100 text-sm">Hubungi Admin</a>
            </div>
          </aside>
        </div>
      </main>
    </div>
  </div>
</body>
</html>