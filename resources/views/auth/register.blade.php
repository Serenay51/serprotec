@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h4 class="mb-4 text-center">Registro</h4>
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-success w-100" style="background:#2A8D6C;">Registrarse</button>
            </form>
            <p class="mt-3 text-center">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
@endsection
