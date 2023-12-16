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
            <h1>Añadir ponente</h1>
            {{-- Formulario para guardar datos de un ponente --}}
            <form method="post" action="{{ url('ponente-save') }}" class="needs-validation" novalidate>
                @csrf
                
                <div class="form-group">
                    <label for="Id_acto">Acto:</label>
                    <select class="form-control" name="Id_acto" id="Id_acto" required>
                        {{-- Iterar sobre 'actos' --}}
                        @foreach ($actos as $acto)
                            <option value="{{ $acto->Id_acto }}">{{ $acto->Titulo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="Id_persona">Persona:</label>
                    <select class="form-control" name="Id_persona" id="Id_persona" required>
                        {{-- Iterar sobre 'personas' --}}
                        @foreach ($personas as $persona)
                            <option value="{{ $persona->Id_persona }}">{{ $persona->Apellido1 }} {{ $persona->Apellido2 }}, {{ $persona->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="Orden">Orden:</label>
                    <input type="number" class="form-control" name="Orden" id="Orden" value="0" min="0" required>
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
