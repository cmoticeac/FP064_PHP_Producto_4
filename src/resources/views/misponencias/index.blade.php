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
            <div class="container-fluid">
                <div class="row">
                    <!-- Gestionar ponentes -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Mis ponencias</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id Acto</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Título</th>
                                            <th>Descripción Corta</th>
                                            <th>Número de Asistentes</th>
                                            <th>Tipo Acto</th>
                                            <th>Descripción Larga</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($actos as $acto)
                                            <tr>
                                                <td>{{ $acto->Id_acto }}</td>
                                                <td>{{ $acto->Fecha }}</td>
                                                <td>{{ $acto->Hora }}</td>
                                                <td>{{ $acto->Titulo }}</td>
                                                <td>{{ $acto->Descripcion_corta }}</td>
                                                <td>{{ $acto->Num_asistentes }}</td>
                                                <td>{{ $acto->Id_tipo_acto }}</td>
                                                <td>{{ $acto->Descripcion_larga }}</td>
                                                <td class="d-inline-block">
                                                    {{-- Si la fecha y hora es posterior a la actual se puede subir documentos --}}
                                                    <div>
                                                        @if ($acto->puedeSubirDocumentacion)
                                                        <a href="{{ url('misponencias-docs', ['id' => $acto->Id_acto]) }}" class="btn btn-primary btn-sm mb-1">
                                                            <i class="nc-icon nc-ruler-pencil"></i> Gestionar documentación
                                                        </a>
                                                        @else
                                                        <span class="text-danger">
                                                        Este acto no ha finalizado.
                                                        </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                <table>             
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

@endsection
