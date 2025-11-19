@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
        <h4 class="text-center mb-3">Login Admin</h4>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first('login') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.login.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="text-decoration-none">← Kembali ke halaman utama</a>
        </div>
    </div>
</div>
@endsection
