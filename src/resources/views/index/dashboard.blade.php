{{-- Extiende de la plantilla 'page.blade.php' --}}
@extends('page')

{{-- Define el título de la página como 'Dashboard' --}}
@section('title', 'Dashboard')

{{-- Inicio del bloque de contenido principal de la página --}}
@section('body')

    <div class="wrapper">
        {{-- Incluye 'sidebar.html' --}}
        @include('sidebar', ['user' => $user ?? null])

        <div class="main-panel">
            
            {{-- Incluye 'navbar.html' --}}
            @include('navbar', ['flash_messages' => $flash_messages ?? null])

            <div class="content">
                <div class="container-fluid">

                    @if ($user->Id_tipo_usuario == 1)
                        <!-- Dashboard admin -->
                        <div class="row">

                            <!-- Gestionar Actos -->
                            <div class="col-12">
                                <div class="card ">
                                    <div class="card-header ">
                                        <h4 class="card-title">Gestionar Actos</h4>
                                        <a href="{{ url('acto-edit') }}" class="btn btn-success float-right">
                                            <i class="nc-icon nc-simple-add"></i> Añadir
                                        </a>
                                    </div>
                                    <div class="card-body ">
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
                                                        <td>{{ $acto->tipo_acto }}</td>
                                                        <td>{{ $acto->Descripcion_larga }}</td>
                                                        <td class="d-inline-block">
                                                            <div>
                                                                <a href="{{ url('acto-edit', ['id' => $acto->Id_acto]) }}" class="btn btn-primary btn-sm mb-1">
                                                                    <i class="nc-icon nc-ruler-pencil"></i> Editar
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <a href="{{ url('ponente-list', ['id' => $acto->Id_acto]) }}" class="btn btn-success btn-sm mb-1">
                                                                    <i class="nc-icon nc-ruler-pencil"></i> Ponentes
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <a href="{{ url('inscritos-list', ['id' => $acto->Id_acto]) }}" class="btn btn-secondary btn-sm mb-1">
                                                                    <i class="nc-icon nc-ruler-pencil"></i> Inscritos
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <!-- Botón para eliminar un acto -->
                                                                <a href="{{ url('acto-delete', ['id' => $acto->Id_acto]) }}" class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Estás seguro de que quieres eliminar este acto? Solo se pueden eliminar actos sin ponentes ni inscritos.')">
                                                                    <i class="nc-icon nc-simple-remove"></i> Eliminar
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <!-- Botón para gestionar documentación -->
                                                                <a href="{{ url('misponencias-docs', ['id' => $acto->Id_acto]) }}" class="btn btn-primary btn-sm mb-1">
                                                                    <i class="nc-icon nc-ruler-pencil"></i> Gestionar documentación
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>                                                                            
                                    </div>
                                </div>
                            </div>

                            <!-- Gestionar tipos actos -->
                            <div class="col-12">
                                <div class="card ">
                                    <div class="card-header ">
                                        <h4 class="card-title">Gestionar Tipos de Acto</h4>
                                        <a href="{{ url('tipoacto-edit') }}" class="btn btn-success float-right">
                                            <i class="nc-icon nc-simple-add"></i> Añadir
                                        </a>
                                    </div>
                                    <div class="card-body ">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Id Tipo Acto</th>
                                                    <th>Descripción</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tipos_acto as $tipo_acto)
                                                    <tr>
                                                        <td>{{ $tipo_acto->Id_tipo_acto }}</td>
                                                        <td>{{ $tipo_acto->Descripcion }}</td>
                                                        <td>
                                                            <a href="{{ url('tipoacto-edit', ['id' => $tipo_acto->Id_tipo_acto]) }}" class="btn btn-primary btn-sm mr-1">
                                                                <i class="nc-icon nc-ruler-pencil"></i> Editar
                                                            </a>
                                                            <a href="{{ url('tipoacto-delete', ['id' => $tipo_acto->Id_tipo_acto]) }}" class="btn btn-danger btn-sm">
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
                    @endif
                    
                    </div>
                    <div class="row">

                        <!-- Calendario -->
                        <div class="col-6">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title"></h4>
                                </div>
                                <ul>
                                    <li>Consulta todos los eventos</li>
                                    <li>Consulta los eventos a los que estás inscrito</li>
                                    <li>Sucríbete o desuscríbete</li>
                                </ul>
                                <a class="btn btn-primary w-100" href="{{ url('calendario') }}">Calendario de Eventos</a>
                            </div>
                        </div>

                        <!-- Mi cuenta -->
                        <div class="col-6">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title"></h4>
                                </div>
                                <ul>
                                    <li>Consulta tus datos</li>
                                    <li>Modifica tu información</li>
                                    <li>Cambia mi contraseña</li>
                                </ul>
                                <a class="btn btn-success w-100" href="{{ url('user-edit') }}">Mi Cuenta</a>
                            </div>
                        </div>

                    </div>
                </div>
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
