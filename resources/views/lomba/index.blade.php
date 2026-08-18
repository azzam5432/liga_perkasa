{{-- resources/views/lomba/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Daftar Lomba')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-dark text-white d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2" style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i> Daftar Lomba
                </h5>
                <a href="{{ route('lomba.create') }}" class="btn btn-light btn-sm rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i> Tambah Lomba
                </a>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($lombas->count() > 0)
                    <div class="row g-4">
                        @foreach ($lombas as $lomba)
                        <div class="col-xl-4 col-lg-6">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-header py-3" style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-white fw-bold">
                                            <i class="fas fa-trophy me-2"></i>{{ $lomba->nama_lomba }}
                                        </h6>
                                        <span class="badge bg-{{ $lomba->status_badge }} rounded-pill px-3 py-2">
                                            {{ $lomba->status_label }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-tag me-1"></i> Kategori
                                        </small>
                                        <span class="fw-semibold">{{ $lomba->kategori ?? '-' }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar me-1"></i> Tanggal
                                        </small>
                                        <span class="fw-semibold">
                                            {{ $lomba->tanggal_mulai ? \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d M Y') : '-' }}
                                            {{ $lomba->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d M Y') : '' }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-users me-1"></i> Tim Terdaftar
                                        </small>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-semibold">{{ $lomba->tims_count ?? 0 }}</span>
                                            @if ($lomba->kuota_tim)
                                                <small class="text-muted">/ {{ $lomba->kuota_tim }}</small>
                                                <div class="flex-grow-1">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-success" style="width: {{ $lomba->kuota_persentase }}%;"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-map-marker-alt me-1"></i> Tempat
                                        </small>
                                        <span class="fw-semibold">{{ $lomba->tempat ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('lomba.show', $lomba->id_lomba) }}" class="btn btn-outline-dark btn-sm flex-fill rounded-pill">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('lomba.edit', $lomba->id_lomba) }}" class="btn btn-outline-warning btn-sm flex-fill rounded-pill">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('lomba.destroy', $lomba->id_lomba) }}" method="POST" class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill" onclick="return confirm('Yakin hapus lomba ini?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center flex-column flex-sm-row gap-2 mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Menampilkan {{ $lombas->firstItem() ?? 0 }} - {{ $lombas->lastItem() ?? 0 }} dari {{ $lombas->total() }} data
                        </div>
                        <div>
                            {{ $lombas->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data lomba</p>
                        <a href="{{ route('lomba.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus me-1"></i> Tambah Lomba Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #1a2332, #2d3748) !important;
    }
    
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .btn-outline-info:hover {
        background: #1a2332;
        color: #fff;
    }
    
    .btn-outline-warning:hover {
        background: #ffc107;
        color: #fff;
    }
    
    .btn-outline-danger:hover {
        background: #dc3545;
        color: #fff;
    }
    
    .progress {
        border-radius: 10px;
        background: #e9ecef;
    }
    
    .progress-bar {
        border-radius: 10px;
        background: linear-gradient(135deg, #28a745, #20c997);
    }
</style>
@endsection