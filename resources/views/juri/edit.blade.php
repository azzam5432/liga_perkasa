@extends('layouts.master')

@section('title', 'Edit Juri')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Juri</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('juri.update', $juri->id_juri) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Juri</label>
                        <p class="fw-bold">{{ $juri->user->name }}</p>
                        <small class="text-muted">{{ $juri->user->email }}</small>
                    </div>

                    <div class="mb-3">
                        <label for="spesialisasi" class="form-label fw-bold">Spesialisasi</label>
                        <input type="text" class="form-control @error('spesialisasi') is-invalid @enderror" 
                               id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $juri->spesialisasi) }}">
                        @error('spesialisasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institusi" class="form-label fw-bold">Institusi</label>
                        <input type="text" class="form-control @error('institusi') is-invalid @enderror" 
                               id="institusi" name="institusi" value="{{ old('institusi', $juri->institusi) }}">
                        @error('institusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pengalaman" class="form-label fw-bold">Pengalaman</label>
                        <textarea class="form-control @error('pengalaman') is-invalid @enderror" 
                                  id="pengalaman" name="pengalaman" rows="3">{{ old('pengalaman', $juri->pengalaman) }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="aktif" {{ old('status', $juri->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $juri->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('juri.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection