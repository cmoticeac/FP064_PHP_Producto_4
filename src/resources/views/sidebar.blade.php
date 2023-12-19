<!-- Barra lateral con una imagen de fondo -->
<div class="sidebar" data-image="{{ asset('img/sidebar.jpg') }}">
    <div class="sidebar-wrapper">
        <!-- Sección del logo con enlace a la página de inicio y muestra el tipo de usuario -->
        <div class="logo">
            <a href="{{ url('/') }}" class="simple-text">
                PHPDevelopers
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link">
                    <p>
                        @if ($user->Id_tipo_usuario == 1)
                            ADMINISTRADOR
                        @elseif ($user->Id_tipo_usuario == 2)
                            PONENTE
                        @elseif ($user->Id_tipo_usuario == 3)
                            USUARIO
                        @endif
                    </p>
                </a>
            </li>
            @if ($user->Id_tipo_usuario == 1)
                <!-- Elemento de navegación solo para admin -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('ponente-list') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Gestionar ponentes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('inscritos-list') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Gestionar inscritos</p>
                    </a>
                </li>
            @endif
            @if ($user->Id_tipo_usuario == 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('misponencias-list') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Mis ponencias</p>
                    </a>
                </li>
            @endif
            <li>
                <a class="nav-link" href="{{ url('calendario') }}">
                    <i class="nc-icon nc-notes"></i>
                    <p>Calendario</p>
                </a>
            </li>
                <li>
                    <a class="nav-link" href="{{ url('/eventos') }}">
                        <i class="nc-icon nc-notes"></i>
                        <p>Documentos Eventos</p>
                    </a>
                </li>
            <!-- Elemento de navegación para editar el perfil del usuario -->
            <li>
                <a class="nav-link" href="{{ url('user-edit') }}">
                    <i class="nc-icon nc-circle-09"></i>
                    <p>Perfil usuario</p>
                </a>
            </li>
            <!-- Elemento de navegación para editar mi cuenta y cerrar sesión -->
            <li class="nav-item active active-pro">
                <a class="nav-link active" href="{{ url('logout') }}">
                    <i class="nc-icon nc-alien-33"></i>
                    <p>Cerrar sesión</p>
                </a>
            </li>
        </ul>
    </div>
</div>
