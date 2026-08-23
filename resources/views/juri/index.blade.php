@extends('layouts.master')

@section('title', 'Data Juri')

@section('content')
<style>
    .juri-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .juri-avatar-initial {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        border: 2px solid #e2e8f0;
        font-size: 18px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i> Data Juri</h5>
                <a href="{{ route('juri.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Juri
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
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Spesialisasi</th>
                                <th>Institusi</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($juris as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($item->user->foto_profil && file_exists(public_path('uploads/profil/' . $item->user->foto_profil)))
                                        <img src="{{ asset('uploads/profil/' . $item->user->foto_profil) }}" 
                                             alt="{{ $item->user->name }}" 
                                             class="juri-avatar">
                                    @else
                                        <div class="juri-avatar-initial" 
                                             style="background: {{ $item->user->avatar_color ?? '#667eea' }};">
                                            {{ $item->user->initials ?? strtoupper(substr($item->user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->user->name }}</strong><br>
                                    <small class="text-muted">{{ $item->user->email }}</small>
                                </td>
                                <td>{{ $item->spesialisasi ?? '-' }}</td>
                                <td>{{ $item->institusi ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('juri.show', $item->id_juri) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('juri.edit', $item->id_juri) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('juri.destroy', $item->id_juri) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus juri ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-user-tie fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada data juri</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $juris->links() }}
            </div>
        </div>
    </div>
</div>
@endsection