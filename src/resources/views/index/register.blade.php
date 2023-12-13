{{-- Extiende la plantilla base "page.blade.php" --}}
@extends('page')

{{-- Define el bloque 'title' con el título "Registro" --}}
@section('title', 'Registro')

{{-- Inicia el bloque 'body' para el contenido principal de la página --}}
@section('body')

<div class="wrapper">
    <div class="sidebar" data-image="{{ asset('img/sidebar.jpg') }}">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('/') }}" class="simple-text">
                    PHPDevelopers
                </a>
            </div>
            <ul class="nav">
                <li>
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="nc-icon nc-circle-09"></i>
                        <p>Registro</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
            
        {{-- Incluye 'navbar.html' --}}
        @include('navbar', ['flash_messages' => $flash_messages ?? null])
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="content">
            <div class="container-fluid">

                @includeWhen(session('flash_messages'), 'messages', ['flash_messages' => session('flash_messages')])

                <div class="row">
                    {{-- Formularios de login y registro --}}
                    <div class="row">

                        <div class="col-md-6 offset-md-2">
                            
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Login</h4>
                                </div>
                                
                                <div class="card-body">
                                
                                    <form action="{{ url('/loginPost') }}" method="post" onsubmit="return validarFormularioLogin()">
                                        @csrf
                                        <div>
                                            <label for="Username-login">Nombre de Usuario:</label>
                                            <input type="text" id="Username-login" name="Username" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="Password-login">Contraseña:</label>
                                            <input type="password" id="Password-login" name="Password" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-fill pull-right">Acceder</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-2">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Registro</h4>
                                </div>
                                
                                <div class="card-body">
                                
                                    <form action="{{ url('/registerPost') }}" method="post" onsubmit="return validarFormularioRegistro()">
                                        @csrf
                                        <div>
                                            <label for="Nombre-register">Nombre:</label>
                                            <input type="text" id="Nombre-register" name="Nombre" autocomplete="given-name" required>
                                        </div>
                                        <div>
                                            <label for="Apellido1-register">Primer Apellido:</label>
                                            <input type="text" id="Apellido1-register" name="Apellido1" autocomplete="family-name" required>
                                        </div>
                                        <div>
                                            <label for="Apellido2-register">Segundo Apellido:</label>
                                            <input type="text" id="Apellido2-register" name="Apellido2" autocomplete="family-name" required>
                                        </div>
                                        <div>
                                            <label for="Username-register">Nombre de Usuario:</label>
                                            <input type="text" id="Username-register" name="Username" autocomplete="username" required>
                                        </div>
                                        <div>
                                            <label for="Password-register">Contraseña:</label>
                                            <input type="password" id="Password-register" name="Password" autocomplete="new-password" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-fill pull-right">Registrarse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav>
                    <p class="copyright text-center">
                        FP064 Desarrollo back-end con PHP, framework MVC y gestor de contenidos
                    </p>
                </nav>
            </div>
        </footer>
    </div>
</div>

{{-- Script de validación para los formularios --}}
<script>
   // Función de validación para el formulario de Login
function validarFormularioLogin() {
    let camposLogin = ['Username-login', 'Password-login'];
    for (let i = 0; i < camposLogin.length; i++) {
        let valor = document.getElementById(camposLogin[i]).value;
        if (valor.trim() === '') {
            alert('Por favor, completa todos los campos del login.');
            return false;
        }
    }
    return true;
}

// Función de validación para el formulario de Registro
function validarFormularioRegistro() {
    let camposRegistro = ['Nombre-register', 'Apellido1-register', 'Apellido2-register', 'Username-register', 'Password-register'];
    for (let i = 0; i < camposRegistro.length; i++) {
        let valor = document.getElementById(camposRegistro[i]).value;
        if (valor.trim() === '') {
            alert('Por favor, completa todos los campos del registro.');
            return false;
        }
    }
    return true;
}
</script>

@endsection
