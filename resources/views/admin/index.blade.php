@extends('layouts.master')
@section('title', 'Data Panitia')
@section('content')
<style>
/* ===== CSS ===== */
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

.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #edf2f7;
    flex-shrink: 0;
}

.avatar-initial-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: white;
    border: 2px solid #edf2f7;
    flex-shrink: 0;
}

.badge-role {
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}

.badge-role-superadmin {
    background: #edf2f7;
    color: #4a5568;
}

.badge-role-panitia {
    background: #ebf8ff;
    color: #2b6cb0;
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

.social-icons {
    display: flex;
    gap: 3px;
    align-items: center;
}

.social-icons a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    color: white;
    font-size: 9px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.social-icons a:hover {
    transform: scale(1.15);
}

.social-instagram { background: #E4405F; }
.social-facebook { background: #1877F2; }
.social-twitter { background: #1DA1F2; }
.social-linkedin { background: #0A66C2; }

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

.modal-custom .form-control {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.modal-custom .form-control:focus {
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

/* ===== RESPONSIVE ===== */
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
}
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4>Data Panitia</h4>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPanitiaModal">
        <i class="fas fa-plus"></i> Tambah Panitia
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
    <div class="filter-select">
        <select id="filterRole" onchange="filterTable()">
            <option value="">Semua Role</option>
            <option value="super_admin">Super Admin</option>
            <option value="panitia">Panitia</option>
        </select>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table id="panitiaTable">
            <thead>
                <tr>
                    <th style="width: 40px; min-width: 40px;">No</th>
                    <th class="col-sticky-left" style="min-width: 160px;">Nama</th>
                    <th style="min-width: 150px;">Email</th>
                    <th style="min-width: 100px;">Telepon</th>
                    <th style="min-width: 100px;">Jabatan</th>
                    <th style="min-width: 80px;">Role</th>
                    <th style="min-width: 70px;">Sosial</th>
                    <th class="col-sticky-right" style="min-width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($panitias as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="col-sticky-left">
                            <div class="d-flex align-items-center gap-2">
                                @if($item->foto_profil && file_exists(public_path('uploads/profil/' . $item->foto_profil)))
                                    <img src="{{ asset('uploads/profil/' . $item->foto_profil) }}"
                                         alt="{{ $item->name }}"
                                         class="avatar-sm">
                                @else
                                    <div class="avatar-initial-sm"
                                         style="background: {{ $item->avatar_color ?? '#667eea' }};">
                                        {{ $item->initials ?? strtoupper(substr($item->name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="fw-semibold" style="font-size: 13px;">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td style="font-size: 13px;">{{ $item->email }}</td>
                        <td style="font-size: 13px;">{{ $item->no_telp ?? '-' }}</td>
                        <td style="font-size: 13px;">{{ $item->jabatan ?? '-' }}</td>
                        <td>
                            <span class="badge-role {{ $item->role === 'super_admin' ? 'badge-role-superadmin' : 'badge-role-panitia' }}">
                                {{ $item->role_label }}
                            </span>
                        </td>
                        <td>
                            <div class="social-icons">
                                @if($item->instagram)
                                    <a href="{{ $item->instagram }}" target="_blank" class="social-instagram" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if($item->facebook)
                                    <a href="{{ $item->facebook }}" target="_blank" class="social-facebook" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if($item->twitter)
                                    <a href="{{ $item->twitter }}" target="_blank" class="social-twitter" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if($item->linkedin)
                                    <a href="{{ $item->linkedin }}" target="_blank" class="social-linkedin" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                @if(!$item->instagram && !$item->facebook && !$item->twitter && !$item->linkedin)
                                    <span style="font-size: 11px; color: #a0aec0;">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="openShowModal(
                                    {{ $item->id }},
                                    '{{ addslashes($item->name) }}',
                                    '{{ addslashes($item->email) }}',
                                    '{{ addslashes($item->no_telp) }}',
                                    '{{ addslashes($item->jabatan) }}',
                                    '{{ $item->role }}',
                                    '{{ addslashes($item->instagram) }}',
                                    '{{ addslashes($item->facebook) }}',
                                    '{{ addslashes($item->twitter) }}',
                                    '{{ addslashes($item->linkedin) }}',
                                    '{{ addslashes($item->bio) }}',
                                    '{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->updated_at ? $item->updated_at->format('d F Y H:i') : '' }}',
                                    '{{ $item->foto_profil ? asset('uploads/profil/' . $item->foto_profil) : '' }}'
                                )">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-warning" title="Edit"
                                    onclick="openEditModal(
                                        {{ $item->id }},
                                        '{{ addslashes($item->name) }}',
                                        '{{ addslashes($item->email) }}',
                                        '{{ addslashes($item->no_telp) }}',
                                        '{{ addslashes($item->jabatan) }}',
                                        '{{ addslashes($item->instagram) }}',
                                        '{{ addslashes($item->facebook) }}',
                                        '{{ addslashes($item->twitter) }}',
                                        '{{ addslashes($item->linkedin) }}',
                                        '{{ addslashes($item->bio) }}'
                                    )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger" title="Hapus"
                                        onclick="return confirm('Yakin hapus data panitia ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h6>Belum ada data panitia</h6>
                                <p>Silakan tambahkan panitia baru melalui tombol di atas.</p>
                                <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPanitiaModal" style="display: inline-flex; border: none;">
                                    <i class="fas fa-plus me-1"></i> Tambah Panitia
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($panitias->hasPages())
        <div class="pagination-wrapper">
            <span class="info-text">
                Menampilkan <strong>{{ $panitias->firstItem() }}</strong> sampai <strong>{{ $panitias->lastItem() }}</strong> dari <strong>{{ $panitias->total() }}</strong> panitia
            </span>
            {{ $panitias->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- ===== MODAL EDIT PANITIA ===== -->
<div class="modal fade modal-custom" id="editPanitiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #fefcbf;">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2" style="color: #d69e2e;"></i> Edit Panitia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPanitia" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_no_telp" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_no_telp" name="no_telp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" id="edit_instagram" name="instagram">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control" id="edit_facebook" name="facebook">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control" id="edit_twitter" name="twitter">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" id="edit_linkedin" name="linkedin">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="edit_bio" name="bio" rows="2" placeholder="Tuliskan sedikit tentang panitia ini..."></textarea>
                    </div>
                    <input type="hidden" id="edit_panitia_id" name="panitia_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnUpdatePanitia" style="background: #d69e2e;">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL SHOW/DETAIL PANITIA ===== -->
<div class="modal fade modal-custom" id="showPanitiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle me-2" style="color: #2b6cb0;"></i> Detail Panitia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div id="showAvatar" class="d-inline-block">
                        <div class="avatar-show" style="width: 80px; height: 80px; border-radius: 50%; background: #667eea; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                            -
                        </div>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showName">-</h5>
                    <span class="badge-role" id="showRole">-</span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Email</label>
                            <p class="fw-semibold" id="showEmail">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">No. Telepon</label>
                            <p class="fw-semibold" id="showNoTelp">-</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block">Jabatan</label>
                            <p class="fw-semibold" id="showJabatan">-</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Media Sosial</label>
                    <div id="showSocial" class="d-flex gap-2">
                        <span class="text-muted">-</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Bio</label>
                    <p id="showBio" class="text-muted" style="font-style: italic;">-</p>
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
                <button type="button" class="btn-primary-custom" id="btnEditFromShow" style="background: #d69e2e;">
                    <i class="fas fa-edit me-1"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL TAMBAH PANITIA ===== -->
<div class="modal fade modal-custom" id="tambahPanitiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i> Tambah Panitia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPanitia" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="modal_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="modal_password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="modal_password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_no_telp" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_no_telp" name="no_telp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_jabatan" name="jabatan" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modal_foto_profil" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="modal_foto_profil" name="foto_profil" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" id="modal_instagram" name="instagram" placeholder="https://instagram.com/username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control" id="modal_facebook" name="facebook" placeholder="https://facebook.com/username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control" id="modal_twitter" name="twitter" placeholder="https://twitter.com/username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" id="modal_linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modal_bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="modal_bio" name="bio" rows="2" placeholder="Tuliskan sedikit tentang panitia ini..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-primary-custom" id="btnSimpanPanitia">
                    <i class="fas fa-save me-1"></i> Simpan
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
    const role = document.getElementById('filterRole').value;

    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(function() {
        currentPage = 1;
        fetchData(search, role, currentPage);
    }, 300);
}

// ===== FETCH DATA VIA AJAX =====
function fetchData(search, role, page) {
    const tableBody = document.querySelector('#panitiaTable tbody');
    const paginationWrapper = document.querySelector('.pagination-wrapper');

    if (tableBody) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-4">
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
    url.searchParams.set('role', role);
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

        const newTableBody = doc.querySelector('#panitiaTable tbody');
        const newPagination = doc.querySelector('.pagination-wrapper');

        if (tableBody && newTableBody) {
            tableBody.innerHTML = newTableBody.innerHTML;
        }

        if (paginationWrapper && newPagination) {
            paginationWrapper.innerHTML = newPagination.innerHTML;
        }

        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('search', search);
        newUrl.searchParams.set('role', role);
        newUrl.searchParams.set('page', page);
        window.history.pushState({}, '', newUrl);

        attachPaginationListeners();
    })
    .catch(error => {
        console.error('Error:', error);
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">
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
                const role = document.getElementById('filterRole').value;
                const page = url.searchParams.get('page') || 1;

                currentPage = parseInt(page);
                fetchData(search, role, currentPage);
            }
        });
    });
}

// ===== MODAL EDIT =====
function openEditModal(id, name, email, no_telp, jabatan, instagram, facebook, twitter, linkedin, bio) {
    const modalElement = document.getElementById('editPanitiaModal');
    const modal = new bootstrap.Modal(modalElement);

    document.getElementById('formEditPanitia').action = '/admin/' + id;
    document.getElementById('edit_panitia_id').value = id;

    document.getElementById('edit_name').value = name || '';
    document.getElementById('edit_email').value = email || '';
    document.getElementById('edit_no_telp').value = no_telp || '';
    document.getElementById('edit_jabatan').value = jabatan || '';
    document.getElementById('edit_instagram').value = instagram || '';
    document.getElementById('edit_facebook').value = facebook || '';
    document.getElementById('edit_twitter').value = twitter || '';
    document.getElementById('edit_linkedin').value = linkedin || '';
    document.getElementById('edit_bio').value = bio || '';

    modal.show();
}

// ===== MODAL SHOW =====
function openShowModal(id, name, email, no_telp, jabatan, role, instagram, facebook, twitter, linkedin, bio, created_at, updated_at, foto) {
    const modalElement = document.getElementById('showPanitiaModal');
    const modal = new bootstrap.Modal(modalElement);

    document.getElementById('showName').textContent = name || '-';
    document.getElementById('showEmail').textContent = email || '-';
    document.getElementById('showNoTelp').textContent = no_telp || '-';
    document.getElementById('showJabatan').textContent = jabatan || '-';
    document.getElementById('showBio').textContent = bio || 'Tidak ada bio';
    document.getElementById('showCreatedAt').textContent = created_at || '-';
    document.getElementById('showUpdatedAt').textContent = updated_at || '-';

    const roleBadge = document.getElementById('showRole');
    if (role === 'super_admin') {
        roleBadge.textContent = 'Super Admin';
        roleBadge.className = 'badge-role badge-role-superadmin';
    } else {
        roleBadge.textContent = 'Panitia';
        roleBadge.className = 'badge-role badge-role-panitia';
    }

    const avatarContainer = document.getElementById('showAvatar');
    if (foto && foto !== 'null' && foto !== '') {
        avatarContainer.innerHTML = '<img src="' + foto + '" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e2e8f0;">';
    } else {
        const initials = name ? name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2) : '??';
        const colors = ['#667eea', '#48bb78', '#ed8936', '#9f7aea', '#fc8181', '#4299e1', '#ed64a6', '#38a169'];
        const colorIndex = name ? name.length % colors.length : 0;
        avatarContainer.innerHTML = '<div style="width: 80px; height: 80px; border-radius: 50%; background: ' + colors[colorIndex] + '; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">' + initials + '</div>';
    }

    const socialContainer = document.getElementById('showSocial');
    let socialHtml = '';
    if (instagram) socialHtml += '<a href="' + instagram + '" target="_blank" class="social-instagram" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; color: white; font-size: 14px; text-decoration: none;"><i class="fab fa-instagram"></i></a>';
    if (facebook) socialHtml += '<a href="' + facebook + '" target="_blank" class="social-facebook" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; color: white; font-size: 14px; text-decoration: none;"><i class="fab fa-facebook-f"></i></a>';
    if (twitter) socialHtml += '<a href="' + twitter + '" target="_blank" class="social-twitter" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; color: white; font-size: 14px; text-decoration: none;"><i class="fab fa-twitter"></i></a>';
    if (linkedin) socialHtml += '<a href="' + linkedin + '" target="_blank" class="social-linkedin" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; color: white; font-size: 14px; text-decoration: none;"><i class="fab fa-linkedin-in"></i></a>';
    if (!socialHtml) socialHtml = '<span class="text-muted">-</span>';
    socialContainer.innerHTML = socialHtml;

    document.getElementById('btnEditFromShow').onclick = function() {
        modal.hide();
        setTimeout(function() {
            openEditModal(id, name, email, no_telp, jabatan, instagram, facebook, twitter, linkedin, bio);
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

// ===== EVENT LISTENERS =====
document.addEventListener('DOMContentLoaded', function() {
    const modalEdit = document.getElementById('editPanitiaModal');
    const modalTambah = document.getElementById('tambahPanitiaModal');

    // ===== UPDATE PANITIA =====
    document.getElementById('btnUpdatePanitia').addEventListener('click', function() {
        const form = document.getElementById('formEditPanitia');
        const formData = new FormData(form);
        const btn = this;

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
                const modal = bootstrap.Modal.getInstance(modalEdit);
                modal.hide();
                showNotification('success', data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Silakan coba lagi.');
                alert('Terjadi kesalahan: \n' + errorMsg);
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

    // ===== SIMPAN PANITIA =====
    document.getElementById('btnSimpanPanitia').addEventListener('click', function() {
        const form = document.getElementById('formTambahPanitia');
        const formData = new FormData(form);
        const btn = this;

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
                const modal = bootstrap.Modal.getInstance(modalTambah);
                modal.hide();
                showNotification('success', data.message);
                form.reset();
                setTimeout(() => location.reload(), 1500);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Silakan coba lagi.');
                alert('Terjadi kesalahan: \n' + errorMsg);
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

    // ===== ATTACH PAGINATION LISTENERS INITIAL =====
    attachPaginationListeners();

    // ===== RESTORE SEARCH/FILTER FROM URL =====
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    const roleParam = urlParams.get('role');

    if (searchParam) {
        document.getElementById('searchInput').value = searchParam;
    }
    if (roleParam) {
        document.getElementById('filterRole').value = roleParam;
    }

    if (searchParam || roleParam) {
        const page = urlParams.get('page') || 1;
        currentPage = parseInt(page);
        fetchData(searchParam || '', roleParam || '', currentPage);
    }
});
</script>
@endsection