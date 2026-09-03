@extends('layouts.master')

@section('title', 'Rekap Finalis - ' . $lomba->nama_lomba)

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
    <h4><i class="fas fa-chart-bar me-2"></i> Rekap - {{ $lomba->nama_lomba }}</h4>
    <a href="{{ route('finalis.index', $lomba->id_lomba) }}" class="btn-secondary-custom">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="min-width: 200px;">Nama Tim</th>
                    <th style="min-width: 100px;">Nilai Penyisihan</th>
                    <th style="min-width: 100px;">Nilai Final</th>
                    <th style="min-width: 100px;">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekap as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item['tim']->nama_tim }}</td>
                        <td>
                            <span class="badge bg-info">{{ $item['nilai_penyisihan'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $item['nilai_final'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary" style="font-size: 14px; padding: 6px 14px;">
                                {{ $item['total_nilai'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-chart-bar"></i>
                                <h6>Belum ada data</h6>
                                <p>Belum ada nilai yang diinput untuk lomba ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection