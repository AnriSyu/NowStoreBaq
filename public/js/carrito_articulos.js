let carrito = localStorage.getItem('carrito');
carrito  = carrito ? JSON.parse(carrito) : [];
$(function () {


    if (carrito.length === 0) {
        $("#button_pagar").attr("disabled", true);
        $("#checkbox_todo").attr("disabled", true).removeAttr("checked");
    }

    if (carrito.length > 0) {
        pintarHtml();
    } else{
        pintarHtmlBolsaVacia();
    }



    $(document).on("click",".icon_borrar_articulo",function(){
        const index = $(this).data('index');
        carrito.splice(index, 1);
        $(`#articulo${index}`).remove();
        localStorage.setItem('carrito',JSON.stringify(carrito));
        carrito = localStorage.getItem("carrito");
        actualizarIndices();
        recalcularTotales();
        if(carrito.length===0){
            pintarHtmlBolsaVacia();
        }
    });
    $("#checkbox_todo").click(function(){
        let isChecked = $(this).is(':checked');
        $('.check_articulo').prop('checked', isChecked);
        $("#button_pagar").attr("disabled", !isChecked);
        recalcularTotales();
    });
    $(document).on("click",".check_articulo",function(){
        let allChecked = $('.check_articulo:checked').length === $('.check_articulo').length;
        $('#checkbox_todo').prop('checked', allChecked);
        $("#button_pagar").attr("disabled", $('.check_articulo:checked').length === 0);
        recalcularTotales();
    });
    $(document).on("keyup",".input_selector_cantidad",function(){
        let index = $(this).data('index');
        index = parseInt(index);
        actualizarCantidad(index);
    });

    $("#button_pagar").click(function(){
        const articulos_pagar = carrito.filter((item, index) => $("#checkbox" + index).is(":checked"));
        localStorage.setItem("articulos_pagar",JSON.stringify(articulos_pagar));
        //acc es el articulo completo el json
        //item es el valor de la propiedad
        let total = 0;
        let descuento = 0;
        let resumenPrecio = 0;
        let precioMitadTotal = 0;
        const montoRecargo = 5000;
        articulos_pagar.forEach((acc, item) => {
            let precioFinal = acc.precio_venta;
            let precioMitad = 0;

            if ($("#btn50_50_" + item).hasClass("btn-5050-activo") || acc.precio_venta <= 20000) {
                precioFinal += montoRecargo;
                precioMitad = precioFinal / 2;
            } else {
                precioMitad = acc.precio_venta;
            }

            total += acc.precio_venta * acc.cantidad;
            precioMitadTotal += precioMitad * acc.cantidad;

            if (acc.descuento !== undefined && acc.descuento !== "0") {
                let descuentoDinero = (acc.precio_original * acc.descuento / 100) * acc.cantidad;
                descuento += descuentoDinero;
            }

            resumenPrecio += acc.precio_venta * acc.cantidad;
        });

        localStorage.setItem("precioMitadTotal", precioMitadTotal);
        localStorage.setItem("total", total);
        localStorage.setItem("descuento", descuento);

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/genpedido",
            data: {
                articulos_pagar:JSON.stringify(articulos_pagar),
                total:total,
                descuento:descuento,
                precioMitadTotal: precioMitadTotal,
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){
            window.location.href = response.url_redirect;
        }).fail(function(response){
            if(response.status === 401) {
                window.location.href = response.responseJSON.url_redirect;
            }
        });
    })

})

function formatearPrecio(precio){
    let formatter = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP'
    });
    return formatter.format(precio)
}

function cambiarCantidad(cantidad,index) {
    const inputCantidad = $("#input_cantidad"+index)
    let cantidadActual = parseInt(inputCantidad.val());
    cantidadActual += cantidad;
    if (cantidadActual < 1) cantidadActual = 1;
    inputCantidad.val(cantidadActual);
    if ($("#checkbox" + index).is(":checked")) {
        actualizarCarrito(index, cantidadActual);
    }
}

function actualizarCarrito(index, cantidadActual) {
    carrito[index].cantidad = cantidadActual;
    recalcularTotales();
}
function recalcularTotales() {
    let resumenPrecio = 0;
    let resumenDescuento = 0;
    let precioMitadTotal = 0;
    let cantidadArticulosPagar = 0;
    const montoRecargo = 5000;
    carrito.forEach((item, index) => {
        let checkboxActivo = $("#checkbox" + index).is(":checked");
        let btn5050Activo = $("#btn50_50_" + index).hasClass("btn-5050-activo");

        if (checkboxActivo) {
            let precioFinal = item.precio_venta;
            let precioMitad = 0;

            if (btn5050Activo || item.precio_venta <= 20000) {
                precioFinal += montoRecargo;
                precioMitad = precioFinal / 2;
            } else {
                precioMitad = item.precio_venta;
            }

            resumenPrecio += item.precio_venta * item.cantidad;

            precioMitadTotal += precioMitad * item.cantidad;

            if (item.descuento !== undefined && item.descuento !== "0") {
                let descuentoDinero = (item.precio_original * item.descuento / 100) * item.cantidad;
                resumenDescuento += descuentoDinero;
            }

            cantidadArticulosPagar += item.cantidad;
        }
    });

    resumenDescuento = Math.round(resumenDescuento * 100) / 100;
    let resumenPrecioF = formatearPrecio(resumenPrecio);
    let resumenDescuentoF = formatearPrecio(resumenDescuento);
    let precioMitadF = formatearPrecio(precioMitadTotal);

    $("#span_cantidad_articulos_pagar, #span_cantidad_articulos").text("(" + cantidadArticulosPagar + ")");
    $("#span_resumen_precio").text(resumenPrecioF);
    $("#span_precio_mitad").text("Total con mitad: " + precioMitadF);
    $("#p_resumen_descuento").text("Descuento: " + resumenDescuentoF);
}
function actualizarCantidad(index) {
    const inputCantidad = $("#input_cantidad" + index);
    let cantidadActual = parseInt(inputCantidad.val());
    if (isNaN(cantidadActual) || cantidadActual < 1) cantidadActual = 1;
    inputCantidad.val(cantidadActual);

    if ($("#checkbox" + index).is(":checked")) {
        actualizarCarrito(index, cantidadActual);
    }
}
function pintarHtml() {
    let cantidadTotal = 0;

    let resumenPrecio = 0;

    const montoRecargo = 5000;

    let resumenDescuento = 0;

    let precioMitadTotal = 0;

    let html = '';


    carrito.forEach((item, index) => {
        let precioFinal = item.precio_venta;
        let precioMitad = 0;

        if (item.precio_venta <= 20000) {
            precioFinal += montoRecargo;
            precioMitad = precioFinal / 2;
        } else {
            precioMitad = item.precio_venta;
        }

        if (item.precio_venta <= 20000) {
            resumenPrecio += item.precio_venta * item.cantidad;
        } else {
            resumenPrecio += item.precio_venta * item.cantidad;
        }

        precioMitadTotal += precioMitad * item.cantidad;
        html += `<div class="row align-items-center g-0 mb-3 articulo " id="articulo${index}">
            <div class="col-1 text-center">
                <div class="checkbox-wrapper-19">
                    <input class="check_articulo" type="checkbox" id="checkbox${index}" checked />
                    <label for="checkbox${index}" class="check-box"></label>
                </div>
            </div>
            <div class="col-2 text-center ">
                <img src="${item.imagen}" class="img-fluid" alt="img" title="${item.nombre}" style="width: 170px;height: 120px">
            </div>
            <div class="col  ms-4">
                <div class="row align-items-center">
                    <div class="col">
                        <p>${item.nombre}</p>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col d-flex">
                        <span class="me-4"><strong>Color: </strong> ${item.color}</span>
                        <span><strong>Talla: </strong> ${item.talla}</span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">`;
        if (item.precio_original_con_simbolo === "0") {
            html += `                        <span class="nsb-articulo-precio-normal" id="span_precio_actual">${item.precio_venta_con_simbolo}</span>`;
        } else {
            html += `                        <span class="nsb-articulo-precio-descuento" id="span_precio_actual">${item.precio_venta_con_simbolo}</span>`;
        }
        if (item.descuento_con_simbolo !== "-0%") {
            html += `                        <del class="nsb-articulo-precio-borrado" id="span_precio_original">${item.precio_original_con_simbolo}</del>
                                        <span class="nsb-articulo-descuento" id="span_descuento">${item.descuento_con_simbolo}</span>`
        }
        html += `                        `;
        if (item.precio_venta <= 20000) {
            html += `<span class="nsb-articulo-recargo ms-2" id="span_recargo${index}">+$5.000</span>
            <span class="nsb-articulo-precio-mitad" id="span_precio_mitad${index}">(${formatearPrecio(precioMitad)})</span>`
        } else {
            html += `<span class="nsb-articulo-recargo" id="span_recargo${index}" style="display: none">+ $5.000</span>
            <span class="nsb-articulo-precio-mitad" id="span_precio_mitad${index}" style="display: none"></span>
                 `
        }
        html += `</div>`;
        if (item.precio_venta > 20000) {
            html += `<button class="btn btn-sm me-4 btn-5050-desactivado btn-5050" id="btn50_50_${index}" data-id="${index}"">50/50</button>`
        }
        html += `
                            <div class="flex-row-reverse ">
                                <button type="button" class="btn btn-light btn-sm" onclick="cambiarCantidad(-1,${index})">-</button>
                                <input type="text" class="nsb-selector-cantidad input_selector_cantidad" id="input_cantidad${index}" data-index="${index}" value="${item.cantidad}">
                                <button type="button" class="btn btn-light btn-sm" onclick="cambiarCantidad(1,${index})">+</button>
                            </div>

                            <button class="fas fa-trash-can ms-4 icon_borrar_articulo" id="icon_borrar_articulo" data-index="${index}"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        cantidadTotal += item.cantidad;



        if (item.descuento !== undefined && item.descuento !== "0") {
            let descuentoDinero = (item.precio_original * item.descuento / 100) * item.cantidad;
            resumenDescuento += descuentoDinero;
        }

    });
    $("#cardbody_lista_articulos").html(html);
    resumenDescuento = Math.round(resumenDescuento * 100) / 100;

    let resumenPrecioF = formatearPrecio(resumenPrecio);
    let resumenDescuentoF = formatearPrecio(resumenDescuento);
    let precioMitadF = formatearPrecio(precioMitadTotal);


    $("#span_cantidad_articulos").text("(" + cantidadTotal + ")");
    $("#span_cantidad_articulos_carrito_navbar").text(cantidadTotal);
    $("#span_resumen_precio").text(resumenPrecioF);
    $("#span_precio_mitad").text("Total con mitad: " + precioMitadF);
    $("#p_resumen_descuento").text("Descuento: " + resumenDescuentoF);

}

function pintarHtmlBolsaVacia() {
    let html = '<div class="text-center my-5"><i class="fas fa-shopping-cart fa-7x mb-5 text-black"></i> <h3 class="fw-bolder text-black">TU BOLSA ESTÁ VACÍA</h3> </div>';
    $("#cardbody_lista_articulos").html(html);
}


function actualizarIndices() {
    $("#carrito .articulo").each(function(i) {
        $(this).attr("id", "articulo" + i);
        $(this).find(".check_articulo").attr("id", "checkbox" + i).data("index", i);
        $(this).find("label[for^='checkbox']").attr("for", "checkbox" + i);
        $(this).find(".input_selector_cantidad").attr("id", "input_cantidad" + i);
        $(this).find(".btn-light").attr("onclick", `cambiarCantidad(-1, ${i}), cambiarCantidad(1, ${i})`);
        $(this).find(".icon_borrar_articulo").data("index", i);
    });
}

$(document).on("click", ".btn-5050", function(){
    let index = $(this).data('id');
    toggleFiftyFifty(index);

});
function toggleFiftyFifty(index){
    let articulo = carrito[index];
    let precioMitad = (articulo.precio_venta + 5000) / 2;
    let precioMitadF = formatearPrecio(precioMitad);
    let recargo = $("#span_recargo" + index);
    let precioMitadElement = $("#span_precio_mitad" + index);
    let btn5050 = $("#btn50_50_" + index);

    if(btn5050.hasClass("btn-5050-desactivado")){
        btn5050.removeClass("btn-5050-desactivado");
        btn5050.addClass("btn-5050-activo");
        recargo.show();
        precioMitadElement.show();
        precioMitadElement.text(`(${precioMitadF})`);
        btn5050.notify("50/50 activado", {position: "top", className: "success"});

    }else{
        btn5050.removeClass("btn-5050-activo");
        btn5050.addClass("btn-5050-desactivado");
        recargo.hide();
        precioMitadElement.hide();
        btn5050.notify("50/50 desactivado", {position: "top", className: "error"});
    }

    recalcularTotales();
}
