{{-- resources/views/lomba/show.blade.php --}}
@extends('layouts.master')

@section('title', 'Detail Lomba - ' . $lomba->nama_lomba)

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

    .detail-card {
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #edf2f7;
        padding: 24px;
    }

    .detail-label {
        color: #718096;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 500;
        color: #1a2332;
        margin-top: 4px;
    }
</style>

<div class="page-header">
    <h4><i class="fas fa-trophy me-2"></i> {{ $lomba->nama_lomba }}</h4>
    <a href="{{ route('lomba.index') }}" class="btn-secondary-custom" style="background: #edf2f7; border: none; color: #4a5568; padding: 8px 20px; border-radius: 8px; font-weight: 600; text-decoration: none;">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="detail-card">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Nama Lomba</div>
                <div class="detail-value">{{ $lomba->nama_lomba }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Kategori</div>
                <div class="detail-value">{{ $lomba->kategori ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Jenis Lomba</div>
                <div class="detail-value">
                    <span class="badge-jenis badge-jenis-{{ $lomba->jenis }}">
                        {{ $lomba->jenis_label }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge-status badge-status-{{ $lomba->status }}">
                        <span class="dot"></span>
                        {{ $lomba->status_label }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Tanggal Mulai</div>
                <div class="detail-value">{{ $lomba->tanggal_mulai ? \Carbon\Carbon::parse($lomba->tanggal_mulai)->format('d F Y') : '-' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <div class="detail-label">Tanggal Selesai</div>
                <div class="detail-value">{{ $lomba->tanggal_selesai ? \Carbon\Carbon::parse($lomba->tanggal_selesai)->format('d F Y') : '-' }}</div>
            </div>
        </div>
    </div>

    @if($lomba->deskripsi)
    <div class="mb-3">
        <div class="detail-label">Deskripsi</div>
        <div class="detail-value">{{ $lomba->deskripsi }}</div>
    </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="detail-label">Jumlah Juri</div>
            <div class="detail-value">{{ $lomba->juri->count() }}</div>
        </div>
        <div class="col-md-4">
            <div class="detail-label">Jumlah Finalis</div>
            <div class="detail-value">{{ $lomba->finalis->count() }}</div>
        </div>
        <div class="col-md-4">
            <div class="detail-label">Jumlah Kriteria</div>
            <div class="detail-value">{{ $lomba->kriterias->count() }}</div>
        </div>
    </div>
</div>

@if(Auth::user()->isSuperAdmin())
<div class="mt-4">
    <div class="d-flex gap-2">
        <a href="{{ route('lomba.edit', $lomba->id_lomba) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit Lomba
        </a>
        <a href="{{ route('lomba.finalis', $lomba->id_lomba) }}" class="btn btn-info">
            <i class="fas fa-users me-1"></i> Kelola Finalis
        </a>
    </div>
</div>
@endif
@endsection