
var expr = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
var expr1 = /^[a-zA-Z]*$/;


$(document).ready(function () {
    $("#guardar").click(function () {
        var matricula = $("#matricula").val();
        var email = $("#email").val();
        var correo = $("#correo").val();
        var pass = $("#pass").val();
        var repass = $("#repass").val();
        var delegacion = $("#repass").val();
        var primer = $("#primer").val();
        var segundo = $("#segundo").val();
        var tercer = $("#tercer").val();

        if (correo == "" || !expr.test(correo)) {
            $("#mensaje3").fadeIn("slow");
            return false;
        } else {
            $("#mensaje3").fadeOut();

            if (passw != repass) {
                $("#mensaje4").fadeIn("slow");
                return false;
            }
        }
    })
});


$("#email").keyup(function () {
    if ($(this).val() != "" && expr.test($(this).val())) {
        $("#mensaje3").fadeOut();
        return false;
    }
});

var valido = false;
$("#repass").keyup(function (e) {
    var pass = $("#pass").val();
    var re_pass = $("#repass").val();

    if (pass != re_pass)
    {
        $("#repass").css({"background": "#F22"});
        valido = true;
    } else if (pass == re_pass)
    {
        $("#repass").css({"background": "#8F8"});
        $("#mensaje4").fadeOut();
        valido = true;
    }
});
