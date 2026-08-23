@extends('layouts.master')

@section('title', 'Form Penilaian Juri')

@section('content')
<style>
    .nilai-slider {
        width: 100%;
        accent-color: #667eea;
        height: 6px;
    }
    .nilai-display {
        font-size: 28px;
        font-weight: 700;
        color: #667eea;
        text-align: center;
        min-width: 60px;
        display: inline-block;
    }
    .tim-card {
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .tim-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .tim-card .card-header {
        background: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Form Penilaian Juri</h5>
                <small class="text-white-50">Silahkan beri penilaian untuk setiap tim yang belum dinilai</small>
            </div>
            <div class="card-body">
                @if($timBelumDinilai->isEmpty())
                    <div class="alert alert-success text-center py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 d-block"></i>
                        <h5>Semua tim sudah dinilai!</h5>
                        <p class="text-muted">Terima kasih telah menyelesaikan penilaian.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                @else
                    <form action="{{ route('juri.penilaian.store') }}" method="POST">
                        @csrf
                        
                        @foreach($timBelumDinilai as $index => $tim)
                            <div class="card tim-card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-users me-2 text-primary"></i>
                                        {{ $tim->nama_tim }}
                                    </h6>
                                    <span class="badge bg-primary">Tim #{{ $loop->iteration }}</span>
                                </div>
                                <div class="card-body">
                                    @foreach($kriteria as $kIndex => $kriteria)
                                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="fw-bold">
                                                    {{ $kriteria->nama_kriteria }}
                                                    <small class="text-muted">(Bobot: {{ $kriteria->bobot }}%)</small>
                                                </label>
                                                @if($kriteria->tipe == 'skala')
                                                    <span class="nilai-display" 
                                                          id="nilai-{{ $tim->id_tim }}-{{ $kriteria->id_kriteria }}">
                                                        {{ $kriteria->skala_min }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($kriteria->tipe == 'skala')
                                                <input type="range" 
                                                       class="form-range nilai-slider" 
                                                       name="penilaian[{{ $index }}][nilai]" 
                                                       min="{{ $kriteria->skala_min }}" 
                                                       max="{{ $kriteria->skala_max }}" 
                                                       value="{{ $kriteria->skala_min }}"
                                                       oninput="updateNilai(this, 'nilai-{{ $tim->id_tim }}-{{ $kriteria->id_kriteria }}')">
                                                <div class="d-flex justify-content-between text-muted small">
                                                    <span>{{ $kriteria->skala_min }}</span>
                                                    <span>{{ $kriteria->skala_max }}</span>
                                                </div>
                                            @elseif($kriteria->tipe == 'pilihan_ganda')
                                                <select class="form-select" name="penilaian[{{ $index }}][nilai]">
                                                    <option value="">Pilih Nilai</option>
                                                    @for($i = $kriteria->skala_min; $i <= $kriteria->skala_max; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            @else
                                                <textarea class="form-control" 
                                                          name="penilaian[{{ $index }}][komentar]" 
                                                          rows="2" 
                                                          placeholder="Masukkan komentar untuk kriteria ini..."></textarea>
                                            @endif
                                            
                                            <input type="hidden" name="penilaian[{{ $index }}][id_tim]" value="{{ $tim->id_tim }}">
                                            <input type="hidden" name="penilaian[{{ $index }}][id_kriteria]" value="{{ $kriteria->id_kriteria }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <span class="text-muted me-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pastikan semua penilaian sudah diisi
                                </span>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i> Simpan Semua Penilaian
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateNilai(slider, displayId) {
    document.getElementById(displayId).textContent = slider.value;
}
</script>
@endsection