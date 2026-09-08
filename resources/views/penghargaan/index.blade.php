@extends('layouts.master')

@section('title', 'Penghargaan Khusus')

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
    font-size: 22px; /* Diperbesar dari 20px */
}

.page-header .btn-primary-custom {
    background: #1a365d;
    border: none;
    color: #ffffff;
    padding: 10px 24px; /* Padding sedikit lebih besar */
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px; /* Diperbesar dari 14px */
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
    font-size: 15px; /* Diperbesar dari 14px */
}

.table-scroll table thead th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    font-size: 13px; /* Diperbesar dari 11px */
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 12px 14px;
    border-bottom: 2px solid #edf2f7;
    text-align: left;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table-scroll table tbody td {
    padding: 12px 14px; /* Padding sedikit lebih besar */
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

.badge-bobot {
    background: #ebf8ff;
    color: #2b6cb0;
    padding: 4px 12px; /* Padding lebih besar */
    border-radius: 12px;
    font-size: 14px; /* Diperbesar dari 11px */
    font-weight: 600;
}

.badge-tim {
    background: #c6f6d5;
    color: #22543d;
    padding: 4px 12px; /* Padding lebih besar */
    border-radius: 12px;
    font-size: 14px; /* Diperbesar dari 11px */
    font-weight: 600;
}

.btn-action {
    width: 34px; /* Lebih besar dari 28px */
    height: 34px; /* Lebih besar dari 28px */
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: #a0aec0;
    transition: all 0.2s ease;
    font-size: 14px; /* Diperbesar dari 12px */
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

.empty-state {
    padding: 40px 16px;
    text-align: center;
}

.empty-state i {
    font-size: 48px; /* Diperbesar dari 40px */
    color: #e2e8f0;
    margin-bottom: 12px;
    display: block;
}

.empty-state h6 {
    color: #1a2332;
    font-weight: 600;
    margin-bottom: 4px;
    font-size: 18px; /* Diperbesar dari 16px */
}

.empty-state p {
    color: #a0aec0;
    font-size: 14px; /* Diperbesar dari 13px */
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
    font-size: 20px; /* Diperbesar dari 18px */
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
    font-size: 14px; /* Diperbesar dari 13px */
    color: #1a2332;
}

.modal-custom .form-control,
.modal-custom .form-select {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 14px; /* Padding lebih besar */
    font-size: 15px; /* Diperbesar dari 14px */
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
    padding: 10px 22px; /* Padding lebih besar */
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px; /* Diperbesar dari 14px */
    transition: all 0.2s ease;
}

.modal-custom .btn-secondary-custom:hover {
    background: #e2e8f0;
}

.modal-custom .btn-primary-custom {
    background: #1a365d;
    border: none;
    color: #ffffff;
    padding: 10px 26px; /* Padding lebih besar */
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px; /* Diperbesar dari 14px */
    transition: all 0.2s ease;
}

.modal-custom .btn-primary-custom:hover {
    background: #2b6cb0;
}

/* RESPONSIVE - TIDAK DIUBAH */
@media (max-width: 768px) {
    .page-header {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .page-header .btn-primary-custom {
        font-size: 12px;
        padding: 6px 14px;
    }
    .page-header h4 {
        font-size: 16px;
        margin: 0;
    }

    .table-scroll table thead th:nth-child(1),
    .table-scroll table thead th:nth-child(2),
    .table-scroll table thead th:last-child {
        display: table-cell;
    }

    .table-scroll table thead th:nth-child(3),
    .table-scroll table thead th:nth-child(4) {
        display: none;
    }

    .table-scroll table tbody td:nth-child(1),
    .table-scroll table tbody td:nth-child(2),
    .table-scroll table tbody td:last-child {
        display: table-cell;
    }

    .table-scroll table tbody td:nth-child(3),
    .table-scroll table tbody td:nth-child(4) {
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
    <h4><i class="fas fa-award me-2"></i> Penghargaan Khusus</h4>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPenghargaanModal">
        <i class="fas fa-plus"></i> Tambah Penghargaan
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 200px;">Kategori</th>
                    <th style="min-width: 100px;">Bobot</th>
                    <th style="min-width: 200px;">Tim</th>
                    <th class="col-sticky-right" style="min-width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penghargaan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left fw-semibold">{{ $item->kategori }}</td>
                        <td>
                            <span class="badge-bobot">{{ $item->bobot }}</span>
                        </td>
                        <td>
                            @if($item->id_tim)
                                <span class="badge-tim">{{ $item->tim->nama_tim ?? '-' }}</span>
                            @else
                                <span class="text-muted">Belum ada tim</span>
                            @endif
                        </td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Pilih Tim" data-bs-toggle="modal" data-bs-target="#assignTimModal{{ $item->id_penghargaan }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn-action btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editPenghargaanModal{{ $item->id_penghargaan }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('penghargaan.destroy', $item->id_penghargaan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger" title="Hapus" onclick="return confirm('Yakin hapus penghargaan ini?')">
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
                                <i class="fas fa-award"></i>
                                <h6>Belum ada penghargaan</h6>
                                <p>Klik tombol "Tambah Penghargaan" untuk menambahkan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PENGHARGAAN -->
<div class="modal fade modal-custom" id="tambahPenghargaanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2" style="color: #1a365d;"></i> Tambah Penghargaan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPenghargaan" action="{{ route('penghargaan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-control" placeholder="Masukkan kategori penghargaan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="bobot" class="form-control" placeholder="Masukkan bobot nilai" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" form="formTambahPenghargaan" class="btn-primary-custom">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@foreach($penghargaan as $item)
<!-- MODAL ASSIGN TIM -->
<div class="modal fade modal-custom" id="assignTimModal{{ $item->id_penghargaan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2" style="color: #2b6cb0;"></i> Pilih Tim - {{ $item->kategori }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAssignTim{{ $item->id_penghargaan }}" action="{{ route('penghargaan.assignTim', $item->id_penghargaan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Tim <span class="text-danger">*</span></label>
                        <select name="id_tim" class="form-select" required>
                            <option value="">-- Pilih Tim --</option>
                            @foreach($tim as $t)
                                <option value="{{ $t->id_tim }}" {{ $item->id_tim == $t->id_tim ? 'selected' : '' }}>{{ $t->nama_tim }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" form="formAssignTim{{ $item->id_penghargaan }}" class="btn-primary-custom" style="background: #2b6cb0;">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PENGHARGAAN -->
<div class="modal fade modal-custom" id="editPenghargaanModal{{ $item->id_penghargaan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="color: #d69e2e;"></i> Edit Penghargaan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPenghargaan{{ $item->id_penghargaan }}" action="{{ route('penghargaan.update', $item->id_penghargaan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-control" value="{{ $item->kategori }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="bobot" class="form-control" value="{{ $item->bobot }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" form="formEditPenghargaan{{ $item->id_penghargaan }}" class="btn-primary-custom" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection