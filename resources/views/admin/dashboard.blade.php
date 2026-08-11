@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Tim</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalTim ?? 0 }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Peserta</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalPeserta ?? 0 }}</h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Rata-rata per Tim</h6>
                                <h2 class="mb-0 fw-bold">
                                    {{ $totalTim > 0 ? round($totalPeserta / $totalTim, 1) : 0 }}
                                </h2>
                            </div>
                            <div class="display-4 opacity-50">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i> Data Peserta Lomba
                </h5>
                <span class="badge bg-light text-dark">
                    <i class="fas fa-database me-1"></i> {{ $dataPeserta->total() ?? 0 }} Data
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 20%">Nama Tim</th>
                                <th style="width: 20%">Ketua Tim</th>
                                <th style="width: 15%">Prodi</th>
                                <th class="text-center" style="width: 15%">Jumlah Anggota</th>
                                <th style="width: 15%">No Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPeserta as $item)
                            @php
                                $pesertas = $item->pesertas;
                                $ketua = $pesertas->whereNotNull('ketua_peserta')->first();
                                $first = $pesertas->first();
                                $jumlahAnggota = $item->pesertas_count ?? $pesertas->count();
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">
                                    <i class="fas fa-users text-primary me-1"></i>
                                    {{ $item->nama_tim }}
                                </td>
                                <td>{{ $ketua->ketua_peserta ?? '-' }}</td>
                                <td>{{ $first->prodi ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info rounded-pill px-3 py-2">
                                        <i class="fas fa-user me-1"></i> {{ $jumlahAnggota }}
                                    </span>
                                </td>
                                <td>{{ $first->no_telp ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted d-block mb-3"></i>
                                    <span class="text-muted">Belum ada data peserta</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan {{ $dataPeserta->firstItem() ?? 0 }} - {{ $dataPeserta->lastItem() ?? 0 }} 
                        dari {{ $dataPeserta->total() ?? 0 }} data
                    </div>
                    <div>
                        {{ $dataPeserta->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card.bg-primary, .card.bg-success, .card.bg-info {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card.bg-primary:hover, 
    .card.bg-success:hover, 
    .card.bg-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    
    .page-link {
        border-radius: 0.375rem !important;
        margin: 0 2px;
        border: none;
        color: #4e73df;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border-color: #4e73df;
        color: white;
    }
    
    .page-item:not(.active) .page-link:hover {
        background: #e8ecf1;
        color: #224abe;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #1f2937, #111827) !important;
    }
    
    @media (max-width: 768px) {
        .table td, .table th {
            font-size: 0.8rem;
            padding: 0.5rem;
        }
        
        .card-header h5 {
            font-size: 0.9rem;
        }
    }
</style>
@endsection