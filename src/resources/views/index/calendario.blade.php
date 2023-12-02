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
                                    <!-- Calendario -->
                                    <div class="col-12">
                                        <div class="card ">
                                            <div id='calendar'></div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var calendarEl = document.getElementById('calendar');
                                                    var calendar = new FullCalendar.Calendar(calendarEl, {
                                                        themeSystem: 'bootstrap5',
                                                        locale: 'es',
                                                        initialView: 'dayGridMonth',
                                                        firstDay: 1,
                                                        headerToolbar: {
                                                            left: 'prev,next today',
                                                            center: 'title',
                                                            right: 'dayGridMonth,timeGridWeek,timeGridDay',
                                                        },
                                                        buttonText: {
                                                            today: 'Hoy',
                                                            month: 'Mes',
                                                            week: 'Semana',
                                                            day: 'Día',
                                                            list: 'Lista'
                                                        },
                                                        eventDidMount: function(info) {
                                                            $(info.el).tooltip({
                                                                title: `${info.event.extendedProps.description}<div><a href="${info.event.extendedProps.url}"><strong>${info.event.extendedProps.description2}</strong></a></div>`,	
                                                                html: true,
                                                                container: 'body',
                                                                delay: { "show": 50, "hide": 50 }
                                                            });
                                                        },
                                                        events: {!! $eventos !!}
                                                    });
                                                    calendar.render();
                                                });
                                            </script>
                                        </div>
                                    </div>

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
