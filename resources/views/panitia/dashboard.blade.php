{{-- resources/views/panitia/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard Panitia')

@section('content')
<style>
    .welcome-section {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        border: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .welcome-section .welcome-text h2 {
        font-weight: 700;
        color: #1a2332;
        font-size: 20px;
        margin-bottom: 2px;
    }

    .welcome-section .welcome-text p {
        color: #718096;
        margin-bottom: 0;
        font-size: 14px;
    }

    .welcome-section .welcome-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .welcome-section .welcome-badges .badge {
        padding: 6px 16px;
        font-weight: 500;
        font-size: 12px;
        background: #f7fafc;
        color: #4a5568;
        border: 1px solid #edf2f7;
    }

    .welcome-section .welcome-badges .badge i {
        margin-right: 6px;
    }

    .stat-card {
        border: 1px solid #edf2f7;
        border-radius: 10px;
        padding: 18px 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        border-color: #1a365d;
    }

    .stat-card .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }

    .stat-card .stat-number {
        font-size: 26px;
        font-weight: 700;
        color: #1a2332;
        line-height: 1.2;
    }

    .stat-card .stat-label {
        color: #718096;
        font-size: 13px;
        font-weight: 500;
        margin-top: 2px;
    }

    .stat-icon-primary { background: linear-gradient(135deg, #1a365d, #2b6cb0); }
    .stat-icon-success { background: linear-gradient(135deg, #48bb78, #38a169); }
    .stat-icon-info { background: linear-gradient(135deg, #4299e1, #3182ce); }
    .stat-icon-warning { background: linear-gradient(135deg, #ed8936, #dd6b20); }

    .lomba-card {
        border: 1px solid #edf2f7;
        border-radius: 10px;
        transition: all 0.3s ease;
        height: 100%;
        background: #ffffff;
    }

    .lomba-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        transform: translateY(-3px);
    }

    .lomba-card .card-body {
        padding: 16px 18px;
    }

    .lomba-card .lomba-title {
        font-weight: 600;
        color: #1a2332;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .lomba-card .lomba-meta {
        font-size: 13px;
        color: #718096;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .lomba-card .lomba-meta i {
        width: 16px;
        color: #a0aec0;
    }

    .lomba-card .lomba-status {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 8px;
    }

    .lomba-card .lomba-status.belum {
        background: #fefcbf;
        color: #975a16;
    }

    .lomba-card .lomba-status.sudah {
        background: #c6f6d5;
        color: #22543d;
    }

    .lomba-card .btn-penilaian {
        font-size: 12px;
        padding: 4px 14px;
        border-radius: 6px;
        background: #1a365d;
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }

    .lomba-card .btn-penilaian:hover {
        background: #2b6cb0;
    }

    .lomba-card .btn-penilaian.sudah {
        background: #48bb78;
    }

    .lomba-card .btn-penilaian.sudah:hover {
        background: #38a169;
    }

    .card-header-custom {
        background: #ffffff;
        border-bottom: 1px solid #edf2f7;
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-header-custom h6 {
        font-weight: 600;
        color: #1a2332;
        margin: 0;
        font-size: 15px;
    }

    .card-header-custom .btn-outline-primary {
        font-size: 12px;
        padding: 4px 14px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        background: transparent;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .card-header-custom .btn-outline-primary:hover {
        background: #f7fafc;
        border-color: #b0b8c4;
    }

    .table-container {
        padding: 0 20px 20px 20px;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table-container table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 10px 12px;
        border-bottom: 1px solid #edf2f7;
        text-align: left;
    }

    .table-container table tbody td {
        padding: 10px 12px;
        color: #2d3748;
        border-bottom: 1px solid #f7fafc;
        vertical-align: middle;
    }

    .table-container table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-container table tbody tr:hover {
        background: #f7fafc;
    }

    .table-container .badge-count {
        background: #ebf8ff;
        color: #2b6cb0;
        padding: 2px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
    }

    .empty-state {
        padding: 30px 16px;
        text-align: center;
    }

    .empty-state i {
        font-size: 36px;
        color: #e2e8f0;
        display: block;
        margin-bottom: 10px;
    }

    .empty-state h6 {
        color: #1a2332;
        font-weight: 600;
        margin-bottom: 2px;
        font-size: 15px;
    }

    .empty-state p {
        color: #a0aec0;
        font-size: 13px;
        margin-bottom: 0;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0 0 0;
        border-top: 1px solid #edf2f7;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
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
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .welcome-section {
            flex-direction: column;
            align-items: flex-start;
            padding: 16px 20px;
        }
        .welcome-section .welcome-text h2 {
            font-size: 18px;
        }
        .stat-card .stat-number {
            font-size: 22px;
        }
        .table-container {
            padding: 0 12px 12px 12px;
            overflow-x: auto;
        }
        .table-container table {
            font-size: 13px;
            min-width: 500px;
        }
        .lomba-card .card-body {
            padding: 12px 14px;
        }
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .pagination-wrapper .pagination {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .welcome-section {
            padding: 14px 16px;
        }
        .welcome-section .welcome-text h2 {
            font-size: 16px;
        }
        .welcome-section .welcome-text p {
            font-size: 13px;
        }
        .stat-card {
            padding: 14px 16px;
        }
        .stat-card .stat-number {
            font-size: 20px;
        }
        .card-header-custom {
            padding: 10px 14px;
        }
        .card-header-custom h6 {
            font-size: 14px;
        }
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .pagination-wrapper .pagination .page-link {
            font-size: 11px;
            padding: 3px 8px;
        }
    }
</style>

<div class="welcome-section">
    <div class="welcome-text">
        <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
        <p>{{ Auth::user()->role_label }} — {{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="welcome-badges">
        <span class="badge">
            <i class="fas fa-circle text-success" style="font-size: 8px;"></i> Sistem Online
        </span>
        <span class="badge">
            <i class="fas fa-clock"></i> {{ now()->format('H:i') }} WIB
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-primary me-3">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalTim ?? 0 }}</div>
                <div class="stat-label">Total Tim</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-success me-3">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalPeserta ?? 0 }}</div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
    </div>

    @if(isset($juri) && $juri)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-info me-3">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalLomba ?? 0 }}</div>
                <div class="stat-label">Lomba Ditugaskan</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-warning me-3">
                <i class="fas fa-pen"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalTimSudahDinilai ?? 0 }}</div>
                <div class="stat-label">Tim Sudah Dinilai</div>
            </div>
        </div>
    </div>
    @endif
</div>

@if(isset($juri) && $juri && isset($lombaDitugaskan) && $lombaDitugaskan->count() > 0)
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header-custom">
                <h6><i class="fas fa-tasks text-primary me-2"></i> Lomba yang Ditugaskan</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($lombaDitugaskan as $lomba)
                        @php
                            $sudahDinilai = \App\Models\Nilai::where('id_lomba', $lomba->id_lomba)
                                ->where('id_juri', $juri->id_juri)
                                ->count();
                            $totalTim = \App\Models\Tim::count();
                        @endphp
                        <div class="col-md-4 col-sm-6">
                            <div class="lomba-card">
                                <div class="card-body">
                                    <div class="lomba-title">{{ $lomba->nama_lomba }}</div>
                                    <div class="lomba-meta">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d/m/Y') }}
                                        <span class="mx-1">→</span>
                                        {{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d/m/Y') }}
                                    </div>
                                    <div class="lomba-meta">
                                        <i class="fas fa-tag"></i> {{ $lomba->kategori ?? 'Umum' }}
                                    </div>
                                    <span class="lomba-status {{ $sudahDinilai > 0 ? 'sudah' : 'belum' }}">
                                        <i class="fas fa-circle" style="font-size: 6px; vertical-align: middle; margin-right: 4px;"></i>
                                        {{ $sudahDinilai > 0 ? $sudahDinilai . '/' . $totalTim . ' Tim Dinilai' : 'Belum Dinilai' }}
                                    </span>
                                    <div>
                                        <a href="{{ route('nilai.create', $lomba->id_lomba) }}" class="btn-penilaian {{ $sudahDinilai > 0 ? 'sudah' : '' }}">
                                            <i class="fas fa-pen me-1"></i> 
                                            {{ $sudahDinilai > 0 ? 'Edit Nilai' : 'Beri Nilai' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(isset($juri) && $juri)
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada lomba yang ditugaskan kepada Anda. Silakan hubungi admin.
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header-custom">
                <h6><i class="fas fa-users text-primary me-2"></i> Data Tim Terbaru</h6>
                <a href="{{ route('panitia.index') }}" class="btn-outline-primary">
                    <i class="fas fa-arrow-right me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Tim</th>
                                <th>Ketua</th>
                                <th>No Telp</th>
                                <th style="text-align: center;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataPeserta ?? [] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->nama_tim }}</strong></td>
                                <td>{{ $item->pesertas->whereNotNull('ketua_peserta')->first()->ketua_peserta ?? '-' }}</td>
                                <td>{{ $item->pesertas->first()->no_telp ?? '-' }}</td>
                                <td style="text-align: center;">
                                    <span class="badge-count">{{ $item->pesertas->count() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h6>Belum ada data tim</h6>
                                        <p>Silakan tambahkan tim melalui menu Data Tim.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($dataPeserta) && $dataPeserta->hasPages())
                <div class="pagination-wrapper">
                    <span class="info-text">
                        Menampilkan <strong>{{ $dataPeserta->firstItem() }}</strong> sampai <strong>{{ $dataPeserta->lastItem() }}</strong> dari <strong>{{ $dataPeserta->total() }}</strong> tim
                    </span>
                    {{ $dataPeserta->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection