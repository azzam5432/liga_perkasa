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

    .badge-finalis {
        background: #c6f6d5;
        color: #22543d;
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
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
    <h4><i class="fas fa-trophy me-2"></i> Finalis - {{ $lomba->nama_lomba }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('lomba.index') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
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

<!-- ===== ALERT ===== -->
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

<!-- ===== INFO ===== -->
<div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Info:</strong> Finalis ditentukan otomatis dari nilai penyisihan tertinggi. 
    @if($lomba->is_final_active)
        <span class="badge-finalis ms-2">Babak Final Sedang Berlangsung</span>
    @else
        <span class="badge bg-warning ms-2">Babak Penyisihan</span>
    @endif
</div>

<!-- ===== TABLE FINALIS ===== -->
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
                </tr>
            </thead>
            <tbody>
                @forelse($finalis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item->tim->nama_tim ?? '-' }}</td>
                        <td>
                            <span class="badge bg-primary">#{{ $item->peringkat }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $item->nilai_penyisihan }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $item->nilai_final }}</span>
                        </td>
                        <td>
                            @if($item->nilai_final > 0)
                                <span class="badge-finalis">Sudah Final</span>
                            @else
                                <span class="badge bg-warning">Belum Final</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
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

@endsection