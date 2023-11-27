{{-- Extiende de la plantilla 'page.blade.php', heredando su estructura básica --}}
@extends('page')

{{-- Define el título de la página como 'Dashboard' --}}
@section('title', 'Dashboard')

{{-- Inicio del bloque de contenido principal de la página --}}
@section('body')
    <div class="wrapper">
        {{-- Incluye 'sidebar.blade.php', pasando la variable 'user' si existe --}}
        @include('sidebar', ['user' => $user ?? null])

        <div class="main-panel">
            
            {{-- Incluye 'navbar.blade.php' --}}
            @include('navbar')

            <div class="content">
                {{-- Aquí puedes agregar el contenido específico de la página --}}
            </div>

            <footer class="footer">
                {{-- Pie de página --}}
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
