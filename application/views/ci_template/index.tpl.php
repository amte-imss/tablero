<?php
$tipo_color = array("text-red", "text-yellow", "text-orange", "text-blue", "text-maroon",
    "text-gray", "text-fuchsia", "text-aqua", "text-green");
?>
<!DOCTYPE html>
<html>
    <head>
        <script>
            url = "<?php echo base_url(); ?>";
        </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?> SIPIMSS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!--CSS--> 
        <!--fonts-->
        <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet"/>
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/third-party/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
        <!-- Font Awesome -->
        <link href="<?php echo base_url(); ?>assets/third-party/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

        <!--animate css-->
        <!--Usar versión custom-->
        <link href="<?php echo base_url(); ?>assets/css/animate.css/animate.css" rel="stylesheet" type="text/css"/>

        <!--Estilos del template-->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/css/styles_tablero_control.css" rel="stylesheet" type="text/css"/>

        <!--JS-->
        <!-- jquery -->
        <script src="<?php echo base_url(); ?>assets/js/jquery/jquery-2.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/third-party/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- funcionalidad de la plantilla -->
        <script src="<?php echo base_url(); ?>assets/js/custom-template.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/registro/funcionalidad_modal.js" type="text/javascript"></script>
        <script type="text/javascript">
            var site_url = "<?php echo site_url(); ?>";
        </script>
    </head>
    <body class="nav-md">

        <?php
        echo $main_content;
        ?>

    </body>
</html>

