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

            <form method="post" action="{{ url('acto-save') }}" class="needs-validation" novalidate>
                @csrf
                @if (isset($acto->Id_acto))
                    <input type="hidden" name="Id_acto" value="{{ $acto->Id_acto }}">
                @endif

                <div class="form-group">
                    <label for="Fecha">Fecha:</label>
                    <input type="date" class="form-control" name="Fecha" id="Fecha" value="{{ $acto->Fecha ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="Hora">Hora:</label>
                    <input type="time" class="form-control" name="Hora" id="Hora" value="{{ $acto->Hora ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="Titulo">Título:</label>
                    <input type="text" class="form-control" name="Titulo" id="Titulo" value="{{ $acto->Titulo ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="Descripcion_corta">Descripción Corta:</label>
                    <input type="text" class="form-control" name="Descripcion_corta" id="Descripcion_corta" value="{{ $acto->Descripcion_corta ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="Num_asistentes">Número de Asistentes:</label>
                    <input type="number" class="form-control" name="Num_asistentes" id="Num_asistentes" min="0" value="{{ $acto->Num_asistentes ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="Id_tipo_acto">Tipo de Acto:</label>
                    <select class="form-control" name="Id_tipo_acto" id="Id_tipo_acto" required>
                        @foreach ($tipo_acto as $tipo)
                            <option value="{{ $tipo->Id_tipo_acto }}" {{ (isset($acto->Id_tipo_acto) && $acto->Id_tipo_acto == $tipo->Id_tipo_acto) ? 'selected' : '' }}>{{ $tipo->Descripcion }}</option>
                        @endforeach
                    </select>
                </div>                

                <div class="form-group">
                    <label for="Descripcion_larga">Descripción Larga:</label>
                    <textarea class="form-control" name="Descripcion_larga" id="Descripcion_larga" required>{{ $acto->Descripcion_larga ?? '' }}</textarea>
                </div>

                <!-- Botón para enviar el formulario -->
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
