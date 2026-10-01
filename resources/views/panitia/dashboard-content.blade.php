<div class="welcome-section">
    <div class="welcome-text">
        <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
        <p>{{ Auth::user()->role_label }} — {{ now()->format('l, d F Y') }}</p>
    </div>
    <span class="kelas-chip {{ ($kelas ?? 'A') === 'B' ? 'kelas-chip-b' : '' }}">
        <i class="fas fa-{{ ($kelas ?? 'A') === 'B' ? 'medal' : 'crown' }} me-1"></i> Reguler {{ $kelas ?? 'A' }}
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-6 col-lg-6 col-xl-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-primary me-3">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-number">{{ $d['totalTim'] ?? $totalTim ?? 0 }}</div>
                <div class="stat-label">Total Tim</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-6 col-xl-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-success me-3">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <div class="stat-number">{{ $d['totalPeserta'] ?? $totalPeserta ?? 0 }}</div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
    </div>

    {{-- SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia --}}
    {{--
    <div class="col-6 col-md-6 col-lg-6 col-xl-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-info me-3">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <div class="stat-number">{{ $d['totalLomba'] ?? $totalLomba ?? 0 }}</div>
                <div class="stat-label">Lomba Ditugaskan</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-6 col-xl-3">
        <div class="stat-card d-flex align-items-center">
            <div class="stat-icon stat-icon-warning me-3">
                <i class="fas fa-pen"></i>
            </div>
            <div>
                <div class="stat-number">{{ $d['totalTimSudahDinilai'] ?? $totalTimSudahDinilai ?? 0 }}</div>
                <div class="stat-label">Tim Sudah Dinilai</div>
            </div>
        </div>
    </div>
    --}}
</div>

{{-- SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia --}}
{{--
@if(isset($juri) && $juri && isset($d['lombaDitugaskan']) && $d['lombaDitugaskan']->count() > 0)
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header-custom">
                <h6><i class="fas fa-tasks text-primary me-2"></i> Lomba yang Ditugaskan — Reguler {{ $kelas ?? 'A' }}</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($d['lombaDitugaskan'] as $lomba)
                        @php
                            $sudahDinilai = \App\Models\Nilai::where('id_lomba', $lomba->id_lomba)
                                ->where('id_juri', $juri->id_juri)
                                ->exists();
                            $babak = $lomba->is_final_active ? 'final' : ($lomba->jenis == 'penyisihan' ? 'penyisihan' : 'langsung');
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="lomba-card">
                                <div class="card-body">
                                    <div class="lomba-title">{{ $lomba->nama_lomba }}</div>
                                    <span class="lomba-babak {{ $babak }}">
                                        {{ ucfirst($babak) }}
                                    </span>
                                    <div class="lomba-meta">
                                        <i class="fas fa-tag"></i> {{ $lomba->kategori ?? 'Umum' }}
                                    </div>
                                    <div>
                                        @if($sudahDinilai)
                                            <a href="{{ route('nilai.index') }}" class="btn-penilaian sudah">
                                                <i class="fas fa-check me-1"></i> Sudah Dinilai
                                            </a>
                                        @else
                                            <a href="{{ route('nilai.create', $lomba->id_lomba) }}" class="btn-penilaian">
                                                <i class="fas fa-pen me-1"></i> Beri Nilai
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(isset($juri) && $juri)
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada lomba yang ditugaskan kepada Anda. Silakan hubungi admin.
        </div>
    </div>
</div>
@endif
--}}

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header-custom">
                <h6><i class="fas fa-users text-primary me-2"></i> Data Tim Terbaru</h6>
                <a href="{{ route('panitia.index') }}" class="btn-outline-primary">
                    <i class="fas fa-arrow-right me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Tim</th>
                                <th>Ketua</th>
                                <th style="text-align: center;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($d['dataPeserta'] ?? collect() as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->nama_tim }}</strong></td>
                                <td>{{ $item->pesertas->whereNotNull('ketua_peserta')->first()->ketua_peserta ?? '-' }}</td>
                                <td style="text-align: center;">
                                    <span class="badge-count">{{ $item->pesertas->count() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h6>Belum ada data tim</h6>
                                        <p>Silakan tambahkan tim melalui menu Data Tim.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($d['dataPeserta']) && $d['dataPeserta']->hasPages())
                <div class="pagination-wrapper">
                    <span class="info-text">
                        Menampilkan <strong>{{ $d['dataPeserta']->firstItem() }}</strong> sampai <strong>{{ $d['dataPeserta']->lastItem() }}</strong> dari <strong>{{ $d['dataPeserta']->total() }}</strong> tim
                    </span>
                    {{ $d['dataPeserta']->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
