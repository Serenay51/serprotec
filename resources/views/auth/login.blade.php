@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h4 class="mb-4 text-center">Iniciar sesión</h4>
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-success w-100" style="background:#2A8D6C;">Ingresar</button>
            </form>
            <p class="mt-3 text-center">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Registrate</a>
            </p>
        </div>
    </div>
</div>
@endsection
