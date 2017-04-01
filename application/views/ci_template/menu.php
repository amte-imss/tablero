  <header>
    <div class="logos">
        <img src="<?php echo base_url(); ?>assets/img/header/logos3.png" alt="">
    </div>
    <div class="titulo">
        <h1 class="titulo-header">Tablero de control y seguimiento para la educación continua, presencial y a distancia</h1>
    </div>
</header>
<div class="main_container">
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="clearfix"></div>
        <br/>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            
            <div class="menu_section">
                <ul class="nav side-menu">
                    <?php
                        $string_menu = "";
                        foreach($menu as $element){
                            $string_menu .= "<li>";
                            if( !isset($element["url"]) || is_null($element["url"]) ){
                                $string_menu .= '<a >'.$element["label"].'</a>';
                            }else{
                                $string_menu .= '<a href="'.  base_url() .$element["url"].'">'.$element["label"].'</a>';
                            }
                            if( isset($element["childs"]) && !is_null($element) ){
                                $string_menu .= '<ul class="nav child_menu">';
                                foreach($element["childs"] as $child){
                                    $string_menu .= "<li>";
                                    if( !isset($child["url"]) || is_null($child["url"]) ){
                                        $string_menu .= '<a >'.$child["label"].'</a>';
                                    }else{
                                        $etiqueta = empty($child['label']) ? $child['url'] : $child['label'];
                                        $string_menu .= '<a href="'.  base_url() .$child["url"].'">'.$etiqueta.'</a>';
                                    }
                                    if(isset($child["childs"]) && !is_null($child["childs"]) ){
                                        $string_menu .= '<ul class="nav child_menu">';
                                        foreach($child["childs"] as $child2){
                                            $string_menu .= "<li>";
                                            if( !isset($child2["url"]) || is_null($child2["url"])  ){
                                                $string_menu .= '<a >'.$chil2["label"].'</a>';
                                            }else{
                                                $string_menu .= '<a href="'.  base_url() .$chil2["url"].'">'.$chil2["label"].'</a>';
                                            }
                                            $string_menu .= "</li>";
                                        }
                                        $string_menu .= '</ul>';
                                    }
                                    $string_menu .= "</li>";
                                }
                                $string_menu .= '</ul>';
                            }
                            $string_menu .= "</li>";
                        }
                        echo $string_menu;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>