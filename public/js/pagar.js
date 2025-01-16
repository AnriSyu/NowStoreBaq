
$(function(){
    tmpl.select2("#select_departamento","Seleccione un departamento");
    tmpl.select2("#select_municipio","Seleccione un municipio","Seleccione un departamento primero");

    const selectDepartamento = $("#select_departamento")
    const selectMunicipio = $("#select_municipio")

    $("#alerta_error").hide();

    selectDepartamento.change(function(){

        const id = $(this).val();

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/controlador/municipios/getByIdDepartamento",
            data: {
                idDepartamento:id
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){
            let html = "";

            html += `<option value="">Seleccione un municipio</option>`;

            response.data.forEach(municipio => {
                html += `<option value="${municipio.id}">${municipio.municipio}</option>`;
            });

            const idMunicipio = selectMunicipio.data("municipio-seleccionado");

            selectMunicipio.html(html).select2();

            if(idMunicipio){
                selectMunicipio.val(idMunicipio).trigger("change");
            }

        }).fail(function(response){

            if(response.status === 401) {
                alert("error al cargar municipios")
            }

        });
    })


    if(selectDepartamento.val() !== ""){
        selectDepartamento.trigger("change");
    }

    $("#button_guardar").click(function(e){

        e.preventDefault();

        const form = new FormData($("#form_guardar_datos_persona")[0]);

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/carrito/guardar-persona",
            data: form,
            processData: false,
            contentType: false,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){

            $.notify(response.mensaje, "success");

            $("#button_pagar").removeAttr("disabled");

            $("#alerta_datos_incompletos").hide();

        }).fail(function(response){
            const errors = response.responseJSON.errors;

            document.querySelectorAll('.nsb-error').forEach(span => span.innerText = '');

            Object.keys(errors).forEach((inputId) => {

                const errorSpan = $(`#span_${inputId}_error`);

                const input = $(`#${inputId}`);

                if (errorSpan) {
                    errorSpan.text(errors[inputId][0]);

                    input.focus();

                    input.addClass('nsb-input-error');
                }

                input.on('input', () => {
                    errorSpan.text('');

                    input.removeClass('nsb-input-error');
                });


            });

        });
    })

    $("#button_pagar").click(function(e){
        e.preventDefault();

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/carrito/pagar",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){

            $.notify(response.mensaje, "success");

            $("#alerta_error").hide();

            const wamenumber = response.wamenumber;

            const idPedido = response.idPedido;

            //localStorage.removeItem("carrito");

            window.open(`https://wa.me/${wamenumber}?text=Hola, he realizado un pedido con el id ${idPedido}`);

            window.location.href = "/carrito";



        }).fail(function(response){

            let mensajeError = response.responseJSON.mensaje;

            mensajeError += "<p>"+response.responseJSON.detalle+"</p>";

            $("#alerta_error").show().html(mensajeError)

        });
    })



    function handleInput(event, maxLength) {
        const input = event.target;

        const value = input.value.replace(/\D/g, '');

        if (value.length > maxLength) {
            input.value = value.slice(0, maxLength);
        } else {
            input.value = value;
        }

    }

    $("#input_celular").on('input', (event) => handleInput(event, 10));

    $("#input_codigo_postal").on('input', (event) => handleInput(event, 6));




})
