@extends('layouts.master')

@section('title', 'Penugasan Juri')

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
        min-width: 600px;
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

    .badge-status .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-status-aktif {
        background: #f0fff4;
        color: #22543d;
    }

    .badge-status-aktif .dot {
        background: #48bb78;
    }

    .badge-status-nonaktif {
        background: #fff5f5;
        color: #9b2c2c;
    }

    .badge-status-nonaktif .dot {
        background: #fc8181;
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
            min-width: 500px;
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
            min-width: 430px;
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
    }
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4>Penugasan Juri</h4>
    <button class="btn-primary-custom" onclick="openTambahPenugasanModal()">
        <i class="fas fa-plus"></i> Tambah Penugasan
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
        <input type="text" id="searchInput" placeholder="Cari juri atau lomba..." onkeyup="filterTable()">
    </div>
    <div class="filter-select">
        <select id="filterStatus" onchange="filterTable()">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Non-Aktif</option>
        </select>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table id="penugasanTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 160px;">Juri</th>
                    <th style="min-width: 150px;">Lomba</th>
                    <th style="min-width: 100px;">Status</th>
                    <th style="min-width: 120px;">Dibuat</th>
                    <th class="col-sticky-right" style="min-width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penugasans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left">
                            <span class="fw-semibold" style="font-size: 13px;">{{ $item->juri->user->name ?? '-' }}</span>
                            <br>
                            <small class="text-muted">{{ $item->juri->spesialisasi ?? '-' }}</small>
                        </td>
                        <td style="font-size: 13px;">{{ $item->lomba->nama_lomba ?? '-' }}</td>
                        <td>
                            <span class="badge-status {{ $item->status == 'aktif' ? 'badge-status-aktif' : 'badge-status-nonaktif' }}">
                                <span class="dot"></span>
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td style="font-size: 13px;">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="openShowPenugasanModal(
                                    {{ $item->id_juri_lomba }},
                                    '{{ addslashes($item->juri->user->name ?? '-') }}',
                                    '{{ addslashes($item->juri->spesialisasi ?? '-') }}',
                                    '{{ addslashes($item->lomba->nama_lomba ?? '-') }}',
                                    '{{ $item->status }}',
                                    '{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->updated_at ? $item->updated_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->juri->user->foto_profil ? asset('uploads/profil/' . $item->juri->user->foto_profil) : '' }}',
                                    '{{ addslashes($item->juri->user->name ?? '-') }}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-warning" title="Edit" onclick="openEditPenugasanModal(
                                    {{ $item->id_juri_lomba }},
                                    {{ $item->id_juri }},
                                    {{ $item->id_lomba }},
                                    '{{ $item->status }}'
                                )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-danger" title="Hapus" onclick="deletePenugasan({{ $item->id_juri_lomba }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-user-tag"></i>
                                <h6>Belum ada penugasan juri</h6>
                                <p>Silakan tambahkan penugasan baru melalui tombol di atas.</p>
                                <button class="btn-primary-custom" onclick="openTambahPenugasanModal()" style="display: inline-flex; border: none;">
                                    <i class="fas fa-plus me-1"></i> Tambah Penugasan
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($penugasans->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $penugasans->firstItem() }}</strong> sampai <strong>{{ $penugasans->lastItem() }}</strong> dari <strong>{{ $penugasans->total() }}</strong> penugasan
            </span>
            {{ $penugasans->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- ===== MODAL TAMBAH PENUGASAN ===== -->
<div class="modal fade modal-custom" id="tambahPenugasanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2" style="color: #1a365d;"></i> Tambah Penugasan Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPenugasan" action="{{ route('juri_lomba.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="modal_id_juri" class="form-label">Pilih Juri <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_id_juri" name="id_juri" required>
                            <option value="">-- Pilih Juri --</option>
                            @foreach($juri ?? [] as $j)
                                <option value="{{ $j->id_juri }}">{{ $j->user->name }} - {{ $j->spesialisasi ?? 'Tanpa Spesialisasi' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_id_lomba" class="form-label">Pilih Lomba <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_id_lomba" name="id_lomba" required>
                            <option value="">-- Pilih Lomba --</option>
                            @foreach($lomba ?? [] as $l)
                                <option value="{{ $l->id_lomba }}">{{ $l->nama_lomba }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_status" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanPenugasan">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT PENUGASAN ===== -->
<div class="modal fade modal-custom" id="editPenugasanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2" style="color: #d69e2e;"></i> Edit Penugasan Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPenugasan" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Juri</label>
                        <p class="fw-semibold" id="edit_juri_name">-</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lomba</label>
                        <p class="fw-semibold" id="edit_lomba_name">-</p>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>

                    <input type="hidden" id="edit_penugasan_id" name="penugasan_id" value="">
                    <input type="hidden" id="edit_id_juri" name="id_juri" value="">
                    <input type="hidden" id="edit_id_lomba" name="id_lomba" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdatePenugasan" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL SHOW PENUGASAN ===== -->
<div class="modal fade modal-custom" id="showPenugasanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Detail Penugasan Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div id="showPenugasanAvatar" class="d-inline-block">
                        <div class="avatar-show" style="width: 80px; height: 80px; border-radius: 50%; background: #667eea; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                            -
                        </div>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showJuriName">-</h5>
                    <p class="text-muted" id="showJuriSpesialisasi">-</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Lomba</label>
                            <p class="fw-semibold" id="showLombaName">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Status</label>
                            <p id="showPenugasanStatus">-</p>
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
                <button type="button" class="btn-primary-custom" id="btnEditFromShowPenugasan" style="background: #d69e2e;">
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
    const tableBody = document.querySelector('#penugasanTable tbody');
    const paginationWrapper = document.querySelector('.pagination-wrapper');

    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
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
        
        const newTableBody = doc.querySelector('#penugasanTable tbody');
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
                    Menampilkan <strong>1</strong> sampai <strong>${totalRows}</strong> dari <strong>${totalRows}</strong> penugasan
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
                    <td colspan="6" class="text-center py-4">
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

// ===== DELETE PENUGASAN =====
function deletePenugasan(id) {
    if (!confirm('Yakin hapus penugasan ini?')) {
        return;
    }

    fetch('/juri_lomba/' + id, {
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
            alert(data.message || 'Gagal menghapus penugasan.');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        console.error('Error:', error);
    });
}

// ===== MODAL TAMBAH PENUGASAN =====
function openTambahPenugasanModal() {
    const modal = new bootstrap.Modal(document.getElementById('tambahPenugasanModal'));
    modal.show();
}

document.getElementById('btnSimpanPenugasan').addEventListener('click', function() {
    const form = document.getElementById('formTambahPenugasan');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('tambahPenugasanModal');
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

// ===== MODAL EDIT PENUGASAN =====
function openEditPenugasanModal(id, idJuri, idLomba, status) {
    const modalElement = document.getElementById('editPenugasanModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('formEditPenugasan').action = '/juri_lomba/' + id;
    document.getElementById('edit_penugasan_id').value = id;
    document.getElementById('edit_id_juri').value = idJuri;
    document.getElementById('edit_id_lomba').value = idLomba;
    
    document.getElementById('edit_status').value = status || 'aktif';
    
    modal.show();
}

document.getElementById('btnUpdatePenugasan').addEventListener('click', function() {
    const form = document.getElementById('formEditPenugasan');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('editPenugasanModal');
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

// ===== MODAL SHOW PENUGASAN =====
function openShowPenugasanModal(id, juriName, spesialisasi, lombaName, status, created_at, updated_at, foto, fullName) {
    const modalElement = document.getElementById('showPenugasanModal');
    const modal = new bootstrap.Modal(modalElement);
    
    // Set data
    document.getElementById('showJuriName').textContent = juriName || '-';
    document.getElementById('showJuriSpesialisasi').textContent = spesialisasi || '-';
    document.getElementById('showLombaName').textContent = lombaName || '-';
    document.getElementById('showCreatedAt').textContent = created_at || '-';
    document.getElementById('showUpdatedAt').textContent = updated_at || '-';
    
    // Status
    const statusBadge = document.getElementById('showPenugasanStatus');
    if (status === 'aktif') {
        statusBadge.innerHTML = '<span class="badge-status badge-status-aktif"><span class="dot"></span> Aktif</span>';
    } else {
        statusBadge.innerHTML = '<span class="badge-status badge-status-nonaktif"><span class="dot"></span> Non-Aktif</span>';
    }
    
    // Avatar dengan foto profil
    const avatarContainer = document.getElementById('showPenugasanAvatar');
    const name = fullName || juriName || '-';
    
    if (foto && foto !== 'null' && foto !== '') {
        avatarContainer.innerHTML = '<img src="' + foto + '" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e2e8f0;">';
    } else {
        const initials = name ? name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2) : '??';
        const colors = ['#667eea', '#48bb78', '#ed8936', '#9f7aea', '#fc8181', '#4299e1', '#ed64a6', '#38a169'];
        const colorIndex = name ? name.length % colors.length : 0;
        avatarContainer.innerHTML = '<div style="width: 80px; height: 80px; border-radius: 50%; background: ' + colors[colorIndex] + '; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">' + initials + '</div>';
    }
    
    // Tombol Edit
    document.getElementById('btnEditFromShowPenugasan').onclick = function() {
        modal.hide();
        setTimeout(function() {
            // Cari data juri dan lomba dari tabel
            const rows = document.querySelectorAll('#penugasanTable tbody tr');
            let idJuri = '';
            let idLomba = '';
            rows.forEach(row => {
                const btn = row.querySelector('.btn-action.btn-info');
                if (btn && btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(id)) {
                    // Ambil id juri dan lomba dari hidden atau data
                    const cells = row.querySelectorAll('td');
                    // Bisa ditambahkan data attribute di row
                }
            });
            openEditPenugasanModal(id, idJuri, idLomba, status);
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