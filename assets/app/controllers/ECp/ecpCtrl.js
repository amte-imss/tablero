angular.module('tableroApp')
    .controller("ecpCtrl", 
        [ "$scope", "$http", function($scope, $http){
        $scope.panelTitle = "Educación a distancia";

        // Funciones para efecto de llegada de panel 
        $scope.panelClass = {
            fadeInLeftBig: true
            ,fadeOutLeftBig: false
            ,animated: true
        }
        
        //  Se ajusta el tamaño del contenedor general
        $(".right_col").css("min-height", window.innerHeight);
        
        // Funciones para efecto de salida de panel
        $scope.$on("$routeChangeStart", function(){
            console.log("Cambiando de ruta");
            $scope.panelClass = {
                fadeInLeftBig: false
                ,fadeOutRightBig: true
                ,animated: true
            }
        });
    
    }]);