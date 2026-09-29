@extends('layouts.master')

@section('title', 'Dashboard Panitia')

@section('content')
<style>
.welcome-section {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
    border: 1px solid #edf2f7;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.welcome-section .welcome-text h2 {
    font-weight: 700;
    color: #1a2332;
    font-size: 20px;
    margin-bottom: 2px;
}

.welcome-section .welcome-text p {
    color: #718096;
    margin-bottom: 0;
    font-size: 14px;
}

.stat-card {
    border: 1px solid #edf2f7;
    border-radius: 10px;
    padding: 18px 20px;
    transition: all 0.3s ease;
    background: #ffffff;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.07);
    border-color: #1a365d;
}

.stat-card .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
    flex-shrink: 0;
}

.stat-card .stat-number {
    font-size: 26px;
    font-weight: 700;
    color: #1a2332;
    line-height: 1.2;
}

.stat-card .stat-label {
    color: #718096;
    font-size: 13px;
    font-weight: 500;
    margin-top: 2px;
}

.stat-icon-primary { background: linear-gradient(135deg, #1a365d, #2b6cb0); }
.stat-icon-success { background: linear-gradient(135deg, #48bb78, #38a169); }
.stat-icon-info { background: linear-gradient(135deg, #4299e1, #3182ce); }
.stat-icon-warning { background: linear-gradient(135deg, #ed8936, #dd6b20); }

.lomba-card {
    border: 1px solid #edf2f7;
    border-radius: 10px;
    transition: all 0.3s ease;
    height: 100%;
    background: #ffffff;
}

.lomba-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.07);
    transform: translateY(-3px);
}

.lomba-card .card-body {
    padding: 14px 16px;
}

.lomba-card .lomba-title {
    font-weight: 600;
    color: #1a2332;
    font-size: 14px;
    margin-bottom: 6px;
}

.lomba-card .lomba-babak {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 12px;
    display: inline-block;
    margin-bottom: 6px;
}

.lomba-card .lomba-babak.penyisihan {
    background: #ebf8ff;
    color: #2b6cb0;
}

.lomba-card .lomba-babak.final {
    background: #fefcbf;
    color: #975a16;
}

.lomba-card .lomba-babak.langsung {
    background: #f0fff4;
    color: #22543d;
}

.lomba-card .lomba-meta {
    font-size: 12px;
    color: #718096;
    display: flex;
    align-items: center;
    gap: 6px;
}

.lomba-card .lomba-meta i {
    width: 14px;
    color: #a0aec0;
}

.lomba-card .btn-penilaian {
    font-size: 11px;
    padding: 3px 12px;
    border-radius: 6px;
    background: #1a365d;
    color: #ffffff;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
    margin-top: 8px;
}

.lomba-card .btn-penilaian:hover {
    background: #2b6cb0;
}

.lomba-card .btn-penilaian.sudah {
    background: #48bb78;
}

.lomba-card .btn-penilaian.sudah:hover {
    background: #38a169;
}

.card-header-custom {
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.card-header-custom h6 {
    font-weight: 600;
    color: #1a2332;
    margin: 0;
    font-size: 15px;
}

.card-header-custom .btn-outline-primary {
    font-size: 12px;
    padding: 4px 14px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    background: transparent;
    transition: all 0.2s ease;
    text-decoration: none;
}

.card-header-custom .btn-outline-primary:hover {
    background: #f7fafc;
    border-color: #b0b8c4;
}

.table-container {
    padding: 0 20px 20px 20px;
}

.table-container table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-container table thead th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 10px 12px;
    border-bottom: 1px solid #edf2f7;
    text-align: left;
}

.table-container table tbody td {
    padding: 10px 12px;
    color: #2d3748;
    border-bottom: 1px solid #f7fafc;
    vertical-align: middle;
}

.table-container table tbody tr:last-child td {
    border-bottom: none;
}

.table-container table tbody tr:hover {
    background: #f7fafc;
}

.table-container .badge-count {
    background: #ebf8ff;
    color: #2b6cb0;
    padding: 2px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 12px;
}

.empty-state {
    padding: 30px 16px;
    text-align: center;
}

.empty-state i {
    font-size: 36px;
    color: #e2e8f0;
    display: block;
    margin-bottom: 10px;
}

.empty-state h6 {
    color: #1a2332;
    font-weight: 600;
    margin-bottom: 2px;
    font-size: 15px;
}

.empty-state p {
    color: #a0aec0;
    font-size: 13px;
    margin-bottom: 0;
}

.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0 0 0;
    border-top: 1px solid #edf2f7;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.pagination-wrapper .info-text {
    font-size: 12px;
    color: #a0aec0;
}

.pagination-wrapper .info-text strong {
    color: #1a2332;
}

.pagination-wrapper .pagination {
    margin: 0;
    gap: 2px;
}

.pagination-wrapper .page-item .page-link {
    border: none;
    border-radius: 6px;
    color: #4a5568;
    font-weight: 500;
    font-size: 12px;
    padding: 4px 10px;
    transition: all 0.2s ease;
    background: transparent;
}

.pagination-wrapper .page-item.active .page-link {
    background: #1a365d;
    color: #ffffff;
}

.pagination-wrapper .page-item:not(.active) .page-link:hover {
    background: #f7fafc;
    color: #1a2332;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #cbd5e0;
    opacity: 0.5;
    cursor: not-allowed;
}

/* ===== Chip Kelas ===== */
.kelas-chip {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 20px;
    background: #ebf8ff;
    color: #2b6cb0;
    border: 1px solid #bee3f8;
}

.kelas-chip-b {
    background: #fefcbf;
    color: #975a16;
    border-color: #f6e05e;
}

/* ===== Tab Reguler A / B ===== */
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

@media (max-width: 768px) {
    .welcome-section {
        flex-direction: column;
        align-items: flex-start;
        padding: 16px 20px;
    }
    .welcome-section .welcome-text h2 {
        font-size: 18px;
    }
    .stat-card .stat-number {
        font-size: 22px;
    }
    .table-container {
        padding: 0 12px 12px 12px;
        overflow-x: auto;
    }
    .table-container table {
        font-size: 13px;
        min-width: 500px;
    }
    .lomba-card .card-body {
        padding: 12px 14px;
    }
    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
    }
    .pagination-wrapper .pagination {
        justify-content: center;
    }
    .dashboard-tabs .nav-link {
        padding: 6px 14px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .welcome-section {
        padding: 14px 16px;
    }
    .welcome-section .welcome-text h2 {
        font-size: 16px;
    }
    .welcome-section .welcome-text p {
        font-size: 13px;
    }
    .stat-card {
        padding: 14px 16px;
    }
    .stat-card .stat-number {
        font-size: 20px;
    }
    .card-header-custom {
        padding: 10px 14px;
    }
    .card-header-custom h6 {
        font-size: 14px;
    }
    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
    }
    .pagination-wrapper .pagination .page-link {
        font-size: 11px;
        padding: 3px 8px;
    }
}
</style>

<ul class="nav dashboard-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-reguler-a" data-bs-toggle="tab" data-bs-target="#pane-reguler-a" type="button" role="tab" aria-controls="pane-reguler-a" aria-selected="true">
            <i class="fas fa-th-large me-1"></i> Reguler A
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-reguler-b" data-bs-toggle="tab" data-bs-target="#pane-reguler-b" type="button" role="tab" aria-controls="pane-reguler-b" aria-selected="false">
            <i class="fas fa-th-large me-1"></i> Reguler B
        </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="pane-reguler-a" role="tabpanel" aria-labelledby="tab-reguler-a" tabindex="0">
        @include('panitia.dashboard-content', ['kelas' => 'A', 'd' => $dataPerKelas['A']])
    </div>

    <div class="tab-pane fade" id="pane-reguler-b" role="tabpanel" aria-labelledby="tab-reguler-b" tabindex="0">
        @include('panitia.dashboard-content', ['kelas' => 'B', 'd' => $dataPerKelas['B']])
    </div>
</div>
@endsection
