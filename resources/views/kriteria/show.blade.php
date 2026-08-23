@extends('layouts.master')

@section('title', 'Detail Kriteria')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Detail Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Nama Kriteria</label>
                            <p class="fw-bold">{{ $kriteria->nama_kriteria }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Bobot</label>
                            <p class="fw-bold">{{ $kriteria->bobot }}%</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Tipe</label>
                            <p><span class="badge bg-info">{{ ucfirst($kriteria->tipe) }}</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Status</label>
                            <p>
                                <span class="badge {{ $kriteria->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $kriteria->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                @if($kriteria->tipe == 'skala')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Skala Minimum</label>
                            <p class="fw-bold">{{ $kriteria->skala_min }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Skala Maksimum</label>
                            <p class="fw-bold">{{ $kriteria->skala_max }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($kriteria->deskripsi)
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Deskripsi</label>
                    <p>{{ $kriteria->deskripsi }}</p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Dibuat</label>
                            <p>{{ $kriteria->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Diupdate</label>
                            <p>{{ $kriteria->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('kriteria.edit', $kriteria->id_kriteria) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection