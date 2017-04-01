angular.module("tableroApp")
        // Directiva para crear un modal
        .directive("modalDirective", [ "TABLERO_CONSTANTS", function(TABLERO_CONSTANTS){
           var cont = 0;
           var modalObj = {
               retrict: "A"
               ,replace: true
               ,transclude: true
               ,templateUrl: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ] + "assets/app/directives/modal/views/modal.html"
               ,scope: {
                   config: "="
//                   // Atributo que activa el modal
//                   // @acept: boolean
//                   activo: "="
//                   // Tamaños de modal según bootstrap sm, md, lg
//                   // @acept: string ['sm', 'md', 'lg']
//                   ,tamanno: "@"
//                   // Tipo de modal según aviso
//                   // @acept: string ['warning', 'error', 'success']
//                   ,colorClass: "@colorclass"
//                   // Texto en el cuerpo
//                   // @acept: string                   
//                   ,textoBody: "=body"
//                   // Texto en la cevecera
//                   // @acept: string
//                   ,textoHeader: "=header"
//                   // Indica si el modal se puede cerrar con el botón de "x" o click fuera del modal
//                   // @acept: bolean
//                   ,cerrable: "="
//                   ,aceptarCallBack: "&aceptarcallback"
//                   ,botonAceptar: "=botonaceptar"
               }
               // Función actua como controlador de la directiva
               ,link: function(scope, element, atributes){
                   scope.modalId = "modal"+cont;
                   
                   // Evento de cerrado de modal
                   $(element).on('hidden.bs.modal', function(){
                       scope.config.activo = false;
                       scope.config.colorClass = null;
                       console.log("oculatando");
                  });
                   
                   // Clases para el tamaño del modal
                   scope.config.tamanno = (typeof scope.tamanno === "undefined" ? "md" : scope.config.tamanno) ;
                        

                   
                   // Se asigna configuración si el modal se puede cerrar dando click sin seleccionar opciones
                   // (dando click fuera del modal o en botón "x")
                   scope.botonCerrar;
                   
                   // Se coloca un observer sobre el elemento scope.activo para detectar cuando mostrar el modal
                   scope.$watch("config", function(newValue, oldValue){
                         if(newValue.activo !== oldValue.activo && newValue.activo == true){
                             // se configura si el modal se puede cerrar dando click afuera de el 
                             scope.botonCerrar = (typeof scope.config.cerrable === "undefined" ? true : scope.config.cerrable);
                            if( !scope.botonCerrar){
                                $('#'+scope.modalId).modal({
                                    show: false
                                    , keyboard: false
                                    , backdrop: false
                                });
                            }else{
                                $('#'+scope.modalId).modal({
                                    show: false
                                    , keyboard: true
                                    , backdrop: true
                                });
                            };
                            scope.clases = {
                                tamanno: {
                                    "modal-sm": (scope.config.tamanno === "sm" ? true : false) 
                                    , "modal-md": (scope.config.tamanno === "md" ? true : false) 
                                    , "modal-lg": (scope.config.tamanno === "lg" ? true : false) 
                                }
                                , color:{
                                    "warning": (scope.config.colorClass === "warning" ? true : false )
                                    ,"danger": (scope.config.colorClass === "danger" ? true : false )
                                    ,"error": (scope.config.colorClass === "error" ? true : false )
                                }
                            };
                             $('#'+scope.modalId).modal('show');
                         }
                   });
                   
               }
           };
           
           return modalObj;
           
        }]);