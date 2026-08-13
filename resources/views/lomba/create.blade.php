{{-- resources/views/lomba/create.blade.php --}}
@extends('layouts.master')

@section('title', 'Tambah Lomba')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i> Tambah Lomba Baru</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Ada kesalahan:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('lomba.store') }}" method="POST">
                    @csrf

                    <!-- Nama Lomba -->
                    <div class="mb-3">
                        <label for="nama_lomba" class="form-label fw-bold">
                            <i class="fas fa-trophy text-primary me-1"></i> Nama Lomba <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_lomba') is-invalid @enderror" 
                               id="nama_lomba" 
                               name="nama_lomba" 
                               value="{{ old('nama_lomba') }}" 
                               placeholder="Masukkan Nama Lomba" 
                               required>
                        @error('nama_lomba')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori & Status -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">
                                <i class="fas fa-tag me-1"></i> Kategori
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                <i class="fas fa-circle me-1"></i> Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">
                            <i class="fas fa-align-left me-1"></i> Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4" 
                                  placeholder="Masukkan deskripsi lomba">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label fw-bold">
                                <i class="fas fa-calendar-alt me-1"></i> Tanggal Mulai
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" 
                                   name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label fw-bold">
                                <i class="fas fa-calendar-check me-1"></i> Tanggal Selesai
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" 
                                   name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tempat & Kuota -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tempat" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt me-1"></i> Tempat
                            </label>
                            <input type="text" 
                                   class="form-control @error('tempat') is-invalid @enderror" 
                                   id="tempat" 
                                   name="tempat" 
                                   value="{{ old('tempat') }}" 
                                   placeholder="Masukkan tempat lomba">
                            @error('tempat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kuota_tim" class="form-label fw-bold">
                                <i class="fas fa-users me-1"></i> Kuota Tim
                            </label>
                            <input type="number" 
                                   class="form-control @error('kuota_tim') is-invalid @enderror" 
                                   id="kuota_tim" 
                                   name="kuota_tim" 
                                   value="{{ old('kuota_tim') }}" 
                                   placeholder="Maksimal tim" 
                                   min="1">
                            @error('kuota_tim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Min & Max Anggota -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="min_anggota" class="form-label fw-bold">
                                <i class="fas fa-user-plus me-1"></i> Minimal Anggota <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('min_anggota') is-invalid @enderror" 
                                   id="min_anggota" 
                                   name="min_anggota" 
                                   value="{{ old('min_anggota', 5) }}" 
                                   min="1" 
                                   max="20" 
                                   required>
                            @error('min_anggota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="max_anggota" class="form-label fw-bold">
                                <i class="fas fa-user-friends me-1"></i> Maksimal Anggota <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('max_anggota') is-invalid @enderror" 
                                   id="max_anggota" 
                                   name="max_anggota" 
                                   value="{{ old('max_anggota', 20) }}" 
                                   min="1" 
                                   max="20" 
                                   required>
                            @error('max_anggota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4">
                        <a href="{{ route('lomba.index') }}" class="btn btn-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: linear-gradient(135deg, #4e73df, #224abe); border: none;">
                            <i class="fas fa-save me-1"></i> Simpan Lomba
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe) !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .card.shadow-sm {
        transition: box-shadow 0.3s ease;
    }
    
    .card.shadow-sm:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }
    
    .btn-primary {
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.4);
    }
    
    .btn-secondary {
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(108, 117, 125, 0.3);
    }
    
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endsection