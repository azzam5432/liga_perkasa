@extends('layouts.master')

@section('title', 'Edit Tim')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Tim</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Ada kesalahan:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @php
                    $ketua = $tim->pesertas->whereNotNull('ketua_peserta')->first();
                    $anggota = $tim->pesertas->whereNull('ketua_peserta');
                @endphp

                <form action="{{ route('admin.update', $tim->id_tim) }}" method="POST" id="formEditTim">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nama Tim -->
                    <div class="mb-4">
                        <label for="nama_tim" class="form-label fw-bold">
                            <i class="fas fa-trophy text-primary me-1"></i> Nama Tim <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_tim') is-invalid @enderror" 
                               id="nama_tim" 
                               name="nama_tim" 
                               value="{{ old('nama_tim', $tim->nama_tim) }}" 
                               placeholder="Masukkan Nama Tim" 
                               required>
                        @error('nama_tim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data Ketua -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-user-tie text-primary me-2"></i> Data Ketua Tim</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ketua_peserta" class="form-label fw-bold">
                                        Nama Ketua <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ketua_peserta') is-invalid @enderror" 
                                           id="ketua_peserta" 
                                           name="ketua_peserta" 
                                           value="{{ old('ketua_peserta', $ketua->ketua_peserta ?? '') }}" 
                                           placeholder="Masukkan Nama Ketua" 
                                           required>
                                    @error('ketua_peserta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prodi" class="form-label fw-bold">
                                        Program Studi <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('prodi') is-invalid @enderror" 
                                            id="prodi" 
                                            name="prodi" 
                                            required>
                                        <option value="">Pilih Program Studi</option>
                                        <option value="Teknologi Rekayasa Perangkat Lunak" {{ old('prodi', $ketua->prodi ?? '') == 'Teknologi Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Teknologi Rekayasa Perangkat Lunak</option>
                                        <option value="Bisnis Digital" {{ old('prodi', $ketua->prodi ?? '') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                                        <option value="Teknik Komputer" {{ old('prodi', $ketua->prodi ?? '') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                                    </select>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="no_telp" class="form-label fw-bold">
                                        No. Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('no_telp') is-invalid @enderror" 
                                           id="no_telp" 
                                           name="no_telp" 
                                           value="{{ old('no_telp', $ketua->no_telp ?? '') }}" 
                                           placeholder="Masukkan No. Telepon" 
                                           required>
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Anggota -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-users text-primary me-2"></i> Daftar Anggota</h6>
                            <span class="badge bg-info text-white" id="totalAnggota">{{ $anggota->count() }} Anggota</span>
                        </div>
                        <div class="card-body">
                            <div id="participant-list">
                                @forelse ($anggota as $index => $peserta)
                                <div class="participant-item d-flex align-items-center gap-2 mb-2" data-index="{{ $index + 2 }}">
                                    <div class="flex-grow-1">
                                        <label class="form-label mb-0 small fw-bold text-primary">
                                            <i class="fas fa-user me-1"></i> Anggota {{ $index + 1 }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               name="nama_peserta[]" 
                                               value="{{ old('nama_peserta.' . $index, $peserta->nama_peserta) }}" 
                                               placeholder="Masukkan Nama Anggota {{ $index + 2 }}" 
                                               required>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-3 text-muted">
                                    <i class="fas fa-users fa-2x d-block mb-2"></i>
                                    Belum ada anggota
                                </div>
                                @endforelse
                            </div>

                            <!-- Tombol Tambah di Bawah -->
                            <div class="mt-3 text-center">
                                <button type="button" class="btn btn-success btn-sm rounded-pill px-4" onclick="addParticipant()">
                                    <i class="fas fa-plus me-1"></i> Tambah Anggota
                                </button>
                            </div>
                            
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Minimal 4 anggota (total minimal 5 peserta), maksimal 19 anggota (total maksimal 20 peserta)
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-white rounded-pill px-4" style="background: linear-gradient(135deg, #f6c23e, #dda20a); border: none;">
                            <i class="fas fa-save me-1"></i> Update Tim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const participantList = document.getElementById('participant-list');
    const totalAnggota = document.getElementById('totalAnggota');
    let participantCount = participantList.querySelectorAll('.participant-item').length + 1; // +1 karena ketua
    
    // Update total anggota
    function updateTotalAnggota() {
        const items = participantList.querySelectorAll('.participant-item');
        const count = items.length;
        totalAnggota.textContent = count + ' Anggota';
        
        // Sembunyikan tombol hapus jika hanya 1 anggota
        const removeButtons = participantList.querySelectorAll('.btn-remove');
        if (count <= 1) {
            removeButtons.forEach(btn => btn.style.display = 'none');
        } else {
            removeButtons.forEach(btn => btn.style.display = 'block');
        }
    }
    
    // Renumber semua anggota
    function renumberParticipants() {
        const items = participantList.querySelectorAll('.participant-item');
        items.forEach((item, index) => {
            const num = index + 2;
            const label = item.querySelector('label');
            const input = item.querySelector('input');
            if (label) {
                label.innerHTML = `<i class="fas fa-user me-1"></i> Anggota ${num} <span class="text-danger">*</span>`;
            }
            if (input) {
                input.placeholder = `Masukkan Nama Anggota ${num}`;
            }
            item.setAttribute('data-index', num);
        });
        
        if (items.length > 0) {
            const lastIndex = parseInt(items[items.length - 1].getAttribute('data-index'));
            participantCount = lastIndex;
        } else {
            participantCount = 1;
        }
    }
    
    // Fungsi tambah anggota
    window.addParticipant = function() {
        const totalItems = participantList.querySelectorAll('.participant-item').length;
        
        // Cek batas maksimal (1 ketua + 19 anggota = 20 total)
        if (totalItems >= 19) {
            alert('Maksimal 19 anggota (total 20 peserta)!');
            return;
        }
        
        participantCount++;
        const newIndex = participantCount;
        
        const div = document.createElement('div');
        div.className = 'participant-item d-flex align-items-center gap-2 mb-2';
        div.setAttribute('data-index', newIndex);
        
        div.innerHTML = `
            <div class="flex-grow-1">
                <label class="form-label mb-0 small fw-bold text-primary">
                    <i class="fas fa-user me-1"></i> Anggota ${newIndex} <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control form-control-sm" 
                       name="nama_peserta[]" 
                       placeholder="Masukkan Nama Anggota ${newIndex}"
                       required>
            </div>
            <button type="button" class="btn btn-danger btn-sm btn-remove" onclick="removeParticipant(this)" title="Hapus Anggota">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        participantList.appendChild(div);
        updateTotalAnggota();
    };
    
    // Fungsi hapus anggota
    window.removeParticipant = function(button) {
        const div = button.closest('.participant-item');
        if (!div) return;
        
        const items = participantList.querySelectorAll('.participant-item');
        
        // Minimal 1 anggota (selain ketua)
        if (items.length <= 1) {
            alert('Minimal harus ada 1 anggota (selain ketua)!');
            return;
        }
        
        // Konfirmasi hapus
        if (!confirm('Yakin ingin menghapus anggota ini?')) {
            return;
        }
        
        div.remove();
        
        // Renumber semua anggota setelah dihapus
        renumberParticipants();
        updateTotalAnggota();
    };
    
    // Inisialisasi total anggota
    updateTotalAnggota();
});

// Validasi sebelum submit
document.getElementById('formEditTim').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.participant-item');
    const total = items.length + 1; // +1 untuk ketua
    
    if (total < 5) {
        e.preventDefault();
        alert('Minimal total peserta 5 orang (1 ketua + minimal 4 anggota)!');
        return false;
    }
    
    if (total > 20) {
        e.preventDefault();
        alert('Maksimal total peserta 20 orang (1 ketua + maksimal 19 anggota)!');
        return false;
    }
    
    // Cek semua input tidak kosong
    let empty = false;
    items.forEach(item => {
        const input = item.querySelector('input');
        if (input && input.value.trim() === '') {
            empty = true;
            input.classList.add('is-invalid');
        } else if (input) {
            input.classList.remove('is-invalid');
        }
    });
    
    // Cek input ketua
    const ketuaInput = document.querySelector('input[name="ketua_peserta"]');
    if (ketuaInput && ketuaInput.value.trim() === '') {
        empty = true;
        ketuaInput.classList.add('is-invalid');
    }
    
    if (empty) {
        e.preventDefault();
        alert('Semua nama peserta harus diisi!');
        return false;
    }
    
    return true;
});
</script>

<style>
    /* Gradient Header */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #f6c23e, #dda20a) !important;
    }
    
    /* Form Control Focus */
    .form-control:focus, .form-select:focus {
        border-color: #f6c23e;
        box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
    }
    
    /* Card Hover */
    .card.shadow-sm {
        transition: box-shadow 0.3s ease;
    }
    
    .card.shadow-sm:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }
    
    /* Button Styles */
    .btn-warning {
        background: linear-gradient(135deg, #f6c23e, #dda20a) !important;
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(246, 194, 62, 0.4);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.4);
    }
    
    .btn-secondary {
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(108, 117, 125, 0.3);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(40, 167, 69, 0.4);
    }
    
    .btn-danger {
        transition: all 0.2s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(220, 53, 69, 0.4);
    }
    
    /* Participant Item Animation */
    .participant-item {
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Input invalid */
    .participant-item input.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Responsive */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
        }
        
        .form-control-sm {
            font-size: 0.8rem;
        }
        
        .participant-item {
            flex-wrap: wrap;
        }
        
        .participant-item .btn-remove {
            margin-left: auto;
        }
    }
</style>
@endsection