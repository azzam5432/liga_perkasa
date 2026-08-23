@extends('layouts.master')

@section('title', 'Rekap Penilaian')

@section('content')
<style>
    .rank-badge {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: white;
    }
    .rank-1 { background: linear-gradient(135deg, #FFD700, #FDB931); box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3); }
    .rank-2 { background: linear-gradient(135deg, #C0C0C0, #A8A8A8); box-shadow: 0 3px 10px rgba(192, 192, 192, 0.3); }
    .rank-3 { background: linear-gradient(135deg, #CD7F32, #B8722A); box-shadow: 0 3px 10px rgba(205, 127, 50, 0.3); }
    .rank-other { background: #6c757d; }
    
    .rekap-table tbody tr {
        transition: all 0.3s ease;
    }
    .rekap-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }
    .rekap-table tbody tr td:first-child {
        font-weight: 700;
    }
    .progress {
        height: 10px;
        border-radius: 10px;
        background: #edf2f7;
    }
    .progress-bar {
        border-radius: 10px;
        transition: width 1s ease;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Rekap Penilaian</h5>
                <span class="badge bg-light text-dark">
                    <i class="fas fa-users me-1"></i> {{ count($rekap) }} Tim
                </span>
            </div>
            <div class="card-body">
                @if(empty($rekap))
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Belum ada data penilaian</h5>
                        <p class="text-muted">Silahkan lakukan penilaian terlebih dahulu.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover rekap-table">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 60px;">Rank</th>
                                    <th>Nama Tim</th>
                                    <th style="width: 120px;">Jumlah Penilaian</th>
                                    <th style="width: 150px;">Total Nilai</th>
                                    <th style="width: 250px;">Rata-rata</th>
                                    <th style="width: 130px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekap as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <span class="rank-badge {{ $index < 3 ? 'rank-' . ($index + 1) : 'rank-other' }}">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $item['tim']->nama_tim }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i> 
                                            {{ $item['tim']->created_at->format('d F Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $item['jml_penilaian'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ number_format($item['total_nilai'], 2) }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <strong class="text-primary" style="min-width: 60px;">
                                                {{ number_format($item['rata_rata'], 2) }}
                                            </strong>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar 
                                                    {{ $item['rata_rata'] >= 80 ? 'bg-success' : 
                                                       ($item['rata_rata'] >= 60 ? 'bg-primary' : 
                                                       ($item['rata_rata'] >= 40 ? 'bg-warning' : 'bg-danger')) }}" 
                                                    style="width: {{ $item['rata_rata'] }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item['rata_rata'] >= 80)
                                            <span class="status-badge bg-success text-white">
                                                <i class="fas fa-star me-1"></i> Sangat Baik
                                            </span>
                                        @elseif($item['rata_rata'] >= 60)
                                            <span class="status-badge bg-primary text-white">
                                                <i class="fas fa-thumbs-up me-1"></i> Baik
                                            </span>
                                        @elseif($item['rata_rata'] >= 40)
                                            <span class="status-badge bg-warning text-dark">
                                                <i class="fas fa-minus me-1"></i> Cukup
                                            </span>
                                        @else
                                            <span class="status-badge bg-danger text-white">
                                                <i class="fas fa-exclamation me-1"></i> Kurang
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Belum ada data penilaian</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-3">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="badge bg-success" style="width: 15px; height: 15px; border-radius: 50%; padding: 0;"></span>
                                    <span class="text-muted">Sangat Baik (≥80%)</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="badge bg-primary" style="width: 15px; height: 15px; border-radius: 50%; padding: 0;"></span>
                                    <span class="text-muted">Baik (60-79%)</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="badge bg-warning" style="width: 15px; height: 15px; border-radius: 50%; padding: 0;"></span>
                                    <span class="text-muted">Cukup (40-59%)</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="badge bg-danger" style="width: 15px; height: 15px; border-radius: 50%; padding: 0;"></span>
                                    <span class="text-muted">Kurang (&lt;40%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Cetak Rekap
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.progress-bar').forEach(function(bar) {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(function() {
            bar.style.width = width;
        }, 300);
    });
});
</script>
@endsection