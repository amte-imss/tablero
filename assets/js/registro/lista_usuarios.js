function set_status_usuario(id_usuario){
    var status = document.getElementById('usuario_chbox_' +id_usuario).checked;
    $.ajax({
        url: site_url + "/registro/set_status/" + id_usuario 
        , method: "post"
        , data: {status:status}
        , success: function (response) {
            
        }
        , error: function () {
            console.warn("No se pudo realizar la conexión");
        }
    });
}

function paginar_usuarios(num_page) {
    if ($.isNumeric(num_page)) {
        document.getElementById('usuarios_current_page').value = num_page;
        $('#form_usuarios').submit();
    }
}