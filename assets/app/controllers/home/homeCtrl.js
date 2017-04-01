angular.module('tableroApp')
	.controller("homeCtrl", [ "$scope", function($scope){
		
        $scope.panelTitle = "Resumen general";
        
//        $scope.radioTipoSeleccion = "PAIS";
        $scope.radioTipoSeleccion = "REGION";
        $scope.seleccinoado = "";
        
        $scope.$on("map-selection", function(event, data){
            $scope.seleccionado = data.seleccionado;
        });
        
        // Estilos para entrada de panel
        $scope.panelClass = {
            fadeInLeftBig: true
            ,fadeOutLeftBig: false
            ,animated: true
        };
        
        //  Se ajusta el tamaÃ±o del contenedor general
        $(".right_col").css("min-height", window.innerHeight);
        
        // Captura de evento de cambio de ruta
        $scope.$on("$routeChangeStart", function(){
            // Estilos de salida de panel
            $scope.panelClass = {
                fadeInLeftBig: false
                ,fadeOutRightBig: true
                ,animated: true
            }
        });
        
	}]);