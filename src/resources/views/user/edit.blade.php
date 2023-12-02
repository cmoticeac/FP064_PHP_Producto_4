{{-- Extiende la plantilla base "page.blade.php" --}}
@extends('page')

{{-- Define el bloque 'title' con el título "Dashboard" --}}
@section('title', 'Dashboard')

{{-- Inicia el bloque 'content' para el contenido principal de la página --}}
@section('body')

<div class="wrapper">
    {{-- Incluye 'sidebar.blade.php', pasa 'user' si existe --}}
    @include('sidebar', ['user' => $user ?? null])

    <div class="main-panel">
        {{-- Incluye 'navbar.blade.php', pasa 'flash_messages' si existe --}}
        @include('navbar', ['flash_messages' => $flash_messages ?? null])

        <div class="content">
            <!-- Formulario para editar datos del usuario -->
            <form action="{{ url('user-save') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="Username"><strong>Nombre de usuario</strong></label>
                    <input type="text" class="form-control" id="Username" name="Username" value="{{ $user->Username ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="Password"><strong>Contraseña</strong> (sólo rellenar si desea modificar su contraseña)</label>
                    <input type="password" class="form-control" id="Password" name="Password" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="Nombre"><strong>Nombre</strong></label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="{{ $user->Nombre ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="Apellido1"><strong>Apellido 1</strong></label>
                    <input type="text" class="form-control" id="Apellido1" name="Apellido1" value="{{ $user->Apellido1 ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="Apellido2"><strong>Apellido 2</strong></label>
                    <input type="text" class="form-control" id="Apellido2" name="Apellido2" value="{{ $user->Apellido2 ?? '' }}">
                </div>
                <!-- Botón de envío del formulario -->
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>                
                
        </div>
        <!-- Pie de página -->
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

@endsection
