@extends('layouts.master')

@section('title', 'Detail Panitia')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Detail Panitia</h5>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ $panitia->foto_profil_url }}" 
                         alt="{{ $panitia->name }}" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #e2e8f0;">
                    <h3 class="mt-3">{{ $panitia->name }}</h3>
                    <span class="badge-role {{ $panitia->role === 'super_admin' ? 'badge-super-admin' : 'badge-panitia' }}">
                        {{ $panitia->role_label }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Email</label>
                            <p class="fw-bold">{{ $panitia->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">No. Telepon</label>
                            <p class="fw-bold">{{ $panitia->no_telp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Jabatan</label>
                            <p class="fw-bold">{{ $panitia->jabatan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Bergabung</label>
                            <p class="fw-bold">{{ $panitia->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold">Bio</label>
                    <p class="fw-bold">{{ $panitia->bio ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold">Media Sosial</label>
                    <div class="panitia-social mt-2">
                        @if($panitia->instagram)
                            <a href="{{ $panitia->instagram }}" target="_blank" class="social-instagram">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        @endif
                        @if($panitia->facebook)
                            <a href="{{ $panitia->facebook }}" target="_blank" class="social-facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        @endif
                        @if($panitia->twitter)
                            <a href="{{ $panitia->twitter }}" target="_blank" class="social-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        @endif
                        @if($panitia->linkedin)
                            <a href="{{ $panitia->linkedin }}" target="_blank" class="social-linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('admin.edit', $panitia->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-role {
        padding: 5px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-super-admin {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .badge-panitia {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .panitia-social a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        margin-right: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .panitia-social a:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .social-instagram { background: #E4405F; }
    .social-facebook { background: #1877F2; }
    .social-twitter { background: #1DA1F2; }
    .social-linkedin { background: #0A66C2; }
</style>
@endsection