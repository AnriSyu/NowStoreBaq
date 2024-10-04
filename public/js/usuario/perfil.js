$(function() {
    tmpl.select2("#select_departamento", "Seleccione un departamento");
    tmpl.select2("#select_municipio", "Seleccione un municipio", "Seleccione un departamento primero");

    const selectDepartamento = $("#select_departamento");
    const selectMunicipio = $("#select_municipio");


    selectDepartamento.change(function(){
        tmpl.getMunicipios(selectDepartamento, selectMunicipio);
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
            url:"/controlador/persona/save",
            data: form,
            processData: false,
            contentType: false,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){

            $.notify(response.mensaje, "success");

            $("#alerta_datos_incompletos").hide();

        }).fail(function(response){
            const errors = response.responseJSON.errors;

            if(response.status === 419){
                $.notify("Su sesión ha expirado, por favor recargue la página", "error");
                return;
            }

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

});
