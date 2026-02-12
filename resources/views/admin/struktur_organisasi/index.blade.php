<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Struktur Organisasi - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: #004269;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #004269;
            color: white;
        }

        .btn-primary:hover {
            background: #003050;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .photo {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        @media (max-width: 900px) {
            .page-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .table-container { overflow-x: auto; }
            .table { min-width: 720px; }
        }

        @media (max-width: 640px) {
            .container { padding: 1.25rem; }
            .actions { flex-wrap: wrap; }
        }

        .actions a, .actions button {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .edit-btn {
            background: #17a2b8;
            color: white;
        }

        .edit-btn:hover {
            background: #138496;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .posisi-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .posisi-director {
            background: #d4af37;
            color: #333;
        }

        .posisi-secretary {
            background: #b4a7d6;
            color: white;
        }

        .posisi-staff {
            background: #87ceeb;
            color: white;
        }

        .status-active {
            background: #28a745;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            font-size: 0.85rem;
        }

        .status-inactive {
            background: #dc3545;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            font-size: 0.85rem;
        }

        .back-link {
            margin-bottom: 1rem;
        }

        .back-link a {
            color: #004269;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .table {
                font-size: 0.9rem;
            }

            .table th, .table td {
                padding: 0.7rem;
            }

            .actions {
                flex-direction: column;
            }

            .actions a, .actions button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-link">
            <a href="/admin"><i class="fas fa-arrow-left"></i> Kembali ke Admin</a>
        </div>

        <div class="page-header">
            <h1><i class="fas fa-sitemap"></i> Kelola Struktur Organisasi</h1>
            <a href="{{ route('struktur-organisasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Role/Jabatan</th>
                        <th>Posisi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($strukturs as $struktur)
                        <tr>
                            <td>
                                @if ($struktur->foto)
                                    <img src="{{ Storage::url($struktur->foto) }}" alt="{{ $struktur->nama }}" class="photo">
                                @else
                                    <span style="color: #999;">Tidak ada foto</span>
                                @endif
                            </td>
                            <td><strong>{{ $struktur->nama }}</strong></td>
                            <td>{{ $struktur->role }}</td>
                            <td>
                                <span class="posisi-badge posisi-{{ $struktur->posisi }}">
                                    {{ ucfirst($struktur->posisi) }}
                                </span>
                            </td>
                            <td>{{ $struktur->urutan }}</td>
                            <td>
                                @if ($struktur->is_active)
                                    <span class="status-active">Aktif</span>
                                @else
                                    <span class="status-inactive">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('struktur-organisasi.edit', $struktur) }}" class="edit-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('struktur-organisasi.destroy', $struktur) }}" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem;">
                                <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem;"></i>
                                <p>Tidak ada data struktur organisasi. <a href="{{ route('struktur-organisasi.create') }}">Tambah sekarang</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
