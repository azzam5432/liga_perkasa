@extends('layouts.master')

@section('title', 'Penilaian - ' . $lomba->nama_lomba)

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

.btn-submit-nilai {
    background: linear-gradient(135deg, #48bb78, #38a169);
    border: none;
    color: white;
    padding: 8px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-submit-nilai:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(72, 187, 120, 0.35);
    color: white;
}

.btn-submit-nilai:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
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

.podium-juara {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.podium-card {
    flex: 1;
    min-width: 200px;
    border: 2px solid #edf2f7;
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    background: #ffffff;
}

.podium-card:hover {
    border-color: #1a365d;
    background: #f7fafc;
}

.podium-card.selected {
    border-color: #1a365d;
    background: #ebf8ff;
}

.podium-card .podium-icon {
    font-size: 32px;
    margin-bottom: 8px;
}

.podium-card .podium-label {
    font-weight: 700;
    font-size: 14px;
    color: #1a2332;
    margin-bottom: 6px;
}

.podium-card .podium-poin {
    font-size: 12px;
    color: #718096;
    margin-bottom: 8px;
}

.podium-card .podium-tim {
    font-weight: 600;
    font-size: 13px;
    color: #1a365d;
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

.table-scroll table tbody tr.selected {
    background: #ebf8ff !important;
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
    .podium-juara {
        flex-direction: column;
    }
    .podium-card {
        min-width: 100%;
    }
    .table-scroll table {
        font-size: 13px;
        min-width: 500px;
    }
}
</style>

<div class="page-header">
    <h4>
        <i class="fas fa-pen me-2"></i> Penilaian - {{ $lomba->nama_lomba }}
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('nilai.index') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" form="formNilai" class="btn-submit-nilai" id="btnSimpanNilai">
            <i class="fas fa-save"></i> Simpan Nilai
        </button>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($sudahDinilai) && $sudahDinilai)
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Lomba ini sudah dinilai oleh <strong>{{ $juriYangMenilai->user->name ?? 'Juri' }}</strong>. Anda tidak bisa menilai lagi.
    </div>
@endif

<div class="info-badge mb-3">
    <span><i class="fas fa-trophy me-1"></i> Bobot: <strong>{{ $lomba->bobot }}</strong></span>
    <span class="ms-2"><i class="fas fa-info-circle me-1"></i> Juara 1: {{ $lomba->bobot * 3 }} poin, Juara 2: {{ $lomba->bobot * 2 }} poin, Juara 3: {{ $lomba->bobot }} poin</span>
    @if($lomba->is_final_active)
        <span class="ms-2"><i class="fas fa-trophy text-info me-1"></i> Babak Final</span>
    @endif
</div>

<div class="table-wrapper">
    <div class="table-scroll">
        <form action="{{ route('nilai.store') }}" method="POST" id="formNilai">
            @csrf
            <input type="hidden" name="id_lomba" value="{{ $lomba->id_lomba }}">

            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th style="min-width: 200px;">Nama Tim</th>
                        <th style="text-align: center; width: 120px;">Juara 1</th>
                        <th style="text-align: center; width: 120px;">Juara 2</th>
                        <th style="text-align: center; width: 120px;">Juara 3</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim as $index => $t)
                        <tr id="row-{{ $t->id_tim }}" class="tim-row">
                            <td style="text-align: center; font-weight: 600; color: #1a2332;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="fw-semibold">{{ $t->nama_tim }}</td>
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="juara_1" 
                                       value="{{ $t->id_tim }}" 
                                       class="tim-radio"
                                       id="juara1-{{ $t->id_tim }}"
                                       onchange="onJuaraSelected(1, {{ $t->id_tim }})"
                                       @if(isset($sudahDinilai) && $sudahDinilai) disabled @endif>
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="juara_2" 
                                       value="{{ $t->id_tim }}" 
                                       class="tim-radio"
                                       id="juara2-{{ $t->id_tim }}"
                                       onchange="onJuaraSelected(2, {{ $t->id_tim }})"
                                       @if(isset($sudahDinilai) && $sudahDinilai) disabled @endif>
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="juara_3" 
                                       value="{{ $t->id_tim }}" 
                                       class="tim-radio"
                                       id="juara3-{{ $t->id_tim }}"
                                       onchange="onJuaraSelected(3, {{ $t->id_tim }})"
                                       @if(isset($sudahDinilai) && $sudahDinilai) disabled @endif>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h6>Belum ada data tim</h6>
                                    <p>Silakan tambahkan tim terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
let selectedJuara = { 1: null, 2: null, 3: null };

function onJuaraSelected(juara, timId) {
    // Hapus radio lain yang sama di juara tersebut
    document.querySelectorAll('input[name="juara_' + juara + '"]').forEach(radio => {
        if (radio.value != timId) {
            radio.checked = false;
        }
    });

    // Cek duplikat di juara lain
    for (let j = 1; j <= 3; j++) {
        if (j != juara && selectedJuara[j] == timId) {
            alert('Tim ini sudah dipilih sebagai Juara ' + j + '!');
            document.querySelector('input[name="juara_' + juara + '"][value="' + timId + '"]').checked = false;
            selectedJuara[juara] = null;
            return;
        }
    }

    selectedJuara[juara] = timId;

    // Highlight row jika dipilih sebagai juara
    document.querySelectorAll('.tim-row').forEach(row => {
        row.classList.remove('selected');
    });

    for (let j = 1; j <= 3; j++) {
        if (selectedJuara[j]) {
            const row = document.getElementById('row-' + selectedJuara[j]);
            if (row) {
                row.classList.add('selected');
            }
        }
    }

    updatePodium();
}

function updatePodium() {
    const podiumElements = {
        1: document.getElementById('podium-tim-1'),
        2: document.getElementById('podium-tim-2'),
        3: document.getElementById('podium-tim-3')
    };

    for (let j = 1; j <= 3; j++) {
        if (selectedJuara[j]) {
            const row = document.getElementById('row-' + selectedJuara[j]);
            const nama = row ? row.querySelector('.fw-semibold').textContent : '-';
            if (podiumElements[j]) {
                podiumElements[j].textContent = nama;
            }
        } else {
            if (podiumElements[j]) {
                podiumElements[j].textContent = 'Belum dipilih';
            }
        }
    }
}

document.getElementById('formNilai').addEventListener('submit', function(e) {
    @if(isset($sudahDinilai) && $sudahDinilai)
        e.preventDefault();
        alert('⚠️ Lomba ini sudah dinilai!');
        return false;
    @endif

    if (selectedJuara[1] === null || selectedJuara[2] === null || selectedJuara[3] === null) {
        e.preventDefault();
        alert('⚠️ Silakan pilih Juara 1, 2, dan 3!');
        return false;
    }

    const namaJuara1 = document.querySelector('#row-' + selectedJuara[1] + ' .fw-semibold')?.textContent || 'Tim';
    const bobot = {{ $lomba->bobot }};
    const poin1 = bobot * 3;

    if (!confirm(`Yakin dengan penilaian berikut?\n\nJuara 1: ${namaJuara1} (${poin1} poin)\n\nTim lain akan mendapat 0 poin.`)) {
        e.preventDefault();
        return false;
    }

    const btn = document.getElementById('btnSimpanNilai');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Menyimpan...';

    return true;
});
</script>
@endsection