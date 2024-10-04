$(function(){

    $(".button_ver_carrito").click(function(){
        var id = $(this).data("id")
        $.ajax({
            url: "/usuario/pedido/ver-carrito",
            type: "POST",
            data: {id: id},
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){
            let items = response.carrito;

            let modalBodyHtml = '<div class="row">';
            items.forEach(function(item) {
                modalBodyHtml += `
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card shadow-sm border-light rounded">
                        <img src="${item.imagen}" class="card-img-top" alt="${item.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${item.nombre}</h5>
                            <p class="card-text">
                                <strong>SKU:</strong> <span>${item.sku}</span><br>
                                <strong>Color:</strong> <span class="badge bg-primary text-white">${item.color}</span><br>
                                <strong>Talla:</strong> <span class="badge bg-info text-dark">${item.talla}</span><br>
                                <strong>Cantidad:</strong> <span class="fw-bold">${item.cantidad}</span><br>
                                <strong>Precio:</strong> <span class="text-success fw-bold">${item.precio_venta_con_simbolo}</span><br>
                                <strong>Descuento:</strong> <span class="nsb-text-primary fw-bold">${item.descuento_con_simbolo} (${item.precio_original_con_simbolo})</span>
                            </p>
                        </div>
                    </div>
                </div>
            `;
            });
            modalBodyHtml += '</div>';

            let modalHtml = `
            <div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="carritoModalLabel">Carrito de Pedido #${id}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ${modalBodyHtml}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
            $('body').append(modalHtml);

            $('#carritoModal').modal('show');

            $('#carritoModal').on('hidden.bs.modal', function () {
                $(this).remove();
            });

        }).fail(function(response){
            tmpl.notificacionError(response.responseJSON.mensaje)
        })
    })
})
