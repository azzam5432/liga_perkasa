@extends('layouts.master')

@section('title', 'Detail Penilaian')

@section('content')
<style>
    .nilai-display {
        font-size: 48px;
        font-weight: 700;
        color: #667eea;
        text-align: center;
        padding: 20px;
        background: #f7fafc;
        border-radius: 12px;
    }
</style>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Detail Penilaian</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Tim</label>
                            <p class="fw-bold">{{ $penilaian->tim->nama_tim ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Juri</label>
                            <p class="fw-bold">{{ $penilaian->juri->user->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Kriteria</label>
                            <p class="fw-bold">{{ $penilaian->kriteria->nama_kriteria ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Status</label>
                            <p>
                                <span class="badge {{ $penilaian->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($penilaian->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold">Nilai</label>
                    <div class="nilai-display">
                        {{ $penilaian->nilai !== null ? $penilaian->nilai : 'Belum Dinilai' }}
                    </div>
                </div>

                @if($penilaian->komentar)
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Komentar</label>
                    <p class="fw-bold">{{ $penilaian->komentar }}</p>
                </div>
                @endif

                @if($penilaian->dokumen_pendukung)
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Dokumen Pendukung</label>
                    <p>
                        <a href="{{ asset('uploads/penilaian/' . $penilaian->dokumen_pendukung) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file me-1"></i> Lihat Dokumen
                        </a>
                    </p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Dibuat</label>
                            <p>{{ $penilaian->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Diupdate</label>
                            <p>{{ $penilaian->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('penilaian.edit', $penilaian->id_penilaian) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection