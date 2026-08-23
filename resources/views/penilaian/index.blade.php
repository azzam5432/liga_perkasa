@extends('layouts.master')

@section('title', 'Data Penilaian')

@section('content')
<style>
    .nilai-badge {
        font-size: 16px;
        font-weight: 700;
        padding: 5px 15px;
        border-radius: 20px;
    }
    .nilai-tinggi { background: #c6f6d5; color: #22543d; }
    .nilai-sedang { background: #fefcbf; color: #975a16; }
    .nilai-rendah { background: #fed7d7; color: #9b2c2c; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Data Penilaian</h5>
                <a href="{{ route('penilaian.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Penilaian
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tim</th>
                                <th>Juri</th>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penilaians as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tim->nama_tim ?? '-' }}</td>
                                <td>{{ $item->juri->user->name ?? '-' }}</td>
                                <td>{{ $item->kriteria->nama_kriteria ?? '-' }}</td>
                                <td>
                                    @if($item->nilai !== null)
                                        <span class="nilai-badge 
                                            {{ $item->nilai >= 80 ? 'nilai-tinggi' : ($item->nilai >= 60 ? 'nilai-sedang' : 'nilai-rendah') }}">
                                            {{ $item->nilai }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('penilaian.show', $item->id_penilaian) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('penilaian.edit', $item->id_penilaian) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('penilaian.destroy', $item->id_penilaian) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus penilaian ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada data penilaian</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $penilaians->links() }}
            </div>
        </div>
    </div>
</div>
@endsection