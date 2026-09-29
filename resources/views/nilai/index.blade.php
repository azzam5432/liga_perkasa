@extends('layouts.master')

@section('title', 'Penilaian Lomba')

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
}

.table-scroll table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
    font-size: 15px;
}

.table-scroll table thead th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 12px 14px;
    border-bottom: 2px solid #edf2f7;
    text-align: left;
    white-space: nowrap;
}

.table-scroll table tbody td {
    padding: 12px 14px;
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

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: #a0aec0;
    transition: all 0.2s ease;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
}

.btn-action:hover {
    background: #f7fafc;
    color: #1a2332;
}

.btn-action.btn-primary {
    color: #2b6cb0;
}

.btn-action.btn-primary:hover {
    background: #ebf8ff;
}

.btn-action.btn-success {
    color: #22543d;
}

.btn-action.btn-success:hover {
    background: #c6f6d5;
}

.btn-action.btn-warning {
    color: #d69e2e;
}

.btn-action.btn-warning:hover {
    background: #fefcbf;
}

.dashboard-tabs {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 10px;
    padding: 6px;
    display: inline-flex;
    gap: 4px;
    margin-bottom: 20px;
}

.dashboard-tabs .nav-link {
    font-size: 13px;
    font-weight: 600;
    color: #4a5568;
    border: none;
    border-radius: 7px;
    padding: 7px 20px;
    transition: all 0.2s ease;
}

.dashboard-tabs .nav-link:hover {
    color: #1a365d;
    background: #f7fafc;
}

.dashboard-tabs .nav-link.active {
    background: #1a365d;
    color: #ffffff;
}

.kelas-subtitle {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 20px;
    background: {{ ($kelas ?? 'A') === 'B' ? '#fefcbf' : '#ebf8ff' }};
    color: {{ ($kelas ?? 'A') === 'B' ? '#975a16' : '#2b6cb0' }};
}

.kelas-pill {
    display: inline-block;
    margin-left: 8px;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 10px;
    background: #ebf8ff;
    color: #2b6cb0;
}

.kelas-pill.kelas-b {
    background: #fefcbf;
    color: #975a16;
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
    .page-header h4 {
        font-size: 18px;
    }
    .table-scroll table {
        font-size: 13px;
    }
}
</style>

<div class="page-header">
    <h4><i class="fas fa-pen me-2"></i> Penilaian Lomba <span class="kelas-subtitle">Kelas {{ $kelas ?? 'A' }}</span></h4>
</div>

<!-- Tab Reguler A / B -->
<ul class="nav dashboard-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ ($kelas ?? 'A') === 'A' ? 'active' : '' }}" type="button" onclick="gantiKelas('A')">
            <i class="fas fa-crown me-1"></i> Reguler A
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ ($kelas ?? 'A') === 'B' ? 'active' : '' }}" type="button" onclick="gantiKelas('B')">
            <i class="fas fa-medal me-1"></i> Reguler B
        </button>
    </li>
</ul>

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

<div class="table-wrapper">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Nama Lomba</th>
                    <th>Bobot</th>
                    <th>Status</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lombas as $index => $lomba)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">
                            {{ $lomba->nama_lomba }}
                            <span class="kelas-pill {{ $lomba->kelas === 'B' ? 'kelas-b' : '' }}">Kelas {{ $lomba->kelas }}</span>
                        </td>
                        <td>{{ $lomba->bobot }}</td>
                        <td>
                            @if($lomba->nilai->isNotEmpty())
                                <span class="badge bg-success">Sudah Dinilai</span>
                            @else
                                <span class="badge bg-secondary">Belum Dinilai</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($lomba->nilai->isNotEmpty())
                                <a href="{{ route('nilai.edit', $lomba->id_lomba) }}" class="btn-action btn-warning" title="Edit Nilai">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('nilai.create', $lomba->id_lomba) }}" class="btn-action btn-primary" title="Nilai Lomba">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <h6>Belum ada lomba</h6>
                                <p>Silakan tambahkan lomba terlebih dahulu.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
function gantiKelas(kelas) {
    const url = new URL(window.location.href);
    url.searchParams.set('kelas', kelas);
    window.location.href = url.toString();
}
</script>
@endsection