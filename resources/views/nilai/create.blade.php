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

    .info-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #4a5568;
        background: #f7fafc;
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid #edf2f7;
    }

    .info-badge .badge-count {
        background: #1a365d;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .info-badge .badge-warning {
        background: #ed8936;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .info-badge .badge-success {
        background: #48bb78;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
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
        border-left: 3px solid #1a365d;
    }

    .radio-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .radio-custom {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #cbd5e0;
        display: inline-block;
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .radio-custom.selected {
        border-color: #1a365d;
        background: #1a365d;
    }

    .radio-custom.selected::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
    }

    .radio-custom:hover {
        border-color: #1a365d;
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
        .info-badge {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            width: 100%;
        }
        .table-scroll table {
            font-size: 13px;
            min-width: 500px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h4>
        <i class="fas fa-pen me-2"></i> Penilaian - {{ $lomba->nama_lomba }}
    </h4>
    <div class="d-flex gap-2">
        <span class="info-badge">
            <span><i class="fas fa-trophy me-1"></i> Bobot: <strong>{{ $lomba->bobot }}</strong></span>
        </span>
        <a href="{{ route('nilai.index') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" form="formNilai" class="btn-submit-nilai" id="btnSimpanNilai">
            <i class="fas fa-save"></i> Simpan Nilai
        </button>
    </div>
</div>

<!-- ===== ALERT ===== -->
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

<!-- ===== INFO STATUS ===== -->
<div class="info-badge mb-3">
    <span><i class="fas fa-users me-1"></i> Total Tim: <strong>{{ $tim->count() }}</strong></span>
    @if(isset($sudahDinilai) && $sudahDinilai)
        <span class="ms-2">
            <i class="fas fa-check-circle text-success me-1"></i>
            <span class="badge-success">Sudah Dinilai oleh {{ $juriYangMenilai->user->name ?? 'Juri' }}</span>
        </span>
    @else
        <span class="ms-2">
            <i class="fas fa-info-circle text-warning me-1"></i>
            <span class="badge-warning">Belum Dinilai</span>
        </span>
    @endif
    @if($lomba->is_final_active)
        <span class="ms-2">
            <i class="fas fa-trophy text-info me-1"></i>
            <span class="badge" style="background: #bee3f8; color: #2b6cb0;">Babak Final</span>
        </span>
    @endif
</div>

<!-- ===== TABLE ===== -->
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
                        <th style="text-align: center; width: 60px;">Pilih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim as $index => $t)
                        <tr id="row-{{ $t->id_tim }}" onclick="selectTim({{ $t->id_tim }})">
                            <td style="text-align: center; font-weight: 600; color: #1a2332;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="fw-semibold">{{ $t->nama_tim }}</td>
                            <td style="text-align: center;">
                                <div class="radio-wrapper">
                                    <input type="radio" 
                                           name="id_tim" 
                                           value="{{ $t->id_tim }}" 
                                           class="d-none tim-radio"
                                           id="radio-{{ $t->id_tim }}"
                                           onchange="onTimSelected({{ $t->id_tim }})"
                                           @if(isset($sudahDinilai) && $sudahDinilai) disabled @endif>
                                    <label for="radio-{{ $t->id_tim }}" class="radio-custom" id="label-{{ $t->id_tim }}"></label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
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
// ==========================================
// SELECT TIM
// ==========================================
let selectedTim = null;

function selectTim(id) {
    const radio = document.getElementById('radio-' + id);
    if (radio) {
        radio.checked = true;
        onTimSelected(id);
    }
}

function onTimSelected(id) {
    // Hapus semua highlight
    document.querySelectorAll('#formNilai tbody tr').forEach(row => {
        row.classList.remove('selected');
    });
    
    // Highlight row yang dipilih
    const row = document.getElementById('row-' + id);
    if (row) {
        row.classList.add('selected');
    }
    
    // Update label radio
    document.querySelectorAll('.radio-custom').forEach(label => {
        label.classList.remove('selected');
    });
    const label = document.getElementById('label-' + id);
    if (label) {
        label.classList.add('selected');
    }
    
    selectedTim = id;
}

// ==========================================
// VALIDASI SEBELUM SUBMIT
// ==========================================
document.getElementById('formNilai').addEventListener('submit', function(e) {
    @if(isset($sudahDinilai) && $sudahDinilai)
        e.preventDefault();
        alert('⚠️ Lomba ini sudah dinilai oleh {{ $juriYangMenilai->user->name ?? "Juri" }}!');
        return false;
    @endif
    
    // ✅ Cek apakah ada tim yang dipilih
    if (selectedTim === null) {
        e.preventDefault();
        alert('⚠️ Silakan pilih 1 tim yang menang!');
        return false;
    }
    
    // ✅ Konfirmasi
    const namaTim = document.querySelector('#row-' + selectedTim + ' .fw-semibold')?.textContent || 'Tim';
    if (!confirm(`Yakin tim "${namaTim}" yang menang di lomba ini?\n\nTim tersebut akan mendapat {{ $lomba->bobot }} poin.`)) {
        e.preventDefault();
        return false;
    }
    
    // ✅ Disable tombol submit
    const btn = document.getElementById('btnSimpanNilai');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Menyimpan...';
    
    return true;
});

// ==========================================
// AUTO SELECT FIRST TIM IF ONLY ONE
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const tims = document.querySelectorAll('#formNilai tbody tr:not(.empty-state)');
    
    if (tims.length === 1) {
        const firstTim = tims[0];
        const radio = firstTim.querySelector('.tim-radio');
        if (radio) {
            radio.checked = true;
            onTimSelected(parseInt(radio.value));
        }
    }
});
</script>
@endsection