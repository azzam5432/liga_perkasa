@extends('layouts.master')

@section('title', 'Data Panitia')

@section('content')
<style>
    .header-gradient {
        background: linear-gradient(135deg, #1a2332 0%, #2d3748 100%);
        border-radius: 15px;
        padding: 20px 30px;
    }

    .panitia-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        background: #ffffff;
    }

    .panitia-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.12);
    }

    .panitia-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #a1a1a198;
        padding: 3px;
        background: white;
    }

    .panitia-social {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .panitia-social a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .panitia-social a:hover {
        transform: scale(1.15);
    }

    .social-instagram { background: #E4405F; }
    .social-facebook  { background: #1877F2; }
    .social-twitter   { background: #1DA1F2; }
    .social-linkedin  { background: #0A66C2; }

    .badge-role {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-super-admin {
        background: linear-gradient(135deg, #1a2332, #2d3748);
        color: white;
    }

    .badge-panitia {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .custom-pagination-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 12px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .custom-pagination-container .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .custom-pagination-container .page-item .page-link {
        border: none;
        border-radius: 8px !important;
        color: #4a5568;
        font-weight: 500;
        font-size: 13px;
        padding: 6px 12px;
        transition: all 0.2s ease;
    }

    .custom-pagination-container .page-item.active .page-link {
        background-color: #1a2332;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(26, 35, 50, 0.3);
    }

    .custom-pagination-container .page-item:not(.active) .page-link:hover {
        background-color: #edf2f7;
        color: #1a2332;
    }

    .custom-pagination-container .page-item.disabled .page-link {
        color: #cbd5e0;
        background-color: transparent;
    }
</style>

<div class="container-fluid">
    <div class="header-gradient text-white d-flex justify-content-between align-items-center mb-4 shadow-sm">
        <div>
            <h5 class="mb-0 fw-bold"><i class="fas fa-users-cog me-2"></i> Data Panitia</h5>
            <small class="opacity-75">Kelola data panitia yang terdaftar</small>
        </div>
        <a href="{{ route('admin.create') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Panitia
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($panitias as $item)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card panitia-card h-100 text-center p-3">
                    <div class="card-body d-flex flex-column align-items-center p-2">
                        <div class="position-relative mb-3">
                            <img src="{{ $item->foto_profil_url }}" alt="{{ $item->name }}" class="panitia-avatar shadow-sm">
                        </div>

                        <h6 class="fw-bold mb-1 text-dark">{{ $item->name }}</h6>
                        <p class="text-muted small mb-2">{{ $item->jabatan ?? 'Panitia' }}</p>

                        <span class="badge-role mb-3 {{ $item->role === 'super_admin' ? 'badge-super-admin' : 'badge-panitia' }}">
                            {{ $item->role_label }}
                        </span>

                        <div class="w-100 border-top border-bottom py-2 my-2 text-start small text-muted">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-envelope text-primary me-2" style="width: 16px;"></i>
                                <span class="text-truncate">{{ $item->email }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-success me-2" style="width: 16px;"></i>
                                <span>{{ $item->no_telp ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="panitia-social my-2">
                            @if($item->instagram)
                                <a href="{{ $item->instagram }}" target="_blank" class="social-instagram" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if($item->facebook)
                                <a href="{{ $item->facebook }}" target="_blank" class="social-facebook" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if($item->twitter)
                                <a href="{{ $item->twitter }}" target="_blank" class="social-twitter" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if($item->linkedin)
                                <a href="{{ $item->linkedin }}" target="_blank" class="social-linkedin" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            @endif
                        </div>

                        <div class="mt-auto pt-3 d-flex gap-2 justify-content-center w-100">
                            <a href="{{ route('admin.show', $item->id) }}" class="btn btn-sm btn-outline-dark flex-fill" title="Detail">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-sm btn-outline-warning flex-fill" title="Edit">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.destroy', $item->id) }}" method="POST" class="d-inline flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" title="Hapus"
                                        onclick="return confirm('Yakin hapus data panitia ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data panitia</h5>
                    <p class="text-muted small">Klik tombol "Tambah Panitia" di atas untuk menambahkan data baru.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if ($panitias->hasPages())
        <div class="custom-pagination-container mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Menampilkan <strong>{{ $panitias->firstItem() }}</strong> sampai <strong>{{ $panitias->lastItem() }}</strong> dari <strong>{{ $panitias->total() }}</strong> panitia
            </div>
            <div>
                {{ $panitias->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection