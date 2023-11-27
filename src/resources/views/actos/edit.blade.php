{{-- Extiende la plantilla base "page.blade.php" --}}
@extends('page')

{{-- Define el bloque 'title' con el título "Dashboard" --}}
@section('title', 'Dashboard')

{{-- Inicia el bloque 'body' para el contenido principal de la página --}}
@section('body')

<div class="wrapper">
    {{-- Incluye 'sidebar.blade.php', pasando la variable 'user' si existe --}}
    @include('sidebar', ['user' => $user ?? null])

    <div class="main-panel">
        {{-- Incluye 'navbar.blade.php', pasando los mensajes flash si están disponibles --}}
        @include('navbar', ['flash_messages' => session('flash_messages') ?? []])

        <div class="content">
            {{-- Formulario para guardar datos de un acto --}}
            <form method="post" action="{{ url('acto-save') }}" class="needs-validation" novalidate>
                @if (isset($acto->Id_acto))
                    <input type="hidden" name="Id_acto" value="{{ $acto->Id_acto }}">
                @endif
            
                {{-- Resto del formulario --}}
                {{-- Repite la estructura para cada campo, reemplazando la sintaxis de Twig con la de Blade --}}
                <div class="form-group">
                    {{-- Ejemplo para el campo Fecha --}}
                    <label for="Fecha">Fecha:</label>
                    <input type="date" class="form-control" name="Fecha" id="Fecha" value="{{ $acto->Fecha ?? '' }}" required>
                </div>
                
                {{-- Continúa con los otros campos siguiendo el mismo patrón --}}
                {{-- ... --}}

                {{-- Para el select de Tipo de Acto --}}
                <div class="form-group">
                    <label for="Id_tipo_acto">Tipo de Acto:</label>
                    <select class="form-control" name="Id_tipo_acto" id="Id_tipo_acto" required>
                        @foreach ($tipo_acto as $tipo)
                            <option value="{{ $tipo->Id_tipo_acto }}" {{ $acto->Id_tipo_acto == $tipo->Id_tipo_acto ? 'selected' : '' }}>{{ $tipo->Descripcion }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón para enviar el formulario --}}
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
            
        </div>
    
        {{-- Footer --}}
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
