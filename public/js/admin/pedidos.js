$(function(){
    const divAlertaError = $("#div_alerta_error");
    divAlertaError.hide();

    function formatCurrency(value) {
        return new Intl.NumberFormat('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
    }

    function formatDate(dateStr) {
        if (!dateStr) return 'Sin fecha';
        const date = new Date(dateStr);
        return date.toISOString().split('T')[0]; // Formato 'Y-m-d'
    }

    $("#form_filtro_pedido").submit(function(e){
        e.preventDefault()
        const data = $(this).serialize()
        $.ajax({
            type: "GET",
            url: "/admin/controlador/pedidos/get",
            data: data,
        }).done(function(response){
            const data = response.data;
            $("#tbody_pedidos").html('');
            if(data.length === 0){
                divAlertaError.show();
                $("#span_mensaje_error").text('No se encontraron pedidos con los filtros seleccionados');
                return;
            }else {
                divAlertaError.hide();
                data.forEach(pedido => {
                    $("#tbody_pedidos").append(`
                    <tr>
                        <td>${pedido.id}</td>
                        <td>${formatDate(pedido.fecha_ingreso)}</td>
                        <td>${formatDate(pedido.fecha_entrega)}</td>
                        <td>${pedido.usuario.persona.nombres} ${pedido.usuario.persona.apellidos}</td>
                        <td>${pedido.estado_pedido}</td>
                        <td>${pedido.observacion ?? 'Sin observación'}</td>
                        <td class="text-end">$${formatCurrency(parseFloat(pedido.total))}</td>
                        <td class="text-end">$${formatCurrency(parseFloat(pedido.descuento))}</td>
                        <td>
                            <a href="/admin/pedido/${pedido.url_pedido}" class="btn btn-sm btn-info" title="Ver detalles del pedido">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-warning button_cambiar_estado" title="Cambiar estado" data-id="${pedido.url_pedido}">
                                <i class="fas fa-exchange-alt"></i>
                            </button>

                            <!--<button class="btn btn-sm btn-danger button_eliminar_registro" title="Eliminar pedido" data-id="${pedido.url_pedido}">
                               <i class="fas fa-trash"></i>
                             </button>-->
                        </td>
                    </tr>
                `)
                });
            }

        }).fail(function (response) {
            divAlertaError.show();
            $("#span_mensaje_error").text(response.responseJSON.message);
        })
    });

    $(document).on('click', ".button_cambiar_estado", function(){
        cambiarEstado($(this));
    });

    $(".button_cambiar_estado").click(function () {
        cambiarEstado($(this));
    });

    $(document).on('click', ".button_eliminar_registro", function(){
        eliminarRegistro($(this));
    });

    $(".button_eliminar_registro").click(function () {
        eliminarRegistro($(this));
    });

    $(document).on('click', ".button_activar_registro", function(){
        activarRegistro($(this));
    });

    $(".button_activar_registro").click(function () {
        activarRegistro($(this));
    });

    async function eliminarRegistro(selector) {
        const id = selector.data('id');
        const respuesta = await tmpl.confirmarEliminarRegistro();
        if (respuesta) {
            $.ajax({
                url: '/admin/controlador/pedidos/soft-delete',
                method: 'POST',
                data: {
                    url_pedido: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (response) {
                $('#form_filtro_pedido').submit();
                tmpl.notificacion('Pedido eliminado correctamente');
            }).fail(function (response) {
                alert('Error al eliminar el pedido');
            });
        }
    }

    async function activarRegistro(selector) {
        const id = selector.data('id');
        const respuesta = await tmpl.confirmarActivarRegistro();
        if (respuesta) {
            $.ajax({
                url: '/admin/controlador/pedidos/restore',
                method: 'POST',
                data: {
                    url_pedido: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (response) {
                $('#form_filtro_pedido').submit();
                tmpl.notificacion('Pedido activado correctamente');
            }).fail(function (response) {
                alert('Error al activar el pedido');
            });
        }
    }

    function cambiarEstado(selector) {
        const id = selector.data('id');
        let modalHtml = `
        <div class="modal fade" id="cambiarEstadoModal" tabindex="-1" aria-labelledby="cambiarEstadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarEstadoModalLabel">Cambiar estado del pedido #${id}</h5>
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

        // Limpiar el modal del DOM cuando se cierra
        $('#cambiarEstadoModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });

        $("#guardarEstado").click(function() {
            const nuevoEstado = $("#estadoPedido").val();
            $.ajax({
                url: '/admin/controlador/pedidos/update',
                method: 'POST',
                data: {
                    url_pedido: id,
                    estado_pedido: nuevoEstado,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                }
            }).done(function(response) {
                $('#cambiarEstadoModal').modal('hide');
                $('#form_filtro_pedido').submit();
            }).fail(function(response) {
                alert('Error al cambiar el estado del pedido');
            });
        });
    }



})
