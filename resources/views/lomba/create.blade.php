{{-- resources/views/lomba/create.blade.php --}}
@extends('layouts.master')

@section('title', 'Tambah Lomba')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 0 16px 0;
        border-bottom: 1px solid #edf2f7;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h4 {
        font-weight: 700;
        color: #1a2332;
        margin: 0;
        font-size: 20px;
    }

    .form-section {
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #edf2f7;
        padding: 24px;
    }

    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #1a2332;
    }

    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a365d;
        box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.06);
    }

    .jenis-card {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .jenis-card:hover {
        border-color: #1a365d;
        background: #f7fafc;
    }

    .jenis-card.selected {
        border-color: #1a365d;
        background: #ebf8ff;
    }

    .jenis-card .jenis-icon {
        font-size: 32px;
        color: #1a365d;
        margin-bottom: 8px;
        display: block;
    }

    .jenis-card .jenis-title {
        font-weight: 600;
        color: #1a2332;
    }

    .jenis-card .jenis-desc {
        font-size: 13px;
        color: #718096;
    }

    .btn-secondary-custom {
        background: #edf2f7;
        border: none;
        color: #4a5568;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-secondary-custom:hover {
        background: #e2e8f0;
    }

    .btn-primary-custom {
        background: #1a365d;
        border: none;
        color: #ffffff;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
        background: #2b6cb0;
    }

    @media (max-width: 768px) {
        .jenis-card .jenis-icon {
            font-size: 24px;
        }
        .jenis-card .jenis-title {
            font-size: 13px;
        }
        .jenis-card .jenis-desc {
            font-size: 11px;
        }
    }
</style>

<div class="page-header">
    <h4><i class="fas fa-plus-circle me-2"></i> Tambah Lomba</h4>
    <a href="{{ route('lomba.index') }}" class="btn-secondary-custom">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="form-section">
    <form action="{{ route('lomba.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_lomba" class="form-label">Nama Lomba <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_lomba') is-invalid @enderror" 
                   id="nama_lomba" name="nama_lomba" value="{{ old('nama_lomba') }}" required>
            @error('nama_lomba')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                           id="kategori" name="kategori" value="{{ old('kategori') }}" placeholder="Contoh: Akademik, Teknologi, Seni">
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Lomba <span class="text-danger">*</span></label>
                    <div class="row g-2" id="jenisContainer">
                        <div class="col-4">
                            <div class="jenis-card" data-value="langsung" onclick="pilihJenis(this)">
                                <span class="jenis-icon">🏆</span>
                                <div class="jenis-title">Langsung</div>
                                <div class="jenis-desc">Tanpa babak</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="jenis-card" data-value="penyisihan" onclick="pilihJenis(this)">
                                <span class="jenis-icon">📊</span>
                                <div class="jenis-title">Penyisihan</div>
                                <div class="jenis-desc">Ada babak penyisihan</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="jenis-card" data-value="final" onclick="pilihJenis(this)">
                                <span class="jenis-icon">👑</span>
                                <div class="jenis-title">Final</div>
                                <div class="jenis-desc">Babak final</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="jenis" name="jenis" value="langsung">
                    @error('jenis')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                           id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                           id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('lomba.index') }}" class="btn-secondary-custom">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn-primary-custom">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
function pilihJenis(element) {
    document.querySelectorAll('.jenis-card').forEach(card => {
        card.classList.remove('selected');
    });
    element.classList.add('selected');
    document.getElementById('jenis').value = element.dataset.value;
}

document.addEventListener('DOMContentLoaded', function() {
    const defaultCard = document.querySelector('.jenis-card[data-value="langsung"]');
    if (defaultCard) {
        defaultCard.classList.add('selected');
    }
});
</script>
@endsection