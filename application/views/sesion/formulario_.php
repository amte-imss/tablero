<?php ?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Login</title>

        <?php echo css("captcha.css"); ?>
        <?php echo css("style_sesion.css"); ?>
        <?php echo css("securimage.css"); ?>
    </head>

    <body>
        <div class="login-wrap" style="background:"siglo.jpg";">
            <div class="login-html">
                <!-- <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Entrar</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Registrarse</label> -->
                <br>
                <div class="login-form">
                    <?php echo form_open('sesion/iniciar_sesion', array('id' => 'login')); ?>
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="user" class="label">Usuario</label>
                            <input id="usuario" name="usuario" type="text" class="input">
                        </div>
                        <?php echo form_error_format('usuario'); ?>
                        <div class="group">
                            <label for="pass" class="label">Contraseña</label>
                            <input id="password" name="password" type="password" class="input" data-type="password">
                        </div>

                        <div class="group">

                            <!--inicio captcha-->

                            <div class="rc-anchor rc-anchor-normal rc-anchor-light">
                                <div class="rc-anchor-aria-status">
                                    <section><span id="recaptcha-accessible-status" aria-live="assertive" aria-atomic="true">Es necesaria una verificación para el Recaptcha</span></section>
                                </div>
                                <div class="rc-anchor-error-msg-container" style="display:none"><span class="rc-anchor-error-msg"></span></div>
                                <div id="rc-anchor-content" class="rc-anchor-content">
                                    <div class="rc-inline-block">
                                        <div class="rc-anchor-center-container">
                                            <div class="rc-anchor-center-item rc-anchor-checkbox-holder">
                                                <span class="recaptcha-checkbox goog-inline-block recaptcha-checkbox-unchecked rc-anchor-checkbox" role="checkbox" aria-checked="false" id="recaptcha-anchor" tabindex="0" dir="ltr" aria-labelledby="recaptcha-anchor-label">
                                                    <div id="recaptcha-checkbox-border" class="recaptcha-checkbox-border" role="presentation"></div>
                                                    <img id="recaptcha-checkbox-gif" class="recaptcha-checkbox-gif" src="" alt=""/>
<!--                                                    <div class="recaptcha-checkbox-borderAnimation" role="presentation"></div>
                                                    <div class="recaptcha-checkbox-spinner" role="presentation"></div>
                                                    <div class="recaptcha-checkbox-spinnerAnimation" role="presentation"></div>
                                                    <div class="recaptcha-checkbox-checkmark" role="presentation"></div>-->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rc-inline-block">
                                        <div class="rc-anchor-center-container"><label class="rc-anchor-center-item rc-anchor-checkbox-label" aria-hidden="true" role="presentation" id="recaptcha-anchor-label">No soy un robot</label></div>
                                    </div>
                                </div>
                                <div class="rc-anchor-normal-footer">
                                    <div class="rc-anchor-logo-portrait" aria-hidden="true" role="presentation">
                                        <div class="rc-anchor-logo-img rc-anchor-logo-img-portrait"></div>
                                        <div class="rc-anchor-logo-text">reCAPTCHA</div>
                                    </div>
                                    <div class="rc-anchor-pt"><a  target="_blank">Privacidad</a><span aria-hidden="true" role="presentation"> - </span><a  target="_blank">Condiciones</a></div>
                                </div>
                            </div>

                            <!--fin captcha-->


                        </div>

                        <div class="group">
                            <input type="submit" class="button" value="Entrar">
                        </div>
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <a href="#forgot">¿Olvidó su contraseña?</a>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                    <div class="sign-up-htm">
                        <div class="group">
                            <label for="user" class="label">Nombre Completo</label>
                            <input id="user" type="text" class="input">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Contraseña</label>
                            <input id="pass" type="password" class="input" data-type="password">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Repite la contraseña</label>
                            <input id="pass" type="password" class="input" data-type="password">
                        </div>

                        <div class="group">
                            <label for="pass" class="label">Email</label>
                            <input id="pass" type="text" class="input">
                        </div>
                        <div class="group">
                            <label for="user" class="label">Matrícula</label>
                            <input id="matricula" type="text" class="input">
                        </div>

                        <div class="group">
                            <label for="user" class="label">Clave Delegacional</label>
                            <input list="Clave Delegacional">
                            <datalist id="Clave Delegacional">
                                <option value="BC">
                                <option value="BCS">
                                <option value="SONORA">
                                <option value="CHIHUAHUA">
                                <option value="COLIMA">
                            </datalist>
                        </div>
                        <div class="group">
                            <label for="user" class="label">Clave de Categoría</label>
                            <input id="clave_cat" type="text" class="input">
                        </div>
                        <div class="group">
                            <label for="user" class="label">Unidad</label>
                            <input list="unidad">
                            <datalist id="unidad">
                                <option value="BC">
                                <option value="BCS">
                                <option value="SONORA">
                                <option value="CHIHUAHUA">
                                <option value="COLIMA">
                            </datalist>
                        </div>


                        <div class="group">
                            <input type="submit" class="button" value="Enviar">
                        </div>
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <label for="tab-1">¿Ya estas registrado?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/capt.js" type="text/javascript"></script>

    </body>
</html>
