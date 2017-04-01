function cerrar_sesion_ficha(site_url) {
    $.ajax({
        url: site_url + "/sesion/cerrar_sesion"

        , method: "post"
        , success: function (response) {
            window.location.assign(site_url);
        }
        , error: function () {
            console.warn("No se pudo realizar la conexión");
        }
    });
}
