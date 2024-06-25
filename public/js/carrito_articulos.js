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
        recalcularTotales();
    });
    $(document).on("click",".check_articulo",function(){
        let allChecked = $('.check_articulo:checked').length === $('.check_articulo').length;
        $('#checkbox_todo').prop('checked', allChecked);
        recalcularTotales();
    });
    $(document).on("keyup",".input_selector_cantidad",function(){
        let index = $(this).data('index');
        index = parseInt(index);
        actualizarCantidad(index);
    });

    $("#button_pagar").click(function(){
        const articulos_pagar = carrito.filter((item, index) => $("#checkbox" + index).is(":checked"));
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
    let cantidadArticulosPagar = 0;
    carrito.forEach((item,index) => {
        if ($("#checkbox" + index).is(":checked")) {
            resumenPrecio += (item.precio_venta * item.cantidad);
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
    $("#span_cantidad_articulos_pagar,#span_cantidad_articulos").text("("+cantidadArticulosPagar+")");
    $("#span_resumen_precio").text(resumenPrecioF);
    $("#p_resumen_descuento").text("Descuento: " +resumenDescuentoF);
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
function pintarHtml(){
    let cantidadTotal = 0;

    let resumenPrecio = 0;

    let resumenDescuento = 0;

    let html='';
    carrito.forEach((item,index) => {
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
    if(item.precio_original_con_simbolo === "0") {
        html += `                        <span class="nsb-articulo-precio-normal" id="span_precio_actual">${item.precio_venta_con_simbolo}</span>`;
    }else{
        html += `                        <span class="nsb-articulo-precio-descuento" id="span_precio_actual">${item.precio_venta_con_simbolo}</span>`;
    }
    if(item.descuento_con_simbolo !== "0") {
        html +=`                        <del class="nsb-articulo-precio-borrado" id="span_precio_original">${item.precio_original_con_simbolo}</del>
                                        <span class="nsb-articulo-descuento" id="span_descuento">${item.descuento_con_simbolo}</span>`
    }
    html+= `                </div>

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
        resumenPrecio += (item.precio_venta * item.cantidad);
        if (item.descuento !== undefined && item.descuento !== "0") {
            let descuentoDinero = (item.precio_original * item.descuento / 100) * item.cantidad;
            resumenDescuento += descuentoDinero;
        }

    });
    $("#cardbody_lista_articulos").html(html);
    resumenDescuento = Math.round(resumenDescuento * 100) / 100;

    let resumenPrecioF = formatearPrecio(resumenPrecio);
    let resumenDescuentoF = formatearPrecio(resumenDescuento);


    $("#span_cantidad_articulos").text("("+cantidadTotal+")");
    $("#span_cantidad_articulos_carrito_navbar").text(cantidadTotal);
    $("#span_resumen_precio").text(resumenPrecioF);
    $("#p_resumen_descuento").text("Descuento: " +resumenDescuentoF);

}

function pintarHtmlBolsaVacia() {
    let html='<div class="text-center my-5"><i class="fas fa-shopping-cart fa-7x mb-5 text-black"></i> <h3 class="fw-bolder text-black">TU BOLSA ESTÁ VACÍA</h3> </div>';
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
