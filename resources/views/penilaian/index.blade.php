@extends('layouts.master')

@section('title', 'Data Penilaian')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 0 16px 0;
        border-bottom: 1px solid #edf2f7;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h4 {
        font-weight: 700;
        color: #1a2332;
        margin: 0;
        font-size: 20px;
    }

    .page-header .btn-primary-custom {
        background: #1a365d;
        border: none;
        color: #ffffff;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .page-header .btn-primary-custom:hover {
        background: #2b6cb0;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 54, 93, 0.25);
        color: #ffffff;
    }

    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        align-items: center;
        background: #ffffff;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #edf2f7;
    }

    .filter-bar .search-box {
        flex: 1;
        min-width: 180px;
        position: relative;
    }

    .filter-bar .search-box input {
        width: 100%;
        padding: 8px 14px 8px 38px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: #f7fafc;
        color: #1a2332;
    }

    .filter-bar .search-box input:focus {
        outline: none;
        border-color: #1a365d;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.06);
    }

    .filter-bar .search-box input::placeholder {
        color: #a0aec0;
    }

    .filter-bar .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
    }

    .filter-bar .filter-select {
        min-width: 130px;
    }

    .filter-bar .filter-select select {
        width: 100%;
        padding: 8px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: #f7fafc;
        color: #1a2332;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a5568' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        cursor: pointer;
    }

    .filter-bar .filter-select select:focus {
        outline: none;
        border-color: #1a365d;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.06);
    }

    .table-wrapper {
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-scroll table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
        font-size: 14px;
        min-width: 700px;
    }

    .table-scroll table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 10px 14px;
        border-bottom: 1px solid #edf2f7;
        text-align: left;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-scroll table tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        color: #2d3748;
        border-bottom: 1px solid #f7fafc;
    }

    .table-scroll table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-scroll table tbody tr:hover {
        background: #f7fafc;
    }

    .col-sticky-left {
        position: sticky;
        left: 0;
        z-index: 5;
        background: #ffffff;
        min-width: 160px;
    }

    .col-sticky-right {
        position: sticky;
        right: 0;
        z-index: 5;
        background: #ffffff;
        min-width: 100px;
        text-align: center;
    }

    .table-scroll table thead .col-sticky-left,
    .table-scroll table thead .col-sticky-right {
        background: #f7fafc;
        z-index: 11;
    }

    .table-scroll table tbody tr:hover .col-sticky-left,
    .table-scroll table tbody tr:hover .col-sticky-right {
        background: #f7fafc;
    }

    .table-scroll table tbody .col-sticky-left {
        box-shadow: 2px 0 8px rgba(0,0,0,0.03);
    }

    .table-scroll table tbody .col-sticky-right {
        box-shadow: -2px 0 8px rgba(0,0,0,0.03);
    }

    .nilai-badge {
        font-size: 14px;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 20px;
        display: inline-block;
    }

    .nilai-tinggi { background: #c6f6d5; color: #22543d; }
    .nilai-sedang { background: #fefcbf; color: #975a16; }
    .nilai-rendah { background: #fed7d7; color: #9b2c2c; }

    .badge-status-custom {
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-status-selesai {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-status-draft {
        background: #fefcbf;
        color: #975a16;
    }

    .btn-action {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #a0aec0;
        transition: all 0.2s ease;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-action:hover {
        background: #f7fafc;
        color: #1a2332;
    }

    .btn-action.btn-info {
        color: #2b6cb0;
    }

    .btn-action.btn-info:hover {
        background: #ebf8ff;
    }

    .btn-action.btn-warning {
        color: #d69e2e;
    }

    .btn-action.btn-warning:hover {
        background: #fefcbf;
    }

    .btn-action.btn-danger {
        color: #e53e3e;
    }

    .btn-action.btn-danger:hover {
        background: #fff5f5;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border-top: 1px solid #edf2f7;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-wrapper .info-text {
        font-size: 12px;
        color: #a0aec0;
    }

    .pagination-wrapper .info-text strong {
        color: #1a2332;
    }

    .pagination-wrapper .pagination {
        margin: 0;
        gap: 2px;
    }

    .pagination-wrapper .page-item .page-link {
        border: none;
        border-radius: 6px;
        color: #4a5568;
        font-weight: 500;
        font-size: 12px;
        padding: 4px 10px;
        transition: all 0.2s ease;
        background: transparent;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #1a365d;
        color: #ffffff;
    }

    .pagination-wrapper .page-item:not(.active) .page-link:hover {
        background: #f7fafc;
        color: #1a2332;
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e0;
    }

    .empty-state {
        padding: 40px 16px;
        text-align: center;
    }

    .empty-state i {
        font-size: 40px;
        color: #e2e8f0;
        margin-bottom: 12px;
        display: block;
    }

    .empty-state h6 {
        color: #1a2332;
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 16px;
    }

    .empty-state p {
        color: #a0aec0;
        font-size: 13px;
        margin-bottom: 14px;
    }

    /* ===== MODAL STYLES ===== */
    .modal-custom .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .modal-custom .modal-header {
        border-bottom: 1px solid #edf2f7;
        padding: 16px 24px;
    }

    .modal-custom .modal-header .modal-title {
        font-weight: 700;
        color: #1a2332;
        font-size: 18px;
    }

    .modal-custom .modal-header .modal-title i {
        color: #1a365d;
    }

    .modal-custom .modal-body {
        padding: 24px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-custom .modal-footer {
        border-top: 1px solid #edf2f7;
        padding: 16px 24px;
    }

    .modal-custom .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #1a2332;
    }

    .modal-custom .form-control,
    .modal-custom .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .modal-custom .form-control:focus,
    .modal-custom .form-select:focus {
        border-color: #1a365d;
        box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.06);
    }

    .modal-custom .btn-secondary-custom {
        background: #edf2f7;
        border: none;
        color: #4a5568;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .modal-custom .btn-secondary-custom:hover {
        background: #e2e8f0;
    }

    .modal-custom .btn-primary-custom {
        background: #1a365d;
        border: none;
        color: #ffffff;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .modal-custom .btn-primary-custom:hover {
        background: #2b6cb0;
    }

    .modal-custom .btn-primary-custom:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .page-header .btn-primary-custom {
            align-self: flex-start;
            font-size: 13px;
            padding: 6px 16px;
        }
        .page-header h4 {
            font-size: 18px;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
            padding: 10px 12px;
        }
        .filter-bar .search-box {
            min-width: 100%;
        }
        .filter-bar .filter-select {
            min-width: 100%;
        }

        .table-scroll table {
            min-width: 550px;
        }
        .table-scroll table thead th {
            font-size: 10px;
            padding: 8px 10px;
        }
        .table-scroll table tbody td {
            padding: 8px 10px;
            font-size: 13px;
        }
        .col-sticky-left {
            min-width: 130px;
        }
        .col-sticky-right {
            min-width: 80px;
        }

        .modal-custom .modal-body {
            padding: 16px;
            max-height: 60vh;
        }
        .modal-custom .modal-header {
            padding: 12px 16px;
        }
        .modal-custom .modal-footer {
            padding: 12px 16px;
            flex-direction: column;
            gap: 8px;
        }
        .modal-custom .modal-footer .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .page-header h4 {
            font-size: 16px;
        }
        .page-header .btn-primary-custom {
            font-size: 12px;
            padding: 5px 14px;
        }
        .table-scroll table {
            min-width: 450px;
        }
        .table-scroll table thead th {
            font-size: 9px;
            padding: 6px 8px;
        }
        .table-scroll table tbody td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .col-sticky-left {
            min-width: 100px;
        }
        .col-sticky-right {
            min-width: 70px;
        }
        .btn-action {
            width: 22px;
            height: 22px;
            font-size: 10px;
        }
        .nilai-badge {
            font-size: 11px;
            padding: 2px 10px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4>Data Penilaian</h4>
    <button class="btn-primary-custom" onclick="openTambahPenilaianModal()">
        <i class="fas fa-plus"></i> Tambah Penilaian
    </button>
</div>

<!-- ===== ALERT ===== -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ===== FILTER BAR ===== -->
<div class="filter-bar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari tim, juri, atau kriteria..." onkeyup="filterTable()">
    </div>
    <div class="filter-select">
        <select id="filterStatus" onchange="filterTable()">
            <option value="">Semua Status</option>
            <option value="selesai">Selesai</option>
            <option value="draft">Draft</option>
        </select>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table id="penilaianTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 150px;">Tim</th>
                    <th style="min-width: 130px;">Juri</th>
                    <th style="min-width: 140px;">Kriteria</th>
                    <th style="min-width: 80px; text-align: center;">Nilai</th>
                    <th style="min-width: 100px;">Status</th>
                    <th class="col-sticky-right" style="min-width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penilaians as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left">
                            <span class="fw-semibold" style="font-size: 13px;">{{ $item->tim->nama_tim ?? '-' }}</span>
                        </td>
                        <td style="font-size: 13px;">{{ $item->juri->user->name ?? '-' }}</td>
                        <td style="font-size: 13px;">{{ $item->kriteria->nama_kriteria ?? '-' }}</td>
                        <td style="text-align: center;">
                            @if($item->nilai !== null)
                                <span class="nilai-badge 
                                    {{ $item->nilai >= 80 ? 'nilai-tinggi' : ($item->nilai >= 60 ? 'nilai-sedang' : 'nilai-rendah') }}">
                                    {{ $item->nilai }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status-custom {{ $item->status == 'selesai' ? 'badge-status-selesai' : 'badge-status-draft' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="openShowPenilaianModal(
                                    '{{ addslashes($item->tim->nama_tim ?? '-') }}',
                                    '{{ addslashes($item->juri->user->name ?? '-') }}',
                                    '{{ addslashes($item->kriteria->nama_kriteria ?? '-') }}',
                                    '{{ $item->nilai }}',
                                    '{{ $item->status }}',
                                    '{{ addslashes($item->komentar) }}',
                                    '{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->updated_at ? $item->updated_at->format('d F Y H:i') : '' }}'
                                )">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-warning" title="Edit" onclick="openEditPenilaianModal(
                                    {{ $item->id_penilaian }},
                                    {{ $item->id_tim }},
                                    {{ $item->id_juri }},
                                    {{ $item->id_kriteria }},
                                    '{{ $item->nilai }}',
                                    '{{ addslashes($item->komentar) }}',
                                    '{{ $item->status }}'
                                )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-danger" title="Hapus" onclick="deletePenilaian({{ $item->id_penilaian }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <h6>Belum ada data penilaian</h6>
                                <p>Silakan tambahkan penilaian baru melalui tombol di atas.</p>
                                <button class="btn-primary-custom" onclick="openTambahPenilaianModal()" style="display: inline-flex; border: none;">
                                    <i class="fas fa-plus me-1"></i> Tambah Penilaian
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($penilaians->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $penilaians->firstItem() }}</strong> sampai <strong>{{ $penilaians->lastItem() }}</strong> dari <strong>{{ $penilaians->total() }}</strong> penilaian
            </span>
            {{ $penilaians->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- ===== MODAL TAMBAH PENILAIAN ===== -->
<div class="modal fade modal-custom" id="tambahPenilaianModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2" style="color: #1a365d;"></i> Tambah Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPenilaian" action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_id_tim" class="form-label">Tim <span class="text-danger">*</span></label>
                                <select class="form-select" id="modal_id_tim" name="id_tim" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach($tim ?? [] as $t)
                                        <option value="{{ $t->id_tim }}">{{ $t->nama_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_id_juri" class="form-label">Juri <span class="text-danger">*</span></label>
                                <select class="form-select" id="modal_id_juri" name="id_juri" required>
                                    <option value="">-- Pilih Juri --</option>
                                    @foreach($juri ?? [] as $j)
                                        <option value="{{ $j->id_juri }}">{{ $j->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_id_kriteria" class="form-label">Kriteria <span class="text-danger">*</span></label>
                                <select class="form-select" id="modal_id_kriteria" name="id_kriteria" required>
                                    <option value="">-- Pilih Kriteria --</option>
                                    @foreach($kriteria ?? [] as $k)
                                        <option value="{{ $k->id_kriteria }}">{{ $k->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_nilai" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="modal_nilai" name="nilai" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="modal_komentar" name="komentar" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modal_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanPenilaian">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT PENILAIAN ===== -->
<div class="modal fade modal-custom" id="editPenilaianModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="color: #d69e2e;"></i> Edit Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPenilaian" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_id_tim" class="form-label">Tim <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_tim" name="id_tim" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach($tim ?? [] as $t)
                                        <option value="{{ $t->id_tim }}">{{ $t->nama_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_id_juri" class="form-label">Juri <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_juri" name="id_juri" required>
                                    <option value="">-- Pilih Juri --</option>
                                    @foreach($juri ?? [] as $j)
                                        <option value="{{ $j->id_juri }}">{{ $j->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_id_kriteria" class="form-label">Kriteria <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_kriteria" name="id_kriteria" required>
                                    <option value="">-- Pilih Kriteria --</option>
                                    @foreach($kriteria ?? [] as $k)
                                        <option value="{{ $k->id_kriteria }}">{{ $k->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nilai" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="edit_nilai" name="nilai" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="edit_komentar" name="komentar" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <input type="hidden" id="edit_penilaian_id" name="penilaian_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdatePenilaian" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL SHOW PENILAIAN ===== -->
<div class="modal fade modal-custom" id="showPenilaianModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Detail Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1a365d, #2b6cb0); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showNamaTim">-</h5>
                    <p class="text-muted" id="showNamaJuri">-</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Kriteria</label>
                            <p class="fw-semibold" id="showNamaKriteria">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Nilai</label>
                            <p id="showNilai">-</p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Komentar</label>
                    <p id="showKomentar" class="text-muted" style="font-style: italic;">-</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Status</label>
                            <p id="showStatusPenilaian">-</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Dibuat</label>
                            <p class="fw-semibold" id="showCreatedAt">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Diupdate</label>
                            <p class="fw-semibold" id="showUpdatedAt">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button type="button" class="btn-primary-custom" id="btnEditFromShowPenilaian" style="background: #d69e2e;">
                    <i class="fas fa-edit me-1"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== JAVASCRIPT ===== -->
<script>
// ===== VARIABLES =====
let searchTimeout = null;
let currentPage = 1;

// ===== SEARCH & FILTER =====
function filterTable() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('filterStatus').value;

    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(function() {
        currentPage = 1;
        fetchData(search, status, currentPage);
    }, 300);
}

// ===== FETCH DATA VIA AJAX =====
function fetchData(search, status, page) {
    const tableBody = document.querySelector('#penilaianTable tbody');
    const paginationWrapper = document.querySelector('.pagination-wrapper');

    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Memuat data...</p>
                </td>
            </tr>
        `;
    }

    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('status', status);
    url.searchParams.set('page', page);

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        const newTableBody = doc.querySelector('#penilaianTable tbody');
        const newPagination = doc.querySelector('.pagination-wrapper');

        if (tableBody && newTableBody) {
            tableBody.innerHTML = newTableBody.innerHTML;
        }

        if (paginationWrapper && newPagination) {
            paginationWrapper.innerHTML = newPagination.innerHTML;
        } else if (paginationWrapper && !newPagination) {
            const totalRows = tableBody ? tableBody.querySelectorAll('tr:not(.empty-state)').length : 0;
            paginationWrapper.innerHTML = `
                <span class="info-text">
                    Menampilkan <strong>1</strong> sampai <strong>${totalRows}</strong> dari <strong>${totalRows}</strong> penilaian
                </span>
            `;
        }

        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('search', search);
        newUrl.searchParams.set('status', status);
        newUrl.searchParams.set('page', page);
        window.history.pushState({}, '', newUrl);

        attachPaginationListeners();
    })
    .catch(error => {
        console.error('Error:', error);
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-exclamation-circle fa-2x text-danger mb-2 d-block"></i>
                        <p class="text-danger">Gagal memuat data. Silakan refresh halaman.</p>
                    </td>
                </tr>
            `;
        }
    });
}

// ===== ATTACH PAGINATION LISTENERS =====
function attachPaginationListeners() {
    document.querySelectorAll('.pagination-wrapper .page-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            if (href) {
                const url = new URL(href, window.location.origin);
                const search = document.getElementById('searchInput').value;
                const status = document.getElementById('filterStatus').value;
                const page = url.searchParams.get('page') || 1;
                currentPage = parseInt(page);
                fetchData(search, status, currentPage);
            }
        });
    });
}

// ===== DELETE PENILAIAN =====
function deletePenilaian(id) {
    if (!confirm('Yakin hapus penilaian ini?')) {
        return;
    }

    fetch('/penilaian/' + id, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            alert(data.message || 'Gagal menghapus penilaian.');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        console.error('Error:', error);
    });
}

// ===== MODAL TAMBAH PENILAIAN =====
function openTambahPenilaianModal() {
    const modal = new bootstrap.Modal(document.getElementById('tambahPenilaianModal'));
    modal.show();
}

document.getElementById('btnSimpanPenilaian').addEventListener('click', function() {
    const form = document.getElementById('formTambahPenilaian');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('tambahPenilaianModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Menyimpan...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            modal.hide();
            showNotification('success', data.message);
            form.reset();
            setTimeout(() => location.reload(), 1500);
        } else {
            const errorMsg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Silakan coba lagi.');
            alert('Terjadi kesalahan:\n' + errorMsg);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        console.error('Error:', error);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save me-1"></i> Simpan';
    });
});

// ===== MODAL EDIT PENILAIAN =====
function openEditPenilaianModal(id, idTim, idJuri, idKriteria, nilai, komentar, status) {
    const modalElement = document.getElementById('editPenilaianModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('formEditPenilaian').action = '/penilaian/' + id;
    document.getElementById('edit_penilaian_id').value = id;
    document.getElementById('edit_id_tim').value = idTim || '';
    document.getElementById('edit_id_juri').value = idJuri || '';
    document.getElementById('edit_id_kriteria').value = idKriteria || '';
    document.getElementById('edit_nilai').value = nilai || '';
    document.getElementById('edit_komentar').value = komentar || '';
    document.getElementById('edit_status').value = status || 'draft';
    
    modal.show();
}

document.getElementById('btnUpdatePenilaian').addEventListener('click', function() {
    const form = document.getElementById('formEditPenilaian');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('editPenilaianModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Mengupdate...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            modal.hide();
            showNotification('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            const errorMsg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Silakan coba lagi.');
            alert('Terjadi kesalahan:\n' + errorMsg);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        console.error('Error:', error);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save me-1"></i> Update';
    });
});

// ===== MODAL SHOW PENILAIAN =====
function openShowPenilaianModal(tim, juri, kriteria, nilai, status, komentar, created_at, updated_at) {
    const modalElement = document.getElementById('showPenilaianModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('showNamaTim').textContent = tim || '-';
    document.getElementById('showNamaJuri').textContent = juri || '-';
    document.getElementById('showNamaKriteria').textContent = kriteria || '-';
    document.getElementById('showKomentar').textContent = komentar || 'Tidak ada komentar';
    document.getElementById('showCreatedAt').textContent = created_at || '-';
    document.getElementById('showUpdatedAt').textContent = updated_at || '-';
    
    // Nilai
    const nilaiElement = document.getElementById('showNilai');
    if (nilai !== null && nilai !== '') {
        const numNilai = parseInt(nilai);
        const badgeClass = numNilai >= 80 ? 'nilai-tinggi' : (numNilai >= 60 ? 'nilai-sedang' : 'nilai-rendah');
        nilaiElement.innerHTML = '<span class="nilai-badge ' + badgeClass + '">' + numNilai + '</span>';
    } else {
        nilaiElement.innerHTML = '<span class="text-muted">-</span>';
    }
    
    // Status
    const statusBadge = document.getElementById('showStatusPenilaian');
    if (status === 'selesai') {
        statusBadge.innerHTML = '<span class="badge-status-custom badge-status-selesai">Selesai</span>';
    } else {
        statusBadge.innerHTML = '<span class="badge-status-custom badge-status-draft">Draft</span>';
    }
    
    // Tombol Edit
    document.getElementById('btnEditFromShowPenilaian').onclick = function() {
        modal.hide();
        setTimeout(function() {
            const editBtn = document.querySelector('#penilaianTable tbody tr:not(.empty-state) .btn-action.btn-warning');
            if (editBtn) {
                editBtn.click();
            }
        }, 300);
    };
    
    modal.show();
}

// ===== SHOW NOTIFICATION =====
function showNotification(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.page-header').parentNode;
    container.insertBefore(alertDiv, document.querySelector('.page-header').nextSibling);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// ===== RESET FORM SAAT MODAL DITUTUP =====
document.querySelectorAll('.modal').forEach(function(modal) {
    modal.addEventListener('hidden.bs.modal', function() {
        const form = this.querySelector('form');
        if (form) {
            form.reset();
            document.querySelectorAll('.is-invalid').forEach(function(el) {
                el.classList.remove('is-invalid');
            });
        }
    });
});

// ===== INITIAL =====
document.addEventListener('DOMContentLoaded', function() {
    attachPaginationListeners();

    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    const statusParam = urlParams.get('status');
    
    if (searchParam) {
        document.getElementById('searchInput').value = searchParam;
    }
    if (statusParam) {
        document.getElementById('filterStatus').value = statusParam;
    }
    
    if (searchParam || statusParam) {
        const page = urlParams.get('page') || 1;
        currentPage = parseInt(page);
        fetchData(searchParam || '', statusParam || '', currentPage);
    }
});
</script>
@endsection