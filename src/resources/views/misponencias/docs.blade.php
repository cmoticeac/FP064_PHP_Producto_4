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
                                            <th>Título del Documento</th>
                                            <th>Orden</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($documentos as $documento)
                                            <tr>
                                                <td><a target="_blank" href="{{ asset('uploads/' . $documento->Localizacion_documentacion) }}">{{ $documento->Titulo_documento }}</a></td>
                                                <td>{{ $documento->Orden }}</td>
                                                <td>
                                                    {{-- Botón para borrar el documento --}}
                                                    <form action="{{ route('misponencias-delete-doc', $documento->Id_presentacion) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No hay documentos disponibles.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
</table>
                                    
                                {{-- Formulario para añadir nuevos documentos --}}
                                <form action="{{ route('misponencias-add-doc') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_acto" value="{{ $id_acto }}">

                                    <div class="form-group">
                                        <label for="documento">Subir Documento:</label>
                                        <input type="file" name="documento" id="documento" class="form-control" required>
                                        <label for="titulo_documento">Titulo Documento:</label>
                                        <input type="input" name="titulo_documento" id="titulo_documento" class="form-control" required>
                                        <label for="orden_documento">Orden:</label>
                                        <input type="number" name="orden_documento" id="orden_documento" class="form-control" min="0" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Subir Documentación</button>
                                </form>
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
