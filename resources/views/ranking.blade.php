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
                                <button class="btn-action btn-info btn-detail-tim" 
                                        data-nama-tim="{{ $item['tim']->nama_tim }}"
                                        data-total-nilai="{{ $item['total_nilai'] }}"
                                        data-jml-menang="{{ $item['jml_menang'] }}"
                                        data-detail='{{ json_encode($item['detail']) }}'
                                        data-tim='{{ json_encode($item['tim']->load('pesertas', 'dosenPembimbing', 'kakakPembimbing')) }}'
                                        data-penghargaan='{{ json_encode($item['penghargaan'] ?? []) }}'
                                        title="Detail">
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
                                <td class="tim-name">{{ $item['tim']->nama_tim }}</td>
                                <td class="total-nilai" style="text-align: center;">
                                    {{ number_format($item['total_nilai'], 1, ',', '.') }}
                                </td>
                                <td class="jml-menang" style="text-align: center;">{{ $item['jml_menang'] }}</td>
                                <td style="text-align: center;">
                                    <button class="btn-action-public btn-detail-tim-public" 
                                            data-nama-tim="{{ $item['tim']->nama_tim }}"
                                            data-total-nilai="{{ $item['total_nilai'] }}"
                                            data-jml-menang="{{ $item['jml_menang'] }}"
                                            data-detail='{{ json_encode($item['detail']) }}'
                                            data-tim='{{ json_encode($item['tim']->load('pesertas', 'dosenPembimbing', 'kakakPembimbing')) }}'
                                            data-penghargaan='{{ json_encode($item['penghargaan'] ?? []) }}'
                                            title="Detail">
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

                <!-- Statistik Utama -->
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

                <div class="mb-4 p-3" style="background: #fff8e1; border: 1px solid #ffe082; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #f57f17;">
                        <i class="fas fa-award me-2"></i> Penghargaan
                    </h6>
                    <div id="modalPenghargaan" style="font-size: 15px; color: #000000;">
                        <span class="text-muted">Tidak ada penghargaan</span>
                    </div>
                </div>

                <!-- SECTION: DETAIL LOMBA (Biru) -->
                <div class="mb-4 p-3" style="background: #e3f2fd; border: 1px solid #90caf9; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #1565c0;">
                        <i class="fas fa-trophy me-2"></i> Detail Lomba yang Dimenangkan
                    </h6>
                    <div id="modalDetailLomba" style="font-size: 15px; color: #000000;">
                        <span class="text-muted">Tidak ada lomba yang dimenangkan</span>
                    </div>
                </div>
                <!-- SECTION: PEMBIMBING (Abu-abu) -->
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

                <!-- SECTION: KETUA TIM (Ungu) -->
                <div class="mb-4 p-3" style="background: #f3e5f5; border: 1px solid #ce93d8; border-radius: 10px;">
                    <h6 class="fw-bold mb-2" style="color: #6a1b9a;">
                        <i class="fas fa-crown me-2"></i> Ketua Tim
                    </h6>
                    <div id="modalKetua" style="font-size: 15px; color: #000000;">-</div>
                </div>

                <!-- SECTION: ANGGOTA TIM (Hijau) -->
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
// ===== ARRAY UNTUK MENYIMPAN DATA TIM =====
let timDataArray = {};

// ===== FUNGSI UNTUK MENGAMBIL DATA RANKING =====
function fetchRanking() {
    fetch('/ranking/data')
        .then(response => response.json())
        .then(data => {
            // Simpan data ke array global untuk digunakan saat klik
            data.forEach((item, index) => {
                timDataArray[item.tim.nama_tim] = item;
            });

            // Update tabel untuk Auth (jika ada)
            if (document.querySelector('#rankingTable tbody')) {
                updateRankingTable(data);
            }
            // Update tabel untuk Public (jika ada)
            if (document.querySelector('.public-table-wrapper tbody')) {
                updatePublicRankingTable(data);
            }
        })
        .catch(error => console.error('Error fetching ranking:', error));
}

// ===== UPDATE TABEL UNTUK AUTH (Panitia/Admin) =====
function updateRankingTable(data) {
    const tbody = document.querySelector('#rankingTable tbody');
    if (!tbody) return;

    // Kosongkan tabel
    tbody.innerHTML = '';

    // Loop data
    data.forEach((item, index) => {
        const row = document.createElement('tr');

        // Rank
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

        // Nama Tim
        const nameCell = document.createElement('td');
        nameCell.className = 'fw-semibold';
        nameCell.textContent = item.tim.nama_tim;
        row.appendChild(nameCell);

        // Total Nilai
        const totalCell = document.createElement('td');
        totalCell.style.textAlign = 'center';
        totalCell.textContent = Number(item.total_nilai).toFixed(1).replace('.', ',');
        row.appendChild(totalCell);

        // Jumlah Menang
        const menangCell = document.createElement('td');
        menangCell.style.textAlign = 'center';
        menangCell.textContent = item.jml_menang;
        row.appendChild(menangCell);

        // Aksi (Detail) - HANYA NAMA TIM YANG DISIMPAN DI DATA ATTRIBUTE
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

// ===== UPDATE TABEL UNTUK PUBLIC =====
function updatePublicRankingTable(data) {
    const tbody = document.querySelector('.public-table-wrapper tbody');
    if (!tbody) return;

    // Kosongkan tabel
    tbody.innerHTML = '';

    // Loop data
    data.forEach((item, index) => {
        const row = document.createElement('tr');

        // Rank
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

        // Nama Tim
        const nameCell = document.createElement('td');
        nameCell.className = 'tim-name';
        nameCell.textContent = item.tim.nama_tim;
        row.appendChild(nameCell);

        // Total Nilai
        const totalCell = document.createElement('td');
        totalCell.className = 'total-nilai';
        totalCell.style.textAlign = 'center';
        totalCell.textContent = Number(item.total_nilai).toFixed(1).replace('.', ',');
        row.appendChild(totalCell);

        // Jumlah Menang
        const menangCell = document.createElement('td');
        menangCell.className = 'jml-menang';
        menangCell.style.textAlign = 'center';
        menangCell.textContent = item.jml_menang;
        row.appendChild(menangCell);

        // Aksi (Detail) - HANYA NAMA TIM YANG DISIMPAN DI DATA ATTRIBUTE
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

// ===== EVENT DELEGATION (AGAR TOMBOL SELALU BERFUNGSI) =====
document.addEventListener('click', function(event) {
    // Untuk tombol Auth
    const btnAuth = event.target.closest('.btn-detail-tim');
    if (btnAuth) {
        const namaTim = btnAuth.getAttribute('data-nama-tim');
        const item = timDataArray[namaTim];
        if (item) {
            openModal(item.tim.nama_tim, item.total_nilai, item.jml_menang, item.detail, item.tim, item.penghargaan);
        }
    }

    // Untuk tombol Public
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
    document.getElementById('modalJumlahMenang').textContent = jumlahMenang || 0;

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

// Panggil pertama kali saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    fetchRanking();
});
</script>
@endsection