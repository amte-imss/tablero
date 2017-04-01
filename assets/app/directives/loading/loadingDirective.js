angular.module("tableroApp")
    .directive("loadingDirective", function(){
        
        var objLoading = {
            restrict: "EA"
//            , templateUrl: "app/directives/loading/views/loading.html"
            , scope: {
                // Parametro que inicia o apaga la ventana de loading
                // @acept {boolean}
                activo: "="
            }
        }
        return objLoading;
    });
