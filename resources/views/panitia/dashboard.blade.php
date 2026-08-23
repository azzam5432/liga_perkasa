@extends('layouts.master')

@section('title', 'Dashboard Panitia')

@section('content')
<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        padding: 20px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
    }
    .stat-card .stat-label {
        color: #718096;
        font-size: 14px;
    }
    .stat-icon-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-icon-success { background: linear-gradient(135deg, #48bb78, #38a169); }
    .stat-icon-info { background: linear-gradient(135deg, #4299e1, #3182ce); }
    .stat-icon-warning { background: linear-gradient(135deg, #ed8936, #dd6b20); }
    
    .lomba-card {
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .lomba-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    .welcome-section .welcome-text {
        position: relative;
        z-index: 1;
    }
</style>

<div class="row">
    <!-- Welcome Section -->
    <div class="col-12">
        <div class="welcome-section">
            <div class="welcome-text">
                <h2>👋 Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p>Anda login sebagai <strong>{{ Auth::user()->role_label }}</strong> — {{ now()->format('l, d F Y') }}</p>
                <div class="mt-2">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>
                        Sistem Online
                    </span>
                    <span class="badge bg-light text-dark ms-2">
                        <i class="fas fa-clock me-1"></i> 
                        {{ now()->format('H:i') }} WIB
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-primary me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalTim }}</div>
                    <div class="stat-label">Total Tim</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-success me-3">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalPeserta }}</div>
                    <div class="stat-label">Total Peserta</div>
                </div>
            </div>
        </div>
    </div>

    @if($juri)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-info me-3">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalLomba }}</div>
                    <div class="stat-label">Lomba Ditugaskan</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-warning me-3">
                    <i class="fas fa-pen"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalPenilaian }}</div>
                    <div class="stat-label">Total Penilaian</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Lomba yang Ditugaskan (Untuk Juri) -->
@if($juri && $lombaDitugaskan->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-tasks me-2"></i> Lomba yang Ditugaskan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($lombaDitugaskan as $lomba)
                    <div class="col-md-4 mb-3">
                        <div class="card lomba-card h-100">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $lomba->nama_lomba }}</h6>
                                <small class="text-muted d-block">
                                    <i class="fas fa-calendar-alt me-1"></i> 
                                    {{ \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d/m/Y') }}
                                </small>
                                <small class="text-muted d-block">
                                    <i class="fas fa-tag me-1"></i> {{ $lomba->kategori ?? 'Umum' }}
                                </small>
                                <span class="badge bg-success mt-2">Aktif</span>
                                <div class="mt-3">
                                    <a href="{{ route('juri.penilaian') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen me-1"></i> Beri Penilaian
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
@endif

<!-- Data Tim Terbaru -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-users me-2"></i> Data Tim Terbaru</h6>
                <a href="{{ route('panitia.index') }}" class="btn btn-light btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Tim</th>
                                <th>Ketua</th>
                                <th>Prodi</th>
                                <th>No Telp</th>
                                <th>Jumlah Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataPeserta as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_tim }}</td>
                                <td>{{ $item->pesertas->whereNotNull('ketua_peserta')->first()->ketua_peserta ?? '-' }}</td>
                                <td>{{ $item->pesertas->first()->prodi ?? '-' }}</td>
                                <td>{{ $item->pesertas->first()->no_telp ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $item->pesertas->count() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">Belum ada data tim</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $dataPeserta->links() }}
            </div>
        </div>
    </div>
</div>
@endsection