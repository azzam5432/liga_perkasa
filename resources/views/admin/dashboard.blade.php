@extends('layouts.master')

@section('title', 'Dashboard Super Admin')

@section('content')
<style>
    .welcome-bar {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        color: #1a2332;
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .welcome-bar .welcome-text h4 {
        font-weight: 700;
        margin: 0;
        font-size: 22px;
    }

    .welcome-bar .welcome-text p {
        margin: 4px 0 0;
        opacity: 0.85;
        font-size: 14px;
        color: #718096;
    }

    .welcome-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .welcome-badges .badge {
        background: #f7fafc;
        color: #4a5568;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 12px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: #cbd5e0;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .stat-icon-blue { background: #ebf8ff; color: #2b6cb0; }
    .stat-icon-green { background: #c6f6d5; color: #22543d; }
    .stat-icon-purple { background: #f3e8ff; color: #6b46c1; }
    .stat-icon-orange { background: #feebc8; color: #c05621; }

    .stat-number {
        font-size: 26px;
        font-weight: 800;
        color: #1a2332;
        line-height: 1.2;
    }

    .stat-label {
        color: #718096;
        font-size: 12px;
        font-weight: 500;
        margin-top: 2px;
    }

    .dashboard-card {
        background: white;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .card-header-custom {
        padding: 16px 20px;
        font-weight: 600;
        font-size: 14px;
        color: #1a2332;
        border-bottom: 1px solid #edf2f7;
        background: #fafafa;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .activity-content { flex: 1; }

    .activity-user {
        font-weight: 600;
        font-size: 13px;
        color: #1a2332;
    }

    .activity-action {
        color: #718096;
        font-size: 12px;
    }

    .activity-time {
        color: #a0aec0;
        font-size: 11px;
        margin-top: 4px;
    }

    .chart-container {
        position: relative;
        height: 260px;
    }

    .tim-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
        gap: 12px;
    }

    .tim-item:last-child { border-bottom: none; }

    .tim-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        background: #ebf4ff;
        color: #2b6cb0;
        flex-shrink: 0;
    }

    .tim-info { flex: 1; }

    .tim-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a2332;
    }

    .tim-detail {
        font-size: 12px;
        color: #718096;
    }

    .tim-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        background: #c6f6d5;
        color: #22543d;
    }

    .panitia-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
        gap: 12px;
    }

    .panitia-item:last-child { border-bottom: none; }

    .panitia-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .panitia-avatar-initial {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: white;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .panitia-info { flex: 1; }

    .panitia-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a2332;
    }

    .panitia-jabatan {
        font-size: 12px;
        color: #718096;
    }

    .badge-role {
        font-size: 10px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .badge-role-superadmin {
        background: #f3e8ff;
        color: #6b46c1;
    }

    .badge-role-panitia {
        background: #c6f6d5;
        color: #22543d;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }

    .empty-state i {
        font-size: 40px;
        margin-bottom: 12px;
        display: block;
    }

    @media (max-width: 768px) {
        .welcome-bar {
            padding: 18px;
        }
        .welcome-bar .welcome-text h4 {
            font-size: 18px;
        }
        .stat-number {
            font-size: 22px;
        }
        .chart-container {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .stat-card {
            padding: 12px;
        }
        .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .stat-number {
            font-size: 20px;
        }
        .stat-label {
            font-size: 11px;
        }
    }
</style>

<div class="welcome-bar">
    <div class="welcome-text">
        <h4>Selamat Datang, {{ Auth::user()->name }}</h4>
        <p>Super Admin — {{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="welcome-badges">
        <span class="badge"><i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> Sistem Online</span>
        <span class="badge"><i class="fas fa-clock me-1"></i> {{ now()->format('H:i') }} WIB</span>
    </div>
</div>

<div class="row g-3 row-cols-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue"><i class="fas fa-users"></i></div>
            <div class="stat-number">{{ $totalPanitia }}</div>
            <div class="stat-label">Total Panitia</div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card">
            <div class="stat-icon stat-icon-purple"><i class="fas fa-user-shield"></i></div>
            <div class="stat-number">{{ $totalSuperAdmin }}</div>
            <div class="stat-label">Super Admin</div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card">
            <div class="stat-icon stat-icon-green"><i class="fas fa-users"></i></div>
            <div class="stat-number">{{ $totalTim }}</div>
            <div class="stat-label">Total Tim</div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card">
            <div class="stat-icon stat-icon-orange"><i class="fas fa-trophy"></i></div>
            <div class="stat-number">{{ $totalLomba }}</div>
            <div class="stat-label">Total Lomba</div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-xl-8 col-lg-7 col-12">
        <div class="dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar me-2 text-primary"></i> Statistik Pendaftaran Tim</span>
                <span class="badge bg-light text-dark" style="font-size: 11px; font-weight: 400;">6 Bulan</span>
            </div>
            <div class="card-body p-3">
                <div class="chart-container">
                    <canvas id="pendaftaranChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5 col-12">
        <div class="dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-bell me-2 text-warning"></i> Aktivitas Terakhir</span>
                <span class="badge bg-primary" style="font-size: 11px;">{{ $aktivitasTerakhir->count() }}</span>
            </div>
            <div class="card-body p-3" style="max-height: 300px; overflow-y: auto;">
                @forelse ($aktivitasTerakhir as $activity)
                <div class="activity-item">
                    <div class="activity-icon" style="background: #ebf4ff; color: #2b6cb0;">
                        <i class="fas {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="activity-content">
                        <div>
                            <span class="activity-user">{{ $activity['user'] }}</span>
                            <span class="activity-action">{{ $activity['action'] }}</span>
                        </div>
                        <div class="activity-time"><i class="far fa-clock me-1"></i> {{ $activity['time'] }}</div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p class="mb-0">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-xl-6 col-lg-6 col-12">
        <div class="dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2 text-success"></i> Tim Terbaru</span>
                <a href="{{ route('panitia.index') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 4px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 280px; overflow-y: auto;">
                @forelse ($timTerbaru as $tim)
                <div class="tim-item">
                    <div class="tim-avatar">{{ strtoupper(substr($tim->nama_tim, 0, 2)) }}</div>
                    <div class="tim-info">
                        <div class="tim-name">{{ $tim->nama_tim }}</div>
                        <div class="tim-detail">
                            <i class="fas fa-user me-1"></i> {{ $tim->pesertas->count() }} Peserta
                            <span class="mx-2">•</span>
                            <i class="far fa-calendar-alt me-1"></i> {{ $tim->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <span class="tim-badge">Active</span>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p class="mb-0">Belum ada tim terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-12">
        <div class="dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-plus me-2 text-info"></i> Panitia Terbaru</span>
                <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 4px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 280px; overflow-y: auto;">
                @forelse ($panitiaTerbaru as $panitia)
                <div class="panitia-item">
                    @if($panitia->foto_profil && file_exists(public_path('uploads/profil/' . $panitia->foto_profil)))
                        <img src="{{ asset('uploads/profil/' . $panitia->foto_profil) }}" alt="{{ $panitia->name }}" class="panitia-avatar">
                    @else
                        <div class="panitia-avatar-initial" style="background: {{ $panitia->avatar_color ?? '#667eea' }};">
                            {{ $panitia->initials ?? strtoupper(substr($panitia->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="panitia-info">
                        <div class="panitia-name">{{ $panitia->name }}</div>
                        <div class="panitia-jabatan"><i class="fas fa-briefcase me-1"></i> {{ $panitia->jabatan ?? 'Tanpa Jabatan' }}</div>
                    </div>
                    <span class="badge-role badge-role-panitia">Panitia</span>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-user-plus"></i>
                    <p class="mb-0">Belum ada panitia terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($pendaftaranBulanan);
    
    const ctx = document.getElementById('pendaftaranChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(26, 54, 93, 0.15)');
    gradient.addColorStop(1, 'rgba(26, 54, 93, 0.0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.bulan),
            datasets: [{
                label: 'Jumlah Pendaftaran',
                data: chartData.map(item => item.total),
                backgroundColor: gradient,
                borderColor: '#1a365d',
                borderWidth: 2,
                pointBackgroundColor: '#1a365d',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7,
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1a2332',
                    bodyColor: '#718096',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' Pendaftaran';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: 'rgba(0, 0, 0, 0.04)', drawBorder: false }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            },
            interaction: { intersect: false, mode: 'index' }
        }
    });
});
</script>
@endsection