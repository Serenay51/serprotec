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
                    <button class="btn w-100" style="background:#2A8D6C; color: white;">Ingresar</button>
                </form>
                <p class="mt-3 text-center">
                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
