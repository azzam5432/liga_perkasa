@extends('layouts.master')

@section('title', 'Detail Peserta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Detail Peserta
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%;">ID</th>
                        <td>{{ $peserta->id_peserta }}</td>
                    </tr>
                    <tr>
                        <th>Nama Peserta</th>
                        <td>{{ $peserta->nama_peserta }}</td>
                    </tr>
                    <tr>
                        <th>No Telpon</th>
                        <td>{{ $peserta->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $peserta->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Diupdate Pada</th>
                        <td>{{ $peserta->updated_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </table>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.edit', $peserta) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection