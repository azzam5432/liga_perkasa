@extends('layouts.master')

@section('title', 'Data Tim')

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
    min-width: 110px;
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

.badge-count {
    background: #ebf8ff;
    color: #2b6cb0;
    padding: 2px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 12px;
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

.member-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: #f7fafc;
    border-radius: 8px;
    border: 1px solid #edf2f7;
    margin-bottom: 8px;
}

.member-item .member-number {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #1a365d;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .page-header .btn-primary-custom {
        margin-left: 0;
        font-size: 12px;
        padding: 6px 14px;
    }
    .page-header h4 {
        font-size: 16px;
        margin: 0;
    }

    .filter-bar {
        flex-direction: row;
        align-items: center;
        padding: 10px 12px;
        gap: 8px;
    }
    .filter-bar .search-box {
        flex: 1;
        min-width: 0;
    }

    .table-scroll table thead th:nth-child(1),
    .table-scroll table thead th:nth-child(2),
    .table-scroll table thead th:last-child {
        display: table-cell;
    }

    .table-scroll table thead th:nth-child(3),
    .table-scroll table thead th:nth-child(4),
    .table-scroll table thead th:nth-child(5) {
        display: none;
    }

    .table-scroll table tbody td:nth-child(1),
    .table-scroll table tbody td:nth-child(2),
    .table-scroll table tbody td:last-child {
        display: table-cell;
    }

    .table-scroll table tbody td:nth-child(3),
    .table-scroll table tbody td:nth-child(4),
    .table-scroll table tbody td:nth-child(5) {
        display: none;
    }

    .table-scroll table {
        display: table;
        width: 100%;
    }
    .table-scroll table tbody {
        display: table-row-group;
    }
    .table-scroll table tbody tr {
        display: table-row;
    }
    .table-scroll table tbody tr td:last-child {
        text-align: center;
    }

    .table-scroll table thead {
        display: table-header-group;
    }
    .table-scroll table thead tr {
        display: table-row;
    }
    .table-scroll table thead th:last-child {
        text-align: center;
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
        flex-direction: row;
        gap: 8px;
        justify-content: flex-end;
    }
    .modal-custom .modal-footer .btn {
        width: auto;
    }
}

@media (max-width: 480px) {
    .page-header h4 {
        font-size: 14px;
    }
    .page-header .btn-primary-custom {
        font-size: 11px;
        padding: 5px 12px;
    }
}
</style>

<div class="page-header">
    <h4>Data Tim</h4>
    <button class="btn-primary-custom" onclick="openTambahTimModal()">
        <i class="fas fa-plus"></i> Tambah Tim
    </button>
</div>

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

<div class="filter-bar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari nama tim..." onkeyup="filterTable()">
    </div>
</div>

<div class="table-wrapper">
    <div class="table-scroll">
        <table id="timTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 170px;">Nama Tim</th>
                    <th style="min-width: 150px;">Ketua</th>
                    <th style="min-width: 200px;">Dosen Pembimbing</th>
                    <th style="min-width: 200px;">Kakak Mentor</th>
                    <th class="col-sticky-right" style="min-width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tim as $item)
                @php
                    $pesertas = $item->pesertas;
                    $ketua = $pesertas->whereNotNull('ketua_peserta')->first();
                    $dosenList = $item->dosenPembimbing;
                    $kakakList = $item->kakakPembimbing;
                    $anggotaList = $pesertas->whereNull('ketua_peserta')->pluck('nama_peserta')->toArray();
                    $dosenArray = $dosenList->pluck('nama_dosen')->toArray();
                    $kakakArray = $kakakList->pluck('nama_kakak')->toArray();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="col-sticky-left">
                        <span class="fw-semibold" style="font-size: 13px;">{{ $item->nama_tim }}</span>
                    </td>
                    <td style="font-size: 13px;">{{ $ketua->ketua_peserta ?? '-' }}</td>
                    <td style="font-size: 13px;">
                        @if(count($dosenArray) > 0)
                            {{ implode(', ', $dosenArray) }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td style="font-size: 13px;">
                        @if(count($kakakArray) > 0)
                            {{ implode(', ', $kakakArray) }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="col-sticky-right text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn-action btn-info" title="Detail" onclick="openShowTimModal(
                                '{{ addslashes($item->nama_tim) }}',
                                '{{ addslashes($ketua->ketua_peserta ?? '-') }}',
                                {{ json_encode($anggotaList) }},
                                {{ json_encode($dosenArray) }},
                                {{ json_encode($kakakArray) }}
                            )">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action btn-warning" title="Edit" onclick="openEditTimModal(
                                '{{ $item->id_tim }}',
                                '{{ addslashes($item->nama_tim) }}',
                                '{{ addslashes($ketua->ketua_peserta ?? '-') }}',
                                {{ json_encode($anggotaList) }},
                                {{ json_encode($dosenArray) }},
                                {{ json_encode($kakakArray) }}
                            )">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('panitia.destroy', $item->id_tim) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="Hapus"
                                        onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h6>Belum ada data tim</h6>
                            <p>Silakan tambahkan tim baru melalui tombol di atas.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($tim->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $tim->firstItem() }}</strong> sampai <strong>{{ $tim->lastItem() }}</strong> dari <strong>{{ $tim->total() }}</strong> tim
            </span>
            {{ $tim->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<div class="modal fade modal-custom" id="tambahTimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2" style="color: #1a365d;"></i> Tambah Tim
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahTim" action="{{ route('panitia.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="modal_nama_tim" class="form-label">Nama Tim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_nama_tim" name="nama_tim" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_ketua" class="form-label">Ketua Tim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_ketua" name="ketua_peserta" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dosen Pembimbing <span class="text-muted">(Bisa lebih dari 1)</span></label>
                        <div id="modal_dosen_list">
                            <div class="member-item">
                                <span class="member-number">1</span>
                                <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing 1" required>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosen(this)" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahDosen()">
                            <i class="fas fa-plus me-1"></i> Tambah Dosen
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kakak Mentor <span class="text-muted">(Bisa lebih dari 1)</span></label>
                        <div id="modal_kakak_list">
                            <div class="member-item">
                                <span class="member-number">1</span>
                                <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Mentor 1" required>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakak(this)" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahKakak()">
                            <i class="fas fa-plus me-1"></i> Tambah Kakak
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Anggota Tim (Minimal 4)</label>
                        <div id="modal_member_list">
                            <div class="member-item">
                                <span class="member-number">1</span>
                                <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 1" required>
                            </div>
                            <div class="member-item">
                                <span class="member-number">2</span>
                                <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 2" required>
                            </div>
                            <div class="member-item">
                                <span class="member-number">3</span>
                                <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 3" required>
                            </div>
                            <div class="member-item">
                                <span class="member-number">4</span>
                                <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 4" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahAnggota()">
                            <i class="fas fa-plus me-1"></i> Tambah Anggota
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanTim">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-custom" id="editTimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="color: #d69e2e;"></i> Edit Tim
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditTim" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="edit_nama_tim" class="form-label">Nama Tim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_tim" name="nama_tim" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_ketua" class="form-label">Ketua Tim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_ketua" name="ketua_peserta" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dosen Pembimbing <span class="text-muted">(Bisa lebih dari 1)</span></label>
                        <div id="edit_dosen_list"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahDosenEdit()">
                            <i class="fas fa-plus me-1"></i> Tambah Dosen
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kakak Mentor <span class="text-muted">(Bisa lebih dari 1)</span></label>
                        <div id="edit_kakak_list"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahKakakEdit()">
                            <i class="fas fa-plus me-1"></i> Tambah Kakak
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Anggota Tim (Minimal 4)</label>
                        <div id="edit_member_list"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahAnggotaEdit()">
                            <i class="fas fa-plus me-1"></i> Tambah Anggota
                        </button>
                    </div>

                    <input type="hidden" id="edit_tim_id" name="tim_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdateTim" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-custom" id="showTimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Detail Tim
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1a365d, #2b6cb0); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showNamaTim">-</h5>
                    <span class="badge badge-primary" id="showJumlahAnggota">0 Anggota</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Ketua Tim</label>
                            <p class="fw-semibold" id="showKetua">-</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Dosen Pembimbing</label>
                            <div id="showDosenPembimbing" class="d-flex flex-wrap gap-1">
                                <span class="text-muted">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Kakak Mentor</label>
                            <div id="showKakakPembimbing" class="d-flex flex-wrap gap-1">
                                <span class="text-muted">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Daftar Anggota</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size: 13px; margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Anggota</th>
                                </tr>
                            </thead>
                            <tbody id="showAnggotaTable">
                                <tr>
                                    <td colspan="2" class="text-center text-muted">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button type="button" class="btn-primary-custom" id="btnEditFromShowTim" style="background: #d69e2e;">
                    <i class="fas fa-edit me-1"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#timTable tbody tr');

    rows.forEach(row => {
        if (row.querySelector('.empty-state')) return;

        const nama = row.querySelector('td:nth-child(2) .fw-semibold')?.textContent.toLowerCase() || '';

        let show = true;
        if (searchInput && !nama.includes(searchInput)) {
            show = false;
        }
        row.style.display = show ? '' : 'none';
    });
}

function tambahAnggota() {
    const list = document.getElementById('modal_member_list');
    const items = list.querySelectorAll('.member-item');
    const newNumber = items.length + 1;

    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusAnggota(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusAnggota(button) {
    const item = button.closest('.member-item');
    item.remove();
    const list = document.getElementById('modal_member_list');
    const items = list.querySelectorAll('.member-item');
    items.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Anggota ' + (index + 1);
    });
}

function resetAnggotaList() {
    const list = document.getElementById('modal_member_list');
    list.innerHTML = `
        <div class="member-item"><span class="member-number">1</span><input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 1" required></div>
        <div class="member-item"><span class="member-number">2</span><input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 2" required></div>
        <div class="member-item"><span class="member-number">3</span><input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 3" required></div>
        <div class="member-item"><span class="member-number">4</span><input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota 4" required></div>
    `;
}

function tambahAnggotaEdit() {
    const list = document.getElementById('edit_member_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length >= 19) {
        alert('Maksimal 19 anggota!');
        return;
    }
    
    const newNumber = items.length + 1;
    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusAnggotaEdit(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusAnggotaEdit(button) {
    const item = button.closest('.member-item');
    const list = document.getElementById('edit_member_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length <= 4) {
        alert('Minimal 4 anggota!');
        return;
    }
    
    item.remove();
    const remainingItems = list.querySelectorAll('.member-item');
    remainingItems.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Anggota ' + (index + 1);
    });
}

function tambahDosen() {
    const list = document.getElementById('modal_dosen_list');
    const items = list.querySelectorAll('.member-item');
    const newNumber = items.length + 1;

    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosen(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusDosen(button) {
    const item = button.closest('.member-item');
    const list = document.getElementById('modal_dosen_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length <= 1) {
        alert('Minimal 1 dosen pembimbing!');
        return;
    }
    
    item.remove();
    const remainingItems = list.querySelectorAll('.member-item');
    remainingItems.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Dosen Pembimbing ' + (index + 1);
    });
}

function resetDosenList() {
    const list = document.getElementById('modal_dosen_list');
    list.innerHTML = `
        <div class="member-item">
            <span class="member-number">1</span>
            <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing 1" required>
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosen(this)" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
}

function tambahKakak() {
    const list = document.getElementById('modal_kakak_list');
    const items = list.querySelectorAll('.member-item');
    const newNumber = items.length + 1;

    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Mentor ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakak(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusKakak(button) {
    const item = button.closest('.member-item');
    const list = document.getElementById('modal_kakak_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length <= 1) {
        alert('Minimal 1 kakak Mentor!');
        return;
    }
    
    item.remove();
    const remainingItems = list.querySelectorAll('.member-item');
    remainingItems.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Kakak Mentor ' + (index + 1);
    });
}

function resetKakakList() {
    const list = document.getElementById('modal_kakak_list');
    list.innerHTML = `
        <div class="member-item">
            <span class="member-number">1</span>
            <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Mentor 1" required>
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakak(this)" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
}

function tambahDosenEdit() {
    const list = document.getElementById('edit_dosen_list');
    const items = list.querySelectorAll('.member-item');
    const newNumber = items.length + 1;

    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosenEdit(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusDosenEdit(button) {
    const item = button.closest('.member-item');
    const list = document.getElementById('edit_dosen_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length <= 1) {
        alert('Minimal 1 dosen pembimbing!');
        return;
    }
    
    item.remove();
    const remainingItems = list.querySelectorAll('.member-item');
    remainingItems.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Dosen Pembimbing ' + (index + 1);
    });
}

function tambahKakakEdit() {
    const list = document.getElementById('edit_kakak_list');
    const items = list.querySelectorAll('.member-item');
    const newNumber = items.length + 1;

    const div = document.createElement('div');
    div.className = 'member-item';
    div.innerHTML = `
        <span class="member-number">${newNumber}</span>
        <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Mentor ${newNumber}" required>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakakEdit(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
}

function hapusKakakEdit(button) {
    const item = button.closest('.member-item');
    const list = document.getElementById('edit_kakak_list');
    const items = list.querySelectorAll('.member-item');
    
    if (items.length <= 1) {
        alert('Minimal 1 kakak Mentor!');
        return;
    }
    
    item.remove();
    const remainingItems = list.querySelectorAll('.member-item');
    remainingItems.forEach((el, index) => {
        const number = el.querySelector('.member-number');
        if (number) number.textContent = index + 1;
        const input = el.querySelector('input');
        if (input) input.placeholder = 'Nama Kakak Mentor ' + (index + 1);
    });
}

function openTambahTimModal() {
    const modal = new bootstrap.Modal(document.getElementById('tambahTimModal'));
    modal.show();
}

document.getElementById('btnSimpanTim').addEventListener('click', function() {
    const form = document.getElementById('formTambahTim');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('tambahTimModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    const anggotaInputs = document.querySelectorAll('#modal_member_list input[name="anggota[]"]');
    let valid = true;
    anggotaInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (anggotaInputs.length < 4) {
        alert('Minimal 4 anggota!');
        return;
    }

    if (!valid) {
        alert('Semua nama anggota harus diisi!');
        return;
    }

    const dosenInputs = document.querySelectorAll('#modal_dosen_list input[name="dosen_pembimbing[]"]');
    let validDosen = true;
    dosenInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            validDosen = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!validDosen) {
        alert('Nama dosen pembimbing harus diisi!');
        return;
    }

    const kakakInputs = document.querySelectorAll('#modal_kakak_list input[name="kakak_pembimbing[]"]');
    let validKakak = true;
    kakakInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            validKakak = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!validKakak) {
        alert('Nama kakak pembimbing harus diisi!');
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
            resetAnggotaList();
            resetDosenList();
            resetKakakList();
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

function openEditTimModal(id, nama, ketua, anggota, dosen, kakak) {
    const modalElement = document.getElementById('editTimModal');
    const modal = new bootstrap.Modal(modalElement);

    document.getElementById('formEditTim').action = '/panitia/' + id;
    document.getElementById('edit_tim_id').value = id;
    document.getElementById('edit_nama_tim').value = nama || '';
    document.getElementById('edit_ketua').value = ketua || '';

    const list = document.getElementById('edit_member_list');
    list.innerHTML = '';
    
    if (anggota && Array.isArray(anggota) && anggota.length > 0) {
        const filtered = anggota.filter(a => a && a.trim() !== '');
        if (filtered.length > 0) {
            filtered.forEach((name, index) => {
                const div = document.createElement('div');
                div.className = 'member-item';
                div.innerHTML = `
                    <span class="member-number">${index + 1}</span>
                    <input type="text" class="form-control" name="anggota[]" value="${name}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusAnggotaEdit(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                list.appendChild(div);
            });
        } else {
            for (let i = 1; i <= 4; i++) {
                const div = document.createElement('div');
                div.className = 'member-item';
                div.innerHTML = `
                    <span class="member-number">${i}</span>
                    <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota ${i}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusAnggotaEdit(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                list.appendChild(div);
            }
        }
    } else {
        for (let i = 1; i <= 4; i++) {
            const div = document.createElement('div');
            div.className = 'member-item';
            div.innerHTML = `
                <span class="member-number">${i}</span>
                <input type="text" class="form-control" name="anggota[]" placeholder="Nama Anggota ${i}" required>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusAnggotaEdit(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            list.appendChild(div);
        }
    }

    const dosenList = document.getElementById('edit_dosen_list');
    dosenList.innerHTML = '';
    
    if (dosen && Array.isArray(dosen) && dosen.length > 0) {
        const filteredDosen = dosen.filter(d => d && d.trim() !== '');
        if (filteredDosen.length > 0) {
            filteredDosen.forEach((name, index) => {
                const div = document.createElement('div');
                div.className = 'member-item';
                div.innerHTML = `
                    <span class="member-number">${index + 1}</span>
                    <input type="text" class="form-control" name="dosen_pembimbing[]" value="${name}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosenEdit(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                dosenList.appendChild(div);
            });
        } else {
            const div = document.createElement('div');
            div.className = 'member-item';
            div.innerHTML = `
                <span class="member-number">1</span>
                <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing 1" required>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosenEdit(this)" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            dosenList.appendChild(div);
        }
    } else {
        const div = document.createElement('div');
        div.className = 'member-item';
        div.innerHTML = `
            <span class="member-number">1</span>
            <input type="text" class="form-control" name="dosen_pembimbing[]" placeholder="Nama Dosen Pembimbing 1" required>
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusDosenEdit(this)" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        `;
        dosenList.appendChild(div);
    }

    const kakakList = document.getElementById('edit_kakak_list');
    kakakList.innerHTML = '';
    
    if (kakak && Array.isArray(kakak) && kakak.length > 0) {
        const filteredKakak = kakak.filter(k => k && k.trim() !== '');
        if (filteredKakak.length > 0) {
            filteredKakak.forEach((name, index) => {
                const div = document.createElement('div');
                div.className = 'member-item';
                div.innerHTML = `
                    <span class="member-number">${index + 1}</span>
                    <input type="text" class="form-control" name="kakak_pembimbing[]" value="${name}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakakEdit(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                kakakList.appendChild(div);
            });
        } else {
            const div = document.createElement('div');
            div.className = 'member-item';
            div.innerHTML = `
                <span class="member-number">1</span>
                <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Pembimbing 1" required>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakakEdit(this)" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            kakakList.appendChild(div);
        }
    } else {
        const div = document.createElement('div');
        div.className = 'member-item';
        div.innerHTML = `
            <span class="member-number">1</span>
            <input type="text" class="form-control" name="kakak_pembimbing[]" placeholder="Nama Kakak Pembimbing 1" required>
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusKakakEdit(this)" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        `;
        kakakList.appendChild(div);
    }

    modal.show();
}

document.getElementById('btnUpdateTim').addEventListener('click', function() {
    const form = document.getElementById('formEditTim');
    const formData = new FormData(form);
    const btn = this;
    const modalElement = document.getElementById('editTimModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    const anggotaInputs = document.querySelectorAll('#edit_member_list input[name="anggota[]"]');
    let valid = true;
    anggotaInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (anggotaInputs.length < 4) {
        alert('Minimal 4 anggota!');
        return;
    }

    if (!valid) {
        alert('Semua nama anggota harus diisi!');
        return;
    }

    const dosenInputs = document.querySelectorAll('#edit_dosen_list input[name="dosen_pembimbing[]"]');
    let validDosen = true;
    dosenInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            validDosen = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!validDosen) {
        alert('Nama dosen pembimbing harus diisi!');
        return;
    }

    const kakakInputs = document.querySelectorAll('#edit_kakak_list input[name="kakak_pembimbing[]"]');
    let validKakak = true;
    kakakInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            validKakak = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!validKakak) {
        alert('Nama kakak pembimbing harus diisi!');
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

function openShowTimModal(nama, ketua, anggota, dosen, kakak) {
    const modalElement = document.getElementById('showTimModal');
    const modal = new bootstrap.Modal(modalElement);

    document.getElementById('showNamaTim').textContent = nama || '-';
    document.getElementById('showKetua').textContent = ketua || '-';

    const dosenContainer = document.getElementById('showDosenPembimbing');
    if (dosen && Array.isArray(dosen) && dosen.length > 0) {
        const list = dosen.filter(d => d && d.trim() !== '');
        dosenContainer.innerHTML = list.map(name => `
            <span>${name.trim()}</span>
        `).join(', ');
    } else {
        dosenContainer.innerHTML = '<span class="text-muted">-</span>';
    }

    const kakakContainer = document.getElementById('showKakakPembimbing');
    if (kakak && Array.isArray(kakak) && kakak.length > 0) {
        const list = kakak.filter(k => k && k.trim() !== '');
        kakakContainer.innerHTML = list.map(name => `
            <span>${name.trim()}</span>
        `).join(', ');
    } else {
        kakakContainer.innerHTML = '<span class="text-muted">-</span>';
    }

    const tbody = document.getElementById('showAnggotaTable');
    if (anggota && Array.isArray(anggota) && anggota.length > 0) {
        const list = anggota.filter(a => a && a.trim() !== '');
        if (list.length > 0) {
            tbody.innerHTML = list.map((name, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${name.trim()}</td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Tidak ada anggota</td></tr>';
        }
    } else {
        tbody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Tidak ada anggota</td></tr>';
    }

    document.getElementById('btnEditFromShowTim').onclick = function() {
        modal.hide();
        setTimeout(function() {
            const editBtn = document.querySelector('#timTable tbody tr:not(.empty-state) .btn-action.btn-warning');
            if (editBtn) editBtn.click();
        }, 300);
    };

    modal.show();
}

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

document.querySelectorAll('.modal').forEach(function(modal) {
    modal.addEventListener('hidden.bs.modal', function() {
        const form = this.querySelector('form');
        if (form) {
            form.reset();
            document.querySelectorAll('.is-invalid').forEach(function(el) {
                el.classList.remove('is-invalid');
            });
        }
        if (this.id === 'tambahTimModal') {
            resetAnggotaList();
            resetDosenList();
            resetKakakList();
        }
    });
});
</script>
@endsection