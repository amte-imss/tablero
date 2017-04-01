
    <?php
      echo js('ci_template/ficha_usuario.js') ;
    ?>
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <?php echo $usuario["nombre"] ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li class="user-card-group" >
                <a> 
                    <?php echo $usuario["nombre_grupo"] . " " . $usuario["nivel"] ?>
                </a>
            </li>
            <li>
                <?php
                    if(isset($usuario["categoria_nom"]) && !is_null($usuario["categoria_nom"]) && !empty($usuario["categoria_nom"])){
                        echo '<a> '.$usuario["categoria_nom"].' </a>';
                    }
                ?>
            </li>
            <li>
                <a>Matrícula: <?php echo $usuario["matricula"] ?></a>
            </li>
            <li>
                <a>CURP: <?php echo $usuario["curp"] ?></a>
            </li>
            <li>
                <a>Delegación: <?php echo $usuario["del_nom"] ?></a>
            </li>
            <li>
                <a>Unidad: <?php echo $usuario["unidad_nom"] ?></a>
            </li>
            <li><a class="user-card-get-out" onclick="cerrar_sesion_ficha('<?php echo site_url();?>')"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
          </ul>
        </li>
        <li role="presentation" class="dropdown">
            <a id="logoutButton" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-question-circle"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->