{{-- Extiende de la plantilla 'page.blade.php' --}}
@extends('page')

{{-- Define el título de la página como 'Calendario' --}}
@section('title', 'Calendario')

{{-- Inicio del bloque de contenido principal de la página --}}
@section('body')

    <div class="wrapper">
        {{-- Incluye 'sidebar.blade.php' --}}
        @include('sidebar', ['user' => $user ?? null])

        <div class="main-panel">
            
            {{-- Incluye 'navbar.blade.php' --}}
            @include('navbar', ['flash_messages' => $flash_messages ?? null])

            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Calendario de Eventos</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Aquí puedes agregar el contenido del calendario -->
                                    <p>Contenido del Calendario</p>
                                </div>
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
