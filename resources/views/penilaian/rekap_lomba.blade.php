{{-- resources/views/penilaian/rekap_lomba.blade.php --}}
@extends('layouts.master')

@section('title', 'Rekap Penilaian - ' . $lomba->nama_lomba)

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
    .rank-1 { background: linear-gradient(135deg, #FFD700, #FDB931); }
    .rank-2 { background: linear-gradient(135deg, #C0C0C0, #A8A8A8); }
    .rank-3 { background: linear-gradient(135deg, #CD7F32, #B8722A); }
    .rank-other { background: #6c757d; }
    .status-selesai { color: #48bb78; }
    .status-belum { color: #ed8936; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Rekap Penilaian</h5>
                    <small class="text-white-50">{{ $lomba->nama_lomba }}</small>
                </div>
                <div>
                    <a href="{{ route('penilaian.akumulasi-juri', $lomba->id_lomba) }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-users me-1"></i> Akumulasi Juri
                    </a>
                    <form action="{{ route('penilaian.tentukan-finalis', $lomba->id_lomba) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin menentukan finalis otomatis?')">
                            <i class="fas fa-crown me-1"></i> Tentukan Finalis
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Nama Tim</th>
                                <th>Jumlah Penilaian</th>
                                <th>Total Nilai</th>
                                <th>Rata-rata</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekap as $index => $item)
                            <tr>
                                <td>
                                    <span class="rank-badge {{ $index < 3 ? 'rank-' . ($index + 1) : 'rank-other' }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $item['tim']->nama_tim }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        @foreach($item['nilai_per_kriteria'] as $k)
                                            <span class="badge bg-info me-1">
                                                {{ $k['kriteria'] }}: {{ number_format($k['nilai'], 1) }}
                                            </span>
                                        @endforeach
                                    </small>
                                </td>
                                <td class="text-center">{{ $item['jml_penilaian'] }}</td>
                                <td class="text-center">
                                    <strong>{{ number_format($item['total_nilai'], 2) }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong class="text-primary">
                                            {{ number_format($item['rata_rata'], 2) }}
                                        </strong>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar 
                                                {{ $item['rata_rata'] >= 80 ? 'bg-success' : 
                                                   ($item['rata_rata'] >= 60 ? 'bg-primary' : 'bg-warning') }}" 
                                                style="width: {{ $item['rata_rata'] }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($item['is_selesai'])
                                        <span class="status-selesai">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="status-belum">
                                            <i class="fas fa-clock"></i> Menunggu
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
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge bg-success" style="width: 15px; height: 15px; border-radius: 50%;"></span>
                                <span class="text-muted">Selesai Dinilai</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge bg-warning" style="width: 15px; height: 15px; border-radius: 50%;"></span>
                                <span class="text-muted">Menunggu Penilaian</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge bg-primary" style="width: 15px; height: 15px; border-radius: 50%;"></span>
                                <span class="text-muted">Rata-rata Tertinggi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('lomba.show', $lomba->id_lomba) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection