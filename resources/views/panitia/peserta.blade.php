@extends('layouts.master')

@section('title', 'Data Tim')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-dark text-white d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2" style="background: linear-gradient(135deg, #2d3748, #1a2332);">
                <h5 class="mb-0 fs-6 fs-md-5">
                    <i class="fas fa-users me-2"></i> Data Tim
                </h5>
            </div>
            <div class="card-body p-3 p-sm-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Total Tim: <strong>{{ $tim->total() }}</strong>
                    </div>
                    <a href="{{ route('panitia.create') }}" class="btn btn-success btn-sm rounded-pill px-4">
                        <i class="fas fa-plus me-1"></i>  Tim
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Mobile Card View -->
                <div class="d-block d-lg-none">
                    @forelse ($tim as $item)
                    @php
                        $pesertas = $item->pesertas;
                        $ketua = $pesertas->whereNotNull('ketua_peserta')->first();
                        $first = $pesertas->first();
                        $jumlahPeserta = $item->pesertas_count ?? $pesertas->count();
                    @endphp
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title fw-bold mb-0">
                                    <i class="fas fa-users text-dark me-1"></i> {{ $item->nama_tim }}
                                </h6>
                                <span class="badge bg-info rounded-pill px-4 py-3">
                                    <i class="fas fa-user me-1"></i> {{ $jumlahPeserta }}
                                </span>
                            </div>
                            <hr class="my-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Ketua Tim</small>
                                    <span class="fw-semibold">{{ $ketua->ketua_peserta ?? '-' }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Prodi</small>
                                    <span class="fw-semibold">{{ $first->prodi ?? '-' }}</span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">No Telp</small>
                                    <span class="fw-semibold">{{ $first->no_telp ?? '-' }}</span>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.show', $item->id_tim) }}" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                                <a href="{{ route('admin.edit', $item->id_tim) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $item->id_tim) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data tim</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop Grid Card View -->
                <div class="d-none d-lg-block">
                    @if($tim->count() > 0)
                        <div class="row g-5">
                            @forelse ($tim as $item)
                            @php
                                $pesertas = $item->pesertas;
                                $ketua = $pesertas->whereNotNull('ketua_peserta')->first();
                                $first = $pesertas->first();
                                $jumlahPeserta = $item->pesertas_count ?? $pesertas->count();
                            @endphp
                            <div class="col-xl-4 col-lg-6">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-header bg-gradient-info text-white border-0 py-3" style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-users me-2"></i>{{ $item->nama_tim }}
                                            </h6>
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                <i class="fas fa-users me-1"></i> {{ $jumlahPeserta }} Anggota
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-user-tie fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Ketua Tim</small>
                                                <span class="fw-semibold">{{ $ketua->ketua_peserta ?? '-' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-success">
                                                <i class="fas fa-graduation-cap fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Program Studi</small>
                                                <span class="fw-semibold">{{ $first->prodi ?? '-' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-warning">
                                                <i class="fas fa-phone fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">No Telepon</small>
                                                <span class="fw-semibold">{{ $first->no_telp ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('panitia.show', $item->id_tim) }}" class="btn btn-outline-dark btn-sm flex-fill rounded-pill">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                            <a href="{{ route('panitia.edit', $item->id_tim) }}" class="btn btn-outline-warning btn-sm flex-fill rounded-pill">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('panitia.destroy', $item->id_tim) }}" method="POST" class="flex-fill">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill" onclick="return confirm('Yakin hapus data ini?')">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data tim</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data tim</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center flex-column flex-sm-row gap-2 mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan {{ $tim->firstItem() ?? 0 }} - {{ $tim->lastItem() ?? 0 }} dari {{ $tim->total() }} Tim
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $tim->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #1a2332, #2d3748) !important;
    }
    
    .hover-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .hover-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(78, 115, 223, 0.03), rgba(54, 185, 204, 0.03));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 0.5rem;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .hover-card:hover::before {
        opacity: 1;
    }
    
    .hover-card .card-header {
        position: relative;
        z-index: 1;
    }
    
    .hover-card .card-body {
        position: relative;
        z-index: 1;
        padding: 1.25rem 1.25rem 0.5rem 1.25rem;
    }
    
    .hover-card .card-footer {
        position: relative;
        z-index: 1;
    }
    
    /* ===== BUTTON OUTLINE STYLES ===== */
    .btn-outline-info {
        color: #2d3748;
        border: 1.5px solid #2d3748;
        background: transparent;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-info:hover {
        background: #1a2332;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.5rem #1a2332a7;
    }
    
    .btn-outline-warning {
        color: #ffc107;
        border: 1.5px solid #ffc107;
        background: transparent;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-warning:hover {
        background: #ffc107;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.5rem rgba(255, 193, 7, 0.3);
    }
    
    .btn-outline-danger {
        color: #dc3545;
        border: 1.5px solid #dc3545;
        background: transparent;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-danger:hover {
        background: #dc3545;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.5rem rgba(220, 53, 69, 0.3);
    }
    
    .btn-primary.btn-sm {
        font-size: 0.8rem;
        padding: 0.35rem 1.25rem;
        transition: all 0.2s ease;
    }
    
    .btn-primary.btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.75rem rgba(78, 115, 223, 0.4);
    }
    
    .card-header .btn {
        white-space: nowrap;
    }

    .g-5 {
        --bs-gutter-y: 2rem;
        --bs-gutter-x: 2rem;
    }
    
    .row.g-5 > .col-xl-4,
    .row.g-5 > .col-lg-6 {
        padding-left: 16px;
        padding-right: 16px;
        margin-bottom: 16px;
    }
    
    @media (min-width: 1400px) {
        .row.g-5 {
            margin-left: -20px;
            margin-right: -20px;
        }
        
        .row.g-5 > .col-xl-4 {
            padding-left: 20px;
            padding-right: 20px;
            margin-bottom: 20px;
        }
    }
    
    @media (min-width: 992px) and (max-width: 1399px) {
        .row.g-5 {
            margin-left: -16px;
            margin-right: -16px;
        }
        
        .row.g-5 > .col-lg-6 {
            padding-left: 16px;
            padding-right: 16px;
            margin-bottom: 16px;
        }
    }
    
    @media (max-width: 576px) {
        .card-header h5 {
            font-size: 0.95rem !important;
        }
        .card-header .btn {
            font-size: 0.8rem !important;
            padding: 0.25rem 0.75rem !important;
        }
        .btn-sm {
            font-size: 0.7rem !important;
            padding: 0.15rem 0.5rem !important;
        }
        .btn-outline-info, 
        .btn-outline-warning, 
        .btn-outline-danger {
            font-size: 0.7rem !important;
            padding: 0.15rem 0.5rem !important;
        }
    }
    
    .d-block.d-lg-none .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .d-block.d-lg-none .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #1a2332, #2d3748) !important;
    }
    
    /* Pagination Styling */
    .page-link {
        border-radius: 0.375rem !important;
        margin: 0 2px;
        border: none;
        color: #4e73df;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border-color: #4e73df;
        color: #fff;
    }
    
    .page-item:not(.active) .page-link:hover {
        background: #e8ecf1;
        color: #224abe;
    }
    
    .alert {
        border-radius: 0.75rem !important;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const closeButton = alert.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.click();
                }
            });
        }, 5000);
    });
</script>
@endpush
@endsection