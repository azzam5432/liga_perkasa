@extends('layouts.master')

@section('title', 'Data Lomba')

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
        min-width: 200px;
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
        min-width: 500px;
    }

    .table-scroll table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 10px 14px;
        border-bottom: 2px solid #edf2f7;
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
        min-width: 170px;
    }

    .col-sticky-right {
        position: sticky;
        right: 0;
        z-index: 5;
        background: #ffffff;
        min-width: 120px;
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

    .badge-juri {
        background: #ebf8ff;
        color: #2b6cb0;
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        margin: 2px;
    }

    .badge-status {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .badge-status-draft { background: #e2e8f0; color: #4a5568; }
    .badge-status-open { background: #c6f6d5; color: #22543d; }
    .badge-status-selesai { background: #ebf8ff; color: #2b6cb0; }
    .badge-status-closed { background: #fed7d7; color: #9b2c2c; }

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

    /* Jenis Card Style */
    .jenis-card {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .jenis-card:hover {
        border-color: #1a365d;
        background: #f7fafc;
    }

    .jenis-card.selected {
        border-color: #1a365d;
        background: #ebf8ff;
    }

    .jenis-card .jenis-icon {
        font-size: 28px;
        display: block;
        margin-bottom: 4px;
    }

    .jenis-card .jenis-title {
        font-weight: 600;
        font-size: 13px;
        color: #1a2332;
    }

    .jenis-card .jenis-desc {
        font-size: 11px;
        color: #718096;
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

        .table-scroll table {
            font-size: 13px;
            min-width: 450px;
        }
        .table-scroll table thead th {
            font-size: 10px;
            padding: 8px 10px;
        }
        .table-scroll table tbody td {
            padding: 8px 10px;
        }
        .col-sticky-left {
            min-width: 140px;
        }
        .col-sticky-right {
            min-width: 90px;
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
            font-size: 12px;
            min-width: 380px;
        }
        .table-scroll table thead th {
            font-size: 9px;
            padding: 6px 8px;
        }
        .table-scroll table tbody td {
            padding: 6px 8px;
        }
        .col-sticky-left {
            min-width: 110px;
        }
        .col-sticky-right {
            min-width: 70px;
        }
        .btn-action {
            width: 22px;
            height: 22px;
            font-size: 10px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4><i class="fas fa-trophy me-2"></i> Data Lomba</h4>
    @if(Auth::user()->isPanitia() || Auth::user()->isSuperAdmin())
    <button class="btn-primary-custom" onclick="openTambahLombaModal()">
        <i class="fas fa-plus"></i> Tambah Lomba
    </button>
    @endif
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
        <input type="text" id="searchInput" placeholder="Cari nama lomba..." onkeyup="filterTable()">
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table id="lombaTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 170px;">Nama Lomba</th>
                    <th style="min-width: 120px;">Jenis</th>
                    <th style="min-width: 120px;">Status</th>
                    <th style="min-width: 200px;">Juri</th>
                    <th class="col-sticky-right" style="min-width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lombas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left">
                            <span class="fw-semibold" style="font-size: 13px;">{{ $item->nama_lomba }}</span>
                        </td>
                        <td>
                            @if($item->jenis)
                                <span class="badge bg-info">{{ $item->jenis }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status)
                                <span class="badge-status 
                                    {{ $item->status == 'open' ? 'badge-status-open' : 
                                       ($item->status == 'selesai' ? 'badge-status-selesai' : 
                                       ($item->status == 'closed' ? 'badge-status-closed' : 'badge-status-draft')) }}">
                                    {{ $item->status }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td style="font-size: 13px;">
                            @if($item->juri->count() > 0)
                                @foreach($item->juri->take(3) as $juri)
                                    <span class="badge-juri">
                                        {{ $juri->user->name ?? 'Juri' }}
                                    </span>
                                @endforeach
                                @if($item->juri->count() > 3)
                                    <span class="badge-juri">+{{ $item->juri->count() - 3 }} lagi</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="openShowLombaModal({{ $item->id_lomba }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(Auth::user()->isSuperAdmin())
                                    <button class="btn-action btn-warning" title="Edit" onclick="openEditLombaModal({{ $item->id_lomba }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-danger" title="Hapus" onclick="deleteLomba({{ $item->id_lomba }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <h6>Belum ada data lomba</h6>
                                <p>Silakan tambahkan lomba baru melalui tombol di atas.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($lombas->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $lombas->firstItem() }}</strong> sampai <strong>{{ $lombas->lastItem() }}</strong> dari <strong>{{ $lombas->total() }}</strong> lomba
            </span>
            {{ $lombas->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- ========================================== -->
<!-- ===== MODAL TAMBAH LOMBA ===== -->
<!-- ========================================== -->
<div class="modal fade modal-custom" id="tambahLombaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2" style="color: #1a365d;"></i> Tambah Lomba
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahLomba" action="{{ route('lomba.store') }}" method="POST">
                    @csrf

                    <!-- Nama Lomba -->
                    <div class="mb-3">
                        <label for="modal_nama_lomba" class="form-label">Nama Lomba <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_nama_lomba" name="nama_lomba" required>
                    </div>

                    <!-- Deskripsi & Kategori -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="modal_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="modal_deskripsi" name="deskripsi" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Lomba -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Lomba <span class="text-danger">*</span></label>
                        <div class="row g-2" id="jenisContainer">
                            <div class="col-6">
                                <div class="jenis-card" data-value="langsung" onclick="pilihJenis(this)">
                                    <div class="jenis-title">Tanpa Babak</div>
                                    <div class="jenis-desc">Langsung dinilai</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="jenis-card" data-value="penyisihan" onclick="pilihJenis(this)">
                                    <div class="jenis-title">Penyisihan + Final</div>
                                    <div class="jenis-desc">Ada babak final</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="modal_jenis" name="jenis" value="langsung">
                    </div>

                    <!-- Bobot & Jumlah Finalis -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_bobot" class="form-label">Bobot / Poin <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" class="form-control" id="modal_bobot" name="bobot" value="0" min="0" max="100" required>
                                <small class="text-muted">Nilai untuk pemenang</small>
                            </div>
                        </div>
                        <div class="col-md-6" id="modal_finalisSection">
                            <div class="mb-3">
                                <label for="modal_jumlah_finalis" class="form-label">Jumlah Finalis</label>
                                <input type="number" class="form-control" id="modal_jumlah_finalis" name="jumlah_finalis" value="5" min="0">
                                <small class="text-muted">Tim yang masuk final</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="modal_tanggal_mulai" name="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="modal_tanggal_selesai" name="tanggal_selesai">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanLomba">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ===== MODAL EDIT LOMBA ===== -->
<!-- ========================================== -->
<div class="modal fade modal-custom" id="editLombaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="color: #d69e2e;"></i> Edit Lomba
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditLomba" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lomba -->
                    <div class="mb-3">
                        <label for="edit_nama_lomba" class="form-label">Nama Lomba <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_lomba" name="nama_lomba" required>
                    </div>

                    <!-- Deskripsi & Kategori -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="2"></textarea>
                            </div>
                        </div>
                        
                    </div>

                    <!-- Status & Jenis -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Lomba <span class="text-danger">*</span></label>
                                <div class="row g-2" id="jenisContainer">
                                    <div class="col-6">
                                        <div class="jenis-card" data-value="langsung" onclick="pilihJenis(this)">
                                            <div class="jenis-title">Tanpa Babak</div>
                                            <div class="jenis-desc">Langsung dinilai</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="jenis-card" data-value="penyisihan" onclick="pilihJenis(this)">
                                            <div class="jenis-title">Penyisihan + Final</div>
                                            <div class="jenis-desc">Ada babak final</div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="modal_jenis" name="jenis" value="langsung">
                            </div>
                        </div>
                    </div>

                    <!-- Bobot & Jumlah Finalis -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_bobot" class="form-label">Bobot / Poin <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" class="form-control" id="edit_bobot" name="bobot" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="edit_finalisSection">
                            <div class="mb-3">
                                <label for="edit_jumlah_finalis" class="form-label">Jumlah Finalis</label>
                                <input type="number" class="form-control" id="edit_jumlah_finalis" name="jumlah_finalis" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="edit_tanggal_selesai" name="tanggal_selesai">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="edit_lomba_id" name="lomba_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdateLomba" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ===== MODAL SHOW LOMBA ===== -->
<!-- ========================================== -->
<div class="modal fade modal-custom" id="showLombaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Detail Lomba
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="showLombaContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ===== JAVASCRIPT ===== -->
<!-- ========================================== -->
<script>
// ===== FILTER TABLE =====
function filterTable() {
    const search = document.getElementById('searchInput').value;
    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

// ===== PILIH JENIS (TAMBAH) =====
function pilihJenis(element) {
    document.querySelectorAll('#jenisContainer .jenis-card').forEach(card => {
        card.classList.remove('selected');
    });
    element.classList.add('selected');
    document.getElementById('modal_jenis').value = element.dataset.value;
    
    const finalisSection = document.getElementById('modal_finalisSection');
    if (element.dataset.value === 'penyisihan') {
        finalisSection.style.display = 'block';
    } else {
        finalisSection.style.display = 'none';
    }
}

// ===== PILIH JENIS (EDIT) =====
function pilihJenisEdit(element) {
    document.querySelectorAll('#editJenisContainer .jenis-card').forEach(card => {
        card.classList.remove('selected');
    });
    element.classList.add('selected');
    document.getElementById('edit_jenis').value = element.dataset.value;
    
    const finalisSection = document.getElementById('edit_finalisSection');
    if (element.dataset.value === 'penyisihan') {
        finalisSection.style.display = 'block';
    } else {
        finalisSection.style.display = 'none';
    }
}

// ===== MODAL TAMBAH LOMBA =====
function openTambahLombaModal() {
    const modal = new bootstrap.Modal(document.getElementById('tambahLombaModal'));
    modal.show();
}

document.getElementById('btnSimpanLomba').addEventListener('click', function() {
    const form = document.getElementById('formTambahLomba');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('tambahLombaModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    // VALIDASI
    const namaLomba = document.getElementById('modal_nama_lomba').value.trim();
    if (!namaLomba) {
        alert('Nama Lomba wajib diisi!');
        document.getElementById('modal_nama_lomba').focus();
        return;
    }

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
            // Reset jenis ke default
            document.getElementById('modal_jenis').value = 'langsung';
            document.querySelectorAll('#jenisContainer .jenis-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.querySelector('#jenisContainer .jenis-card[data-value="langsung"]').classList.add('selected');
            document.getElementById('modal_finalisSection').style.display = 'none';
            
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

// ===== MODAL EDIT LOMBA =====
function openEditLombaModal(id) {
    const modalElement = document.getElementById('editLombaModal');
    const modal = new bootstrap.Modal(modalElement);
    
    fetch('/lomba/' + id + '/edit', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Gagal mengambil data lomba');
        }
        return response.json();
    })
    .then(data => {
        // Isi form
        document.getElementById('formEditLomba').action = '/lomba/' + id;
        document.getElementById('edit_lomba_id').value = id;
        document.getElementById('edit_nama_lomba').value = data.nama_lomba || '';
        document.getElementById('edit_deskripsi').value = data.deskripsi || '';
        document.getElementById('edit_kategori').value = data.kategori || '';
        document.getElementById('edit_status').value = data.status || 'draft';
        document.getElementById('edit_bobot').value = data.bobot || 0;
        document.getElementById('edit_jumlah_finalis').value = data.jumlah_finalis || 5;
        document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai || '';
        document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || '';
        
        // Set jenis
        const jenis = data.jenis || 'langsung';
        document.getElementById('edit_jenis').value = jenis;
        
        // Highlight card jenis yang sesuai
        document.querySelectorAll('#editJenisContainer .jenis-card').forEach(card => {
            card.classList.remove('selected');
            if (card.dataset.value === jenis) {
                card.classList.add('selected');
            }
        });
        
        // Tampilkan/sembunyikan finalis
        const finalisSection = document.getElementById('edit_finalisSection');
        if (jenis === 'penyisihan') {
            finalisSection.style.display = 'block';
        } else {
            finalisSection.style.display = 'none';
        }
        
        modal.show();
    })
    .catch(error => {
        alert('Gagal memuat data lomba: ' + error.message);
        console.error('Error:', error);
    });
}

// ===== UPDATE LOMBA =====
document.getElementById('btnUpdateLomba').addEventListener('click', function() {
    const form = document.getElementById('formEditLomba');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('editLombaModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    const namaLomba = document.getElementById('edit_nama_lomba').value.trim();
    if (!namaLomba) {
        alert('Nama Lomba wajib diisi!');
        document.getElementById('edit_nama_lomba').focus();
        return;
    }

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

// ===== MODAL SHOW LOMBA =====
function openShowLombaModal(id) {
    const modalElement = document.getElementById('showLombaModal');
    const modal = new bootstrap.Modal(modalElement);
    const content = document.getElementById('showLombaContent');
    
    // Reset content ke loading
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Memuat data...</p>
        </div>
    `;
    
    // Tampilkan modal dulu
    modal.show();
    
    // Fetch data
    fetch('/lomba/' + id, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Gagal mengambil data lomba');
        }
        return response.json();
    })
    .then(data => {
        const lomba = data.lomba;
        const juriList = data.juri_list || [];
        const isSuperAdmin = {{ Auth::user()->isSuperAdmin() ? 'true' : 'false' }};
        
        // Buat HTML untuk detail
        let html = `
            <div class="text-center mb-4">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1a365d, #2b6cb0); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                    <i class="fas fa-trophy"></i>
                </div>
                <h5 class="mt-2 fw-bold">${lomba.nama_lomba || '-'}</h5>
                ${lomba.kategori ? `<span class="badge bg-secondary">${lomba.kategori}</span>` : ''}
                ${lomba.jenis ? `<span class="badge bg-info ms-1">${lomba.jenis}</span>` : ''}
            </div>
        `;

        // Status
        if (lomba.status) {
            const statusClass = lomba.status === 'open' ? 'badge-status-open' : 
                               lomba.status === 'draft' ? 'badge-status-draft' :
                               lomba.status === 'selesai' ? 'badge-status-selesai' : 'badge-status-closed';
            const statusLabel = lomba.status_label || lomba.status;
            html += `
                <div class="mb-3 text-center">
                    <span class="badge-status ${statusClass}">
                        <span class="dot"></span> ${statusLabel}
                    </span>
                </div>
            `;
        }

        // Deskripsi
        if (lomba.deskripsi) {
            html += `
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Deskripsi</label>
                    <p class="fw-semibold">${lomba.deskripsi}</p>
                </div>
            `;
        }

        // Tanggal
        if (lomba.tanggal_mulai || lomba.tanggal_selesai) {
            html += `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block">Tanggal Mulai</label>
                        <p class="fw-semibold">${lomba.tanggal_mulai || '-'}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold d-block">Tanggal Selesai</label>
                        <p class="fw-semibold">${lomba.tanggal_selesai || '-'}</p>
                    </div>
                </div>
            `;
        }

        // Bobot
        if (lomba.bobot !== undefined && lomba.bobot !== null) {
            html += `
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Bobot / Poin</label>
                    <span class="fw-semibold">${lomba.bobot}</span>
                </div>
            `;
        }

        // Daftar Juri
        html += `
            <div class="mb-3">
                <label class="text-muted small fw-bold d-block">Daftar Juri</label>
                <div class="mt-2">
                    ${juriList.length > 0 ? juriList.map(name => `
                        <span class="badge bg-primary me-2 mb-1" style="font-size: 13px; padding: 6px 14px;">
                            <i class="fas fa-user-tie me-1"></i> ${name}
                        </span>
                    `).join('') : '<span class="text-muted">Belum ada juri</span>'}
                </div>
            </div>
        `;

        // Statistik
        html += `
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="text-center p-2 bg-light rounded">
                        <div class="fw-bold" style="font-size: 20px; color: #1a365d;">${data.juri_count || 0}</div>
                        <small class="text-muted">Jumlah Juri</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-2 bg-light rounded">
                        <div class="fw-bold" style="font-size: 20px; color: #1a365d;">${data.finalis_count || 0}</div>
                        <small class="text-muted">Jumlah Finalis</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-2 bg-light rounded">
                        <div class="fw-bold" style="font-size: 20px; color: #1a365d;">${data.kriteria_count || 0}</div>
                        <small class="text-muted">Jumlah Kriteria</small>
                    </div>
                </div>
            </div>
        `;

        content.innerHTML = html;
        
        // Update footer dengan tombol Edit jika Super Admin
        const footer = document.querySelector('#showLombaModal .modal-footer');
        if (footer) {
            if (isSuperAdmin) {
                footer.innerHTML = `
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" onclick="deleteLomba(${id})">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-warning text-white" onclick="closeModalAndEdit(${id})">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Tutup
                            </button>
                        </div>
                    </div>
                `;
            } else {
                footer.innerHTML = `
                    <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                `;
            }
        }
    })
    .catch(error => {
        content.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                <p class="text-danger">${error.message || 'Gagal memuat data lomba.'}</p>
                <button class="btn btn-secondary btn-sm mt-2" onclick="location.reload()">
                    <i class="fas fa-refresh me-1"></i> Refresh
                </button>
            </div>
        `;
        console.error('Error:', error);
    });
}

// ===== FUNGSI TAMBAHAN: Tutup Modal & Buka Edit =====
function closeModalAndEdit(id) {
    const modalElement = document.getElementById('showLombaModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) {
        modal.hide();
    }
    
    setTimeout(function() {
        openEditLombaModal(id);
    }, 300);
}

// ===== DELETE LOMBA =====
function deleteLomba(id) {
    if (!confirm('Yakin hapus lomba ini?')) {
        return;
    }

    fetch('/lomba/' + id, {
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
            // Tutup modal jika terbuka
            const modalElement = document.getElementById('showLombaModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
            setTimeout(() => location.reload(), 1500);
        } else {
            alert(data.message || 'Gagal menghapus lomba.');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        console.error('Error:', error);
    });
}

// ===== SHOW NOTIFICATION =====
function showNotification(type, message) {
    // Hapus alert sebelumnya
    document.querySelectorAll('.alert').forEach(el => el.remove());
    
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
document.getElementById('tambahLombaModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formTambahLomba').reset();
    document.getElementById('modal_jenis').value = 'langsung';
    document.querySelectorAll('#jenisContainer .jenis-card').forEach(card => {
        card.classList.remove('selected');
    });
    document.querySelector('#jenisContainer .jenis-card[data-value="langsung"]').classList.add('selected');
    document.getElementById('modal_finalisSection').style.display = 'none';
});

document.getElementById('editLombaModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('formEditLomba').reset();
});

// ===== EVENT LISTENER UNTUK TOMBOL SHOW =====
document.addEventListener('DOMContentLoaded', function() {
    // Default: sembunyikan section finalis di modal tambah
    document.getElementById('modal_finalisSection').style.display = 'none';
    
    // Default: set jenis card pertama
    const defaultCard = document.querySelector('#jenisContainer .jenis-card[data-value="langsung"]');
    if (defaultCard) {
        defaultCard.classList.add('selected');
    }
});
</script>
@endsection