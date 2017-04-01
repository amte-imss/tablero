angular.module("tableroApp")
    // Directiva para crear menú lateral izquierdo
    // Capacidad de hasta 3 niveles de profundidad
    .directive("menuDirective", function(){
        objMenuDirective = {
            restrict: "EA"
            ,replace: true
            ,templateUrl: "app/directives/menu/views/menu.html"
            ,scope: {
                // Parametro que muestra o esconde el menú
                // @acept: boolean
                show: "="
                // Elementos a mostrar en el menú
                // @acept: estructura json
                , menuElements: "=elements"
            }
            , link: function(scope){
                scope.$watch("show", function(oldValue, newValue){
                    if(oldValue !== newValue && newValue){
                       
                        $SIDEBAR_MENU = $('#sidebar-menu');
                        $SIDEBAR_MENU.on('click', 'a', function(ev){

                            var $li = $(this).parent();

                            if ($li.is('.active')) {
                                $li.removeClass('active active-sm');
                                $('ul:first', $li).slideUp(function() {
                                    setContentHeight();
                                });
                            } else {
                                // prevent closing menu if we are on child menu
                                if (!$li.parent().is('.child_menu')) {
                                    $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                                    $SIDEBAR_MENU.find('li ul').slideUp();
                                }

                                $li.addClass('active');

                                $('ul:first', $li).slideDown(function() {
                                    setContentHeight();
                                });
                            }
                        });
                    }
                })
            }
        };
        return objMenuDirective;
    });
    
// Estructura de ejemplo:
