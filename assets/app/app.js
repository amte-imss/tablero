// tableroApp: Módulo inicial de la aplicación
angular.module('tableroApp', ["ngRoute", "chart.js", "ui.bootstrap", "svgMapModule"])
    // Configuración de rutas, vistas y controladores
    // Se recoje el Json configApp generado en el index desde código php con las configuraciones del usuario y configurar un routerProvider dinamicamente.
    // Pedir documento de configuración si se decea saber como está compuesto configApp.
    .config([ "$routeProvider", function($routeProvider){
        console.log("Variable configApp",configApp);    
        for(var item in configApp.config){
            $routeProvider.when(configApp.config[item].url_link , {
                templateUrl: configApp.url_base + configApp.config[item].url_template
                , controller: configApp.config[item].controller
                , resolve: { tmp: function ($timeout) { return $timeout(function () {  }, configApp.config[item].delay); } }
            })
            if(configApp.config[item].main){
                $routeProvider.otherwise({
                    templateUrl: configApp.url_base + configApp.config[item].url_template
                    , controller: configApp.config[item].controller
                    , resolve: { tmp: function ($timeout) { return $timeout(function () {  }, configApp.config[item].delay); } }
                })
            }
        }
    }])
    // Configuración para el envio de datos AJAX mendiante POST con $http
    .config( function($httpProvider) {
        $httpProvider.defaults.transformRequest = function(obj) {
            var str = [];
            for(var p in obj)
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            return str.join("&");
        };
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        $httpProvider.defaults.headers.post['Access-Control-Allow-Origin'] = '*';
        
    })
    // Colores por deefcto para los elementos de las graficas
    // colores que se usan si el servidor no madan colores
    .config(function (ChartJsProvider) {
        ChartJsProvider.setOptions({ colors : [ '#803690', '#00ADF9', '#DCDCDC', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360'] });
    })
    // Configuraciones de inicio de aplicación.
    .run(["$rootScope", "TABLERO_CONSTANTS", "sessionService", "$http", "$timeout", function($rootScope, TABLERO_CONSTANTS, sessionService, $http, $timeout ){
        // Se asignan valores de usuario, de inicio vacio.
//        $rootScope.usuario = {
//            acceso: true
//        };
        
        $rootScope.usuario = configApp.usuario;
        
        // Gif loading de inicio apagado.
        $rootScope.loadingGif = false;
        // Configuración de modal de inicio.
        $rootScope.genericModal = {
          activo: false
          , txtBody: ""
          , txtHead: ""
          , cerrable: true
        };
        
        // Configuración inicial del menú
        $rootScope.showMenu = true;
        var cambiaUrl = function(url){
            if(url[0] !== "#"){
                if(url[0] === "/"){
                    url = url.substr(1);
                }
                url = TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+ url;
            }
            return url;
        }
        for(var element in configApp.menu){
            if(configApp.menu[element].url !== null && configApp.menu[element].url !== ""){
                configApp.menu[element].url = cambiaUrl(configApp.menu[element].url);
            }
            if( typeof configApp.menu[element].childs !== "undefined"){
                for(var child in configApp.menu[element].childs){
                    if(configApp.menu[element].childs[child].url !== null && configApp.menu[element].childs[child].url !== ""){
                        configApp.menu[element].childs[child].url = cambiaUrl(configApp.menu[element].childs[child].url);
                    }
                    if( typeof configApp.menu[element].childs[child].childs !== "undefined"){
                        for(var child2 in configApp.menu[element].childs[child].childs){
                            if(configApp.menu[element].childs[child].childs[child2].url !== null && configApp.menu[element].childs[child].childs[child2].url !== ""){
                                configApp.menu[element].childs[child].childs[child2].url = cambiaUrl(configApp.menu[element].childs[child].childs[child2].url);
                            }
                        }
                    }
                }
            }
        }
        
        $rootScope.elementsMenuJson = configApp.menu;
        console.log("elementos de menú: ", $rootScope.elementsMenuJson);
        
        // Se crea objeto para majenar elementos del mapa
        $rootScope.mapa = {
            delegaciones: {}
            , regiones: {}
            , umaes: {}
        }
        
        // Se piden datos para mapa
        // --Delegaciónes
        $http({
            method: "GET"
            , url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ] +  TABLERO_CONSTANTS.URL.ESPACIAL.DELEGACION.ACCESO
        }).then(function(response){
            console.log("response delegacion:: ", response);
            if(typeof response.data.acceso !== "undefined" && response.data.acceso == false){
                $rootScope.mapa.delegacion = {};
                console.log(response.data.msj+" "+TABLERO_CONSTANTS.URL.ESPACIAL.DELEGACION.ACCESO);
            }else{
                $rootScope.mapa.delegacion = response.data;
            }
            
        }, function(){
            console.warn(TABLERO_CONSTANTS.MSG.ERROR.CONEXION);
        });
        
        // --Regiónes
        $http({
            method: "GET"
            , url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ] +  TABLERO_CONSTANTS.URL.ESPACIAL.REGION.ACCESO
        }).then(function(response){
            console.log("response en region:: ", response);
            if(typeof response.data.acceso !== "undefined" && response.data.acceso == false){
                $rootScope.mapa.region = {};
                console.log(response.data.msj+" "+TABLERO_CONSTANTS.URL.ESPACIAL.REGION.ACCESO);
            }else{
                $rootScope.mapa.region = response.data;
            }
        }, function(){
            console.warn(TABLERO_CONSTANTS.MSG.ERROR.CONEXION);
        });

        // -UMAES
        $http({
            method: "GET"
            , url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ] +  TABLERO_CONSTANTS.URL.ESPACIAL.UMAE.ACCESO
        }).then(function(response){
            console.log("response en UMAES:: ", response);
            if(typeof response.data.acceso !== "undefined" && response.data.acceso == false){
                $rootScope.mapa.umae = {};
                console.log(response.data.msj+" "+TABLERO_CONSTANTS.URL.ESPACIAL.UMAE.ACCESO);
            }else{
                $rootScope.mapa.umae = response.data;
            }
        }, function(){
            console.warn(TABLERO_CONSTANTS.MSG.ERROR.CONEXION);
        });
        
        // -Unidades
        $http({
            method: "GET"
            , url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ] +  TABLERO_CONSTANTS.URL.ESPACIAL.UNIDAD.ACCESO
        }).then(function(response){
            console.log("response en UMAES:: ", response);
            if(typeof response.data.acceso !== "undefined" && response.data.acceso == false){
                $rootScope.mapa.unidad = {};
                console.log(response.data.msj+" "+TABLERO_CONSTANTS.URL.ESPACIAL.UMAE.ACCESO);
            }else{
                $rootScope.mapa.unidad = response.data;
            }
        }, function(){
            console.warn(TABLERO_CONSTANTS.MSG.ERROR.CONEXION);
        });
        
        
        $rootScope.cerrarSesion = function(){
            sessionService.cierraSesion();
        };
        
        $timeout(function(){
            $(".right_col").css("min-height", window.innerHeight);
        }, 500);
        
    }])
	