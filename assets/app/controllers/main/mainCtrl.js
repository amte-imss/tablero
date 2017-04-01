angular.module("tableroApp")
    .controller("mainCtrl", [ "$scope", "sessionService", function($scope, sessionService){
            
            
            
        $scope.cerrarSesion = function(){
            sessionService.cierraSesion();
        };
                    
    }]);


