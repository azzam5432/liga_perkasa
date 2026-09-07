@extends('layouts.master')

@section('title', 'Finalis - ' . $lomba->nama_lomba)

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

.btn-primary-custom {
    background: #1a365d;
    border: none;
    color: #ffffff;
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    cursor: pointer;
}

.btn-primary-custom:hover {
    background: #2b6cb0;
    color: #ffffff;
}

.btn-secondary-custom {
    background: #edf2f7;
    border: none;
    color: #4a5568;
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary-custom:hover {
    background: #e2e8f0;
}

.btn-activate-final {
    background: #48bb78;
    border: none;
    color: white;
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.btn-activate-final:hover {
    background: #38a169;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
}

.card-header-custom {
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
    padding: 14px 20px;
    font-weight: 600;
    color: #1a2332;
    font-size: 15px;
}

.table-wrapper {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid #edf2f7;
    overflow: hidden;
}

.table-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-scroll table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
    font-size: 14px;
    min-width: 600px;
}

.table-scroll table thead th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 10px 14px;
    border-bottom: 2px solid #edf2f7;
    text-align: left;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table-scroll table tbody td {
    padding: 10px 14px;
    vertical-align: middle;
    color: #2d3748;
    border-bottom: 1px solid #f7fafc;
}

.table-scroll table tbody tr:last-child td {
    border-bottom: none;
}

.table-scroll table tbody tr:hover {
    background: #f7fafc;
}

.empty-state {
    padding: 40px 16px;
    text-align: center;
}

.empty-state i {
    font-size: 40px;
    color: #e2e8f0;
    margin-bottom: 12px;
    display: block;
}

.empty-state h6 {
    color: #1a2332;
    font-weight: 600;
    margin-bottom: 4px;
    font-size: 16px;
}

.empty-state p {
    color: #a0aec0;
    font-size: 13px;
    margin-bottom: 14px;
}

.modal-custom .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.modal-custom .modal-header {
    border-bottom: 1px solid #edf2f7;
    padding: 16px 24px;
}

.modal-custom .modal-header .modal-title {
    font-weight: 700;
    color: #1a2332;
    font-size: 18px;
}

.modal-custom .modal-body {
    padding: 24px;
    text-align: center;
}

.modal-custom .modal-footer {
    border-top: 1px solid #edf2f7;
    padding: 16px 24px;
}

.modal-custom .btn-secondary-custom {
    background: #edf2f7;
    border: none;
    color: #4a5568;
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.modal-custom .btn-secondary-custom:hover {
    background: #e2e8f0;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .page-header h4 {
        font-size: 18px;
    }
    .table-scroll table {
        font-size: 13px;
        min-width: 500px;
    }
    .card-header-custom {
        padding: 10px 14px;
    }
}
</style>

<div class="page-header">
    <h4><i class="fas fa-trophy me-2"></i> Finalis - {{ $lomba->nama_lomba }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('lomba.index') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        @if($lomba->is_final_active)
            <a href="{{ route('nilai.create', $lomba->id_lomba) }}" class="btn-primary-custom">
                <i class="fas fa-pen"></i> Nilai Final
            </a>
        @endif

        @if($lomba->finalis()->count() > 0 && !$lomba->is_final_active)
            <form action="{{ route('finalis.aktifkan-final', $lomba->id_lomba) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-activate-final">
                    <i class="fas fa-play"></i> Aktifkan Final
                </button>
            </form>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Info:</strong> Finalis ditentukan otomatis dari nilai penyisihan tertinggi.
    @if($lomba->is_final_active)
        <span>Babak Final Sedang Berlangsung</span>
    @else
        <span>Babak Penyisihan</span>
    @endif
</div>

@if(!$lomba->is_final_active && $lomba->finalis()->count() < $lomba->jumlah_finalis)
    @if($sudahAdaPenilaian)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header-custom">
                <h6><i class="fas fa-plus-circle text-primary me-2"></i> Tambah Finalis Manual</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('finalis.store', $lomba->id_lomba) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-10">
                        <select name="id_tim" class="form-select" required>
                            <option value="">-- Pilih Tim --</option>
                            @foreach($timTersedia as $tim)
                                <option value="{{ $tim->id_tim }}">{{ $tim->nama_tim }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </form>
                <small class="text-muted">
                    Sisa kuota: {{ $lomba->jumlah_finalis - $lomba->finalis()->count() }} dari {{ $lomba->jumlah_finalis }} finalis
                </small>
            </div>
        </div>
    @endif
@endif

<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="min-width: 200px;">Nama Tim</th>
                    <th style="min-width: 100px;">Peringkat</th>
                    <th style="min-width: 100px;">Nilai Penyisihan</th>
                    <th style="min-width: 100px;">Nilai Final</th>
                    <th style="min-width: 120px;">Status</th>
                    <th style="width: 80px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($finalis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item->tim->nama_tim ?? '-' }}</td>
                        <td>{{ $item->peringkat }}</td>
                        <td>{{ $item->nilai_penyisihan }}</td>
                        <td>{{ $item->nilai_final }}</td>
                        <td>
                            @if($item->nilai_final > 0)
                                <span>Sudah Final</span>
                            @else
                                <span>Belum Final</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if(!$lomba->is_final_active)
                                <form action="{{ route('finalis.destroy', [$lomba->id_lomba, $item->id_finalis]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus finalis ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted"><i class="fas fa-lock"></i></span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <h6>Belum ada finalis</h6>
                                <p>Finalis akan ditentukan otomatis setelah juri memberikan nilai penyisihan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(!$sudahAdaPenilaian)
<div class="modal fade modal-custom" id="infoFinalisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Informasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3 d-block"></i>
                <p class="fw-semibold" style="color: #1a2332;">Finalis belum bisa ditambahkan</p>
                <p class="text-muted">Karena belum ada penilaian penyisihan untuk lomba ini.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(!$sudahAdaPenilaian)
        var modal = new bootstrap.Modal(document.getElementById('infoFinalisModal'));
        modal.show();
    @endif
});
</script>
@endsection