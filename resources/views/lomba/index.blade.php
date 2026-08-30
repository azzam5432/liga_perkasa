{{-- resources/views/lomba/index.blade.php --}}
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

    .filter-bar .filter-select {
        min-width: 140px;
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
        min-width: 180px;
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

    .badge-status-draft {
        background: #e2e8f0;
        color: #4a5568;
    }

    .badge-status-open {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-status-selesai {
        background: #ebf8ff;
        color: #2b6cb0;
    }

    .badge-status-closed {
        background: #fed7d7;
        color: #9b2c2c;
    }

    .badge-jenis {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-jenis-langsung {
        background: #fefcbf;
        color: #975a16;
    }

    .badge-jenis-penyisihan {
        background: #ebf8ff;
        color: #2b6cb0;
    }

    .badge-jenis-final {
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
            font-size: 13px;
            min-width: 600px;
        }
        .table-scroll table thead th {
            font-size: 10px;
            padding: 8px 10px;
        }
        .table-scroll table tbody td {
            padding: 8px 10px;
        }
        .col-sticky-left {
            min-width: 150px;
        }
        .col-sticky-right {
            min-width: 100px;
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
            min-width: 500px;
        }
        .table-scroll table thead th {
            font-size: 9px;
            padding: 6px 8px;
        }
        .table-scroll table tbody td {
            padding: 6px 8px;
        }
        .col-sticky-left {
            min-width: 120px;
        }
        .col-sticky-right {
            min-width: 80px;
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
    <h4>Data Lomba</h4>
    @if(Auth::user()->isPanitia() || Auth::user()->isSuperAdmin())
    <a href="{{ route('lomba.create') }}" class="btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Lomba
    </a>
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
        <input type="text" id="searchInput" placeholder="Cari nama lomba atau kategori..." onkeyup="filterTable()">
    </div>
    <div class="filter-select">
        <select id="filterStatus" onchange="filterTable()">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="open">Open</option>
            <option value="selesai">Selesai</option>
            <option value="closed">Closed</option>
        </select>
    </div>
    <div class="filter-select">
        <select id="filterJenis" onchange="filterTable()">
            <option value="">Semua Jenis</option>
            <option value="langsung">Langsung</option>
            <option value="penyisihan">Penyisihan</option>
            <option value="final">Final</option>
        </select>
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
                    <th style="min-width: 150px;">Kategori</th>
                    <th style="min-width: 100px;">Jenis</th>
                    <th style="min-width: 130px;">Tanggal</th>
                    <th style="min-width: 100px;">Status</th>
                    <th style="min-width: 80px; text-align: center;">Juri</th>
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
                        <td style="font-size: 13px;">{{ $item->kategori ?? '-' }}</td>
                        <td>
                            <span class="badge-jenis badge-jenis-{{ $item->jenis }}">
                                {{ $item->jenis_label }}
                            </span>
                        </td>
                        <td style="font-size: 13px;">
                            @if($item->tanggal_mulai)
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                                @if($item->tanggal_selesai)
                                    - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge-status badge-status-{{ $item->status }}">
                                <span class="dot"></span>
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge bg-primary">{{ $item->juri->count() }}</span>
                        </td>
                        <td class="col-sticky-right text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn-action btn-info" title="Detail" onclick="location.href='{{ route('lomba.show', $item->id_lomba) }}'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(Auth::user()->isSuperAdmin())
                                    <button class="btn-action btn-warning" title="Edit" onclick="location.href='{{ route('lomba.edit', $item->id_lomba) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('lomba.destroy', $item->id_lomba) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger" title="Hapus"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
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
<!-- ===== JAVASCRIPT ===== -->
<!-- ========================================== -->
<script>
// ===== FILTER TABLE =====
function filterTable() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('filterStatus').value;
    const jenis = document.getElementById('filterJenis').value;
    
    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('status', status);
    url.searchParams.set('jenis', jenis);
    url.searchParams.set('page', 1);
    
    window.location.href = url.toString();
}
</script>
@endsection