@extends('layouts.master')

@section('title', 'Data Kriteria')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list-check me-2"></i> Data Kriteria</h5>
                <a href="{{ route('kriteria.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Kriteria
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Kriteria</th>
                                <th>Deskripsi</th>
                                <th>Bobot</th>
                                <th>Tipe</th>
                                <th>Skala</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kriterias as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kriteria }}</td>
                                <td>{{ Str::limit($item->deskripsi, 50) ?? '-' }}</td>
                                <td>{{ $item->bobot }}%</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($item->tipe) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->tipe == 'skala')
                                        {{ $item->skala_min }} - {{ $item->skala_max }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('kriteria.show', $item->id_kriteria) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kriteria.edit', $item->id_kriteria) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $item->id_kriteria) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kriteria ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-list-check fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada data kriteria</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $kriterias->links() }}
            </div>
        </div>
    </div>
</div>
@endsection