@extends('layouts.public')

@section('title', 'Daftar Lomba')

@section('content')
<style>
.page-header {
    text-align: center;
    margin-bottom: 30px;
    color: #ffffff;
    margin-top: 20px;
}

.page-header h1 {
    font-size: 36px;
    font-weight: 800;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    letter-spacing: 1px;
}

.page-header p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin-top: 8px;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
}

.info-poin {
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    text-align: center;
    color: #ffd700;
}

.info-poin strong {
    color: #ffffff;
}

.table-wrapper {
    background: rgba(0, 0, 0, 0.6);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    overflow: hidden;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
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
    background: rgba(255, 215, 0, 0.1);
    color: #ffd700;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 14px 18px;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    text-align: left;
    white-space: nowrap;
}

.table-scroll table tbody td {
    padding: 14px 18px;
    vertical-align: middle;
    color: rgba(255, 255, 255, 0.95);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 15px;
}

.table-scroll table tbody tr:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* TAMPILAN MULTI-LINE UNTUK JUARA 3 */
.podium-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: center;
}

.podium-item {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 8px;
    padding: 4px 10px;
    font-size: 13px;
}

.podium-item .poin {
    color: #ffd700;
    font-weight: 700;
    font-size: 12px;
}

.empty-state {
    padding: 40px 16px;
    text-align: center;
    color: #ffffff;
}

.empty-state i {
    font-size: 48px;
    color: rgba(255, 215, 0, 0.3);
    margin-bottom: 12px;
    display: block;
}

.empty-state h6 {
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 4px;
}

.empty-state p {
    color: rgba(255, 255, 255, 0.6);
    font-size: 15px;
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 24px;
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

    /* Di mobile, badge juara 3 jadi lebih kecil */
    .podium-item {
        font-size: 12px;
        padding: 3px 8px;
    }
}
</style>

<div class="page-header">
    <h1><i class="fas fa-trophy"></i> Daftar Lomba</h1>
    <p>Berikut adalah daftar lomba beserta juara 1, 2, dan 3 di setiap lomba.</p>
</div>

<div class="info-poin">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Juara 1 = 3 × Bobot</strong> | 
    <strong>Juara 2 = 2 × Bobot</strong> | 
    <strong>Juara 3 = 1 × Bobot</strong>
</div>

<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Nama Lomba</th>
                    <th style="text-align: center;">Bobot</th>
                    <th style="text-align: center;">Juara 1</th>
                    <th style="text-align: center;">Juara 2</th>
                    <th style="text-align: center;">Juara 3</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lombas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: #ffffff;">{{ $item['lomba']->nama_lomba }}</td>
                        <td style="text-align: center;">
                            <span style="color: #ffd700; font-weight: 700;">{{ $item['bobot'] }}</span>
                        </td>
                        <td style="text-align: center;">
                            @if($item['juara1'] && $item['juara1']->count() > 0)
                                <div class="podium-list">
                                    @foreach($item['juara1'] as $juara1)
                                        <div class="podium-item">
                                            <span>{{ $juara1->nama_tim }}</span>
                                            <span class="poin">(+{{ number_format($item['bobot'] * 3, 1, ',', '.') }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: rgba(255,255,255,0.5);">Belum ada</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($item['juara2'] && $item['juara2']->count() > 0)
                                <div class="podium-list">
                                    @foreach($item['juara2'] as $juara2)
                                        <div class="podium-item">
                                            <span>{{ $juara2->nama_tim }}</span>
                                            <span class="poin">(+{{ number_format($item['bobot'] * 2, 1, ',', '.') }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: rgba(255,255,255,0.5);">Belum ada</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($item['juara3'] && $item['juara3']->count() > 0)
                                <div class="podium-list">
                                    @foreach($item['juara3'] as $juara3)
                                        @php
                                            // Satu tim bisa dapat Juara 3 lebih dari satu kali: jumlahkan semua barisnya
                                            $jumlah = $item['lomba']->nilai->where('juara', 3)->where('id_tim', $juara3->id_tim)->sum('jumlah');
                                        @endphp
                                        <div class="podium-item">
                                            <span>{{ $juara3->nama_tim }}</span>
                                            <span class="poin">(+{{ number_format($item['bobot'], 1, ',', '.') }} × {{ $jumlah }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: rgba(255,255,255,0.5);">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <h6>Belum ada lomba</h6>
                                <p>Belum ada data lomba yang tersedia.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection