const tmpl = {
    //TODO implementar plantillas generales para cualquier elemento
    select2 : (selector,placeholder="Seleccione una opción",noResults="No hay resultados") => {
        $(selector).select2({
            width: '100%',
            placeholder: placeholder,
            language: {
                noResults: function(){
                    return noResults;
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    },
    confirmarEliminarRegistro: async () => {
        const result = await Swal.fire({
            title: '¿Estás seguro de eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });
        return result.isConfirmed;
    },
    confirmarActivarRegistro: async () => {
        const result = await Swal.fire({
            title: '¿Estás seguro de activar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        });
        return result.isConfirmed;
    },
    notificacion: (mensaje,icono='success') => {
        $.notify(mensaje, icono);
    },
    notificacionError: (mensaje="Error") => {
        $.notify(mensaje, 'error');
    },

    confirmarProceso: async (mensaje,icono='warning') => {
        const result = await Swal.fire({
            title: mensaje,
            icon: icono,
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        });
        return result.isConfirmed;
    },

    mostrarObservacion: (observacion) => {
        Swal.fire({
            title: 'Observación',
            text: observacion,
            icon: 'info',
            confirmButtonText: 'Aceptar'
        });
    },
    getMunicipios: (selectDepartamento, selectMunicipio) => {
        const id = selectDepartamento.val();

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
    },

}
