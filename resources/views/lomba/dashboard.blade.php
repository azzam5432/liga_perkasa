{{-- resources/views/lomba/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard Lomba')

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="card bg-primary text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Lomba</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalLomba }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-success text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Lomba Aktif</h6>
                                <h2 class="mb-0 fw-bold">{{ $lombaAktif }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-warning text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Lomba Closed</h6>
                                <h2 class="mb-0 fw-bold">{{ $lombaClosed }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-info text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Lomba Selesai</h6>
                                <h2 class="mb-0 fw-bold">{{ $lombaSelesai }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tim & Peserta -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card bg-secondary text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Tim</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalTim }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-dark text-white shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Peserta</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalPeserta }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Lomba -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-list me-2"></i> Daftar Lomba</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Lomba</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Tim</th>
                                <th class="text-center">Kuota</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lombas as $index => $lomba)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $lomba->nama_lomba }}</td>
                                <td>{{ $lomba->kategori ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $lomba->status_badge }} rounded-pill">
                                        {{ $lomba->status_label }}
                                    </span>
                                </td>
                                <td>
                                    {{ $lomba->tanggal_mulai ? \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d M Y') : '-' }}
                                </td>
                                <td class="text-center">{{ $lomba->tims_count ?? 0 }}</td>
                                <td class="text-center">
                                    @if ($lomba->kuota_tim)
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $lomba->tims_count ?? 0 }}/{{ $lomba->kuota_tim }}</span>
                                            <div class="progress flex-grow-1" style="height: 6px; max-width: 60px;">
                                                <div class="progress-bar bg-success" style="width: {{ $lomba->kuota_persentase }}%;"></div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('lomba.show', $lomba->id_lomba) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-trophy fa-2x text-muted d-block mb-2"></i>
                                    <span class="text-muted">Belum ada data lomba</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card.bg-primary, .card.bg-success, .card.bg-warning, 
    .card.bg-info, .card.bg-secondary, .card.bg-dark {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card.bg-primary:hover, .card.bg-success:hover, .card.bg-warning:hover,
    .card.bg-info:hover, .card.bg-secondary:hover, .card.bg-dark:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    
    .progress {
        border-radius: 10px;
        background: rgba(255,255,255,0.2);
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
</style>
@endsection