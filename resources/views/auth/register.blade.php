@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card shadow d-flex flex-row" style="width: 800px; height: 500px; overflow: hidden; border-radius: 10px;">

        <!-- Columna Logo -->
        <div class="d-flex justify-content-center align-items-center bg-light" style="width: 50%; padding: 30px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SERPROTEC" style="max-width: 80%; max-height: 80%;">
        </div>

        <!-- Columna Formulario -->
        <div class="d-flex justify-content-center align-items-center" style="width: 50%; padding: 30px;">
            <div style="width: 100%; max-width: 350px;">
                <h4 class="mt-4 mb-4 text-center">Registro</h4>
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
                    <button class="btn w-100" style="background:#2A8D6C; color:white;">Registrarse</button>
                </form>
                <p class="mt-3 text-center">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
