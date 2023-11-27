{{-- Comprueba si hay mensajes flash para mostrar --}}
@if (session('flash_messages'))
    {{-- Contenedor para los mensajes --}}
    <div class="p-3">
        <div class="container-fluid">
            <div class="row">
                {{-- Recorre cada mensaje flash --}}
                @foreach (session('flash_messages') as $mensaje)
                    <div class="alert alert-{{ $mensaje['tipo'] }} w-100" role="alert">
                        {{-- Texto del mensaje --}}
                        {{ $mensaje['texto'] }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
