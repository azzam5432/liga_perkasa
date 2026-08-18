@extends('layouts.master')

@section('title', 'Tambah Panitia')

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i> Tambah Panitia</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telp" class="form-label fw-bold">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                       id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                       id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto_profil" class="form-label fw-bold">Foto Profil</label>
                        <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" 
                               id="foto_profil" name="foto_profil" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="instagram" class="form-label fw-bold">Instagram</label>
                                <input type="url" class="form-control @error('instagram') is-invalid @enderror" 
                                       id="instagram" name="instagram" value="{{ old('instagram') }}" 
                                       placeholder="https://instagram.com/username">
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="facebook" class="form-label fw-bold">Facebook</label>
                                <input type="url" class="form-control @error('facebook') is-invalid @enderror" 
                                       id="facebook" name="facebook" value="{{ old('facebook') }}"
                                       placeholder="https://facebook.com/username">
                                @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="twitter" class="form-label fw-bold">Twitter</label>
                                <input type="url" class="form-control @error('twitter') is-invalid @enderror" 
                                       id="twitter" name="twitter" value="{{ old('twitter') }}"
                                       placeholder="https://twitter.com/username">
                                @error('twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="linkedin" class="form-label fw-bold">LinkedIn</label>
                                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" 
                                       id="linkedin" name="linkedin" value="{{ old('linkedin') }}"
                                       placeholder="https://linkedin.com/in/username">
                                @error('linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label fw-bold">Bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="3" 
                                  placeholder="Tuliskan sedikit tentang panitia ini...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
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