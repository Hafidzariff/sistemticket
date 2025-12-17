@extends('layouts.app')

@section('content')
<h3>Form Laporan Kerusakan IT</h3>

<a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm mb-3">⬅ Kembali ke Dashboard</a>

<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if(!request()->is('admin*'))
        <p class="text-white" >Silakan isi form berikut untuk melaporkan kendala IT Anda.</p>
        
    @endif

    <div class="mb-3">
        <label>Nama Pelapor</label>
        <input type="text" name="nama_pelapor" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Departemen</label>
        <select name="departemen" class="form-control" required>
            <option value="">-- Pilih Departemen --</option>
            <option>Administrasi</option>
            <option>Produksi</option>
            <option>Keuangan</option>
            <option>Gudang</option>
            <option>HRD</option>
            <option>Marketing</option>
            <option>IT</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Jenis Masalah</label>
        <select name="jenis_masalah" class="form-control" required>
            <option>Maintenence</option>
            <option>Troubleshooting/Helpdesk</option>
            <option>Instalasi Software</option>
            <option>Instalasi Perangkat Jaringan</option>
            <option>Instlasi Perangkat Hardware</option>
            <option>Lainnya</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Deskripsi Masalah</label>
        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label>Upload Foto (Opsional)</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Kirim Laporan</button>

    @if(request()->is('admin*'))
        <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">⬅ Kembali ke Dashboard</a>
    @endif
</form>
@endsection
