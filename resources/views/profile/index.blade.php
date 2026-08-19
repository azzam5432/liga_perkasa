@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #1a2332 0%, #2d3748 100%);
        border-radius: 15px 15px 0 0;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    /* Avatar dengan foto */
    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    .profile-avatar-img:hover {
        transform: scale(1.05);
    }

    /* Avatar dengan inisial */
    .profile-avatar-initial {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        color: white;
        border: 4px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin: 0 auto;
    }

    .profile-avatar-initial:hover {
        transform: scale(1.05);
    }

    .profile-avatar-wrapper .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .profile-info h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 5px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .profile-info .user-email {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    .profile-info .user-email i {
        margin-right: 8px;
    }

    .profile-info .user-phone {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
        margin-top: 5px;
    }

    .profile-info .user-phone i {
        margin-right: 8px;
    }

    .profile-info .join-date {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-top: 5px;
    }

    .profile-info .join-date i {
        margin-right: 8px;
    }

    .profile-info .user-role {
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        margin-top: 5px;
    }

    .profile-info .user-role i {
        margin-right: 8px;
    }

    .profile-stats {
        margin-top: -30px;
        position: relative;
        z-index: 2;
    }

    .profile-stats .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: none;
        cursor: default;
    }

    .profile-stats .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .profile-stats .stat-card .stat-icon {
        font-size: 32px;
        color: #667eea;
        margin-bottom: 10px;
        display: block;
    }

    .profile-stats .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .profile-stats .stat-card .stat-label {
        color: #718096;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-stats .stat-card:nth-child(1) .stat-icon {
        color: #4299e1;
    }

    .profile-stats .stat-card:nth-child(2) .stat-icon {
        color: #48bb78;
    }

    .profile-stats .stat-card:nth-child(3) .stat-icon {
        color: #ed8936;
    }

    .profile-stats .stat-card:nth-child(4) .stat-icon {
        color: #9f7aea;
    }

    /* Informasi Detail Profile */
    .profile-detail-section {
        background: #f7fafc;
        border-radius: 12px;
        padding: 20px;
        margin-top: 25px;
    }

    .profile-detail-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .profile-detail-item:last-child {
        border-bottom: none;
    }

    .profile-detail-item .detail-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .profile-detail-item .detail-content {
        flex: 1;
    }

    .profile-detail-item .detail-content .detail-label {
        font-size: 12px;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .profile-detail-item .detail-content .detail-value {
        font-size: 15px;
        color: #2d3748;
        font-weight: 500;
        margin-top: 2px;
    }

    .profile-detail-item .detail-content .detail-value .text-muted {
        color: #a0aec0;
        font-weight: 400;
    }

    .detail-icon-primary { background: #4299e1; }
    .detail-icon-success { background: #48bb78; }
    .detail-icon-warning { background: #ed8936; }
    .detail-icon-purple { background: #9f7aea; }
    .detail-icon-pink { background: #ed64a6; }
    .detail-icon-orange { background: #ed8936; }

    /* Social Media */
    .social-links {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 5px;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 15px;
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
    .social-youtube { background: #FF0000; }
    .social-github { background: #333333; }

    .profile-actions {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .profile-actions .btn-action {
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-actions .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .badge-status {
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
    }

    .badge-role-profile {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-role-superadmin {
        background: linear-gradient(135deg, #1a2332, #2d3748);
        color: white;
    }

    .badge-role-panitia {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 20px;
        }

        .profile-avatar-img,
        .profile-avatar-initial {
            width: 80px;
            height: 80px;
            font-size: 32px;
        }

        .profile-info h2 {
            font-size: 24px;
            margin-top: 15px;
        }

        .profile-stats .stat-card .stat-number {
            font-size: 22px;
        }

        .profile-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .profile-actions .btn-action {
            justify-content: center;
        }

        .profile-detail-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-detail-item .detail-icon {
            margin-bottom: 8px;
        }

        .social-links {
            flex-direction: column;
        }

        .social-link {
            justify-content: center;
        }
    }
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center text-md-start">
                        <div class="profile-avatar-wrapper">
                            @if($user->foto_profil && file_exists(public_path('uploads/profil/' . $user->foto_profil)))
                                <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" 
                                     alt="{{ $user->name }}" 
                                     class="profile-avatar-img">
                            @else
                                <div class="profile-avatar-initial" 
                                     style="background: {{ $user->avatar_color }};">
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
                        <div class="user-email">
                            <i class="fas fa-envelope"></i> {{ $user->email }}
                        </div>
                        @if($user->no_telp)
                        <div class="user-phone">
                            <i class="fas fa-phone"></i> {{ $user->no_telp }}
                        </div>
                        @endif
                        <div class="user-role">
                            <i class="fas fa-user-tag"></i> 
                            <span class="badge-role-profile {{ $user->role === 'super_admin' ? 'badge-role-superadmin' : 'badge-role-panitia' }}">
                                {{ $user->role_label }}
                            </span>
                        </div>
                        <div class="join-date">
                            <i class="fas fa-calendar-alt"></i> Bergabung {{ $user->created_at->format('d F Y') }}
                        </div>
                        <div class="mt-3">
                            <span class="badge-status">
                                <i class="fas fa-circle" style="font-size: 8px; margin-right: 6px; vertical-align: middle;"></i>
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Card -->
            <div class="card-body" style="padding: 30px;">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Statistik -->
                <div class="profile-stats">
                    <div class="row g-3">
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <div class="stat-number">{{ $totalTim ?? 0 }}</div>
                                <div class="stat-label">Total Tim</div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-user-friends"></i>
                                </span>
                                <div class="stat-number">{{ $totalPeserta ?? 0 }}</div>
                                <div class="stat-label">Total Peserta</div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-trophy"></i>
                                </span>
                                <div class="stat-number">{{ $totalLomba ?? 0 }}</div>
                                <div class="stat-label">Total Lomba</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Profile -->
                <div class="profile-detail-section">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Informasi Detail</h6>
                    
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
                                    <div class="detail-value">{{ $user->created_at->format('d F Y, H:i') }}</div>
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
                    <h6 class="fw-bold mb-3"><i class="fas fa-quote-left me-2 text-primary"></i> Bio</h6>
                    <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.8;">{{ $user->bio }}</p>
                </div>
                @endif

                <!-- Social Media Section -->
                @if($user->instagram || $user->facebook || $user->twitter || $user->linkedin)
                <div class="profile-detail-section mt-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-share-alt me-2 text-primary"></i> Media Sosial</h6>
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
</div>

<!-- Logout -->
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