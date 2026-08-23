@extends('layouts.master')

@section('title', 'Tambah Penugasan Juri')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i> Tambah Penugasan Juri</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('juri_lomba.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_juri" class="form-label fw-bold">Pilih Juri <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_juri') is-invalid @enderror" 
                                id="id_juri" name="id_juri" required>
                            <option value="">-- Pilih Juri --</option>
                            @foreach($juri as $j)
                                <option value="{{ $j->id_juri }}" {{ old('id_juri') == $j->id_juri ? 'selected' : '' }}>
                                    {{ $j->user->name }} - {{ $j->spesialisasi ?? 'Tanpa Spesialisasi' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_juri')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_lomba" class="form-label fw-bold">Pilih Lomba <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_lomba') is-invalid @enderror" 
                                id="id_lomba" name="id_lomba" required>
                            <option value="">-- Pilih Lomba --</option>
                            @forelse($lomba as $l)
                                <option value="{{ $l->id_lomba }}" {{ old('id_lomba') == $l->id_lomba ? 'selected' : '' }}>
                                    {{ $l->nama_lomba }} 
                                    @if($l->juri->count() > 0)
                                        ({{ $l->juri->count() }} Juri)
                                    @endif
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada lomba dengan status Open</option>
                            @endforelse
                        </select>
                        @error('id_lomba')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($lomba->isEmpty())
                            <small class="text-warning">Belum ada lomba dengan status "Open". Silahkan buat lomba terlebih dahulu.</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                        <small class="text-muted">Catatan tambahan untuk penugasan ini</small>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('juri_lomba.index') }}" class="btn btn-secondary">
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