$(function(){

    const validarCorreo = correo => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(correo);

    }

    $(document).on("keyup",function(e){
        if(e.which === 13) {
            e.preventDefault();
            $("#button_continuar").click();
        }
    })

    $("#form_rginsc").on("submit",function(e){
        e.preventDefault();
        let correo = $('#input_correo').val().trim()
        let clave = $('#input_clave').val().trim()
        const spanError = $("#span_error")

        if(correo === "" || clave === "") {
            spanError.text("Todos los campos son obligatorios")
            return
        }

        if (!validarCorreo(correo)) {
            spanError.text('Por favor, ingrese un correo electrónico válido.')
            return
        }

        correo = $('<div>').text(correo).html();
        clave = $('<div>').text(clave).html();

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/rginsc",
            data:{
                correo:correo,
                clave:clave
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response){
            $('#span_error').html("");

            if(response.tipo === 'login') {
                if(response.es_administrador) {
                    window.location.href = response.redireccion
                }

                if (window.location.search.includes('?frompage=carrito')) {
                    window.location.href = "/pagar?frompage=login";
                }else{
                    window.location.href = "/usuario/perfil";
                }
            }

        }).fail(function(response){
            const spanError = $('#span_error');
            spanError.empty();
            if(response.status === 422) {
                const errors = response.responseJSON.mensaje;
                $.each(errors, function(key, value) {
                    spanError.append('<p>' + value[0] + '</p>');
                    console.log(value[0]);
                });
            } else if(response.status === 401) {
                spanError.append('<p>' + response.responseJSON.mensaje + '</p>');
            }
        })

    })

    $("#input_correo").on("keyup",function(){

        $("#span_error").text("")

    }).on("change",function(){

        const correo = $(this).val()

        if (!validarCorreo(correo)) {
            $('#input_correo').addClass('nsb-is-invalid')
            $("#span_error").text('Por favor, ingrese un correo electrónico válido.')
            return;
        } else {
            $('#input_correo').removeClass('nsb-is-invalid')
        }
    })

    $("#span_ver_clave").on("click",function(){
        const inputClave = $('#input_clave');

        if (inputClave.attr('type') === 'password') {
            inputClave.attr('type', 'text');
        } else {
            inputClave.attr('type', 'password');
        }
    })

})
