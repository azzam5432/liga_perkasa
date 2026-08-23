@extends('layouts.master')

@section('title', 'Detail Penugasan Juri')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Detail Penugasan Juri</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Juri</label>
                            <p class="fw-bold">
                                {{ $penugasan->juri->user->name ?? '-' }}
                                <br>
                                <small class="text-muted">{{ $penugasan->juri->spesialisasi ?? '-' }}</small>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Lomba</label>
                            <p class="fw-bold">{{ $penugasan->lomba->nama_lomba ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Status</label>
                            <p>
                                <span class="badge {{ $penugasan->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($penugasan->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Tanggal Dibuat</label>
                            <p>{{ $penugasan->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($penugasan->catatan)
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Catatan</label>
                    <p>{{ $penugasan->catatan }}</p>
                </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('juri_lomba.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('juri_lomba.edit', $penugasan->id_juri_lomba) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection