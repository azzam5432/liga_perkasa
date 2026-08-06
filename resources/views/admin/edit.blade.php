@extends('layouts.master')

@section('title', 'Edit Peserta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Data Peserta
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.update', $peserta) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Peserta</label>
                        <input type="text" 
                               class="form-control @error('nama_peserta') is-invalid @enderror" 
                               name="nama_peserta" 
                               value="{{ old('nama_peserta', $peserta->nama_peserta) }}"
                               placeholder="Masukkan Nama Peserta">
                        @error('nama_peserta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">No Telpon</label>
                        <input type="text" 
                               class="form-control @error('no_telp') is-invalid @enderror" 
                               name="no_telp" 
                               value="{{ old('no_telp', $peserta->no_telp) }}"
                               placeholder="Masukkan No Telpon">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection