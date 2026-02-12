<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Biodata Pendaftar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>


    :root{--basic:#004269;--adv:#40826D}
    body{background:var(--basic);}
    /* Card: white background with viridian border */
    .card-adv{border:1px solid var(--adv);box-shadow:0 6px 18px rgba(0,0,0,0.08);background:#fff;color:#0f172a}
    .btn-basic{background:linear-gradient(90deg,var(--basic),#009DA5);box-shadow:0 6px 12px rgba(0,0,0,0.12)}
    /* Thicker form borders for visibility */
    input, select, textarea { border-width: 2px !important; border-color: rgba(15,23,42,0.08) !important; }
    /* Details/account dropdown tweaks */
    .details-acc summary { display:flex; align-items:center; gap:.5rem }
    .details-acc .icon-acc { color:var(--basic); transition:transform .18s ease }
    .details-acc .caret-acc { transition:transform .18s ease; transform-origin:center }
    .details-acc[open] .caret-acc { transform:rotate(180deg) }
    .details-acc[open] .icon-acc { transform:scale(1.04) }
  </style>
</head>
<body class="text-slate-800">
  @include('partials.header')
  <div class="max-w-6xl mx-auto p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">
      <!-- Sidebar (same style as dashboard) -->
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
          {{-- <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="{{ route('pendaftar.payment.show') }}">
            <span class="text-slate-600">Pembayaran</span>
          </a> --}}
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50 bg-slate-50" href="{{ route('pendaftar.biodata.show') }}">
            <span class="text-slate-600">Biodata</span>
          </a>

          <details class="group details-acc">
            <summary class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50 cursor-pointer">
              <svg class="w-5 h-5 text-[#004269] icon-acc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM4 20c0-2.761 3.582-5 8-5s8 2.239 8 5v1H4v-1z"/></svg>
              <span class="font-medium">Akun Saya</span>
              <svg class="w-4 h-4 ml-auto text-slate-400 caret-acc" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
            </summary>
            <div class="pl-4 mt-2 space-y-1">
              <a href="{{ route('pendaftar.akun.email') }}" class="block px-3 py-1 rounded hover:bg-slate-100">Email</a>
              <a href="{{ route('pendaftar.akun.password') }}" class="block px-3 py-1 rounded hover:bg-slate-100">Password</a>
              <a href="{{ route('pendaftar.akun.phone') }}" class="block px-3 py-1 rounded hover:bg-slate-100">No Handphone</a>
              <a href="{{ route('pendaftar.akun.whatsapp') }}" class="block px-3 py-1 rounded hover:bg-slate-100">No Whats App</a>
            </div>
          </details>

        </nav>
      </aside>

      <main>
        <div class="bg-white rounded-xl card-adv p-6">
          @if(session('success'))
            <div class="p-3 mb-4 rounded bg-green-50 text-green-700">{{ session('success') }}</div>
          @endif
          <div class="flex gap-6 items-start">
            <div class="w-64">
              <div class="rounded-lg overflow-hidden shadow-sm">
                <div class="w-full h-64 bg-gradient-to-br from-slate-50 to-white flex items-center justify-center">
                  @if(!empty($pendaftar->photo_url) || !empty($pendaftar->file_path))
                    <img src="{{ asset(ltrim($pendaftar->photo_url ?? $pendaftar->file_path,'/')) }}" alt="Foto Profil" class="w-full h-64 object-cover" />
                  @else
                    <div class="text-center text-slate-400">Belum ada foto profil</div>
                  @endif
                </div>
              </div>

              @if(!empty($pendaftar->ktp_path))
                <div class="mt-3 text-sm">
                  <div class="text-slate-700">Dokumen KTP/Kartu Pelajar telah diunggah. Dokumen tidak ditampilkan di halaman ini untuk menjaga privasi.</div>
                </div>
              @endif

              <a href="{{ route('pendaftar.biodata.edit') }}" class="mt-4 inline-block w-full text-center py-2 rounded-md text-white font-semibold btn-basic">Edit Biodata</a>
            </div>

            <div class="flex-1">
              <div class="flex items-center justify-between">
                <div>
                  <h2 class="text-2xl font-bold text-[#004269]">Biodata Pendaftar</h2>
                  <p class="text-sm text-slate-500">Perbarui informasi pribadi Anda di halaman ini.</p>
                </div>
                <div class="text-sm text-slate-500">Nomor: <span class="font-medium text-slate-700">{{ $pendaftar->nipd ?? ($pendaftar->id ?? '-') }}</span></div>
              </div>

              <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                  $fields = [
                    ['label'=>'Nama','value'=>$pendaftar->nama_mhs ?? '-'],
                    ['label'=>'No. HP','value'=>$pendaftar->no_hp ?? '-'],
                    ['label'=>'Email','value'=>$pendaftar->email ?? '-'],
                    ['label'=>'Jenis Kelas','value'=>$pendaftar->jenis_kelas ?? '-'],
                    ['label'=>'Program Studi','value'=>\App\Helpers\JurusanHelper::getFormat($pendaftar->jurusan ?? null)],
                    ['label'=>'Asal Sekolah','value'=>$pendaftar->asal_sekolah ?? '-'],
                    ['label'=>'Agama','value'=>$pendaftar->agama ?? '-'],
                    ['label'=>'Jenis Kelamin','value'=>$pendaftar->jenis_kelamin ?? '-'],
                    ['label'=>'Alamat','value'=>$pendaftar->alamat ?? '-'],
                    ['label'=>'Kecamatan','value'=>$pendaftar->kecamatan ?? '-'],
                    ['label'=>'Desa','value'=>$pendaftar->desa ?? '-'],
                    ['label'=>'Kode Pos','value'=>$pendaftar->kode_pos ?? '-'],
                    ['label'=>'Tahun Lulus','value'=>$pendaftar->tahun_lulus ?? '-'],
                    ['label'=>'Instagram','value'=>$pendaftar->instagram ?? '-'],
                    ['label'=>'Nama Orang Tua/Wali','value'=>$pendaftar->nama_wali ?? '-'],
                    ['label'=>'No. Telp Orang Tua/Wali','value'=>$pendaftar->telp_wali ?? '-'],
                    ['label'=>'Pekerjaan Orang Tua/Wali','value'=>$pendaftar->pekerjaan_wali ?? '-'],
                  ];
                @endphp

                @foreach($fields as $f)
                  <div class="p-4 bg-white rounded border-l-4 border-[#40826D]">
                    <div class="text-xs text-slate-400">{{ $f['label'] }}</div>
                    <div class="font-medium text-slate-800 mt-1">{{ $f['value'] }}</div>
                  </div>
                @endforeach
              </div>

              <div class="mt-6">
                {{-- <a href="{{ route('pendaftar.dashboard') }}" class="inline-block px-4 py-2 rounded-md border">Kembali ke Dashboard</a> --}}
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
