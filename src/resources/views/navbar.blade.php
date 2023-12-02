<!-- Navbar -->
<!-- Inicio de la barra de navegación -->
<nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class="container-fluid">
        <a class="navbar-brand"> Actos APP </a>
        ...
    </div>
</nav>
<!-- End Navbar -->

{{-- Inclusión de mensajes --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Inclusión del mensaje de estado --}}
@if (session('status'))
    <div class="alert alert-info">
        {{ session('status') }}
    </div>
@endif
