angular.module('tableroApp')
    // Controlador de acceso al sistema
	.controller("loginCtrl", [ "$scope", "$rootScope", "$http", "TABLERO_CONSTANTS", "$location", "sessionService", 
                                function($scope, $rootScope, $http, TABLERO_CONSTANTS, $location, sessionService){
		$scope.userName = "";
        $scope.password = "";
        // Función que pide validar usuario y contrsaseña al servidor
		$scope.accesoLogin = function(){
            if($scope.userName != "" && $scope.password != ""){
                $rootScope.loadingGif = true;
                
                sessionService.iniciaSesion($scope.userName, $scope.password)
                .then(function(response){
                    console.log("En login:: response:", response);
                    // Se quita el loading gif
                    $rootScope.loadingGif = false;
                    // Se asignan los permisos y etiquetas a los elementos de menú
                    if(response.data.acceso && typeof response.data.token !== "undefined" ){
                        $rootScope.usuario = response.data;
                        for(item in $rootScope.elementsMenuJson){
                            if(typeof $rootScope.usuario.permisos.menu[item] !== "undefined"){
                                $rootScope.elementsMenuJson[item].acceso =( typeof $rootScope.usuario.permisos.menu[item].acceso !== "undefined" ? $rootScope.usuario.permisos.menu[item].acceso : $rootScope.elementsMenuJson[item].acceso );
                                $rootScope.elementsMenuJson[item].label = ( typeof $rootScope.usuario.permisos.menu[item].label !== "undefined" ? $rootScope.usuario.permisos.menu[item].label : $rootScope.elementsMenuJson[item].label );
                                if( typeof $rootScope.elementsMenuJson[item].childs !== "undefined" && $rootScope.elementsMenuJson[item].acceso){
                                    for(childItem in $rootScope.elementsMenuJson[item].childs){
                                        console.log("Item: "+ item + "  child: "+childItem);
                                        if( typeof $rootScope.usuario.permisos.menu[childItem] !== "undefined" ){
                                            $rootScope.elementsMenuJson[item].childs[childItem].label = ( typeof $rootScope.usuario.permisos.menu[childItem].label !== "undefined" ? $rootScope.usuario.permisos.menu[childItem].label : $rootScope.elementsMenuJson[item].childs[childItem].label ); 
                                            $rootScope.elementsMenuJson[item].childs[childItem].acceso = ( typeof $rootScope.usuario.permisos.menu[childItem].acceso !== "undefined" ? $rootScope.usuario.permisos.menu[childItem].acceso : $rootScope.elementsMenuJson[item].childs[childItem].acceso );
                                            if(typeof $rootScope.elementsMenuJson[item].childs[childItem].childs !== "undefined"){
                                                for(childItem2 in $rootScope.elementsMenuJson[item].childs[childItem].childs){
                                                    if(typeof $rootScope.elementsMenuJson[item].childs[childItem].childs[childItem2] !== "undefined"){
                                                        $rootScope.elementsMenuJson[item].childs[childItem].childs[childItem2].acceso = ( typeof $rootScope.usuario.permisos.menu[childItem2].acceso !== "undefined" ? $rootScope.usuario.permisos.menu[childItem2].acceso : $rootScope.elementsMenuJson[item].childs[childItem].childs[childItem2].acceso );
                                                        $rootScope.elementsMenuJson[item].childs[childItem].childs[childItem2].label = ( typeof $rootScope.usuario.permisos.menu[childItem2].label !== "undefined" ? $rootScope.usuario.permisos.menu[childItem2].label : $rootScope.elementsMenuJson[item].childs[childItem].childs[childItem2].label );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $rootScope.showMenu = true;
                        $location.path("/home");
                    }else{
                        console.warn("Acceso in correcto");
                        $rootScope.genericModal.txtBody = "Usuario o contraseña incorrectos, no se ha permitido el acceso";
                        $rootScope.genericModal.txtHead = "Error de acceso";
                        $rootScope.genericModal.activo = true;    
                    }
                },function(){
                    console.warn("No se ha podido realizar la conexión")
                    $rootScope.loadingGif = false;
                });
            }        
        }       
	}]);