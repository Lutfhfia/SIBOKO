@extends('layouts.mahasiswa')

@section('title', 'Login')

@section('content')
<div class="container py-5" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4 class="fw-bold">Masuk ke SIBOKO</h4>
                        <p class="text-muted">Masukkan Username/NIM dan password Anda.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 10px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username / NIM</label>
                            <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username') }}" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" style="border-radius: 10px;">Masuk</button>
                    </form>

                    <div class="text-center">
                        <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
