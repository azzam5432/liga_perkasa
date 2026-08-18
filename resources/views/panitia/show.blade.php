@extends('layouts.master')

@section('title', 'Detail Tim')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #2d3748, #1a2332);">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i> Detail Tim
                </h5>
                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                    <i class="fas fa-users me-1"></i> {{ $tim->pesertas->count() ?? 0 }} Anggota
                </span>
            </div>
            
            <div class="card-body p-4">
                @php
                    $ketua = $tim->pesertas->whereNotNull('ketua_peserta')->first();
                    $firstPeserta = $tim->pesertas->first();
                @endphp
                
                <!-- Informasi Tim -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">Nama Tim</label>
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-users me-2"></i> {{ $tim->nama_tim }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">Jumlah Peserta</label>
                            <h5 class="mb-0">
                                <span class="badge bg-info rounded-pill px-4 py-2">
                                    <i class="fas fa-user me-1"></i> {{ $tim->pesertas->count() ?? 0 }} Orang
                                </span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">Ketua Tim</label>
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-user-tie me-2"></i> {{ $ketua->ketua_peserta ?? '-' }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">Program Studi</label>
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-graduation-cap me-2"></i> {{ $ketua->prodi ?? '-' }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">No Telepon</label>
                            <h5 class="mb-0">
                                <i class="fas fa-phone me-2 text-dark"></i> {{ $ketua->no_telp ?? '-' }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small text-uppercase fw-bold">Tanggal Dibuat</label>
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt me-2 text-muted"></i> 
                                {{ $tim->created_at ? $tim->created_at->format('d F Y H:i') : '-' }}
                            </h5>
                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-list me-2 text-dark"></i> Daftar Peserta
                    <span class="badge bg-dark ms-2">{{ $tim->pesertas->count() ?? 0 }}</span>
                </h5>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 8%">No</th>
                                <th>Nama Peserta</th>
                                <th class="text-center" style="width: 20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tim->pesertas as $index => $peserta)
                            <tr>
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <i class="fas fa-user me-2 text-dark"></i>
                                    {{ $peserta->nama_peserta }}
                                </td>
                                <td class="text-center">
                                    @if($peserta->ketua_peserta)
                                        <span class="badge  bg-success rounded-pill px-3 py-2">
                                            <i class="fas fa-crown me-1"></i> Ketua
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">
                                            <i class="fas fa-user me-1"></i> Anggota
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <i class="fas fa-users fa-2x text-muted d-block mb-2"></i>
                                    <span class="text-muted">Belum ada peserta</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('panitia.edit', $tim->id_tim) }}" class="btn btn-warning text-white rounded-pill px-4">
                        <i class="fas fa-edit me-1"></i> Edit Tim
                    </a>
                    <a href="{{ route('panitia.index') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <form action="{{ route('panitia.destroy', $tim->id_tim) }}" method="POST" class="d-inline ms-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('Yakin hapus data ini?')">
                            <i class="fas fa-trash me-1"></i> Hapus Tim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #2d3748, #1a2332) !important;
    }
    
    .info-box {
        background: #f8f9fa;
        padding: 12px 16px;
        border-radius: 10px;
        border-left: 4px solid #1a2332;
        transition: all 0.2s ease;
    }
    
    .info-box:hover {
        background: #e9ecef;
        transform: translateX(3px);
    }
    
    .info-box label {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 4px;
    }
    
    .info-box h5 {
        font-size: 1rem;
    }
    
    .table {
        font-size: 0.9rem;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #1cc88a, #18b97e) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #858796, #5a5c69) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #36494c, #182022) !important;
    }
    
    .btn {
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-warning.text-white:hover {
        background: #e0a800;
        border-color: #e0a800;
    }
    
    .btn-danger:hover {
        background: #c82333;
        border-color: #bd2130;
    }
    
    hr {
        opacity: 0.1;
    }
    
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }
        
        .info-box h5 {
            font-size: 0.85rem;
        }
        
        .table {
            font-size: 0.8rem;
        }
        
        .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .d-flex.flex-wrap {
            gap: 0.5rem !important;
        }
    }
</style>
@endsection