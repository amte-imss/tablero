angular.module("tableroApp")
        .controller("gestionCtrl", ["$scope", "$location", function($scope, $location){
            console.log("En controlador de administración ", $location.path());
            if($location.path() === "/gestionUsuario/buscar"){
                console.log("En buscar usuarios");
                $scope.panelTitle = "Buscar usuarios";
                // Hacer cosas de buscar usuarios..
                
                
                
                
                    
            }else if($location.path() === "/gestionUsuario/registro"){
                console.log("");
                $scope.panelTitle = "Registrar usuarios";
                // Hacer cosas de registro de usuarios..
                
                
                
                
            }
            
            
            // Acciones de animación de panel entrante
            $scope.panelClass = {
                fadeInLeftBig: true
                ,fadeOutLeftBig: false
                ,animated: true
            };
            // Animación de panel saliente
            $scope.$on("$routeChangeStart", function(){
                console.log("Cambiando de ruta");
                $scope.panelClass = {
                    fadeInLeftBig: false
                    ,fadeOutRightBig: true
                    ,animated: true
                }
            });
        }]);

