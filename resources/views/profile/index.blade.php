@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<style>
    /* ===== GLOBAL PROFILE ===== */
    .profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }

    .profile-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }

    /* ===== HEADER PROFILE (Bagian Atas) ===== */
    .profile-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 40px;
        border-bottom: 1px solid #e9ecef;
    }

    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar-img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar-initial {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 700;
        color: white;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }

    .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }

    .profile-info h2 {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .profile-info .text-muted-profile {
        color: #718096;
        font-size: 15px;
    }

    .profile-info .badge-role-profile {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .badge-role-superadmin {
        background: #edf2f7;
        color: #2d3748;
        border: 1px solid #cbd5e0;
    }

    .badge-role-panitia {
        background: #e6fffa;
        color: #319795;
        border: 1px solid #81e6d9;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #38a169;
        font-weight: 600;
    }

    .badge-status i {
        font-size: 8px;
    }

    /* ===== BODY CARD ===== */
    .profile-body {
        padding: 30px;
    }

    /* Alert */
    .alert {
        border-radius: 10px;
        border: none;
        font-size: 14px;
    }

    .alert-success {
        background: #f0fff4;
        color: #276749;
        border-left: 4px solid #48bb78;
    }

    .alert-danger {
        background: #fff5f5;
        color: #9b2c2c;
        border-left: 4px solid #f56565;
    }

    /* Detail Section */
    .profile-detail-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .profile-detail-section h6 {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
    }

    .profile-detail-section h6 i {
        color: #667eea;
        margin-right: 8px;
    }

    .profile-detail-item {
        display: flex;
        align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .profile-detail-item:last-child {
        border-bottom: none;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        flex-shrink: 0;
        font-size: 16px;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        font-size: 12px;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        color: #2d3748;
        font-weight: 500;
    }

    .detail-value .text-muted {
        color: #a0aec0;
        font-weight: 400;
    }

    .detail-icon-primary { background: #4299e1; }
    .detail-icon-success { background: #48bb78; }
    .detail-icon-warning { background: #ed8936; }
    .detail-icon-purple { background: #9f7aea; }
    .detail-icon-pink { background: #ed64a6; }
    .detail-icon-orange { background: #ed8936; }

    /* Bio */
    .bio-text {
        font-size: 15px;
        line-height: 1.8;
        color: #4a5568;
    }

    /* Social Media */
    .social-links {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        color: white;
    }

    .social-instagram { background: #E4405F; }
    .social-facebook { background: #1877F2; }
    .social-twitter { background: #1DA1F2; }
    .social-linkedin { background: #0A66C2; }

    /* Tombol Aksi */
    .profile-actions {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .profile-actions .btn-action {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .profile-actions .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-header {
            padding: 25px;
            text-align: center;
        }

        .profile-info h2 {
            margin-top: 15px;
            font-size: 24px;
        }

        .profile-avatar-wrapper {
            margin-bottom: 10px;
        }

        .profile-body {
            padding: 20px;
        }

        .profile-detail-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-icon {
            margin-bottom: 10px;
        }

        .profile-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .profile-actions .btn-action {
            justify-content: center;
        }
    }
</style>

<div class="profile-wrapper">
    <div class="profile-card">
        <!-- Header Profile -->
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <div class="profile-avatar-wrapper">
                        @if($user->foto_profil && file_exists(public_path('uploads/profil/' . $user->foto_profil)))
                            <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" 
                                 alt="{{ $user->name }}" 
                                 class="profile-avatar-img">
                        @else
                            <div class="profile-avatar-initial" style="background: {{ $user->avatar_color }};">
                                {{ $user->initials }}
                            </div>
                        @endif
                        <span class="avatar-badge">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-9 profile-info">
                    <h2>{{ $user->name }}</h2>
                    <div class="text-muted-profile mb-2">
                        <i class="fas fa-envelope me-2"></i> {{ $user->email }}
                    </div>
                    @if($user->no_telp)
                        <div class="text-muted-profile mb-2">
                            <i class="fas fa-phone me-2"></i> {{ $user->no_telp }}
                        </div>
                    @endif
                    <div class="mb-2">
                        <span class="badge-role-profile {{ $user->role === 'super_admin' ? 'badge-role-superadmin' : 'badge-role-panitia' }}">
                            <i class="fas fa-user-tag me-1"></i> {{ $user->role_label }}
                        </span>
                    </div>
                    <div class="badge-status">
                        <i class="fas fa-circle"></i> Active
                    </div>
                </div>
            </div>
        </div>

        <!-- Body Card -->
        <div class="profile-body">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Informasi Detail -->
            <div class="profile-detail-section">
                <h6><i class="fas fa-info-circle"></i> Informasi Detail</h6>
                
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-primary">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Nama Lengkap</div>
                                <div class="detail-value">{{ $user->name }}</div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-success">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-warning">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">No. Telepon</div>
                                <div class="detail-value">{{ $user->no_telp ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-purple">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Jabatan</div>
                                <div class="detail-value">{{ $user->jabatan ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-pink">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Role</div>
                                <div class="detail-value">
                                    <span class="badge-role-profile {{ $user->role === 'super_admin' ? 'badge-role-superadmin' : 'badge-role-panitia' }}">
                                        {{ $user->role_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-orange">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Tanggal Bergabung</div>
                                <div class="detail-value">{{ $user->created_at->format('d F Y') }}</div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-success">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Terakhir Update</div>
                                <div class="detail-value">{{ $user->updated_at->format('d F Y, H:i') }}</div>
                            </div>
                        </div>

                        <div class="profile-detail-item">
                            <div class="detail-icon detail-icon-primary">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">ID User</div>
                                <div class="detail-value"><span class="text-muted">#{{ $user->id }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bio Section -->
            @if($user->bio)
            <div class="profile-detail-section mt-3">
                <h6><i class="fas fa-quote-left"></i> Bio</h6>
                <p class="bio-text mb-0">{{ $user->bio }}</p>
            </div>
            @endif

            <!-- Social Media Section -->
            @if($user->instagram || $user->facebook || $user->twitter || $user->linkedin)
            <div class="profile-detail-section mt-3">
                <h6><i class="fas fa-share-alt"></i> Media Sosial</h6>
                <div class="social-links">
                    @if($user->instagram)
                        <a href="{{ $user->instagram }}" target="_blank" class="social-link social-instagram">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    @endif
                    @if($user->facebook)
                        <a href="{{ $user->facebook }}" target="_blank" class="social-link social-facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                    @endif
                    @if($user->twitter)
                        <a href="{{ $user->twitter }}" target="_blank" class="social-link social-twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    @endif
                    @if($user->linkedin)
                        <a href="{{ $user->linkedin }}" target="_blank" class="social-link social-linkedin">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-action">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-action">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <button type="button" class="btn btn-outline-danger btn-action" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="logoutModalLabel">
                    <i class="fas fa-sign-out-alt text-danger me-2"></i> Konfirmasi Logout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-question-circle" style="font-size: 60px; color: #667eea;"></i>
                </div>
                <h5 class="mb-2">Yakin ingin logout?</h5>
                <p class="text-muted">Anda akan keluar dari sistem dan perlu login kembali untuk mengakses dashboard.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-sign-out-alt me-1"></i> Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection