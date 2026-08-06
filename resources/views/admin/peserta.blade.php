@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-shadow">
            <div class="card-body">
                <a href="{{ route('admin.create') }}" type="button" class="btn btn-primary mb-4">
                    <i class="fas fa-plus me-1"></i> Tambah Data Peserta
                </a>
                
                @if (session('success'))
                    <div class="alert alert-success alert-custom d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
            </div>
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">Nama Peserta</th>
                    <th scope="col">Nomor Telpon</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peserta as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nama_peserta }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td class="text-center">
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin.destroy', $item) }}" method="POST">
                            <a href="{{ route('admin.show', $item) }}" class="btn btn-sm btn-secondary">SHOW</a>
                            <a href="{{ route('admin.edit', $item) }}" class="btn btn-sm btn-primary">EDIT</a>

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                        </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted d-block mb-2"></i>
                        <span class="text-muted">Belum ada data peserta</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>        
        <div class="text-center mt-3 text-white">
            <small>
                <i class="fas fa-copyright me-1"></i>
                {{ date('Y') }} Dashboard Admin
            </small>
        </div>
    </div>
</div>
@endsection