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

.search-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 8px 14px 8px 38px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
    background: #f7fafc;
    color: #1a2332;
}

.search-box input:focus {
    outline: none;
    border-color: #1a365d;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.06);
}

.search-box input::placeholder {
    color: #a0aec0;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 14px;
}

.filter-bar {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
    background: #ffffff;
    padding: 12px 16px;
    border-radius: 10px;
    border: 1px solid #edf2f7;
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

.medal-emoji {
    font-size: 22px;
    line-height: 1;
}

.rank-number {
    font-size: 14px;
    font-weight: 700;
    color: #4a5568;
}

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

.btn-action.btn-info {
    color: #2b6cb0;
}

.btn-action.btn-info:hover {
    background: #ebf8ff;
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
    max-height: 70vh;
    overflow-y: auto;
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

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f7fafc;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .detail-lomba {
    font-weight: 600;
    font-size: 13px;
    color: #1a2332;
}

.detail-item .detail-babak {
    font-size: 11px;
    font-style: italic;
    color: #718096;
}

.detail-item .detail-nilai {
    font-weight: 700;
    font-size: 14px;
    color: #2b6cb0;
}

.info-list {
    padding: 0;
    margin: 0;
    list-style: none;
}

.info-list li {
    padding: 6px 0;
    font-size: 13px;
    color: #1a2332;
    border-bottom: 1px solid #f7fafc;
}

.info-list li:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .page-header h4 {
        font-size: 16px;
        margin: 0;
    }

    .filter-bar {
        flex-direction: row;
        align-items: center;
        padding: 10px 12px;
        gap: 8px;
    }
    .search-box {
        flex: 1;
        min-width: 0;
    }

    .table-scroll table thead th:nth-child(1),
    .table-scroll table thead th:nth-child(2),
    .table-scroll table thead th:nth-child(3),
    .table-scroll table thead th:last-child {
        display: table-cell;
    }

    .table-scroll table thead th:nth-child(4) {
        display: none;
    }

    .table-scroll table tbody td:nth-child(1),
    .table-scroll table tbody td:nth-child(2),
    .table-scroll table tbody td:nth-child(3),
    .table-scroll table tbody td:last-child {
        display: table-cell;
    }

    .table-scroll table tbody td:nth-child(4) {
        display: none;
    }
}
</style>

<div class="page-header">
    <h4><i class="fas fa-trophy me-2"></i> Ranking Lomba Liga Perkasa</h4>
</div>

<div class="filter-bar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari nama tim..." onkeyup="filterTable()">
    </div>
</div>

<div class="table-wrapper">
    <div class="table-scroll">
        <table id="rankingTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Rank</th>
                    <th style="min-width: 200px;">Nama Tim</th>
                    <th style="min-width: 100px;">Total Nilai</th>
                    <th style="min-width: 100px;">Jumlah Menang</th>
                    <th style="width: 80px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapTim as $index => $item)
                    <tr>
                        <td>
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
                        <td>{{ $item['total_nilai'] }}</td>
                        <td>{{ $item['jml_menang'] }}</td>
                        <td style="text-align: center;">
                            <button class="btn-action btn-info" title="Detail" onclick="openShowRankingModal(
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

<div class="modal fade modal-custom" id="showRankingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #bee3f8;">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2" style="color: #2b6cb0;"></i> Detail Ranking
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1a365d, #2b6cb0); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto; border: 3px solid #e2e8f0;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="mt-2 fw-bold" id="showNamaTim">-</h5>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="fw-bold" style="font-size: 24px; color: #1a365d;" id="showTotalNilai">-</div>
                            <small class="text-muted">Total Nilai</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="fw-bold" style="font-size: 24px; color: #1a365d;" id="showJumlahMenang">-</div>
                            <small class="text-muted">Jumlah Menang</small>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold d-block mb-2">Ketua Tim</label>
                        <div id="showKetuaTim"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold d-block mb-2">Dosen Pembimbing</label>
                        <div id="showDosenPembimbing"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold d-block mb-2">Kakak Pembimbing</label>
                        <div id="showKakakPembimbing"></div>
                    </div>
                </div>

                <label class="text-muted small fw-bold d-block mb-2">Anggota Tim</label>
                <div id="showAnggotaTim"></div>

                <label class="text-muted small fw-bold d-block mt-4 mb-2">Detail Lomba yang Menang</label>
                <div id="showDetailLomba"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#rankingTable tbody tr');

    rows.forEach(row => {
        if (row.querySelector('.empty-state')) return;

        const nama = row.querySelector('td:nth-child(2) .fw-semibold')?.textContent.toLowerCase() || '';

        let show = true;
        if (searchInput && !nama.includes(searchInput)) {
            show = false;
        }
        row.style.display = show ? '' : 'none';
    });
}

function openShowRankingModal(namaTim, totalNilai, jumlahMenang, detail, timData) {
    const modalElement = document.getElementById('showRankingModal');
    const modal = new bootstrap.Modal(modalElement);
    
    document.getElementById('showNamaTim').textContent = namaTim || '-';
    document.getElementById('showTotalNilai').textContent = totalNilai || 0;
    document.getElementById('showJumlahMenang').textContent = jumlahMenang || 0;
    
    const ketuaContainer = document.getElementById('showKetuaTim');
    const dosenContainer = document.getElementById('showDosenPembimbing');
    const kakakContainer = document.getElementById('showKakakPembimbing');
    const anggotaContainer = document.getElementById('showAnggotaTim');
    const detailContainer = document.getElementById('showDetailLomba');
    
    if (timData && timData.pesertas) {
        const ketua = timData.pesertas.find(p => p.ketua_peserta);
        const anggota = timData.pesertas.filter(p => !p.ketua_peserta);
        
        ketuaContainer.innerHTML = ketua ? `<ul class="info-list"><li>${ketua.ketua_peserta || '-'}</li></ul>` : '<ul class="info-list"><li>-</li></ul>';
        
        if (anggota.length > 0) {
            anggotaContainer.innerHTML = '<ul class="info-list">' + anggota.map(function(member) {
                return `<li>${member.nama_peserta || '-'}</li>`;
            }).join('') + '</ul>';
        } else {
            anggotaContainer.innerHTML = '<ul class="info-list"><li>-</li></ul>';
        }
    } else {
        ketuaContainer.innerHTML = '<ul class="info-list"><li>-</li></ul>';
        anggotaContainer.innerHTML = '<ul class="info-list"><li>-</li></ul>';
    }
    
    if (timData && timData.dosen_pembimbing) {
        const dosen = timData.dosen_pembimbing;
        dosenContainer.innerHTML = dosen.length > 0 ? '<ul class="info-list">' + dosen.map(function(d) {
            return `<li>${d.nama_dosen || '-'}</li>`;
        }).join('') + '</ul>' : '<ul class="info-list"><li>-</li></ul>';
    } else {
        dosenContainer.innerHTML = '<ul class="info-list"><li>-</li></ul>';
    }
    
    if (timData && timData.kakak_pembimbing) {
        const kakak = timData.kakak_pembimbing;
        kakakContainer.innerHTML = kakak.length > 0 ? '<ul class="info-list">' + kakak.map(function(k) {
            return `<li>${k.nama_kakak || '-'}</li>`;
        }).join('') + '</ul>' : '<ul class="info-list"><li>-</li></ul>';
    } else {
        kakakContainer.innerHTML = '<ul class="info-list"><li>-</li></ul>';
    }
    
    if (detail && Array.isArray(detail) && detail.length > 0) {
        let html = '';
        detail.forEach(function(item) {
            const babakLabel = item.babak ? item.babak.charAt(0).toUpperCase() + item.babak.slice(1) : '';
            html += `
                <div class="detail-item">
                    <div>
                        <div class="detail-lomba">${item.lomba || '-'} ${babakLabel ? `<span class="detail-babak">(${babakLabel})</span>` : ''}</div>
                    </div>
                    <div class="detail-nilai">${item.nilai}</div>
                </div>
            `;
        });
        detailContainer.innerHTML = html;
    } else {
        detailContainer.innerHTML = '<div class="text-center text-muted py-3">Tidak ada data</div>';
    }
    
    modal.show();
}
</script>
@endsection