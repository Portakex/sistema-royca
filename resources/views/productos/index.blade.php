{{-- Extiende la plantilla principal SÓLO aquí --}}
@extends('adminlte::page')

@section('title', 'Maestro de Productos')

@section('content_header')
    {{-- Mantenemos el H1 aquí para la carga inicial --}}
    <h1 id="view-title">Maestro de Productos</h1>
@stop

@section('content')
    {{-- Input oculto para saber si un formulario está abierto --}}
    <input type="hidden" id="FormOpen" value="0">

    {{-- Este div es el CONTENEDOR donde cargaremos dinámicamente las vistas (tabla, crear, editar) --}}
    <div id="content-wrapper">

        {{-- Alerta para mensajes de éxito (se manejará con JS) --}}
        <div id="success-alert-container">
            {{-- Si hay un mensaje de sesión (carga inicial), lo mostramos --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>✅ {{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Incluimos el contenido inicial (la tabla y buscador) desde un archivo separado --}}
        @include('productos.components.indexContent')

    </div> {{-- Fin de #content-wrapper --}}
@stop

@section('css')
    {{-- Importamos Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos generales (puedes moverlos a un .css si prefieres) */
        .page-title { font-weight: 600; margin-bottom: 25px; color: #4a4a4a; }
        .shadow-sm { box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important; border: none; border-radius: 0.75rem; }
        .btn-registrar, .btn-accion-principal { background-color: #2c519a; border-color: #2c519a; color: white; border-radius: 0.375rem; }
        .btn-registrar:hover, .btn-accion-principal:hover { background-color: #24437e; border-color: #24437e; color: white;}
        .table-header-custom { background-color: #f0f3f8; color: #2c519a; font-weight: 600; }
        .table-header-custom th { border-bottom: 0; }
        .action-icon { color: #0d6efd; text-decoration: none; font-size: 1.1rem; }
        .action-icon:hover { color: #0a58ca; }
        .action-icon-danger { background: none; border: none; padding: 0; color: #dc3545; text-decoration: none; font-size: 1.1rem; cursor: pointer; }
        .action-icon-danger:hover { color: #bb2d3b; }
        .alert-fade-out { transition: opacity 0.5s ease-out; opacity: 0; }

        /* Estilos específicos del formulario (como el de tu compañero) */
        .card-primary.card-outline { border-top: 3px solid #2c519a; }
        .card-primary:not(.card-outline)>.card-header { background-color: #2c519a; }
        .card-title b { font-weight: 600; }
        .input-group-text i { color: #495057; }

    </style>
@stop

@section('js')
    <script>
        // --- Funciones de Utilidad ---

        // Muestra alerta de éxito estilo AdminLTE
        function showSuccessAlert(message) {
            const container = document.getElementById('success-alert-container');
            if (!container) return;
             container.innerHTML = ''; // Limpia alertas anteriores

            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
                <div class="alert alert-success alert-dismissible" data-js-success="1">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                    <span class="js-success-message">${message}</span>
                </div>
            `;
            container.appendChild(wrapper.firstElementChild);

             // Auto-cerrar (Bootstrap 4/AdminLTE style)
            const alertElement = container.querySelector('[data-js-success]');
            if (alertElement) {
                setTimeout(() => {
                     $(alertElement).alert('close'); // Usa el método de Bootstrap
                }, 5000);
            }
        }

        // Inyecta HTML en el contenedor principal y actualiza título
        function injectContent(html) {
            const target = document.getElementById('content-wrapper');
            if (target) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContentWrapper = doc.getElementById('content-wrapper');
                 const newTitle = doc.getElementById('view-title'); // Busca el H1 oculto

                if (newContentWrapper) {
                    target.innerHTML = newContentWrapper.innerHTML;
                } else {
                      // Fallback si la respuesta no tiene #content-wrapper (ej. solo el form)
                    target.innerHTML = html;
                }

                 // Actualizar el título H1 principal
                const currentTitle = document.getElementById('view-title');
                if (currentTitle && newTitle) {
                    currentTitle.innerHTML = newTitle.innerHTML;
                } else if (currentTitle && html.includes('<h1 id="view-title"')) {
                      // Intenta extraer el título si está en el html directo
                    const titleMatch = html.match(/<h1 id="view-title"[^>]*>(.*?)<\/h1>/i);
                    if (titleMatch && titleMatch[1]) {
                        currentTitle.innerHTML = titleMatch[1];
                    }
                }
            }
        }

        // --- Lógica Principal de AJAX ---

        // Función central para cargar contenido
        function fetchAndSwap(url, onDone) {
            console.log("Fetching URL:", url);
            $.ajax({
                url: url,
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).done(function(data) {
                console.log("AJAX success, injecting content.");
                injectContent(data);
                history.pushState({ urlPath: url }, document.title, url);

                 // Marca si estamos en un formulario
                const isCreateForm = /\/productos\/create(\b|\/|\?|$)/.test(url);
                const isEditForm = /\/productos\/(\d+|[^\/]+)\/edit(\b|\/|\?|$)/.test(url);
                $('#FormOpen').val(isCreateForm || isEditForm ? 1 : 0);
                console.log("FormOpen set to:", $('#FormOpen').val());

                if (typeof onDone === 'function') onDone();

            }).fail(function(xhr, status, error) {
                console.error("AJAX failed:", status, error, xhr);
                let msg = 'No se pudo cargar el contenido.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                else if (xhr && xhr.responseText) msg += '<br><small>' + xhr.responseText.substring(0, 200) + '...</small>';
                Swal.fire('Error', msg, 'error');
            });
        }

        // Función para navegar (con confirmación)
        function GoTo(url) {
            var formOpenVal = $('#FormOpen').val();
            console.log("GoTo called for:", url, "FormOpen:", formOpenVal);
            if (formOpenVal == 1 && typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Salir del formulario?',
                    text: 'Los cambios no guardados se perderán.',
                     icon: 'warning', // SweetAlert v11 usa 'icon'
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetchAndSwap(url);
                    }
                });
            } else {
                fetchAndSwap(url);
            }
        }

        // --- Event Listeners ---

        // Escucha clics en enlaces/botones con clase 'ajax-link'
        $(document).on('click', 'a.ajax-link, button.ajax-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href') || $(this).data('url');
            if (url) {
                console.log("AJAX link clicked:", url);
                GoTo(url);
            } else {
                console.warn("AJAX link clicked but no href or data-url found.");
            }
        });

        // Envío AJAX del formulario de CREACIÓN (#createForm)
        $(document).on('submit', '#createForm', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            var csrf = $('meta[name="csrf-token"]').attr('content');
            console.log("Submitting Create form via AJAX to:", $form.attr('action'));

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            }).done(function(resp) {
                console.log("Create success:", resp);
                const successMsg = (resp && resp.message) ? resp.message : 'Producto creado correctamente.';
                fetchAndSwap("{{ route('productos.index') }}", function() {
                    showSuccessAlert(successMsg);
                });
            }).fail(function(xhr) {
                console.error("Create failed:", xhr);
                let msg = 'Error al crear el producto.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                    if (xhr.responseJSON.errors) {
                        msg += '<ul style="text-align: left; margin-top: 10px;">';
                        $.each(xhr.responseJSON.errors, function(key, value) { msg += '<li>' + value + '</li>'; });
                        msg += '</ul>';
                    }
                } else if (xhr && xhr.responseText) {
                    msg += '<br><small>(' + xhr.status + ')</small>';
                }
                Swal.fire({ icon: 'error', title: 'Error', html: msg });
            });
        });

        // Envío AJAX del formulario de EDICIÓN (.editForm)
        $(document).on('submit', '.editForm', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            var csrf = $('meta[name="csrf-token"]').attr('content');
             formData.append('_method', 'PUT'); // Simula PUT
            console.log("Submitting Edit form via AJAX to:", $form.attr('action'));

            $.ajax({
                url: $form.attr('action'),
                 method: 'POST', // Siempre POST para simular PUT/DELETE con FormData
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            }).done(function(resp) {
                console.log("Update success:", resp);
                const successMsg = (resp && resp.message) ? resp.message : 'Producto actualizado correctamente.';
                fetchAndSwap("{{ route('productos.index') }}", function() {
                    showSuccessAlert(successMsg);
                });
            }).fail(function(xhr) {
                console.error("Update failed:", xhr);
                let msg = 'Error al actualizar el producto.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                    if (xhr.responseJSON.errors) {
                        msg += '<ul style="text-align: left; margin-top: 10px;">';
                        $.each(xhr.responseJSON.errors, function(key, value) { msg += '<li>' + value + '</li>'; });
                        msg += '</ul>';
                    }
                } else if (xhr && xhr.responseText) {
                    msg += '<br><small>(' + xhr.status + ')</small>';
                }
                Swal.fire({ icon: 'error', title: 'Error', html: msg });
            });
        });

        // Envío AJAX del formulario de ELIMINACIÓN (.form-delete)
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            var $form = $(this);
            var csrf = $('meta[name="csrf-token"]').attr('content');
            console.log("Initiating Delete confirmation for:", $form.attr('action'));

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                 icon: 'warning', // v11 usa icon
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡elimínalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                 if (result.isConfirmed) { // v11 usa isConfirmed
                    console.log("Delete confirmed, sending AJAX request to:", $form.attr('action'));
                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST', // Siempre POST para simular DELETE
                        data: {
                            _method: 'DELETE',
                            _token: csrf
                        },
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    }).done(function(resp) {
                        console.log("Delete success:", resp);
                        const successMsg = (resp && resp.message) ? resp.message : 'Producto eliminado correctamente.';
                        // Recarga la lista completa
                        fetchAndSwap("{{ route('productos.index') }}", function() {
                            showSuccessAlert(successMsg);
                        });
                    }).fail(function(xhr) {
                        console.error("Delete failed:", xhr);
                        let msg = 'Error al eliminar el producto.';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        else if (xhr && xhr.responseText) msg += '<br><small>(' + xhr.status + ')</small>';
                        Swal.fire({ icon: 'error', title: 'Error', html: msg });
                    });
                } else {
                    console.log("Delete cancelled by user.");
                }
            });
        });

        // Manejo del historial del navegador
        window.addEventListener('popstate', function (event) {
            console.log("Popstate event:", event.state);
            if (event.state && event.state.urlPath) {
                fetchAndSwap(location.pathname + location.search);
            } else if (!event.state && location.pathname.startsWith("{{ url('/productos') }}")) {
                  // Si no hay estado pero estamos en la sección de productos,
                  // probablemente el usuario usó F5 o llegó directo.
                  // Recargar la página completa puede ser una opción segura aquí.
                  // location.reload(); // Descomenta si es necesario
                console.log("Popstate to initial page load state detected.");
                  // O intentar cargar el index si es seguro
                   // fetchAndSwap("{{ route('productos.index') }}");
            }
        });

        // Guardar estado inicial
        if (!history.state || !history.state.urlPath) {
            history.replaceState({ urlPath: window.location.pathname }, document.title, window.location.href);
            console.log("Initial history state replaced for:", window.location.pathname);
        }

    </script>
@stop