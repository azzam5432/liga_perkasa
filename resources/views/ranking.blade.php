@extends('layouts.master')

@section('title', 'Ranking Lomba')

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

    .badge-rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 14px;
    }

    .badge-rank-1 {
        background: #fefcbf;
        color: #975a16;
        border: 2px solid #d69e2e;
    }

    .badge-rank-2 {
        background: #e2e8f0;
        color: #4a5568;
        border: 2px solid #a0aec0;
    }

    .badge-rank-3 {
        background: #fed7d7;
        color: #9b2c2c;
        border: 2px solid #fc8181;
    }

    .badge-rank-lain {
        background: #ebf8ff;
        color: #2b6cb0;
        border: 2px solid #90cdf4;
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
    }
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4><i class="fas fa-trophy me-2"></i> Ranking Lomba Liga Perkasa</h4>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">Rank</th>
                    <th style="min-width: 200px;">Nama Tim</th>
                    <th style="min-width: 100px;">Total Nilai</th>
                    <th style="min-width: 100px;">Jumlah Menang</th>
                    <th style="min-width: 300px;">Detail Lomba</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapTim as $index => $item)
                    <tr>
                        <td>
                            <span class="badge-rank 
                                {{ $index == 0 ? 'badge-rank-1' : 
                                   ($index == 1 ? 'badge-rank-2' : 
                                   ($index == 2 ? 'badge-rank-3' : 'badge-rank-lain')) }}">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="fw-semibold">{{ $item['tim']->nama_tim }}</td>
                        <td>
                            <span class="badge bg-primary" style="font-size: 14px; padding: 6px 14px;">
                                {{ $item['total_nilai'] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $item['jml_menang'] }}</span>
                        </td>
                        <td>
                            @if(count($item['detail']) > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($item['detail'] as $detail)
                                        <span class="badge bg-secondary" title="{{ $detail['lomba'] }} - {{ $detail['babak'] }}">
                                            {{ $detail['lomba'] }}: {{ $detail['nilai'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">Belum ada nilai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <h6>Belum ada data</h6>
                                <p>Belum ada nilai yang diinput untuk tim.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection