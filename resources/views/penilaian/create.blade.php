@extends('layouts.master')

@section('title', 'Tambah Penilaian')

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Penilaian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_tim" class="form-label fw-bold">Tim <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_tim') is-invalid @enderror" 
                                        id="id_tim" name="id_tim" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach($tim as $t)
                                        <option value="{{ $t->id_tim }}" {{ old('id_tim') == $t->id_tim ? 'selected' : '' }}>
                                            {{ $t->nama_tim }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_juri" class="form-label fw-bold">Juri <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_juri') is-invalid @enderror" 
                                        id="id_juri" name="id_juri" required>
                                    <option value="">-- Pilih Juri --</option>
                                    @foreach($juri as $j)
                                        <option value="{{ $j->id_juri }}" {{ old('id_juri') == $j->id_juri ? 'selected' : '' }}>
                                            {{ $j->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_juri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_kriteria" class="form-label fw-bold">Kriteria <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_kriteria') is-invalid @enderror" 
                                        id="id_kriteria" name="id_kriteria" required>
                                    <option value="">-- Pilih Kriteria --</option>
                                    @foreach($kriteria as $k)
                                        <option value="{{ $k->id_kriteria }}" {{ old('id_kriteria') == $k->id_kriteria ? 'selected' : '' }}>
                                            {{ $k->nama_kriteria }} (Bobot: {{ $k->bobot }}%)
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kriteria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nilai" class="form-label fw-bold">Nilai</label>
                                <input type="number" class="form-control @error('nilai') is-invalid @enderror" 
                                       id="nilai" name="nilai" value="{{ old('nilai') }}" min="0">
                                @error('nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label fw-bold">Komentar</label>
                        <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                  id="komentar" name="komentar" rows="3">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dokumen_pendukung" class="form-label fw-bold">Dokumen Pendukung</label>
                        <input type="file" class="form-control @error('dokumen_pendukung') is-invalid @enderror" 
                               id="dokumen_pendukung" name="dokumen_pendukung" accept=".pdf,.doc,.docx,.jpg,.png">
                        <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG. Maks: 2MB</small>
                        @error('dokumen_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
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
@endsection