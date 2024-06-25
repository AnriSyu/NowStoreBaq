const cambiarCantidad = cantidad => {
    const inputCantidad = $("#input_cantidad")
    let cantidadActual = parseInt(inputCantidad.val());
    cantidadActual += cantidad;
    if (cantidadActual < 1) cantidadActual = 1;
    inputCantidad.val(cantidadActual);
}
$(function() {
    $(".alert_mensaje_advertencia").hide();
    $('#button_descripcion').click(function () {
        $('#div_articulo_descripcion').toggleClass('show');
    });
    $("#button_tienda").click(function () {
        $("#div_articulo_tienda").toggleClass('show');
    })
    $("#icon_copiar_sku").click(function () {
        const sku = $("#small_articulo_sku").text();
        navigator.clipboard.writeText(sku)
            .then(function () {
                $.notify("SKU copiado al portapapeles", "success");
            })
            .catch(function (err) {
                console.error('Error al intentar copiar al portapapeles: ', err);
                $.notify("Error al intentar copiar al portapapeles", "error");
            });
    })

    $(".img_articulo_imagen_miniatura").on("mouseover", function (e) {
        const srcImage = $(this).attr('src');
        $("#img_principal").attr('src', srcImage);
    })

    $(".div_color_swatch").click(function () {

        $(".div_color_swatch").removeClass("nsb-color-swatch-focus");

        $(this).addClass("nsb-color-swatch-focus");

        const code = $(this).data("code");
        const articulo = JSON.parse(atob(code))

        document.title = "NowStoreBaq - " + articulo.articulo_nombre;

        $("#h1_articulo_titulo").text(articulo.articulo_nombre);

        $("#img_principal").attr('src', articulo.articulo_imagen);

        $("#small_articulo_sku").text(articulo.articulo_sku);

        $("#span_precio_actual").text(articulo.articulo_precio_venta);

        const spanPrecioOriginal = $("#span_precio_original");

        if (spanPrecioOriginal.length) {
            spanPrecioOriginal.text(articulo.articulo_precio_original);
        }

        const spanDescuento = $("#span_descuento");
        if (spanDescuento.length) {
            spanDescuento.text(articulo.articulo_descuento);
        }

        $("#span_articulo_color").text(articulo.color_titulo);

        const tableDescripcion = $("#table_descripcion");
        tableDescripcion.html('');
        let html = '';
        articulo.articulo_descripcion.forEach(function (valor, indice) {
            // html += `<li><strong>${valor.indice}</strong>${valor.valor}</li>`;
            html += `<tr><th>${valor['indice']}</th><td>${valor['valor']}</td></tr>`;
        });
        tableDescripcion.html(html);

        $(".alert_mensaje_advertencia").show();

    })

    $('.nsb-btn-talla').on('click', function() {
        $("#error_seleccionar_talla").html('');
        $('.nsb-btn-talla').removeClass('nsb-selected');
        $(this).addClass('nsb-selected');
    });

    $("#button_agregar_bolsa").click(function(){
        const nsbBtnTalla = $('.nsb-btn-talla.nsb-selected');
        if (nsbBtnTalla.length === 0) {
            $("#error_seleccionar_talla").text("Por favor, selecciona una talla")
            return;
        }

        let carrito = localStorage.getItem('carrito');
        carrito  = carrito ? JSON.parse(carrito) : [];

        const spanPrecioActual = $("#span_precio_actual");

        const articulo = {
            nombre: $("#h1_articulo_titulo").text(),
            sku: $("#small_articulo_sku").text(),
            precio_venta_con_simbolo: spanPrecioActual.text(),
            color: $("#span_articulo_color").text(),
            talla: nsbBtnTalla.data('talla'),
            cantidad: parseInt($("#input_cantidad").val()),
            imagen:$("#img_principal").attr('src')
        }

        articulo.precio_original_con_simbolo = "0";
        const spanPrecioOriginal = $("#span_precio_original");
        if(spanPrecioOriginal.length > 0){
            articulo.precio_original_con_simbolo = spanPrecioOriginal.text();
        }

        articulo.descuento_con_simbolo = "0";
        const spanDescuento = $("#span_descuento");
        if(spanDescuento.length > 0){
            articulo.descuento_con_simbolo = spanDescuento.text();
        }

        articulo.precio_venta = parseFloat(articulo.precio_venta_con_simbolo.replace(/[$.]/g, ''));

        if(articulo.precio_original_con_simbolo !== "0" && articulo.descuento_con_simbolo !== "0") {
            articulo.precio_original = parseFloat(articulo.precio_original_con_simbolo.replace(/[$.]/g, ''));
            articulo.descuento = articulo.descuento_con_simbolo.replace(/[-%]/g, '');
        }

        let articuloExistente = carrito.find(item => item.sku === articulo.sku && item.talla === articulo.talla && item.color === articulo.color);

        if (articuloExistente) {
            articuloExistente.cantidad += articulo.cantidad;
        } else {
            carrito.push(articulo);
        }

        localStorage.setItem('carrito',JSON.stringify(carrito))

        let cantidad_total = 0;

        carrito.forEach(item => {
            cantidad_total += item.cantidad;
        });

        $("#span_cantidad_articulos_carrito_navbar").text(cantidad_total)

        $.notify("Artículo añadido", "success");

    })

})
