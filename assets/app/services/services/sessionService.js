angular.module("tableroApp")
    .service("sessionService",["$http", "$rootScope", "TABLERO_CONSTANTS", "$location", function($http, $rootScope, TABLERO_CONSTANTS, $location){
        var sessionObj = {
//            iniciaSesion: function(userName, password){
//                var url = "./index.php/sesion/inicio_sesion"
//                return $http({
//                            method: "POST"
//                            , url: url
//                            , data: {
//                                usuario: userName
//                                , password: password
//                            }
//                        });              
//            },
          
             cierraSesion: function(){
                var urlServicio = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + TABLERO_CONSTANTS.URL.EXIT;
//                var urlServicio = "./index.php/sesion/cerrar_sesion"
                $http({
                    url: urlServicio
                    , method: "POST"
                    , data: {
                        token: $rootScope.usuario.token
                    }
                }).then(function(response){
                    if(response.tp_msg === "success"){
                        console.lg(response.msj);
                    }else if(response.tp_msg === "danger"){
                        console.warn(response.msj);
                    }
                    $rootScope.usuario = {
                        acceso: false
                        ,token: ""
                    }
                    window.location.href = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + TABLERO_CONSTANTS.URL.LOGIN ;
                }, function(){
                    console.warn("no se ha podido realizar la conexión");
                    $rootScope.usuario = {
                        acceso: false
                        ,token: ""
                    }
                    window.location.href = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + TABLERO_CONSTANTS.URL.LOGIN  ;
                });
            }
        };
        return sessionObj;
    }]);

