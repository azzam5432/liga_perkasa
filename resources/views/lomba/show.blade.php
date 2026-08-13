{{-- resources/views/lomba/show.blade.php --}}
@extends('layouts.master')

@section('title', 'Detail Lomba')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-info text-white" style="background: linear-gradient(135deg, #2d3748, #1a2332);">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy me-2"></i> Detail Lomba
                    </h5>
                    <div>
                        <a href="{{ route('lomba.edit', $lomba->id_lomba) }}" class="btn btn-warning btn-sm text-white rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('lomba.index') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error:</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('debug'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-bug me-2"></i>
                        <strong>Debug:</strong> {{ session('debug') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Info Lomba -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-tag fa-2x text-dark mb-2"></i>
                                <h6 class="text-muted mb-1">Kategori</h6>
                                <p class="fw-bold mb-0">{{ $lomba->kategori ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-circle fa-2x text-{{ $lomba->status_badge }} mb-2"></i>
                                <h6 class="text-muted mb-1">Status</h6>
                                <p class="fw-bold mb-0">
                                    <span class="badge bg-{{ $lomba->status_badge }} rounded-pill px-3 py-2">
                                        {{ $lomba->status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-2x text-success mb-2"></i>
                                <h6 class="text-muted mb-1">Tanggal</h6>
                                <p class="fw-bold mb-0">
                                    {{ $lomba->tanggal_mulai ? \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d M Y') : '-' }}
                                    {{ $lomba->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d M Y') : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x text-dark mb-2"></i>
                                <h6 class="text-muted mb-1">Tim Terdaftar</h6>
                                <p class="fw-bold mb-0">
                                    {{ $lomba->tims_count ?? 0 }}
                                    @if ($lomba->kuota_tim)
                                        <small class="text-muted">/ {{ $lomba->kuota_tim }}</small>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-align-left me-2"></i> Deskripsi</h6>
                    <div class="p-3 bg-light rounded-3">
                        {{ $lomba->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i> Tempat</h6>
                    <p>{{ $lomba->tempat ?? '-' }}</p>
                </div>

                <!-- Daftar Tim -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-users me-2"></i> Daftar Tim Terdaftar :
                            <span class="badge text-dark rounded-pill ms-2">{{ $lomba->tims_count ?? 0 }}</span>
                        </h6>
                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambahTim" 
                            {{ ($lomba->kuota_tim && $lomba->tims_count >= $lomba->kuota_tim) ? 'disabled' : '' }}>
                            <i class="fas fa-plus me-1"></i> Tambah Tim
                        </button>
                    </div>

                    @if ($lomba->tims && $lomba->tims->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tim</th>
                                        <th>Ketua</th>
                                        <th>Jumlah Peserta</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lomba->tims as $index => $tim)
                                    @php
                                        $ketua = $tim->pesertas->whereNotNull('ketua_peserta')->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $tim->nama_tim }}</td>
                                        <td>{{ $ketua->ketua_peserta ?? '-' }}</td>
                                        <td>
                                            <span class="badge text-dark rounded-pill">
                                                {{ $tim->pesertas_count ?? $tim->pesertas->count() }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.show', $tim->id_tim) }}" class="btn btn-sm btn-dark text-white" title="Detail Tim">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('lomba.hapus-tim', [$lomba->id_lomba, $tim->id_tim]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus dari Lomba" onclick="return confirm('Yakin hapus tim ini dari lomba?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 bg-light rounded-3">
                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada tim yang terdaftar di lomba ini</p>
                            <p class="text-muted small mt-1">Klik tombol "Tambah Tim" untuk menambahkan tim</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- tambah tim ke lomba -->

<div class="modal fade" id="modalTambahTim" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title"><i class="fas fa-user-plus me-2"></i> Tambah Tim ke Lomba</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('lomba.tambah-tim', $lomba->id_lomba) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="id_tim" class="form-label">Pilih Tim <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_tim') is-invalid @enderror" id="id_tim" name="id_tim" required>
                            <option value="">-- Pilih Tim --</option>
                            @if (isset($timAvailable) && $timAvailable->count() > 0)
                                @foreach ($timAvailable as $tim)
                                    <option value="{{ $tim->id_tim }}">{{ $tim->nama_tim }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>Tidak ada tim yang tersedia</option>
                            @endif
                        </select>
                        @error('id_tim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if ($lomba->kuota_tim && $lomba->tims_count >= $lomba->kuota_tim)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Kuota tim untuk lomba ini sudah penuh! ({{ $lomba->tims_count }}/{{ $lomba->kuota_tim }})
                        </div>
                    @elseif (!isset($timAvailable) || $timAvailable->count() == 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Semua tim sudah terdaftar di lomba lain atau tidak ada tim yang tersedia.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3" 
                        {{ ($lomba->kuota_tim && $lomba->tims_count >= $lomba->kuota_tim) || !isset($timAvailable) || $timAvailable->count() == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save me-1"></i> Tambahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-gradient-info {
        background: linear-gradient(135deg, #2d3748, #1a2332)!important;
    }
    
    .card.bg-light {
        transition: all 0.3s ease;
    }
    
    .card.bg-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    }
    
    .btn-primary {
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.4);
    }
    
    .btn-warning {
        transition: all 0.2s ease;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(246, 194, 62, 0.4);
    }
    
    .btn-secondary {
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(108, 117, 125, 0.3);
    }
</style>
@endsection