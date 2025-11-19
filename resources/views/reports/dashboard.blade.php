@extends('layouts.app')

@section('content')

<style>
.dashboard-card {
    border-radius: 15px;
    padding: 25px;
    cursor: pointer;
    transition: 0.25s ease;
    text-decoration: none !important;
    display: block;
}
.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
}
.card-icon {
    font-size: 38px;
    opacity: 0.9;
    margin-bottom: 10px;
}
</style>

<h3>Dashboard Ringkasan Laporan</h3>

@if($laporanBaru->count() > 0)
<div class="alert alert-info">
    <strong>📢 Ada {{ $laporanBaru->count() }} laporan baru!</strong>
    <ul class="mb-0">
        @foreach($laporanBaru as $r)
            <li>{{ $r->nama_pelapor }} - {{ $r->jenis_masalah }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row text-center">

    {{-- TOTAL LAPORAN --}}
    <div class="col-md-3 mb-3">
        <a href="{{ route('reports.index') }}" class="dashboard-card bg-primary text-white">
            <div class="card-icon">📊</div>
            <h4>{{ $total }}</h4>
            <p>Total Laporan</p>
        </a>
    </div>

    {{-- LAPORAN SELESAI --}}
    <div class="col-md-3 mb-3">
        <a href="{{ route('reports.index', ['status' => 'Selesai']) }}" class="dashboard-card bg-success text-white">
            <div class="card-icon">✔️</div>
            <h4>{{ $selesai }}</h4>
            <p>Laporan Selesai</p>
        </a>
    </div>

    {{-- SEDANG DIKERJAKAN --}}
    <div class="col-md-3 mb-3">
        <a href="{{ route('reports.index', ['status' => 'Sedang Dikerjakan']) }}" class="dashboard-card bg-warning text-dark">
            <div class="card-icon">🔧</div>
            <h4>{{ $proses }}</h4>
            <p>Sedang Dikerjakan</p>
        </a>
    </div>

    {{-- LAPORAN BARU --}}
    <div class="col-md-3 mb-3">
        <a href="{{ route('reports.index', ['status' => 'Baru']) }}" class="dashboard-card bg-secondary text-white">
            <div class="card-icon">🆕</div>
            <h4>{{ $baru }}</h4>
            <p>Laporan Baru</p>
        </a>
    </div>

</div>

@endsection
