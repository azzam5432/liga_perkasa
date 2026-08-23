@extends('layouts.master')

@section('title', 'Penugasan Juri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-tag me-2"></i> Penugasan Juri ke Lomba</h5>
                <a href="{{ route('juri_lomba.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Penugasan
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Juri</th>
                                <th>Lomba</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penugasans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->juri->user->name ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item->juri->spesialisasi ?? '-' }}</small>
                                </td>
                                <td>{{ $item->lomba->nama_lomba ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($item->catatan, 30) ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('juri_lomba.show', $item->id_juri_lomba) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('juri_lomba.edit', $item->id_juri_lomba) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('juri_lomba.destroy', $item->id_juri_lomba) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus penugasan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-user-tag fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada penugasan juri</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $penugasans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection