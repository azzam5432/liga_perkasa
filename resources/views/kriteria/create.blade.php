@extends('layouts.master')

@section('title', 'Tambah Kriteria')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Kriteria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label fw-bold">Nama Kriteria <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                               id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}" required>
                        @error('nama_kriteria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bobot" class="form-label fw-bold">Bobot (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('bobot') is-invalid @enderror" 
                                       id="bobot" name="bobot" value="{{ old('bobot', 0) }}" min="0" max="100" required>
                                @error('bobot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipe" class="form-label fw-bold">Tipe <span class="text-danger">*</span></label>
                                <select class="form-select @error('tipe') is-invalid @enderror" 
                                        id="tipe" name="tipe" required>
                                    <option value="skala" {{ old('tipe') == 'skala' ? 'selected' : '' }}>Skala</option>
                                    <option value="pilihan_ganda" {{ old('tipe') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                    <option value="teks" {{ old('tipe') == 'teks' ? 'selected' : '' }}>Teks</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row" id="skalaSection">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="skala_min" class="form-label fw-bold">Skala Minimum</label>
                                <input type="number" class="form-control @error('skala_min') is-invalid @enderror" 
                                       id="skala_min" name="skala_min" value="{{ old('skala_min', 1) }}">
                                @error('skala_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="skala_max" class="form-label fw-bold">Skala Maksimum</label>
                                <input type="number" class="form-control @error('skala_max') is-invalid @enderror" 
                                       id="skala_max" name="skala_max" value="{{ old('skala_max', 100) }}">
                                @error('skala_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Aktif</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeSelect = document.getElementById('tipe');
    const skalaSection = document.getElementById('skalaSection');
    
    function toggleSkala() {
        if (tipeSelect.value === 'skala') {
            skalaSection.style.display = 'flex';
        } else {
            skalaSection.style.display = 'none';
        }
    }
    
    tipeSelect.addEventListener('change', toggleSkala);
    toggleSkala();
});
</script>
@endsection