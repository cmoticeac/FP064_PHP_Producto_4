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
            <!-- Formulario para guardar datos de un tipo_acto -->
            <form method="post" action="{{ url('tipoacto-save') }}" class="needs-validation" novalidate>
                @csrf
                
                {{-- Si existe un tipo_acto, se trata de una edición, por lo que se incluye el campo 'Id_tipo_acto' --}}
                @if (isset($tipo_acto) && $tipo_acto->Id_tipo_acto)
                    <div class="form-group">
                        <label for="Descripcion">ID Tipo Acto:</label><br>
                        <input type="text" name="Id_tipo_acto" value="{{ $tipo_acto->Id_tipo_acto }}" readonly>
                    </div>
                @endif
            
                <div class="form-group">
                    <label for="Descripcion">Descripción:</label>
                    <input type="text" class="form-control" name="Descripcion" id="Descripcion" value="{{ $tipo_acto->Descripcion ?? '' }}" required>
                </div>
        
                {{-- Botón para enviar el formulario --}}
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
            
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

@endsection
