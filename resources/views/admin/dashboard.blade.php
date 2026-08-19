@extends('layouts.master')

@section('title', 'Dashboard Super Admin')

@section('content')
<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        background: white;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.5s ease;
    }

    .stat-card:hover::before {
        transform: scale(1.5);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 12px;
    }

    .stat-card .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 2px;
    }

    .stat-card .stat-label {
        color: #718096;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-card .stat-growth {
        font-size: 13px;
        font-weight: 600;
        margin-top: 8px;
        display: inline-block;
        padding: 3px 12px;
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

    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); }
    .bg-gradient-danger { background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%); }
    .bg-gradient-purple { background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); }

    .stat-icon-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-icon-success { background: linear-gradient(135deg, #48bb78, #38a169); }
    .stat-icon-info { background: linear-gradient(135deg, #4299e1, #3182ce); }
    .stat-icon-warning { background: linear-gradient(135deg, #ed8936, #dd6b20); }

    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        background: white;
    }

    .dashboard-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card .card-header-custom {
        background: transparent;
        border-bottom: 2px solid #f7fafc;
        padding: 15px 20px;
        font-weight: 600;
        color: #2d3748;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.2s ease;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: #f7fafc;
        padding-left: 10px;
        border-radius: 8px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content .activity-user {
        font-weight: 600;
        color: #2d3748;
    }

    .activity-content .activity-action {
        color: #718096;
        font-size: 14px;
    }

    .activity-content .activity-time {
        color: #a0aec0;
        font-size: 12px;
    }

    .chart-container {
        position: relative;
        height: 250px;
        padding: 10px 0;
    }

    .tim-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .tim-item:last-child {
        border-bottom: none;
    }

    .tim-item .tim-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .tim-item .tim-info {
        flex: 1;
    }

    .tim-item .tim-info .tim-name {
        font-weight: 600;
        color: #2d3748;
    }

    .tim-item .tim-info .tim-detail {
        font-size: 13px;
        color: #718096;
    }

    .tim-item .tim-badge {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-section .welcome-text {
        position: relative;
        z-index: 1;
    }

    .welcome-section .welcome-text h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .welcome-section .welcome-text p {
        opacity: 0.9;
        margin-bottom: 0;
    }

    .panitia-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.2s ease;
    }

    .panitia-item:hover {
        background: #f7fafc;
        padding-left: 10px;
        border-radius: 8px;
    }

    /* Avatar dengan foto */
    .panitia-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 12px;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    /* Avatar dengan inisial */
    .panitia-avatar-initial {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: white;
        margin-right: 12px;
        flex-shrink: 0;
        border: 2px solid #e2e8f0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .panitia-item .panitia-info {
        flex: 1;
    }

    .panitia-item .panitia-info .panitia-name {
        font-weight: 600;
        color: #2d3748;
    }

    .panitia-item .panitia-info .panitia-jabatan {
        font-size: 13px;
        color: #718096;
    }

    .badge-role {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .badge-role-superadmin {
        background: #9f7aea;
        color: white;
    }

    .badge-role-panitia {
        background: #48bb78;
        color: white;
    }

    @media (max-width: 768px) {
        .stat-card .stat-number {
            font-size: 24px;
        }
        
        .welcome-section {
            padding: 20px;
        }
        
        .welcome-section .welcome-text h2 {
            font-size: 20px;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="welcome-section">
            <div class="welcome-text">
                <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p>Anda login sebagai <strong>Super Admin</strong> — {{ now()->format('l, d F Y') }}</p>
                <div class="mt-2">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>
                        Sistem Online
                    </span>
                    <span class="badge bg-light text-dark ms-2">
                        <i class="fas fa-clock me-1"></i> 
                        {{ now()->format('H:i') }} WIB
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon stat-icon-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $totalPanitia }}</div>
                    <div class="stat-label">Total Panitia</div>
                    <div class="stat-growth positive">
                        <i class="fas fa-arrow-up me-1"></i> 12%
                    </div>
                </div>
                <div class="text-end">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-arrow-right text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon stat-icon-success">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stat-number">{{ $totalSuperAdmin }}</div>
                    <div class="stat-label">Super Admin</div>
                    <div class="stat-growth neutral">
                        <i class="fas fa-minus me-1"></i> Stabil
                    </div>
                </div>
                <div class="text-end">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-shield-alt text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon stat-icon-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $totalTim }}</div>
                    <div class="stat-label">Total Tim</div>
                    <div class="stat-growth positive">
                        <i class="fas fa-arrow-up me-1"></i> {{ $pertumbuhanBulanIni }}%
                    </div>
                </div>
                <div class="text-end">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-users text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card stat-card shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon stat-icon-warning">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-number">{{ $totalLomba }}</div>
                    <div class="stat-label">Total Lomba</div>
                    <div class="stat-growth positive">
                        <i class="fas fa-arrow-up me-1"></i> 8%
                    </div>
                </div>
                <div class="text-end">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar text-primary me-2"></i> Statistik Pendaftaran Tim</span>
                <span class="badge bg-light text-dark">6 Bulan Terakhir</span>
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
                <span><i class="fas fa-bell text-primary me-2"></i> Aktivitas Terakhir</span>
                <span class="badge bg-primary">{{ $aktivitasTerakhir->count() }}</span>
            </div>
            <div class="card-body p-3" style="max-height: 250px; overflow-y: auto;">
                @forelse ($aktivitasTerakhir as $activity)
                <div class="activity-item">
                    <div class="activity-icon bg-gradient-{{ $activity['color'] }}">
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
                <span><i class="fas fa-users text-success me-2"></i> Tim Terbaru</span>
                <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 300px; overflow-y: auto;">
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
                    <span class="tim-badge bg-success bg-opacity-10 text-success">
                        Active
                    </span>
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
                <span><i class="fas fa-user-plus text-info me-2"></i> Panitia Terbaru</span>
                <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-3" style="max-height: 300px; overflow-y: auto;">
                @forelse ($panitiaTerbaru as $panitia)
                <div class="panitia-item">
                    {{-- Cek apakah ada foto profil --}}
                    @if($panitia->foto_profil && file_exists(public_path('uploads/profil/' . $panitia->foto_profil)))
                        {{-- Tampilkan foto profil --}}
                        <img src="{{ asset('uploads/profil/' . $panitia->foto_profil) }}" 
                             alt="{{ $panitia->name }}" 
                             class="panitia-avatar">
                    @else
                        {{-- Tampilkan inisial dengan warna --}}
                        <div class="panitia-avatar-initial" 
                             style="background: {{ $panitia->avatar_color }};">
                            {{ $panitia->initials }}
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

<!-- Chart.js untuk Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($pendaftaranBulanan);
    
    const ctx = document.getElementById('pendaftaranChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.bulan),
            datasets: [{
                label: 'Jumlah Pendaftaran',
                data: chartData.map(item => item.total),
                backgroundColor: gradient,
                borderColor: '#667eea',
                borderWidth: 3,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
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
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#2d3748',
                    bodyColor: '#718096',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12,
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
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
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