{{-- Extiende la plantilla base "page.blade.php" --}}
@extends('page')

{{-- Define el bloque 'title' con el título "Detalle Evento" --}}
@section('title', 'Detalle del Evento')

{{-- Inicia el bloque 'body' para el contenido principal de la página --}}
@section('body')

<div class="wrapper">
    {{-- Incluye 'sidebar-guest.blade.php' --}}
    @include('sidebar-guest')

    <div class="main-panel">
        {{-- Incluye 'navbar.blade.php', pasando los mensajes flash si están disponibles --}}
        @include('navbar', ['flash_messages' => session('flash_messages') ?? []])

        <div class="content">
            @if($acto)
                <div class="event-details">
                    <h2>{{ $acto->Titulo }}</h2>
                    <p><strong>Fecha y Hora:</strong> {{ $acto->Fecha }}</p>
                    <p><strong>Tipo de Evento:</strong> {{ $acto->tipoActo->Descripcion }}</p>
                    <p><strong>Número de asistentes:</strong> {{ $acto->Num_asistentes }}</p>
                    <p><strong>Descripción corta:</strong> {{ $acto->Descripcion_corta ?? 'No disponible' }}</p>
                    <p><strong>Descripción larga:</strong> {{ $acto->Descripcion_larga ?? 'No disponible' }}</p>

                    {{-- Listar documentos si existen --}}
                    @if($documentos->count() > 0)
                        <p><strong>Documentos</strong></p>
                        <ul>
                            @foreach($documentos as $documento)
                                <li><a target="_blank" href="{{ asset('uploads/' . $documento->Localizacion_documentacion) }}">{{ $documento->Titulo_documento }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                
                    <a href="{{ url('/invitacion') }}" type="submit" class="btn btn-primary">Inscribirse</a>
                </div>
            @else
                <p>El evento solicitado no está disponible.</p>
            @endif
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
