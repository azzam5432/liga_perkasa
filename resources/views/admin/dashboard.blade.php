@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Total Data Peserta: <strong>{{ $dataPeserta->count() }}</strong>
        </div>
        
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">Nama Peserta</th>
                    <th scope="col">Nomor Telpon</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataPeserta as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nama_peserta }}</td>
                    <td>{{ $item->no_telp }}</td>
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