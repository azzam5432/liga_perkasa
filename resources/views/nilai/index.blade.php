@extends('layouts.master')

@section('title', 'Daftar Lomba Penilaian')

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

    .badge-status {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .badge-sudah { background: #c6f6d5; color: #22543d; }
    .badge-belum { background: #fed7d7; color: #9b2c2c; }
    .badge-final { background: #bee3f8; color: #2b6cb0; }
    .badge-finalis { background: #fefcbf; color: #975a16; }

    .btn-action {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #a0aec0;
        transition: all 0.2s ease;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-action:hover {
        background: #f7fafc;
        color: #1a2332;
    }

    .btn-action.btn-primary {
        color: #1a365d;
        background: #ebf8ff;
    }

    .btn-action.btn-primary:hover {
        background: #bee3f8;
    }

    .btn-action.btn-success {
        color: #22543d;
        background: #c6f6d5;
    }

    .btn-action.btn-success:hover {
        background: #9ae6b4;
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
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4><i class="fas fa-clipboard-list me-2"></i> Daftar Lomba Penilaian</h4>
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

<!-- ===== TABLE ===== -->
<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="min-width: 200px;">Nama Lomba</th>
                    <th style="min-width: 80px;">Bobot</th>
                    <th style="min-width: 100px;">Jenis</th>
                    <th style="min-width: 120px;">Status</th>
                    <th style="min-width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lombas as $item)
                    @php
                        $sudahDinilai = $item->nilai->isNotEmpty();
                        $isFinal = $item->is_final_active;
                        $jumlahFinalis = $item->finalis()->count();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item->nama_lomba }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $item->bobot }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $item->jenis == 'penyisihan' ? 'Penyisihan + Final' : 'Langsung' }}</span>
                        </td>
                        <td>
                            @if($isFinal)
                                <span class="badge-status badge-final">
                                    <i class="fas fa-trophy"></i> Babak Final
                                </span>
                            @elseif($sudahDinilai && $item->jenis == 'penyisihan' && $jumlahFinalis > 0)
                                <span class="badge-status badge-finalis">
                                    <i class="fas fa-users"></i> Finalis: {{ $jumlahFinalis }}
                                </span>
                            @elseif($sudahDinilai)
                                <span class="badge-status badge-sudah">
                                    <i class="fas fa-check-circle"></i> Sudah Dinilai
                                </span>
                            @else
                                <span class="badge-status badge-belum">
                                    <i class="fas fa-clock"></i> Belum Dinilai
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(!$sudahDinilai)
                                <a href="{{ route('nilai.create', $item->id_lomba) }}" 
                                   class="btn-action btn-primary" 
                                   title="Beri Nilai">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @elseif($item->jenis == 'penyisihan' && $jumlahFinalis > 0 && !$isFinal)
                                <a href="{{ route('finalis.index', $item->id_lomba) }}" 
                                   class="btn-action btn-success" 
                                   title="Lihat Finalis">
                                    <i class="fas fa-trophy"></i>
                                </a>
                            @elseif($isFinal)
                                <a href="{{ route('finalis.index', $item->id_lomba) }}" 
                                   class="btn-action btn-success" 
                                   title="Lihat Hasil Final">
                                    <i class="fas fa-trophy"></i>
                                </a>
                            @else
                                <span class="text-muted"><i class="fas fa-lock"></i></span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <h6>Belum ada lomba yang ditugaskan</h6>
                                <p>Silakan hubungi panitia untuk penugasan lomba.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection