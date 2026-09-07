@extends('layouts.master')

@section('title', 'Edit Profile')

@section('content')
<style>
    .edit-profile-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .edit-profile-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .edit-profile-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px 30px;
        border-bottom: 1px solid #e9ecef;
    }

    .edit-profile-header h5 {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .edit-profile-body {
        padding: 30px;
    }

    /* Tabs */
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 25px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #718096;
        font-weight: 600;
        padding: 12px 20px;
        margin-bottom: -2px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
        border: none;
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        border-bottom: 3px solid #667eea;
        background: transparent;
    }

    .nav-tabs .nav-link i {
        margin-right: 6px;
    }

    /* Form */
    .form-label {
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        background: #ffffff;
    }

    /* Upload Foto */
    .photo-upload-section {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .photo-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        font-size: 30px;
        overflow: hidden;
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-upload-actions {
        flex: 1;
    }

    .btn-upload-photo {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-upload-photo:hover {
        background: #5a67d8;
        transform: translateY(-1px);
    }

    .photo-hint {
        font-size: 12px;
        color: #a0aec0;
        margin-top: 8px;
        display: block;
    }

    /* Input Password Group */
    .password-group {
        position: relative;
    }

    .password-group .form-control {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #a0aec0;
        cursor: pointer;
        font-size: 16px;
        transition: color 0.3s;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    /* Alert */
    .alert {
        border-radius: 10px;
        border: none;
        font-size: 14px;
        padding: 15px 20px;
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

    /* Tombol Aksi */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .btn-action {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary-action {
        background: #f8f9fa;
        border: 1px solid #e2e8f0;
        color: #4a5568;
    }

    .btn-secondary-action:hover {
        background: #e2e8f0;
        color: #2d3748;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .edit-profile-header {
            padding: 20px;
        }

        .edit-profile-body {
            padding: 20px;
        }

        .photo-upload-section {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="edit-profile-wrapper">
    <div class="edit-profile-card">
        <!-- Header -->
        <div class="edit-profile-header">
            <h5><i class="fas fa-user-edit me-2" style="color: #667eea;"></i> Edit Profile</h5>
        </div>

        <!-- Body -->
        <div class="edit-profile-body">
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

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">
                        <i class="fas fa-key"></i> Password
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Tab Edit Profile -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Upload Foto -->
                        <div class="photo-upload-section">
                            <div class="photo-preview" id="photoPreview">
                                @if($user->foto_profil && file_exists(public_path('uploads/profil/' . $user->foto_profil)))
                                    <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" alt="Foto Profil">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="photo-upload-actions">
                                <label for="foto_profil" class="btn-upload-photo">
                                    <i class="fas fa-camera"></i> Pilih Foto
                                </label>
                                <input type="file" 
                                       id="foto_profil" 
                                       name="foto_profil" 
                                       class="d-none" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                <span class="photo-hint">Format: JPG, PNG, JPEG. Maksimal 2MB.</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_telp" class="form-label fw-bold">No. Telepon</label>
                            <input type="text" 
                                   class="form-control @error('no_telp') is-invalid @enderror" 
                                   id="no_telp" 
                                   name="no_telp" 
                                   value="{{ old('no_telp', $user->no_telp) }}">
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                            <input type="text" 
                                   class="form-control @error('jabatan') is-invalid @enderror" 
                                   id="jabatan" 
                                   name="jabatan" 
                                   value="{{ old('jabatan', $user->jabatan) }}">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary-action btn-action">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-action">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab Ganti Password -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Password Saat Ini</label>
                            <div class="password-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword('current_password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Password Baru</label>
                            <div class="password-group">
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password" 
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword('new_password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <div class="password-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation" 
                                       required>
                                <button type="button" class="password-toggle" onclick="togglePassword('new_password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary-action btn-action">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning btn-action">
                                <i class="fas fa-key"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview Foto Sebelum Upload
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Foto Profil">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle Show/Hide Password
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection