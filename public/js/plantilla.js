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
    }
}
