;(function(){
    var elementClick = document.getElementById("rc-anchor-content");
    elementClick.addEventListener("click", function(){
        document.getElementById("recaptcha-checkbox-border").style.display = "none";
        document.getElementById("recaptcha-checkbox-gif").setAttribute("src", "http://localhost/tablero2/assets/img/captcha/nocaptchaMini.gif");
    });
})();

