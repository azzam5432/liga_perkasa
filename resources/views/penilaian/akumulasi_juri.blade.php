{{-- resources/views/penilaian/akumulasi_juri.blade.php --}}
@extends('layouts.master')

@section('title', 'Akumulasi Nilai Per Juri')

@section('content')
<style>
    .juri-card {
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .juri-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .nilai-cell {
        font-weight: 600;
        font-size: 16px;
    }
    .nilai-tinggi { color: #48bb78; }
    .nilai-sedang { color: #ed8936; }
    .nilai-rendah { color: #fc8181; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i> Akumulasi Nilai Per Juri</h5>
                <small class="text-white-50">{{ $lomba->nama_lomba }}</small>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($data as $item)
                    <div class="col-md-6 mb-4">
                        <div class="card juri-card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $item['juri']->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item['juri']->spesialisasi ?? '-' }}</small>
                                </div>
                                <span class="badge bg-primary">{{ $item['penilaian']->filter(function($p) { return $p['nilai'] > 0; })->count() }} Tim</span>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Tim</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item['penilaian'] as $index => $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $p['tim']->nama_tim }}</td>
                                            <td class="text-center">
                                                @if($p['nilai'] > 0)
                                                    <span class="nilai-cell 
                                                        {{ $p['nilai'] >= 80 ? 'nilai-tinggi' : 
                                                           ($p['nilai'] >= 60 ? 'nilai-sedang' : 'nilai-rendah') }}">
                                                        {{ number_format($p['nilai'], 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted">Belum ada data juri</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('penilaian.rekap-lomba', $lomba->id_lomba) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection