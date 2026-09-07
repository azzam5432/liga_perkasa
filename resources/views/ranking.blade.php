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
    /* Background dihapus dari sini karena sudah di body layout public */
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

/* Public Header */
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

/* Public Search */
.public-search {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
    background: rgba(0, 0, 0, 0.4);
    padding: 12px 16px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(6px);
}

.public-search .search-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.public-search .search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    font-size: 15px;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transition: all 0.3s;
}

.public-search .search-box input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.public-search .search-box input:focus {
    outline: none;
    border-color: #ffd700;
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
}

.public-search .search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.6);
    font-size: 15px;
}

/* Public Table */
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
    font-size: 15px;
}

.public-table-wrapper table thead th {
    background: rgba(255, 215, 0, 0.1);
    color: #ffd700;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 14px 18px;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    text-align: left;
}

.public-table-wrapper table tbody td {
    padding: 14px 18px;
    vertical-align: middle;
    color: rgba(255, 255, 255, 0.95);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 15px;
}

.public-table-wrapper table tbody tr:hover {
    background: rgba(255, 255, 255, 0.1);
}

.public-table-wrapper .medal-emoji {
    font-size: 28px;
    filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.5));
}

.public-table-wrapper .rank-number {
    font-size: 17px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.7);
}

.public-table-wrapper .tim-name {
    color: #ffffff;
    font-weight: 700;
    font-size: 16px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.public-table-wrapper .total-nilai {
    font-weight: 700;
    color: #ffd700;
    font-size: 17px;
    text-shadow: 0 0 8px rgba(255, 215, 0, 0.3);
}

.public-table-wrapper .jml-menang {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
}

/* Public Empty State */
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

/* Tombol Aksi Public */
.btn-action-public {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transition: all 0.2s;
    font-size: 15px;
    cursor: pointer;
}

.btn-action-public:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffd700;
}
@endif

/* ===== AUTH STYLE (Panitia & Admin) ===== */
@if(Auth::check())
.ranking-page {
    background: #f8f9fa;
}

/* Header */
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

/* Filter */
.filter-bar {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
    background: #ffffff;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.search-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 10px 14px 10px 40px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 15px;
    transition: all 0.2s;
    background: #f8f9fa;
    color: #000000;
}

.search-box input:focus {
    outline: none;
    border-color: #ffc107;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
}

.search-box input::placeholder {
    color: #adb5bd;
}

.search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    font-size: 15px;
}

/* Table Auth */
.table-wrapper {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.table-scroll {
    overflow-x: auto;
}

.table-scroll table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

.table-scroll table thead th {
    background: #f8f9fa;
    color: #000000;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 18px;
    border-bottom: 2px solid #e9ecef;
    text-align: left;
    white-space: nowrap;
}

.table-scroll table tbody td {
    padding: 14px 18px;
    vertical-align: middle;
    color: #000000;
    border-bottom: 1px solid #f1f3f5;
    font-size: 15px;
}

.table-scroll table tbody tr:last-child td {
    border-bottom: none;
}

.table-scroll table tbody tr:hover {
    background: #f8f9fa;
}

/* Auth Medal */
.table-scroll .medal-emoji {
    font-size: 28px;
}

.table-scroll .rank-number {
    font-size: 17px;
    font-weight: 700;
    color: #000000;
}

.table-scroll .fw-semibold {
    font-weight: 700;
    color: #000000;
    font-size: 16px;
}

.table-scroll table tbody td:nth-child(3) {
    font-weight: 700;
    color: #000000;
    font-size: 17px;
}

.table-scroll table tbody td:nth-child(4) {
    font-weight: 600;
    color: #000000;
    font-size: 15px;
}

/* Action Button Auth */
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dee2e6;
    background: transparent;
    color: #000000;
    transition: all 0.2s;
    font-size: 15px;
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

/* Empty State Auth */
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

/* ===== MODAL (Sama untuk semua) ===== */
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

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f1f3f5;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .detail-lomba {
    font-weight: 700;
    font-size: 15px;
    color: #000000;
}

.detail-item .detail-babak {
    font-size: 13px;
    color: #6c757d;
    font-style: italic;
}

.detail-item .detail-nilai {
    font-weight: 700;
    font-size: 16px;
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
        padding: 12px;
    }

    @if(!Auth::check())
    .ranking-page {
        padding: 12px;
    }
    .public-header h1 {
        font-size: 24px;
    }
    .public-header p {
        font-size: 14px;
    }
    .public-table-wrapper table {
        font-size: 14px;
    }
    .public-table-wrapper table thead th {
        font-size: 12px;
        padding: 10px 12px;
    }
    .public-table-wrapper table tbody td {
        padding: 10px 12px;
        font-size: 14px;
    }
    .public-table-wrapper .medal-emoji {
        font-size: 22px;
    }
    @endif

    @if(Auth::check())
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .page-header h4 {
        font-size: 20px;
    }
    .btn-award {
        font-size: 14px;
        padding: 8px 16px;
        width: 100%;
        justify-content: center;
    }

    .filter-bar {
        padding: 10px 12px;
    }
    .search-box {
        min-width: 0;
    }
    .search-box input {
        font-size: 14px;
        padding: 8px 12px 8px 36px;
    }

    .table-scroll table {
        font-size: 14px;
    }
    .table-scroll table thead th {
        font-size: 12px;
        padding: 10px 12px;
    }
    .table-scroll table tbody td {
        padding: 10px 12px;
        font-size: 14px;
    }

    .table-scroll .medal-emoji {
        font-size: 22px;
    }
    .table-scroll .rank-number {
        font-size: 15px;
    }
    @endif

    .modal-custom .modal-body {
        padding: 16px;
    }
    .modal-custom .modal-header .modal-title {
        font-size: 18px;
    }
    .bg-light-custom .value {
        font-size: 24px;
    }
    #modalNamaTim {
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    @if(Auth::check())
    .page-header h4 {
        font-size: 17px;
    }
    .table-scroll table {
        font-size: 13px;
    }
    .table-scroll table tbody td {
        font-size: 13px;
        padding: 8px 10px;
    }
    .table-scroll table thead th {
        font-size: 11px;
        padding: 8px 10px;
    }
    .table-scroll .medal-emoji {
        font-size: 18px;
    }
    .table-scroll .rank-number {
        font-size: 13px;
    }
    @endif
}
</style>

<!-- ===== CONTENT ===== -->

@if(Auth::check())
<!-- ===== TAMPILAN PANITIA / ADMIN ===== -->
<div class="ranking-page">
    <div class="page-header">
        <h4><i class="fas fa-trophy"></i> Ranking Lomba</h4>
        
        @if(Auth::user()->isPanitia() || Auth::user()->isSuperAdmin())
            <a href="{{ route('penghargaan.index') }}" class="btn-award">
                <i class="fas fa-award"></i> Penghargaan
            </a>
        @endif
    </div>

    <div class="filter-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama tim...">
        </div>
    </div>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table id="rankingTable">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">Rank</th>
                        <th style="min-width: 180px;">Nama Tim</th>
                        <th style="min-width: 100px; text-align: center;">Total Nilai</th>
                        <th style="min-width: 100px; text-align: center;">Jumlah Menang</th>
                        <th style="width: 70px; text-align: center;">Aksi</th>
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
                            <td class="fw-semibold">{{ $item['tim']->nama_tim }}</td>
                            <td style="text-align: center;">
                                {{ number_format($item['total_nilai'], 1, ',', '.') }}
                            </td>
                            <td style="text-align: center;">{{ $item['jml_menang'] }}</td>
                            <td style="text-align: center;">
                                <button class="btn-action btn-info" title="Detail" onclick="openModal(
                                    '{{ addslashes($item['tim']->nama_tim) }}',
                                    {{ $item['total_nilai'] }},
                                    {{ $item['jml_menang'] }},
                                    {{ json_encode($item['detail']) }},
                                    {{ json_encode($item['tim']->load('pesertas', 'dosenPembimbing', 'kakakPembimbing')) }}
                                )">
                                    <i class="fas fa-eye"></i>
                                </button>
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
</div>

@else
<!-- ===== TAMPILAN PUBLIC ===== -->
<div class="ranking-page">
    <div class="public-ranking-wrapper">
        <!-- Public Header -->
        <div class="public-header">
            <h1><i class="fas fa-trophy"></i> Ranking Lomba Liga Perkasa</h1>
            <p>Berikut adalah daftar peringkat tim berdasarkan total nilai yang telah dikumpulkan.</p>
        </div>

        <!-- Public Search -->
        <div class="public-search">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="publicSearchInput" placeholder="Cari nama tim...">
            </div>
        </div>

        <!-- Public Table -->
        <div class="public-table-wrapper">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">Rank</th>
                            <th style="min-width: 180px;">Nama Tim</th>
                            <th style="min-width: 100px; text-align: center;">Total Nilai</th>
                            <th style="min-width: 100px; text-align: center;">Jumlah Menang</th>
                            <th style="width: 70px; text-align: center;">Aksi</th> <!-- Kolom Aksi Ditambahkan -->
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
                                <td class="tim-name">{{ $item['tim']->nama_tim }}</td>
                                <td class="total-nilai" style="text-align: center;">
                                    {{ number_format($item['total_nilai'], 1, ',', '.') }}
                                </td>
                                <td class="jml-menang" style="text-align: center;">{{ $item['jml_menang'] }}</td>
                                <td style="text-align: center;">
                                    <button class="btn-action-public" title="Detail" onclick="openModal(
                                        '{{ addslashes($item['tim']->nama_tim) }}',
                                        {{ $item['total_nilai'] }},
                                        {{ $item['jml_menang'] }},
                                        {{ json_encode($item['detail']) }},
                                        {{ json_encode($item['tim']->load('pesertas', 'dosenPembimbing', 'kakakPembimbing')) }}
                                    )">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
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

<!-- ===== MODAL (Sama untuk semua) ===== -->
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
                <div class="text-center mb-4">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #ffc107; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-trophy" style="font-size: 36px; color: #000000;"></i>
                    </div>
                    <h5 class="mt-3 fw-bold" id="modalNamaTim">-</h5>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="bg-light-custom">
                            <div class="value" id="modalTotalNilai">-</div>
                            <div class="label">Total Nilai</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light-custom">
                            <div class="value" id="modalJumlahMenang">-</div>
                            <div class="label">Jumlah Menang</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <span class="info-label">Ketua Tim</span>
                        <div id="modalKetua" style="font-size: 15px; color: #000000;">-</div>
                    </div>
                    <div class="col-md-4">
                        <span class="info-label">Dosen Pembimbing</span>
                        <div id="modalDosen" style="font-size: 15px; color: #000000;">-</div>
                    </div>
                    <div class="col-md-4">
                        <span class="info-label">Kakak Mentor</span>
                        <div id="modalKakak" style="font-size: 15px; color: #000000;">-</div>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="info-label">Anggota Tim</span>
                    <div id="modalAnggota" style="font-size: 15px; color: #000000;">-</div>
                </div>

                <div class="mt-3">
                    <span class="info-label">Detail Lomba yang Dimenangkan</span>
                    <div id="modalDetailLomba" style="font-size: 15px; color: #000000;">-</div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Search untuk Auth
    @if(Auth::check())
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#rankingTable tbody tr');
            
            rows.forEach(row => {
                if (row.querySelector('.empty-state')) return;
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });
    }
    @endif

    // Search untuk Public
    @if(!Auth::check())
    const publicSearch = document.getElementById('publicSearchInput');
    if (publicSearch) {
        publicSearch.addEventListener('keyup', function() {
            const value = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.public-table-wrapper tbody tr');
            
            rows.forEach(row => {
                if (row.querySelector('.public-empty')) return;
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });
    }
    @endif
});

function openModal(namaTim, totalNilai, jumlahMenang, detail, timData) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    
    document.getElementById('modalNamaTim').textContent = namaTim || '-';
    document.getElementById('modalTotalNilai').textContent = parseFloat(totalNilai).toFixed(1).replace('.', ',');
    document.getElementById('modalJumlahMenang').textContent = jumlahMenang || 0;

    let ketua = '-', anggotaHtml = '-';
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

    let detailHtml = '-';
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
</script>
@endsection