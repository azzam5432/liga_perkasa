@extends('layouts.master')

@section('title', 'Data Juri')

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

    .juri-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #edf2f7;
        flex-shrink: 0;
    }

    .juri-avatar-initial {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        border: 2px solid #edf2f7;
        font-size: 13px;
        flex-shrink: 0;
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
        .juri-avatar {
            width: 28px;
            height: 28px;
        }
        .juri-avatar-initial {
            width: 28px;
            height: 28px;
            font-size: 11px;
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
        .juri-avatar {
            width: 24px;
            height: 24px;
        }
        .juri-avatar-initial {
            width: 24px;
            height: 24px;
            font-size: 10px;
        }
        .btn-action {
            width: 22px;
            height: 22px;
            font-size: 10px;
        }
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
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4>Data Juri</h4>
    <button class="btn-primary-custom" onclick="openTambahJuriModal()">
        <i class="fas fa-plus"></i> Tambah Juri
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
        <input type="text" id="searchInput" placeholder="Cari nama atau email..." onkeyup="filterTable()">
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table id="juriTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 160px;">Nama Juri</th>
                    <th style="min-width: 150px;">Email</th>
                    <th style="min-width: 180px;">Bidang Penjurian</th>
                    <th class="col-sticky-right" style="min-width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($juris as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left">
                            <div class="d-flex align-items-center gap-2">
                                @if($item->user->foto_profil && file_exists(public_path('uploads/profil/' . $item->user->foto_profil)))
                                    <img src="{{ asset('uploads/profil/' . $item->user->foto_profil) }}" 
                                         alt="{{ $item->user->name }}" 
                                         class="juri-avatar">
                                @else
                                    <div class="juri-avatar-initial" 
                                         style="background: {{ $item->user->avatar_color ?? '#667eea' }};">
                                        {{ $item->user->initials ?? strtoupper(substr($item->user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="fw-semibold" style="font-size: 13px;">{{ $item->user->name }}</span>
                            </div>
                        </td>
                        <td style="font-size: 13px;">{{ $item->user->email }}</td>
                        <td style="font-size: 13px;">{{ $item->spesialisasi ?? '-' }}</td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="openShowJuriModal(
                                    {{ $item->id_juri }},
                                    '{{ addslashes($item->user->name) }}',
                                    '{{ addslashes($item->user->email) }}',
                                    '{{ addslashes($item->spesialisasi) }}',
                                    {{ $item->penilaians->count() }},
                                    '{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->updated_at ? $item->updated_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->user->foto_profil ? asset('uploads/profil/' . $item->user->foto_profil) : '' }}'
                                )">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="btn-action btn-warning" title="Edit" onclick="openEditJuriModal({{ $item->id_juri }},'{{ addslashes($item->user->name) }}','{{ addslashes($item->user->email) }}','{{ addslashes($item->spesialisasi) }}')">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('juri.destroy', $item->id_juri) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger" title="Hapus"
                                            onclick="return confirm('Yakin hapus juri ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-user-tie"></i>
                                <h6>Belum ada data juri</h6>
                                <p>Silakan tambahkan juri baru melalui tombol di atas.</p>
                                <a href="{{ route('juri.create') }}" class="btn-primary-custom" style="display: inline-flex; border: none;">
                                    <i class="fas fa-plus me-1"></i> Tambah Juri
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($juris->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $juris->firstItem() }}</strong> sampai <strong>{{ $juris->lastItem() }}</strong> dari <strong>{{ $juris->total() }}</strong> juri
            </span>
            {{ $juris->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- ===== MODAL TAMBAH JURI ===== -->
<div class="modal fade modal-custom" id="tambahJuriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2" style="color: #1a365d;"></i> Tambah Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahJuri" action="{{ route('juri.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="modal_user_id" class="form-label">Pilih Panitia <span class="text-danger">*</span></label>
                        <select class="form-control" id="modal_user_id" name="user_id" required>
                            <option value="">-- Pilih Panitia --</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_spesialisasi" class="form-label">Bidang Penjurian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_spesialisasi" name="spesialisasi" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanJuri">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT JURI ===== -->
<div class="modal fade modal-custom" id="editJuriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2" style="color: #d69e2e;"></i> Edit Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditJuri" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Juri</label>
                        <p class="fw-semibold" id="edit_juri_name">-</p>
                        <small class="text-muted" id="edit_juri_email">-</small>
                    </div>

                    <div class="mb-3">
                        <label for="edit_spesialisasi" class="form-label">Bidang Penjurian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_spesialisasi" name="spesialisasi" required>
                    </div>

                    <input type="hidden" id="edit_juri_id" name="juri_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdateJuri" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL SHOW JURI ===== -->
<div class="modal fade modal-custom" id="showJuriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle me-2" style="color: #2b6cb0;"></i> Detail Juri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div id="showJuriAvatar" class="d-inline-block">
                        <div class="avatar-show" style="width: 80px; height: 80px; border-radius: 50%; background: #667eea; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                            -
                        </div>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showJuriName">-</h5>
                    <p class="text-muted" id="showJuriEmail">-</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Bidang Penjurian</label>
                            <p class="fw-semibold" id="showJuriSpesialisasi">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Total Penilaian</label>
                            <p class="fw-semibold" id="showJuriTotalPenilaian">0</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Dibuat</label>
                            <p class="fw-semibold" id="showJuriCreatedAt">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Diupdate</label>
                            <p class="fw-semibold" id="showJuriUpdatedAt">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button type="button" class="btn-primary-custom" id="btnEditFromShowJuri" style="background: #d69e2e;">
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

    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(function() {
        currentPage = 1;
        fetchData(search, currentPage);
    }, 300);
}

// ===== FETCH DATA VIA AJAX =====
function fetchData(search, page) {
    const tableBody = document.querySelector('#juriTable tbody');
    const paginationWrapper = document.querySelector('.pagination-wrapper');

    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">
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
        
        const newTableBody = doc.querySelector('#juriTable tbody');
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
                    Menampilkan <strong>1</strong> sampai <strong>${totalRows}</strong> dari <strong>${totalRows}</strong> juri
                </span>
            `;
        }

        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('search', search);
        newUrl.searchParams.set('page', page);
        window.history.pushState({}, '', newUrl);

        attachPaginationListeners();
    })
    .catch(error => {
        console.error('Error:', error);
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4">
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
                const page = url.searchParams.get('page') || 1;
                currentPage = parseInt(page);
                fetchData(search, currentPage);
            }
        });
    });
}

// ===== MODAL TAMBAH JURI =====
document.getElementById('btnSimpanJuri').addEventListener('click', function() {
    const form = document.getElementById('formTambahJuri');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('tambahJuriModal');
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

function openTambahJuriModal() {
    const modal = new bootstrap.Modal(document.getElementById('tambahJuriModal'));
    modal.show();
}

// ===== MODAL EDIT JURI =====
function openEditJuriModal(id, name, email, spesialisasi) {
    const modalElement = document.getElementById('editJuriModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('formEditJuri').action = '/juri/' + id;
    document.getElementById('edit_juri_id').value = id;
    
    // Isi data
    document.getElementById('edit_juri_name').textContent = name || '-';
    document.getElementById('edit_juri_email').textContent = email || '-';
    document.getElementById('edit_spesialisasi').value = spesialisasi || '';
    
    modal.show();
}

document.getElementById('btnUpdateJuri').addEventListener('click', function() {
    const form = document.getElementById('formEditJuri');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('editJuriModal');
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

// ===== MODAL SHOW JURI =====
function openShowJuriModal(id, name, email, spesialisasi, totalPenilaian, created_at, updated_at, foto) {
    const modalElement = document.getElementById('showJuriModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('showJuriName').textContent = name || '-';
    document.getElementById('showJuriEmail').textContent = email || '-';
    document.getElementById('showJuriSpesialisasi').textContent = spesialisasi || '-';
    document.getElementById('showJuriTotalPenilaian').textContent = totalPenilaian || 0;
    document.getElementById('showJuriCreatedAt').textContent = created_at || '-';
    document.getElementById('showJuriUpdatedAt').textContent = updated_at || '-';
    
    // Avatar
    const avatarContainer = document.getElementById('showJuriAvatar');
    if (foto && foto !== 'null' && foto !== '') {
        avatarContainer.innerHTML = '<img src="' + foto + '" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e2e8f0;">';
    } else {
        const initials = name ? name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2) : '??';
        const colors = ['#667eea', '#48bb78', '#ed8936', '#9f7aea', '#fc8181', '#4299e1', '#ed64a6', '#38a169'];
        const colorIndex = name ? name.length % colors.length : 0;
        avatarContainer.innerHTML = '<div style="width: 80px; height: 80px; border-radius: 50%; background: ' + colors[colorIndex] + '; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">' + initials + '</div>';
    }
    
    // Tombol Edit
    document.getElementById('btnEditFromShowJuri').onclick = function() {
        modal.hide();
        setTimeout(function() {
            openEditJuriModal(id, name, email, spesialisasi);
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

document.addEventListener('DOMContentLoaded', function() {
    attachPaginationListeners();

    // Restore search from URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    if (searchParam) {
        document.getElementById('searchInput').value = searchParam;
        const page = urlParams.get('page') || 1;
        currentPage = parseInt(page);
        fetchData(searchParam, currentPage);
    }

    // Tombol Tambah Juri buka modal
    document.querySelector('.btn-primary-custom[href="{{ route('juri.create') }}"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('tambahJuriModal'));
        modal.show();
    });
});
</script>
@endsection