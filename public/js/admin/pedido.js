$(function(){

    const url = window.location.href;

    const url_pedido = url.split('/').pop();

    $("#span_entregar_pedido").click(async function(){
        const result = await tmpl.confirmarProceso('¿Estás seguro de entregar este pedido?');
        if(result){
            cambiarEstado(url_pedido, 'entregar');
        }
    });

    $("#span_cancelar_pedido").click(async function(){
        const result = await tmpl.confirmarProceso('¿Estás seguro de cancelar este pedido?');
        if(result){
            cambiarEstado(url_pedido, 'cancelar');
        }
    });

    $("#button_editar_estado_pedido").click(function(){
        modalCambiarEstado($(this));
    });

    $("#button_editar_observacion").click(function(){
        modalEditarObservacion($(this));
    })

    $("#a_descargar_informe").click(function() {
        $.ajax({
            url: '/admin/controlador/pedidos/pdf',
            method: 'POST',
            data: {
                url_pedido: url_pedido,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                responseType: 'blob' // Importante para manejar la respuesta como binario (PDF)
            }
        }).done(function(response) {
            const blob = new Blob([response], { type: 'application/pdf' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `pedido_${url_pedido}.pdf`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }).fail(function(response) {
            tmpl.notificacionError('Error al descargar el informe del pedido');
        });
    });


    function cambiarEstado(url, estado){
        $.ajax({
            url: '/admin/controlador/pedidos/'+estado,
            method: 'POST',
            data: {
                url_pedido: url_pedido,
                estado_pedido: estado,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            location.reload();
        }).fail(function (response) {
            tmpl.notificacionError('Error al cambiar el estado del pedido');
        });
    }


    function modalCambiarEstado(selector) {
        let modalHtml = `
        <div class="modal fade" id="cambiarEstadoModal" tabindex="-1" aria-labelledby="cambiarEstadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarEstadoModalLabel">Cambiar estado del pedido #${url_pedido}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="cambiarEstadoForm">
                            <div class="mb-3">
                                <label for="estadoPedido" class="form-label">Seleccionar nuevo estado</label>
                                <select class="form-select" id="estadoPedido" name="estado">
                                    <option value="a pagar">A pagar</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en envio">En envío</option>
                                    <option value="entregado">Entregado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarEstado">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    `;

        $('body').append(modalHtml);

        $('#cambiarEstadoModal').modal('show');

        $('#cambiarEstadoModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });

        $("#guardarEstado").click(function() {
            const nuevoEstado = $("#estadoPedido").val();
            $.ajax({
                url: '/admin/controlador/pedidos/cambiar-estado',
                method: 'POST',
                data: {
                    url_pedido: url_pedido,
                    estado_pedido: nuevoEstado,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                }
            }).done(function(response) {
                $('#cambiarEstadoModal').modal('hide');
                location.reload();
            }).fail(function(response) {
                tmpl.notificacionError('Error al cambiar el estado del pedido');
            });
        });
    }

    function modalEditarObservacion(selector) {
        const observacion = $("#p_observacion").text();
        let modalHtml = `
        <div class="modal fade" id="editarObservacionModal" tabindex="-1" aria-labelledby="editarObservacionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarObservacionModalLabel">Editar observación del pedido #${url_pedido}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body
                    ">
                        <form id="editarObservacionForm">
                            <div class="mb-3">
                                <label for="observacionPedido" class="form-label
                                ">Observación</label>
                                <textarea class="form-control" id="observacionPedido" name="observacion" rows="3">${observacion}</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer
                    ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarObservacion">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    `;

            $('body').append(modalHtml);

            $('#editarObservacionModal').modal('show');

            $('#editarObservacionModal').on('hidden.bs.modal', function () {
                $(this).remove();
            });

            $("#guardarObservacion").click(function() {
                const nuevaObservacion = $("#observacionPedido").val();
                $.ajax({
                    url: '/admin/controlador/pedidos/update',
                    method: 'POST',
                    data: {
                        url_pedido: url_pedido,
                        observacion: nuevaObservacion,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    }
                }).done(function(response) {
                    $('#editarObservacionModal').modal('hide');
                    location.reload();
                }).fail(function(response) {
                    tmpl.notificacionError('Error al cambiar la observación del pedido');
                });
            });
    }


    $('.a-cambiar-vista').click(function(e) {
        e.preventDefault(); // Evita la acción por defecto

        // Obtener la vista seleccionada
        var vista = $(this).data('vista');

        if (vista === 'tarjeta') {
            $('#carrito').show(); // Mostrar vista en tarjeta
            $('#carrito-tabla').hide(); // Ocultar vista en tabla
        } else if (vista === 'tabla') {
            $('#carrito').hide(); // Ocultar vista en tarjeta
            $('#carrito-tabla').show(); // Mostrar vista en tabla
        }
    });

})
