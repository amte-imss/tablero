<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/third-party/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/css/styles_tablero_control.css" rel="stylesheet" type="text/css"/>
        <?php echo css("style_sesion.css"); ?>
        <?php echo css("securimage.css"); ?>
        <?php echo js("jquery/jquery-2.min.js"); ?>
        <?php // echo base_url() . 'assets/img/loading.gif'; ?>
        <script type="text/javascript">
            var img_url_loader = "<?php echo img_url_loader('loading.gif'); ?>";
            var site_url = "<?php echo site_url(); ?>";
        </script>
        <?php echo js("general.js"); ?>
    </head>

    <body>
        <header>
            <div class="logos">
                <img src="<?php echo base_url(); ?>assets/img/header/logos3.png" alt="">
            </div>
            <div class="titulo">
                <h1 class="titulo-header">Tablero de control y seguimiento para la educación continua, presencial y a distancia</h1>
            </div>
        </header>
        <br><br><br>
        <div class="login-wrap" >
            <div class="login-html">
                <!--<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Entrar</label>-->
                <!--<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Registrarse</label>-->
                <div class="login-form">
                    <?php echo form_open('sesion/index', array('id' => 'session_form')); ?>
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="user" class="label">Usuario:</label>
                            <input id="usuario" name="usuario" type="text" class="input">

                        </div>
                        <?php echo form_error_format('usuario'); ?>
                        <div class="group">
                            <label for="pass" class="label">Contraseña:</label>
                            <input id="password" name="password" type="password" class="input" data-type="password">
                        </div>
                        <?php echo form_error_format('password'); ?>

                        <br>

                        <div class="group">
                            <div class="captcha-container" id="captcha_first">
                               <img id="captcha" src="<?php echo site_url(); ?>/captcha" alt="CAPTCHA Image" />
                            </div>
<!--                            <div class="captcha-container" id="captcha_first">
                                <img src="<?php // echo $captcha['image_src'];         ?>" alt="CAPTCHA security code" />
                                <script type="text/javascript">
                                    // inicia codigo javascript necesario para un captcha
                                    $(document).ready(function () {
//                                        alert('hshs');
                                        data_ajax(site_url + "/captchac/get_new_captcha_ajax", null, "#captcha_first"); // cargamos por primera vez el captcha
                                    });
                                    // termina codigo javascript necesario para un captcha
                                </script>
                            </div>-->

                            <a class="btn btn-lg btn-primary pull-right" onclick="document.getElementById('captcha').src = '<?php echo site_url(); ?>/captcha/index/' + Math.random(); return false">
                                <span class="glyphicon glyphicon-refresh"></span>
                            </a>
                            <br>
                            <label for="captcha" class="label">Introduzca el captcha:</label>
                            <input id="captcha" name="captcha" type="text" class="input">
                        </div>
                        <?php echo form_error_format('captcha'); ?>

                        <div class="group">
                            <input type="submit" class="btn btn-success btn-lg btn-login" value="Entrar">
                        </div>

                        <br>
                        <div class="foot-lnk">
                            <a href="<?php echo site_url(); ?>/sesion/recuperar_password">¿Olvidó su contraseña?</a>
                        </div>

                        <?php echo form_close(); ?>
                    </div>

                </div>
            </div>
        </div><br><br>


    </body>
</html>
<script type="text/javascript">
    // inicia codigo javascript necesario para un captcha
//    $(document).ready(function () {
////                                        alert('hshs');
//    });
//    // termina codigo javascript necesario para un captcha
//    window.onload = function () {
//        alert('OK');
//    }
    function change_image() {
        data_ajax(site_url + "/captchac/get_new_captcha_ajax", null, "#captcha_first"); // cargamos por primera vez el captcha
    }
</script>
