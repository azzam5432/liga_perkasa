@extends('layouts.master')

@section('title', 'Dashboard Super Admin')

@section('content')
<style>
    .stat-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
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
        color: #1a365d;
        background: #ebf4ff;
        margin-bottom: 10px;
    }

    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #1a2332;
        margin-bottom: 2px;
    }

    .stat-card .stat-label {
        color: #718096;
        font-size: 13px;
        font-weight: 500;
    }

    .stat-card .stat-growth {
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .stat-growth.positive {
        background: #c6f6d5;
        color: #22543d;
    }

    .stat-growth.negative {
        background: #fed7d7;
        color: #9b2c2c;
    }

    .stat-growth.neutral {
        background: #e2e8f0;
        color: #4a5568;
    }

    .dashboard-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #ffffff;
        height: 100%;
    }

    .dashboard-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .dashboard-card .card-header-custom {
        background: transparent;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 20px;
        font-weight: 600;
        color: #1a2332;
        font-size: 15px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.2s ease;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: #f7fafc;
        padding-left: 8px;
        border-radius: 6px;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 14px;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content .activity-user {
        font-weight: 600;
        color: #1a2332;
        font-size: 14px;
    }

    .activity-content .activity-action {
        color: #718096;
        font-size: 13px;
    }

    .activity-content .activity-time {
        color: #a0aec0;
        font-size: 12px;
    }

    .chart-container {
        position: relative;
        height: 220px;
        padding: 6px 0;
    }

    .tim-item {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .tim-item:last-child {
        border-bottom: none;
    }

    .tim-item .tim-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ebf4ff;
        color: #1a365d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .tim-item .tim-info {
        flex: 1;
    }

    .tim-item .tim-info .tim-name {
        font-weight: 600;
        color: #1a2332;
        font-size: 14px;
    }

    .tim-item .tim-info .tim-detail {
        font-size: 12px;
        color: #718096;
    }

    .tim-item .tim-badge {
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #c6f6d5;
        color: #22543d;
    }

    .panitia-item {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.2s ease;
    }

    .panitia-item:last-child {
        border-bottom: none;
    }

    .panitia-item:hover {
        background: #f7fafc;
        padding-left: 8px;
        border-radius: 6px;
    }

    .panitia-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 12px;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .panitia-avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: white;
        margin-right: 12px;
        flex-shrink: 0;
        border: 2px solid #e2e8f0;
    }

    .panitia-item .panitia-info {
        flex: 1;
    }

    .panitia-item .panitia-info .panitia-name {
        font-weight: 600;
        color: #1a2332;
        font-size: 14px;
    }

    .panitia-item .panitia-info .panitia-jabatan {
        font-size: 12px;
        color: #718096;
    }

    .badge-role {
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        flex-shrink: 0;
        background: #ebf4ff;
        color: #1a365d;
    }

    .badge-role-superadmin {
        background: #9f7aea;
        color: white;
    }

    .badge-role-panitia {
        background: #48bb78;
        color: white;
    }

    .welcome-bar {
        padding: 12px 0 20px 0;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .welcome-bar .welcome-text h4 {
        font-weight: 700;
        color: #1a2332;
        margin: 0;
        font-size: 20px;
    }

    .welcome-bar .welcome-text p {
        color: #718096;
        margin: 0;
        font-size: 14px;
    }

    .welcome-bar .welcome-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .welcome-bar .welcome-badges .badge {
        padding: 6px 14px;
        font-weight: 500;
        font-size: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #4a5568;
    }

    .welcome-bar .welcome-badges .badge i {
        margin-right: 6px;
    }

    @media (max-width: 768px) {
        .stat-card .stat-number {
            font-size: 22px;
        }
        .welcome-bar {
            flex-direction: column;
            align-items: flex-start;
        }
        .welcome-bar .welcome-text h4 {
            font-size: 18px;
        }
    }
</style>

<div class="welcome-bar">
    <div class="welcome-text">
        <h4>Selamat Datang, {{ Auth::user()->name }}</h4>
        <p>Super Admin — {{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="welcome-badges">
        <span class="badge">
            <i class="fas fa-circle text-success" style="font-size: 8px;"></i> Sistem Online
        </span>
        <span class="badge">
            <i class="fas fa-clock"></i> {{ now()->format('H:i') }} WIB
        </span>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $totalPanitia }}</div>
            <div class="stat-label">Total Panitia</div>
            <div class="stat-growth positive">
                <i class="fas fa-arrow-up me-1"></i> 12%
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-number">{{ $totalSuperAdmin }}</div>
            <div class="stat-label">Super Admin</div>
            <div class="stat-growth neutral">
                <i class="fas fa-minus me-1"></i> Stabil
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $totalTim }}</div>
            <div class="stat-label">Total Tim</div>
            <div class="stat-growth positive">
                <i class="fas fa-arrow-up me-1"></i> {{ $pertumbuhanBulanIni }}%
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card">
            <div class="stat-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-number">{{ $totalLomba }}</div>
            <div class="stat-label">Total Lomba</div>
            <div class="stat-growth positive">
                <i class="fas fa-arrow-up me-1"></i> 8%
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar text-dark me-2"></i> Statistik Pendaftaran Tim</span>
                <span class="badge bg-light text-dark" style="font-weight: 400; font-size: 11px;">6 Bulan Terakhir</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pendaftaranChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-bell text-dark me-2"></i> Aktivitas Terakhir</span>
                <span class="badge " style="font-size: 11px;">{{ $aktivitasTerakhir->count() }}</span>
            </div>
            <div class="card-body p-3" style="max-height: 230px; overflow-y: auto;">
                @forelse ($aktivitasTerakhir as $activity)
                <div class="activity-item">
                    <div class="activity-icon bg-gradient-{{ $activity['color'] }}" style="background: #ebf4ff; color: #1a365d;">
                        <i class="fas {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="activity-content">
                        <div>
                            <span class="activity-user">{{ $activity['user'] }}</span>
                            <span class="activity-action">{{ $activity['action'] }}</span>
                        </div>
                        <div class="activity-time">
                            <i class="far fa-clock me-1"></i> {{ $activity['time'] }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    <p>Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users text-dark me-2"></i> Tim Terbaru</span>
                <a href="{{ route('panitia.index') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 4px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 260px; overflow-y: auto;">
                @forelse ($timTerbaru as $tim)
                <div class="tim-item">
                    <div class="tim-avatar">
                        {{ strtoupper(substr($tim->nama_tim, 0, 2)) }}
                    </div>
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
                <div class="text-center text-muted py-4">
                    <i class="fas fa-users fa-3x mb-3 d-block"></i>
                    <p>Belum ada tim terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-plus text-dark me-2"></i> Panitia Terbaru</span>
                <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 4px 12px;">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 260px; overflow-y: auto;">
                @forelse ($panitiaTerbaru as $panitia)
                <div class="panitia-item">
                    @if($panitia->foto_profil && file_exists(public_path('uploads/profil/' . $panitia->foto_profil)))
                        <img src="{{ asset('uploads/profil/' . $panitia->foto_profil) }}" 
                             alt="{{ $panitia->name }}" 
                             class="panitia-avatar">
                    @else
                        <div class="panitia-avatar-initial" 
                             style="background: {{ $panitia->avatar_color ?? '#667eea' }};">
                            {{ $panitia->initials ?? strtoupper(substr($panitia->name, 0, 2)) }}
                        </div>
                    @endif
                    
                    <div class="panitia-info">
                        <div class="panitia-name">{{ $panitia->name }}</div>
                        <div class="panitia-jabatan">
                            <i class="fas fa-briefcase me-1"></i> {{ $panitia->jabatan ?? 'Tanpa Jabatan' }}
                        </div>
                    </div>
                    <span class="badge-role badge-role-panitia">
                        Panitia
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-user-plus fa-3x mb-3 d-block"></i>
                    <p>Belum ada panitia terdaftar</p>
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
                legend: {
                    display: false
                },
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
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.04)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endsection