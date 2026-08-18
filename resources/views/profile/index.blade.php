@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<style>
    /* Profile Page Styles */
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar-wrapper .avatar-icon {
        font-size: 120px;
        color: white;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
        transition: transform 0.3s ease;
    }

    .profile-avatar-wrapper .avatar-icon:hover {
        transform: scale(1.05) rotate(-5deg);
    }

    .profile-avatar-wrapper .avatar-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
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

    .profile-info .join-date {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-top: 8px;
    }

    .profile-info .join-date i {
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

    @media (max-width: 768px) {
        .profile-header {
            padding: 20px;
        }

        .profile-avatar-wrapper .avatar-icon {
            font-size: 80px;
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
    }
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card border-0 shadow-lg overflow-hidden">
            <!-- Header Profile dengan Gradient -->
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center text-md-start">
                        <div class="profile-avatar-wrapper">
                            <i class="fas fa-user-circle avatar-icon"></i>
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
                                <div class="stat-number">5</div>
                                <div class="stat-label">Total Tim</div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-user-friends"></i>
                                </span>
                                <div class="stat-number">12</div>
                                <div class="stat-label">Total Peserta</div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-trophy"></i>
                                </span>
                                <div class="stat-number">3</div>
                                <div class="stat-label">Lomba Diikuti</div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="stat-card">
                                <span class="stat-icon">
                                    <i class="fas fa-medal"></i>
                                </span>
                                <div class="stat-number">2</div>
                                <div class="stat-label">Penghargaan</div>
                            </div>
                        </div>
                    </div>
                </div>

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

<!-- Modal Logout Konfirmasi -->
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