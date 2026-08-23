@extends('layouts.master')

@section('title', 'Detail Juri')

@section('content')
<style>
    .juri-avatar-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #e2e8f0;
    }
    .juri-avatar-initial-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        border: 5px solid #e2e8f0;
        font-size: 56px;
        margin: 0 auto;
    }
</style>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Detail Juri</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if($juri->user->foto_profil && file_exists(public_path('uploads/profil/' . $juri->user->foto_profil)))
                        <img src="{{ asset('uploads/profil/' . $juri->user->foto_profil) }}" 
                             alt="{{ $juri->user->name }}" 
                             class="juri-avatar-large">
                    @else
                        <div class="juri-avatar-initial-large" 
                             style="background: {{ $juri->user->avatar_color ?? '#667eea' }};">
                            {{ $juri->user->initials ?? strtoupper(substr($juri->user->name, 0, 2)) }}
                        </div>
                    @endif
                    <h3 class="mt-3">{{ $juri->user->name }}</h3>
                    <p class="text-muted">{{ $juri->user->email }}</p>
                    <span class="badge {{ $juri->status == 'aktif' ? 'bg-success' : 'bg-danger' }}" style="font-size: 14px; padding: 8px 20px;">
                        {{ ucfirst($juri->status) }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Spesialisasi</label>
                            <p class="fw-bold">{{ $juri->spesialisasi ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Institusi</label>
                            <p class="fw-bold">{{ $juri->institusi ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                @if($juri->pengalaman)
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Pengalaman</label>
                    <p>{{ $juri->pengalaman }}</p>
                </div>
                @endif

                <div class="mb-3">
                    <label class="text-muted small fw-bold">Total Penilaian</label>
                    <p class="fw-bold">{{ $juri->penilaians->count() }} Penilaian</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Dibuat</label>
                            <p>{{ $juri->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Diupdate</label>
                            <p>{{ $juri->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('juri.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('juri.edit', $juri->id_juri) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection