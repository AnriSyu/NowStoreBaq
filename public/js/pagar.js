
$(function(){
    tmpl.select2("#select_departamento","Seleccione un departamento");
    tmpl.select2("#select_municipio","Seleccione un municipio","Seleccione un departamento primero");
    $("#select_departamento").change(function(){
        const id = $(this).val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/controlador/municipios/get",
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
            $("#select_municipio").html(html).select2();
        }).fail(function(response){
            if(response.status === 401) {
                alert("error al cargar municipios")
            }
        });
    })

})
