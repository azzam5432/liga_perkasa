@extends(Auth::check() ? 'layouts.master' : 'layouts.public')

@section('title', 'Ranking Lomba')

@section('content')
<style>
/* ===== GLOBAL ===== */
.ranking-page {
    padding: 20px;
    min-height: 100vh;
}

/* ===== PUBLIC STYLE ===== */
@if(!Auth::check())
.ranking-page {
    padding: 0;
    margin: 0;
}
body {
    background: url('/icon/liga.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    margin: 0;
}

.public-ranking-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

.public-header {
    text-align: center;
    margin-bottom: 30px;
    color: #ffffff;
    margin-top: 20px;
}

.public-header h1 {
    font-size: 36px;
    font-weight: 800;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    letter-spacing: 1px;
}

.public-header h1 i {
    color: #ffd700;
    margin-right: 10px;
    text-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
}

.public-header p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin-top: 8px;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
}

.public-table-wrapper {
    background: rgba(0, 0, 0, 0.5);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    overflow: hidden;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.public-table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    table-layout: fixed;
}

.public-table-wrapper table thead th {
    background: rgba(255, 215, 0, 0.1);
    color: #ffd700;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 10px 6px;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    text-align: center;
    white-space: nowrap;
}

.public-table-wrapper table tbody td {
    padding: 10px 6px;
    vertical-align: middle;
    color: rgba(255, 255, 255, 0.95);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 14px;
}

.public-table-wrapper .medal-emoji {
    font-size: 28px;
    filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.5));
}

.public-table-wrapper .rank-number {
    font-size: 15px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.7);
}

.public-table-wrapper .tim-name {
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    white-space: normal !important;
    word-wrap: break-word;
}

.public-table-wrapper .total-nilai {
    font-weight: 700;
    color: #ffd700;
    font-size: 14px;
    text-shadow: 0 0 8px rgba(255, 215, 0, 0.3);
}

.public-empty {
    padding: 60px 16px;
    text-align: center;
}

.public-empty i {
    font-size: 48px;
    color: rgba(255, 215, 0, 0.3);
    margin-bottom: 16px;
    display: block;
}

.public-empty h6 {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 6px;
}

.public-empty p {
    color: rgba(255, 255, 255, 0.6);
    font-size: 15px;
    margin: 0;
}

.btn-action-public {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transition: all 0.2s;
    font-size: 14px;
    cursor: pointer;
}

.btn-action-public:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffd700;
}
@endif

/* ===== AUTH STYLE ===== */
@if(Auth::check())
.ranking-page {
    background: #f8f9fa;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.page-header h4 {
    font-size: 24px;
    font-weight: 700;
    color: #000000;
    margin: 0;
}

.page-header h4 i {
    color: #ffc107;
    margin-right: 8px;
}

.btn-award {
    background: #ffc107;
    border: none;
    color: #000000;
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 15px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-award:hover {
    background: #e0a800;
    color: #000000;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
}

.table-wrapper {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.table-scroll {
    overflow-x: hidden; /* HILANGKAN SCROLL */
}

.table-scroll table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    table-layout: fixed;
}

.table-scroll table thead th {
    background: #f8f9fa;
    color: #000000;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 6px;
    border-bottom: 2px solid #e9ecef;
    text-align: center;
    white-space: nowrap;
}

.table-scroll table tbody td {
    padding: 10px 6px;
    vertical-align: middle;
    color: #000000;
    border-bottom: 1px solid #f1f3f5;
    font-size: 14px;
}

.table-scroll .medal-emoji {
    font-size: 28px;
}

.table-scroll .rank-number {
    font-size: 15px;
    font-weight: 700;
    color: #000000;
}

.table-scroll .fw-semibold {
    font-weight: 700;
    color: #000000;
    font-size: 14px;
    white-space: normal !important;
    word-wrap: break-word;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dee2e6;
    background: transparent;
    color: #000000;
    transition: all 0.2s;
    font-size: 14px;
    cursor: pointer;
}

.btn-action:hover {
    background: #f8f9fa;
    color: #000000;
}

.btn-action.btn-info {
    color: #0d6efd;
    border-color: #dee2e6;
}

.btn-action.btn-info:hover {
    background: #e7f1ff;
    border-color: #0d6efd;
}

.empty-state {
    padding: 50px 16px;
    text-align: center;
}

.empty-state i {
    font-size: 48px;
    color: #dee2e6;
    margin-bottom: 12px;
    display: block;
}

.empty-state h6 {
    color: #000000;
    font-weight: 700;
    margin-bottom: 4px;
    font-size: 18px;
}

.empty-state p {
    color: #6c757d;
    font-size: 15px;
    margin: 0;
}
@endif

/* ===== MODAL ===== */
.modal-custom .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.modal-custom .modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: 18px 24px;
}

.modal-custom .modal-header .modal-title {
    font-weight: 700;
    color: #000000;
    font-size: 20px;
}

.modal-custom .modal-body {
    padding: 24px;
    max-height: 70vh;
    overflow-y: auto;
}

.modal-custom .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 16px 24px;
}

.modal-custom .btn-secondary-custom {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #000000;
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.2s;
}

.modal-custom .btn-secondary-custom:hover {
    background: #e9ecef;
    color: #000000;
}

.info-list {
    padding: 0;
    margin: 0;
    list-style: none;
}

.info-list li {
    padding: 6px 0;
    font-size: 15px;
    color: #000000;
    border-bottom: 1px solid #f1f3f5;
}

.info-list li:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 14px;
    font-weight: 700;
    color: #000000;
    display: block;
    margin-bottom: 6px;
}

.bg-light-custom {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    text-align: center;
}

.bg-light-custom .value {
    font-size: 30px;
    font-weight: 700;
    color: #000000;
}

.bg-light-custom .label {
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
}

#modalNamaTim {
    color: #000000;
    font-size: 22px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .ranking-page {
        padding: 8px;
    }

    @if(!Auth::check())
    .ranking-page {
        padding: 8px;
    }
    .public-header h1 {
        font-size: 22px;
    }
    .public-header p {
        font-size: 13px;
    }

    .public-table-wrapper table,
    .table-scroll table {
        font-size: 11px;
        min-width: 100%;
        table-layout: fixed;
    }

    .public-table-wrapper table thead th,
    .table-scroll table thead th {
        font-size: 10px;
        padding: 6px 2px;
        letter-spacing: 0;
    }

    .public-table-wrapper table tbody td,
    .table-scroll table tbody td {
        padding: 6px 2px;
        font-size: 11px;
    }

    .public-table-wrapper .medal-emoji,
    .table-scroll .medal-emoji {
        font-size: 20px; /* Emoji tetap besar di mobile */
    }

    .public-table-wrapper .rank-number,
    .table-scroll .rank-number {
        font-size: 11px;
    }

    .public-table-wrapper .tim-name,
    .table-scroll .fw-semibold {
        font-size: 11px;
        white-space: normal !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .public-table-wrapper .total-nilai,
    .table-scroll table tbody td:nth-child(6) {
        font-size: 11px;
    }

    /* HILANGKAN AKSI DI MOBILE */
    .public-table-wrapper table thead th:last-child,
    .public-table-wrapper table tbody td:last-child,
    .table-scroll table thead th:last-child,
    .table-scroll table tbody td:last-child {
        display: none;
    }

    /* ATUR LEBAR KOLOM */
    .public-table-wrapper table thead th:nth-child(1),
    .public-table-wrapper table tbody td:nth-child(1),
    .table-scroll table thead th:nth-child(1),
    .table-scroll table tbody td:nth-child(1) { width: 10%; } /* Rank */

    .public-table-wrapper table thead th:nth-child(2),
    .public-table-wrapper table tbody td:nth-child(2),
    .table-scroll table thead th:nth-child(2),
    .table-scroll table tbody td:nth-child(2) { width: 40%; } /* Nama Tim */

    .public-table-wrapper table thead th:nth-child(3),
    .public-table-wrapper table tbody td:nth-child(3),
    .table-scroll table thead th:nth-child(3),
    .table-scroll table tbody td:nth-child(3) { width: 12%; } /* Emas */

    .public-table-wrapper table thead th:nth-child(4),
    .public-table-wrapper table tbody td:nth-child(4),
    .table-scroll table thead th:nth-child(4),
    .table-scroll table tbody td:nth-child(4) { width: 12%; } /* Perak */

    .public-table-wrapper table thead th:nth-child(5),
    .public-table-wrapper table tbody td:nth-child(5),
    .table-scroll table thead th:nth-child(5),
    .table-scroll table tbody td:nth-child(5) { width: 12%; } /* Perunggu */

    .public-table-wrapper table thead th:nth-child(6),
    .public-table-wrapper table tbody td:nth-child(6),
    .table-scroll table thead th:nth-child(6),
    .table-scroll table tbody td:nth-child(6) { width: 14%; } /* Total Nilai */
    @endif

    @if(Auth::check())
    .page-header {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .page-header h4 {
        font-size: 16px;
    }
    .btn-award {
        font-size: 12px;
        padding: 6px 12px;
        width: auto;
    }

    .table-scroll table {
        font-size: 11px;
        min-width: 100%;
        table-layout: fixed;
    }
    .table-scroll table thead th {
        font-size: 10px;
        padding: 6px 2px;
        letter-spacing: 0;
    }
    .table-scroll table tbody td {
        padding: 6px 2px;
        font-size: 11px;
    }
    .table-scroll .medal-emoji {
        font-size: 20px; /* Emoji tetap besar di mobile */
    }
    .table-scroll .rank-number {
        font-size: 11px;
    }
    .table-scroll .fw-semibold {
        font-size: 11px;
        white-space: normal !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* HILANGKAN AKSI DI MOBILE */
    .table-scroll table thead th:last-child,
    .table-scroll table tbody td:last-child {
        display: none;
    }

    /* ATUR LEBAR KOLOM */
    .table-scroll table thead th:nth-child(1),
    .table-scroll table tbody td:nth-child(1) { width: 10%; } /* Rank */
    .table-scroll table thead th:nth-child(2),
    .table-scroll table tbody td:nth-child(2) { width: 40%; } /* Nama Tim */
    .table-scroll table thead th:nth-child(3),
    .table-scroll table tbody td:nth-child(3) { width: 12%; } /* Emas */
    .table-scroll table thead th:nth-child(4),
    .table-scroll table tbody td:nth-child(4) { width: 12%; } /* Perak */
    .table-scroll table thead th:nth-child(5),
    .table-scroll table tbody td:nth-child(5) { width: 12%; } /* Perunggu */
    .table-scroll table thead th:nth-child(6),
    .table-scroll table tbody td:nth-child(6) { width: 14%; } /* Total Nilai */
    @endif

    .modal-custom .modal-body {
        padding: 12px;
    }
    .modal-custom .modal-header .modal-title {
        font-size: 16px;
    }
    .bg-light-custom .value {
        font-size: 20px;
    }
    #modalNamaTim {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    @if(Auth::check())
    .page-header h4 {
        font-size: 14px;
    }
    .btn-award {
        font-size: 11px;
        padding: 5px 10px;
        width: auto;
    }

    .table-scroll table {
        font-size: 10px;
        min-width: 100%;
        table-layout: fixed;
    }
    .table-scroll table thead th {
        font-size: 9px;
        padding: 4px 2px;
    }
    .table-scroll table tbody td {
        padding: 4px 2px;
        font-size: 10px;
    }
    .table-scroll .medal-emoji {
        font-size: 18px; /* Emoji tetap besar di mobile kecil */
    }
    .table-scroll .rank-number {
        font-size: 10px;
    }
    .table-scroll .fw-semibold {
        font-size: 10px;
        white-space: normal !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    @endif

    @if(!Auth::check())
    .public-table-wrapper table {
        font-size: 10px;
        min-width: 100%;
        table-layout: fixed;
    }
    .public-table-wrapper table thead th {
        font-size: 9px;
        padding: 4px 2px;
    }
    .public-table-wrapper table tbody td {
        padding: 4px 2px;
        font-size: 10px;
    }
    .public-table-wrapper .medal-emoji {
        font-size: 18px; /* Emoji tetap besar di mobile kecil */
    }
    .public-table-wrapper .rank-number {
        font-size: 10px;
    }
    .public-table-wrapper .tim-name {
        font-size: 10px;
    }
    .public-table-wrapper .total-nilai {
        font-size: 10px;
    }
    @endif
}
</style>

@if(Auth::check())
<!-- ===== TAMPILAN PANITIA / ADMIN ===== -->
<div class="ranking-page">
    
    <div class="page-header">
        <h4><i class="fas fa-trophy"></i> Ranking Lomba</h4>
        <div class="d-flex gap-2">
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('ranking.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
            @endif
            
            @if(Auth::user()->isPanitia() || Auth::user()->isSuperAdmin())
                <a href="{{ route('penghargaan.index') }}" class="btn-award">
                    <i class="fas fa-award"></i> Penghargaan
                </a>
            @endif
        </div>
    </div>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table id="rankingTable">
                <thead>
                    <tr>
                        <th style="text-align: center;">Rank</th>
                        <th style="text-align: left;">Nama Tim</th>
                        <th style="text-align: center; font-size: 16px;">🥇 Emas</th>
                        <th style="text-align: center; font-size: 16px;">🥈 Perak</th>
                        <th style="text-align: center; font-size: 16px;">🥉 Perunggu</th>
                        <th style="text-align: center;">Total Nilai</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapTim as $index => $item)
                        <tr>
                            <td style="text-align: center;">
                                @if($index == 0)
                                    <span class="medal-emoji">🥇</span>
                                @elseif($index == 1)
                                    <span class="medal-emoji">🥈</span>
                                @elseif($index == 2)
                                    <span class="medal-emoji">🥉</span>
                                @else
                                    <span class="rank-number">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="fw-semibold" style="white-space: normal !important; word-wrap: break-word;">
                                {{ $item['tim']->nama_tim }}
                            </td>
                            <td style="text-align: center;">
                                <span class="fw-bold" style="color: #d4af37; font-size: 18px;">{{ $item['emas'] }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="fw-bold" style="color: #c0c0c0; font-size: 18px;">{{ $item['perak'] }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="fw-bold" style="color: #cd7f32; font-size: 18px;">{{ $item['perunggu'] }}</span>
                            </td>
                            <td style="text-align: center;">
                                {{ number_format($item['total_nilai'], 1, ',', '.') }}
                            </td>
                            <td style="text-align: center;">
                                <button class="btn-action btn-info btn-detail-tim" 
                                        data-nama-tim="{{ $item['tim']->nama_tim }}"
                                        title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
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
</div>

@else
<!-- ===== TAMPILAN PUBLIC ===== -->
<div class="ranking-page">
    <div class="public-ranking-wrapper">
        <div class="public-header">
            <h1><i class="fas fa-trophy"></i> Ranking Lomba Liga Perkasa</h1>
            <p>Berikut adalah daftar peringkat tim berdasarkan total nilai yang telah dikumpulkan.</p>
        </div>

        <div class="public-table-wrapper">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center;">Rank</th>
                            <th style="text-align: left;">Nama Tim</th>
                            <th style="text-align: center; font-size: 16px;">🥇</th>
                            <th style="text-align: center; font-size: 16px;">🥈</th>
                            <th style="text-align: center; font-size: 16px;">🥉</th>
                            <th style="text-align: center;">Total Nilai</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapTim as $index => $item)
                            <tr>
                                <td style="text-align: center;">
                                    @if($index == 0)
                                        <span class="medal-emoji">🥇</span>
                                    @elseif($index == 1)
                                        <span class="medal-emoji">🥈</span>
                                    @elseif($index == 2)
                                        <span class="medal-emoji">🥉</span>
                                    @else
                                        <span class="rank-number">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="tim-name" style="white-space: normal !important; word-wrap: break-word;">
                                    {{ $item['tim']->nama_tim }}
                                </td>
                                <td style="text-align: center;">
                                    <span class="fw-bold" style="color: #d4af37; font-size: 18px;">{{ $item['emas'] }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="fw-bold" style="color: #c0c0c0; font-size: 18px;">{{ $item['perak'] }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="fw-bold" style="color: #cd7f32; font-size: 18px;">{{ $item['perunggu'] }}</span>
                                </td>
                                <td class="total-nilai" style="text-align: center;">
                                    {{ number_format($item['total_nilai'], 1, ',', '.') }}
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn-action-public btn-detail-tim-public" 
                                            data-nama-tim="{{ $item['tim']->nama_tim }}"
                                            title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="public-empty">
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
    </div>
</div>
@endif

<!-- ===== MODAL ===== -->
<div class="modal fade modal-custom" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #ffc107;"></i> Detail Ranking
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Header Tim -->
                <div class="text-center mb-4">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #ffc107; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-trophy" style="font-size: 36px; color: #000000;"></i>
                    </div>
                    <h5 class="mt-3 fw-bold" id="modalNamaTim">-</h5>
                </div>

                <!-- Statistik Medali -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="bg-light-custom">
                            <div class="value" style="color: #d4af37; font-size: 32px;" id="modalEmas">-</div>
                            <div class="label">🥇 Emas</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light-custom">
                            <div class="value" style="color: #c0c0c0; font-size: 32px;" id="modalPerak">-</div>
                            <div class="label">🥈 Perak</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light-custom">
                            <div class="value" style="color: #cd7f32; font-size: 32px;" id="modalPerunggu">-</div>
                            <div class="label">🥉 Perunggu</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="bg-light-custom">
                            <div class="value" id="modalTotalNilai">-</div>
                            <div class="label">Total Nilai</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 p-3" style="background: #fff8e1; border: 1px solid #ffe082; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #f57f17;">
                        <i class="fas fa-award me-2"></i> Penghargaan
                    </h6>
                    <div id="modalPenghargaan" style="font-size: 15px; color: #000000;">
                        <span class="text-muted">Tidak ada penghargaan</span>
                    </div>
                </div>

                <div class="mb-4 p-3" style="background: #e3f2fd; border: 1px solid #90caf9; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #1565c0;">
                        <i class="fas fa-trophy me-2"></i> Detail Lomba yang Dimenangkan
                    </h6>
                    <div id="modalDetailLomba" style="font-size: 15px; color: #000000;">
                        <span class="text-muted">Tidak ada lomba yang dimenangkan</span>
                    </div>
                </div>

                <div class="mb-4 p-3" style="background: #f5f5f5; border: 1px solid #e0e0e0; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #424242;">
                        <i class="fas fa-user-tie me-2"></i> Pembimbing dan Mentor
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="info-label">Dosen Pembimbing</span>
                            <div id="modalDosen" style="font-size: 15px; color: #000000;">-</div>
                        </div>
                        <div class="col-md-6">
                            <span class="info-label">Kakak Mentor</span>
                            <div id="modalKakak" style="font-size: 15px; color: #000000;">-</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 p-3" style="background: #f3e5f5; border: 1px solid #ce93d8; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #6a1b9a;">
                        <i class="fas fa-crown me-2"></i> Ketua Tim
                    </h6>
                    <div id="modalKetua" style="font-size: 15px; color: #000000;">-</div>
                </div>

                <div class="mb-4 p-3" style="background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #2e7d32;">
                        <i class="fas fa-users me-2"></i> Anggota Tim
                    </h6>
                    <div id="modalAnggota" style="font-size: 15px; color: #000000;">
                        <span class="text-muted">Tidak ada anggota</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== SCRIPT ===== -->
<script>
let timDataArray = {};

function fetchRanking() {
    fetch('/ranking/data')
        .then(response => response.json())
        .then(data => {
            data.forEach((item, index) => {
                timDataArray[item.tim.nama_tim] = item;
            });

            if (document.querySelector('#rankingTable tbody')) {
                updateRankingTable(data);
            }
            if (document.querySelector('.public-table-wrapper tbody')) {
                updatePublicRankingTable(data);
            }
        })
        .catch(error => console.error('Error fetching ranking:', error));
}

function updateRankingTable(data) {
    const tbody = document.querySelector('#rankingTable tbody');
    if (!tbody) return;

    tbody.innerHTML = '';

    data.forEach((item, index) => {
        const row = document.createElement('tr');

        const rankCell = document.createElement('td');
        rankCell.style.textAlign = 'center';
        if (index === 0) {
            rankCell.innerHTML = '<span class="medal-emoji">🥇</span>';
        } else if (index === 1) {
            rankCell.innerHTML = '<span class="medal-emoji">🥈</span>';
        } else if (index === 2) {
            rankCell.innerHTML = '<span class="medal-emoji">🥉</span>';
        } else {
            rankCell.innerHTML = `<span class="rank-number">${index + 1}</span>`;
        }
        row.appendChild(rankCell);

        const nameCell = document.createElement('td');
        nameCell.className = 'fw-semibold';
        nameCell.style.whiteSpace = 'normal';
        nameCell.style.wordWrap = 'break-word';
        nameCell.style.maxWidth = '300px';
        nameCell.textContent = item.tim.nama_tim;
        row.appendChild(nameCell);

        const emasCell = document.createElement('td');
        emasCell.style.textAlign = 'center';
        emasCell.innerHTML = `<span class="fw-bold" style="color: #d4af37; font-size: 18px;">${item.emas}</span>`;
        row.appendChild(emasCell);

        const perakCell = document.createElement('td');
        perakCell.style.textAlign = 'center';
        perakCell.innerHTML = `<span class="fw-bold" style="color: #c0c0c0; font-size: 18px;">${item.perak}</span>`;
        row.appendChild(perakCell);

        const perungguCell = document.createElement('td');
        perungguCell.style.textAlign = 'center';
        perungguCell.innerHTML = `<span class="fw-bold" style="color: #cd7f32; font-size: 18px;">${item.perunggu}</span>`;
        row.appendChild(perungguCell);

        const totalCell = document.createElement('td');
        totalCell.style.textAlign = 'center';
        totalCell.textContent = Number(item.total_nilai).toFixed(1).replace('.', ',');
        row.appendChild(totalCell);

        const actionCell = document.createElement('td');
        actionCell.style.textAlign = 'center';
        actionCell.innerHTML = `
            <button class="btn-action btn-info btn-detail-tim" 
                    data-nama-tim="${item.tim.nama_tim}"
                    title="Detail">
                <i class="fas fa-eye"></i>
            </button>
        `;
        row.appendChild(actionCell);

        tbody.appendChild(row);
    });
}

function updatePublicRankingTable(data) {
    const tbody = document.querySelector('.public-table-wrapper tbody');
    if (!tbody) return;

    tbody.innerHTML = '';

    data.forEach((item, index) => {
        const row = document.createElement('tr');

        const rankCell = document.createElement('td');
        rankCell.style.textAlign = 'center';
        if (index === 0) {
            rankCell.innerHTML = '<span class="medal-emoji">🥇</span>';
        } else if (index === 1) {
            rankCell.innerHTML = '<span class="medal-emoji">🥈</span>';
        } else if (index === 2) {
            rankCell.innerHTML = '<span class="medal-emoji">🥉</span>';
        } else {
            rankCell.innerHTML = `<span class="rank-number">${index + 1}</span>`;
        }
        row.appendChild(rankCell);

        const nameCell = document.createElement('td');
        nameCell.className = 'tim-name';
        nameCell.style.whiteSpace = 'normal';
        nameCell.style.wordWrap = 'break-word';
        nameCell.style.maxWidth = '300px';
        nameCell.textContent = item.tim.nama_tim;
        row.appendChild(nameCell);

        const emasCell = document.createElement('td');
        emasCell.style.textAlign = 'center';
        emasCell.innerHTML = `<span class="fw-bold" style="color: #d4af37; font-size: 18px;">${item.emas}</span>`;
        row.appendChild(emasCell);

        const perakCell = document.createElement('td');
        perakCell.style.textAlign = 'center';
        perakCell.innerHTML = `<span class="fw-bold" style="color: #c0c0c0; font-size: 18px;">${item.perak}</span>`;
        row.appendChild(perakCell);

        const perungguCell = document.createElement('td');
        perungguCell.style.textAlign = 'center';
        perungguCell.innerHTML = `<span class="fw-bold" style="color: #cd7f32; font-size: 18px;">${item.perunggu}</span>`;
        row.appendChild(perungguCell);

        const totalCell = document.createElement('td');
        totalCell.className = 'total-nilai';
        totalCell.style.textAlign = 'center';
        totalCell.textContent = Number(item.total_nilai).toFixed(1).replace('.', ',');
        row.appendChild(totalCell);

        const actionCell = document.createElement('td');
        actionCell.style.textAlign = 'center';
        actionCell.innerHTML = `
            <button class="btn-action-public btn-detail-tim-public" 
                    data-nama-tim="${item.tim.nama_tim}"
                    title="Detail">
                <i class="fas fa-eye"></i>
            </button>
        `;
        row.appendChild(actionCell);

        tbody.appendChild(row);
    });
}

document.addEventListener('click', function(event) {
    const btnAuth = event.target.closest('.btn-detail-tim');
    if (btnAuth) {
        const namaTim = btnAuth.getAttribute('data-nama-tim');
        const item = timDataArray[namaTim];
        if (item) {
            openModal(item.tim.nama_tim, item.total_nilai, item.jml_menang, item.detail, item.tim, item.penghargaan);
        }
    }

    const btnPublic = event.target.closest('.btn-detail-tim-public');
    if (btnPublic) {
        const namaTim = btnPublic.getAttribute('data-nama-tim');
        const item = timDataArray[namaTim];
        if (item) {
            openModal(item.tim.nama_tim, item.total_nilai, item.jml_menang, item.detail, item.tim, item.penghargaan);
        }
    }
});

function openModal(namaTim, totalNilai, jumlahMenang, detail, timData, penghargaan) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    
    document.getElementById('modalNamaTim').textContent = namaTim || '-';
    document.getElementById('modalTotalNilai').textContent = parseFloat(totalNilai).toFixed(1).replace('.', ',');

    const item = timDataArray[namaTim];
    if (item) {
        document.getElementById('modalEmas').textContent = item.emas || 0;
        document.getElementById('modalPerak').textContent = item.perak || 0;
        document.getElementById('modalPerunggu').textContent = item.perunggu || 0;
    }

    let penghargaanHtml = '<span class="text-muted">Tidak ada penghargaan</span>';
    if (penghargaan && Array.isArray(penghargaan) && penghargaan.length > 0) {
        penghargaanHtml = penghargaan.map(p => `
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-medal me-2" style="color: #f57f17;"></i>
                <span class="fw-semibold">${p.kategori}</span>
                <span class="badge bg-warning text-dark ms-2">+${p.bobot} poin</span>
            </div>
        `).join('');
    }
    document.getElementById('modalPenghargaan').innerHTML = penghargaanHtml;

    let ketua = '-', anggotaHtml = '<span class="text-muted">Tidak ada anggota</span>';
    if (timData && timData.pesertas) {
        const ketuaData = timData.pesertas.find(p => p.ketua_peserta);
        ketua = ketuaData ? ketuaData.ketua_peserta : '-';
        
        const anggotaList = timData.pesertas.filter(p => !p.ketua_peserta);
        if (anggotaList.length > 0) {
            anggotaHtml = '<ul class="info-list">' + anggotaList.map(a => `<li>${a.nama_peserta}</li>`).join('') + '</ul>';
        }
    }
    document.getElementById('modalKetua').innerHTML = ketua;
    document.getElementById('modalAnggota').innerHTML = anggotaHtml;

    let dosenHtml = '-';
    if (timData && timData.dosen_pembimbing && timData.dosen_pembimbing.length > 0) {
        dosenHtml = '<ul class="info-list">' + timData.dosen_pembimbing.map(d => `<li>${d.nama_dosen}</li>`).join('') + '</ul>';
    }
    document.getElementById('modalDosen').innerHTML = dosenHtml;

    let kakakHtml = '-';
    if (timData && timData.kakak_pembimbing && timData.kakak_pembimbing.length > 0) {
        kakakHtml = '<ul class="info-list">' + timData.kakak_pembimbing.map(k => `<li>${k.nama_kakak}</li>`).join('') + '</ul>';
    }
    document.getElementById('modalKakak').innerHTML = kakakHtml;

    let detailHtml = '<span class="text-muted">Tidak ada lomba yang dimenangkan</span>';
    if (detail && Array.isArray(detail) && detail.length > 0) {
        detailHtml = detail.map(item => `
            <div class="detail-item">
                <div>
                    <span class="detail-lomba">${item.lomba || '-'}</span>
                    ${item.babak ? `<span class="detail-babak">(${item.babak})</span>` : ''}
                </div>
                <span class="detail-nilai">${item.nilai}</span>
            </div>
        `).join('');
    }
    document.getElementById('modalDetailLomba').innerHTML = detailHtml;

    modal.show();
}

setInterval(fetchRanking, 5000);

document.addEventListener('DOMContentLoaded', function() {
    fetchRanking();
});
</script>
@endsection