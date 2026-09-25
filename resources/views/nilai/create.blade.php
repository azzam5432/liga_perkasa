@extends('layouts.master')

@section('title', 'Penilaian - ' . $lomba->nama_lomba)

@php
    $isEdit = $isEdit ?? false;
@endphp

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
    min-width: 700px;
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

.gelar-box {
    display: inline-block;
    position: relative;
    margin: 2px 3px;
    cursor: pointer;
    user-select: none;
}

.gelar-box input {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
    margin: 0;
    pointer-events: none;
}

.gelar-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    padding: 4px 12px;
    border-radius: 18px;
    border: 1.5px solid #cbd5e0;
    background: #ffffff;
    color: #718096;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    transition: all 0.15s ease;
}

.gelar-box:hover .gelar-pill {
    border-color: #1a365d;
    color: #1a365d;
}

.gelar-box input:checked + .gelar-pill {
    background: #1a365d;
    border-color: #1a365d;
    color: #ffffff;
}

/* Slot centang selalu tersedia supaya lebar pill tidak berubah saat dipilih */
.gelar-pill::after {
    content: "";
    display: inline-block;
    width: 13px;
}

.gelar-box input:checked + .gelar-pill::after {
    content: "\2713";
}

.gelar-box input:disabled + .gelar-pill {
    opacity: 0.5;
    cursor: not-allowed;
}

.gelar-box input:disabled:checked + .gelar-pill {
    opacity: 1;
}

.gelar-box input:focus-visible + .gelar-pill {
    outline: 2px solid #4299e1;
    outline-offset: 2px;
}

.j3-jumlah {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin-left: 2px;
    vertical-align: middle;
    visibility: hidden; /* ruang dicadangkan, jadi baris tidak bergeser */
}

.j3-jumlah.show {
    visibility: visible;
}

.j3-x {
    font-size: 13px;
    font-weight: 700;
    color: #718096;
}

.jumlah-j3 {
    width: 52px;
    text-align: center;
    padding: 3px 4px;
    border: 1.5px solid #cbd5e0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1a365d;
    background: #f7fafc;
}

.jumlah-j3:focus {
    outline: none;
    border-color: #1a365d;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.08);
}

.jumlah-j3:disabled {
    opacity: 0.5;
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
        min-width: 560px;
    }
}
</style>
<div class="page-header">
    <h4>
        <i class="fas fa-pen me-2"></i> {{ $isEdit ? 'Edit Penilaian' : 'Penilaian' }} - {{ $lomba->nama_lomba }}
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('nilai.index') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        @if(isset($sudahDinilai) && $sudahDinilai && !$isEdit)
            <a href="{{ route('nilai.edit', $lomba->id_lomba) }}" class="btn-secondary-custom">
                <i class="fas fa-edit"></i> Edit Nilai
            </a>
        @endif
        <button type="submit" form="formNilai" class="btn-submit-nilai" id="btnSimpanNilai">
            <i class="fas fa-save"></i> {{ $isEdit ? 'Perbarui Nilai' : 'Simpan Nilai' }}
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
    @if($isEdit)
        <div class="alert alert-warning">
            <i class="fas fa-edit me-2"></i>
            Mode <strong>Edit</strong>: Anda sedang mengubah penilaian babak <strong>{{ $babak }}</strong>. Perubahan akan menimpa nilai lama.
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Lomba ini sudah dinilai di <strong>{{ $babak }}</strong>. Input dinonaktifkan — gunakan tombol <strong>Edit Nilai</strong> untuk mengubah.
        </div>
    @endif
@endif

<div class="info-badge mb-3">
    <span><i class="fas fa-trophy me-1"></i> Bobot: <strong>{{ $lomba->bobot }}</strong></span>
    <span class="ms-2"><i class="fas fa-info-circle me-1"></i> Juara 1: {{ $lomba->bobot * 3 }} poin, Juara 2: {{ $lomba->bobot * 2 }} poin, Juara 3: {{ $lomba->bobot }} poin</span>
    @if($lomba->is_final_active)
        <span class="ms-2"><i class="fas fa-trophy text-info me-1"></i> Babak Final</span>
    @endif
</div>

<div class="alert alert-light border mb-3" style="font-size: 13px;">
    <i class="fas fa-lightbulb text-warning me-1"></i>
    Satu tim bisa mendapat <strong>lebih dari satu gelar</strong> sekaligus (misalnya Juara 1 sekaligus Juara 2). Untuk <strong>Juara 3</strong>: bisa diisi lebih dari satu tim, dan satu tim bisa mendapat Juara 3 lebih dari satu kali — atur kolom <strong>Jumlah</strong> yang muncul saat mencentang J3.
</div>
<div class="table-wrapper">
    <div class="table-scroll">
        <form action="{{ $isEdit ? route('nilai.update', $lomba->id_lomba) : route('nilai.store') }}" method="POST" id="formNilai">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <input type="hidden" name="id_lomba" value="{{ $lomba->id_lomba }}">

            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th style="min-width: 200px;">Nama Tim</th>
                        <th style="text-align: center;">Gelar</th>
                        <th style="text-align: center; width: 150px;">Total Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim as $index => $t)
                        @php
                            $nilaiTim = $nilaiExisting[$t->id_tim] ?? collect();
                            $gelarTim = $nilaiTim->pluck('juara')->filter()->values();
                            $totalTim = (float) $nilaiTim->sum('nilai');
                            $jumlahJ3Tersimpan = $nilaiTim->where('juara', 3)->count();
                            $inputDisabled = isset($sudahDinilai) && $sudahDinilai && !$isEdit;
                        @endphp
                        <tr id="row-{{ $t->id_tim }}" class="tim-row @if($gelarTim->isNotEmpty()) selected @endif">
                            <td style="text-align: center; font-weight: 600; color: #1a2332;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="fw-semibold">{{ $t->nama_tim }}</td>
                            <td style="text-align: center; white-space: nowrap;">
                                @foreach([1, 2, 3] as $gelar)
                                    <label class="gelar-box" title="Juara {{ $gelar }} = {{ $gelar == 1 ? $lomba->bobot * 3 : ($gelar == 2 ? $lomba->bobot * 2 : $lomba->bobot) }} poin">
                                        <input type="checkbox"
                                            name="gelar[{{ $t->id_tim }}][]"
                                            value="{{ $gelar }}"
                                            class="gelar-checkbox"
                                            data-tim="{{ $t->id_tim }}"
                                            @checked($gelarTim->contains($gelar))
                                            @disabled($inputDisabled)>
                                        <span class="gelar-pill gelar-pill-{{ $gelar }}">Juara {{ $gelar }}</span>
                                    </label>
                                    @if($gelar == 3)
                                        <span class="j3-jumlah @if($gelarTim->contains(3)) show @endif" id="j3-wrap-{{ $t->id_tim }}">
                                            <span class="j3-x">×</span>
                                            <input type="number"
                                                name="jumlah_j3_{{ $t->id_tim }}"
                                                id="jumlah-j3-{{ $t->id_tim }}"
                                                class="jumlah-j3"
                                                data-tim="{{ $t->id_tim }}"
                                                value="{{ max(1, $jumlahJ3Tersimpan) }}"
                                                min="1"
                                                title="Berapa kali tim ini mendapat Juara 3"
                                                @disabled($inputDisabled)>
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td style="text-align: center;" id="total-{{ $t->id_tim }}">
                                {{ $totalTim > 0 ? number_format($totalTim, 2) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
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
var POIN = {
    1: {{ $lomba->bobot * 3 }},
    2: {{ $lomba->bobot * 2 }},
    3: {{ $lomba->bobot }}
};

function jumlahJ3(timId) {
    var input = document.getElementById('jumlah-j3-' + timId);
    var val = parseInt(input ? input.value : '1', 10);
    return isNaN(val) || val < 1 ? 1 : val;
}

function hitungSemua() {
    document.querySelectorAll('.gelar-checkbox').forEach(function(cb) {
        var timId = cb.getAttribute('data-tim');
        var row = document.getElementById('row-' + timId);
        var total = 0;

        document.querySelectorAll('.gelar-checkbox[data-tim="' + timId + '"]').forEach(function(c) {
            if (c.checked) {
                var poin = parseFloat(POIN[c.value]) || 0;
                if (c.value == '3') {
                    poin *= jumlahJ3(timId);
                }
                total += poin;
            }
        });

        var el = document.getElementById('total-' + timId);
        if (el) {
            el.textContent = total > 0 ? total.toFixed(2).replace(/\.00$/, '') : '-';
        }
        if (row) {
            if (total > 0) {
                row.classList.add('selected');
            } else {
                row.classList.remove('selected');
            }
        }
    });
}

function timTerpilihGelar(timId, gelar) {
    var cb = document.querySelector('.gelar-checkbox[data-tim="' + timId + '"][value="' + gelar + '"]');
    return cb && cb.checked;
}

function hitungGelar(gelar) {
    var count = 0;
    document.querySelectorAll('.gelar-checkbox[value="' + gelar + '"]').forEach(function(cb) {
        if (cb.checked) {
            count++;
        }
    });
    return count;
}

document.querySelectorAll('.gelar-checkbox').forEach(function(cb) {
    cb.addEventListener('change', function() {
        var timId = cb.getAttribute('data-tim');
        var gelar = cb.value;

        // Juara 1 & 2: hanya boleh 1 tim. Juara 3: bebas (beberapa tim, boleh berulang).
        if (gelar != '3' && cb.checked && hitungGelar(gelar) > 1) {
            alert('Juara ' + gelar + ' hanya boleh dimiliki 1 tim!');
            cb.checked = false;
        }

        if (gelar == '3') {
            var wrapJumlah = document.getElementById('j3-wrap-' + timId);
            if (wrapJumlah) {
                wrapJumlah.classList.toggle('show', cb.checked);
            }
        }

        hitungSemua();
    });
});

document.querySelectorAll('.jumlah-j3').forEach(function(input) {
    input.addEventListener('input', hitungSemua);
});

document.getElementById('formNilai').addEventListener('submit', function(e) {
    @if(isset($sudahDinilai) && $sudahDinilai && !$isEdit)
        e.preventDefault();
        alert('Lomba ini sudah dinilai! Gunakan tombol Edit Nilai untuk mengubah.');
        return false;
    @endif

    var gelar1 = hitungGelar(1);
    var gelar2 = hitungGelar(2);
    var gelar3 = hitungGelar(3);

    if (gelar1 === 0 || gelar2 === 0 || gelar3 === 0) {
        e.preventDefault();
        alert('Silakan pilih tim untuk Juara 1, Juara 2, dan Juara 3!');
        return false;
    }

    if (gelar1 > 1 || gelar2 > 1) {
        e.preventDefault();
        alert('Juara 1 dan Juara 2 hanya boleh dimiliki satu tim (tim yang sama boleh memegang keduanya)!');
        return false;
    }

    var timJuara1 = document.querySelector('.gelar-checkbox[value="1"]:checked').getAttribute('data-tim');
    var namaJuara1 = document.querySelector('#row-' + timJuara1 + ' .fw-semibold') ? document.querySelector('#row-' + timJuara1 + ' .fw-semibold').textContent : 'Tim';

    var juara3List = [];
    document.querySelectorAll('.gelar-checkbox[value="3"]:checked').forEach(function(cb) {
        var tid = cb.getAttribute('data-tim');
        var nama = document.querySelector('#row-' + tid + ' .fw-semibold');
        var j = jumlahJ3(tid);
        juara3List.push((nama ? nama.textContent : 'Tim') + (j > 1 ? ' (x' + j + ')' : ''));
    });

    var pesanAksi = @json($isEdit) ? 'perubahan penilaian' : 'penilaian';
    var poinJuara1 = parseFloat(POIN[1]) || 0;

    if (!confirm('Yakin dengan ' + pesanAksi + ' berikut?\n\nJuara 1: ' + namaJuara1 + ' (' + poinJuara1 + ' poin)\nJuara 3: ' + juara3List.join(', ') + '\n\nSatu tim boleh mendapat lebih dari satu gelar; poin dijumlahkan.')) {
        e.preventDefault();
        return false;
    }

    var btn = document.getElementById('btnSimpanNilai');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Menyimpan...';

    return true;
});

document.querySelectorAll('.gelar-checkbox[value="3"]:checked').forEach(function(cb) {
    var wrapJumlah = document.getElementById('j3-wrap-' + cb.getAttribute('data-tim'));
    if (wrapJumlah) {
        wrapJumlah.classList.add('show');
    }
});

hitungSemua();
</script>
@endsection
