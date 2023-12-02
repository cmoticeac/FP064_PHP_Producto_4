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
                                <h4 class="card-title">Gestionar Ponentes</h4>
                                <a href="{{ url('ponente-add') }}" class="btn btn-success float-right">
                                    <i class="nc-icon nc-simple-add"></i> Añadir
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID Ponente</th>
                                            <th>Persona</th>
                                            <th>Acto</th>
                                            <th>Orden</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ponentes as $ponente)
                                            <tr>
                                                <td>{{ $ponente->id_ponente }}</td>
                                                <td>{{ $ponente->Nombre }} {{ $ponente->Apellido1 }} {{ $ponente->Apellido2 }}</td>
                                                <td>{{ $ponente->Titulo }}</td>
                                                <td>{{ $ponente->Orden }}</td>
                                                <td>
                                                    <a href="{{ url('ponente-remove', ['id' => $ponente->id_ponente]) }}" class="btn btn-danger btn-sm">
                                                        <i class="nc-icon nc-simple-remove"></i> Eliminar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                                                            
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
