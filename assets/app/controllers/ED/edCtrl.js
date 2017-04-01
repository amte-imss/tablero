angular.module('tableroApp')
    .controller("edCtrl",
        [ "$scope", "$rootScope", "TABLERO_CONSTANTS", "$http", "$location", "$compile", "$timeout", "graficasDriverFactory", "$filter", 
        function($scope, $rootScope, TABLERO_CONSTANTS, $http, $location, $compile, $timeout, graficasDriverFactory, $filter){

        $scope.panelTitle = "Educación a distancia";
        $scope.muestraPanelG = true;
    
        console.log("Iniciando controlador ECP");
    
        // Opciones de controlador segÃºn la vista seleccionada
        // Comparativa ECP
        if($location.path() === "/ed/comparativa"){
            
            $scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
            
            console.log("en comparativa");
            
//            $scope.urlConsultaPdf = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + "index.php/exportar/print_pdf" ;
            
            var graficas = graficasDriverFactory("graficaContainer", $scope);
            $scope.panelSubTitle = "Comparativas";

            // Oculta el panel de la grafica
            $scope.muestraPanelGrafica = false;

            // Oculta la selecciÃ³n de comparadores de tipo (seleccion de delegaciones, regiones o umaes especificos)
            $scope.mostrarComparadores = false;

            // Tipo de selecciÃ³n para comparativa
            $scope.tipoSeleccion = [];
            $scope.tipoSeleccion.push({id: 0, "label": "SELECCIONE"});
            
            // Opciones para seleccionar
            $scope.selecciones = { };
            
            $scope.comparadores = [];
            
            $scope.annios = configApp.anios_implementacion;
            $scope.annioSeleccinoado = configApp.anios_implementacion[configApp.anios_implementacion.length - 1];

            $scope.tiposGraficas = graficas.tiposGraficas;
            
            // Variables para controlar las graficas
            // El tipo de grafica a mostrar
            $scope.tiposGraficas = graficas.tiposGraficas;
            // Se inicia en la grafica indice 0
            $scope.tipoGraficaActual = $scope.tiposGraficas[0];
            // Las etiquetas del eje x
            $scope.labels = [];
            // Los nombres de las series
            $scope.series = [];
            // Los valores de las series
            $scope.data = [];
            // Opciones extra para las graficas
            $scope.options = {};
            // Colores deault para las gráficas
            $scope.backgroundColor = ["#2E86C1", "#48C9B0", "#008EAD"];
            
            
            
            for(var tipo in $rootScope.mapa){
                if( Object.keys($rootScope.mapa[tipo]).length > 1 ){
                    $scope.tipoSeleccion.push(
                        {
                          id: tipo 
                          ,label: tipo.toUpperCase()
                        }
                    )
                    $scope.selecciones[tipo] = [];
                    var indice = 0;
                    for(var seleccion in $rootScope.mapa[tipo]){
                        $scope.selecciones[tipo].push($rootScope.mapa[tipo][seleccion]);
                        $scope.selecciones[tipo][indice].id = seleccion;
                        indice++;
                    }
                    $scope.selecciones[tipo] = $filter('orderBy')($scope.selecciones[tipo], "label");
                    if(tipo !== "unidad"){
                        $scope.selecciones[tipo].unshift({label: "SELECCIONE", id: "00"});
                    }
                }
            };

            $scope.tipoSeleccionado = {id: 0, "label": "Seleccione"};
            
            
            var pideServiciosTiposComparativas = function(){
                
                $rootScope.comparativas = {
//                    DELEGACION: {
//                        filtros: {}
//                        , pedido: false
//                        , posicion: 0
//                    }
//                    ,REGION: {
//                        filtros: {}
//                        , pedido: false
//                        , posicion: 0
//                    }
//                    ,UMAE: {
//                        filtros: {}
//                        , pedido: false
//                        , posicion: 0
//                    }
//                    ,UNIDAD: {
//                        filtros: {}
//                        , pedido: false
//                        , posicion: 0
//                    }
                }
                
                
                $http({
                    method: "GET"
                    ,url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+ TABLERO_CONSTANTS.URL.ESPACIAL.DELEGACION.SERVICIO_COMPARATIVA
                }).then(function(response){
                    console.log("comparativas delegacion::", response);
                    $rootScope.comparativas.DELEGACION = response.data;
                }, function(){
                    console.warn("no se ha podido realizar la conexión");
                });

                $http({
                   method: "GET"
                    ,url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+ TABLERO_CONSTANTS.URL.ESPACIAL.REGION.SERVICIO_COMPARATIVA
                }).then(function(response){
                    console.log("comparativas region::", response);
                    $rootScope.comparativas.REGION = response.data;
                }, function(){
                    console.warn("no se ha podido realizar la conexión");
                });

                $http({
                   method: "GET"
                    ,url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+TABLERO_CONSTANTS.URL.ESPACIAL.UMAE.SERVICIO_COMPARATIVA
                }).then(function(response){
                    console.log("comparativas umae::", response);
                    $rootScope.comparativas.UMAE = response.data;
                }, function(){
                    console.warn("no se ha podido realizar la conexión");
                });

                $http({
                   method: "GET"
                    ,url: TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+TABLERO_CONSTANTS.URL.ESPACIAL.UNIDAD.SERVICIO_COMPARATIVA
                }).then(function(response){
                    console.log("comparativas unidad::", response);
                    $rootScope.comparativas.UNIDAD = response.data;
                }, function(){
                    console.warn("no se ha podido realizar la conexión");
                    console.warn(TABLERO_CONSTANTS.URL.BASE[ TABLERO_CONSTANTS.ENVIRONMENT ]+TABLERO_CONSTANTS.URL.ESPACIAL.UNIDAD.SERVICIO_COMPARATIVA);
                });
            }
                
            pideServiciosTiposComparativas();
            
            
            
            
            
            
            
            
            
            
            
            $scope.ocultaDatos = function(){
                $scope.muestraPanelGrafica = false;
            };
            
            
            $scope.comparativas = [];
            
            // Cuando se seleccionan comparadores (alguna región, delegación o umae)
            // Se valida que no seá el mismo id en ambos casos
            $scope.selectComparador = function(indice){
                $scope.muestraPanelGrafica = false;
                if($scope.comparadores[indice].id != "00" ){
                    var indice2 = (indice === 1 ? 0 : 1);
                    if($scope.comparadores[indice].id == $scope.comparadores[indice2].id ){
                        console.log("No puede seleccionar el mismo dos veces");
                        $scope.comparadores[indice] = $scope.selecciones[($scope.tipoSeleccionado.label.toLowerCase())][0];
                        $rootScope.genericModal = {
                            activo: true
                            , txtHead: "Error"
                            , txtBody: "No puede realizar la misma seleción dos veces"
                            , colorClass: "warning"
                         }
                    }
                }
            };
            
            // Evento del botón comparar
            // Manda los datos de comparadores y comparativas para generar la grÃ¡fica
            $scope.comparar = function(){
                var pasa = true;
                for(var item in $scope.comparadores){
                    if($scope.comparadores[item].label === "SELECCIONE" || $scope.comparadores[item].label === "" ){
                        pasa = false;
                    }
                }
                console.log("tipoSeleccionado ", $scope.tipoSeleccionado);
                console.log("comparativas ", $scope.comparativas);
                console.log("comparadores ", $scope.comparadores);
                console.log("annioSeleccinoado ", $scope.annioSeleccinoado);
                if(pasa){
                    console.log("tipo actual", $scope.tipoGraficaActual);
                    console.log("tips", $scope.tiposGraficas);
                    
                        
                    
                    $scope.muestraPanelGrafica = true;
                    $rootScope.loadingGif = true;
                    var urlConsulta = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + TABLERO_CONSTANTS.URL.ESPACIAL[$scope.tipoSeleccionado.id.toUpperCase()].COMPARATIVA ; 
                    console.log("url consulta: ", urlConsulta);
                    
                    $scope.dataSend = {};
                    var cont = 0;
                    for(var item in $rootScope.comparativas[$scope.tipoSeleccionado.label]){
                        $scope.dataSend[item] = $scope.comparativas[cont++];
                    }
                    $scope.dataSend.series = [];
                    for(item in $scope.comparadores){
                        $scope.dataSend.series.push($scope.comparadores[item].id);
                    }
                    $scope.dataSend.año = $scope.annioSeleccinoado;
                    $http({
                        url: urlConsulta
                        , method: "post"
                        , data: $scope.dataSend
                    }).then(function(response){
                        console.log("datos response comparativas:: ", response);
                        
                        $scope.labels = response.data["dimensión"];
                        $scope.series = [];
                        $scope.data = [];
                        for(var item in response.data.reporte){
                            $scope.data.push(response.data.reporte[item]);
                            $scope.series.push($rootScope.mapa[$scope.tipoSeleccionado.id][item].label);
                        }
                        
                        $rootScope.loadingGif = false;
                        $scope.cambiaTipoGrafica(0);
                        
                    }, function(){
                        console.warn("No se ha poido realizar la conexión");                        
                        $rootScope.loadingGif = false;
                        $rootScope.genericModal = {
                            activo: true
                            , txtHead: "Error"
                            , txtBody: "No se ha podido realizar le conexión"
                            , colorClass: "warning"
                         }
                    });
                    
                }else{
                    $rootScope.genericModal = {
                        activo: true
                        , txtHead: "Error"
                        , txtBody: "Debe realizar selección en ambos "
                        , colorClass: "warning"
                     }
                }
             }

             // Evento al cambiar selección en select tipo comparativa
            $scope.seleccionTipoComarativa = function(){
                $scope.muestraPanelGrafica = false;
                if($scope.tipoSeleccionado.id !== 0){
                    $scope.comparativas = [];
                    $scope.comparativas.length = 0;
                    for(var item in $rootScope.comparativas[$scope.tipoSeleccionado.label]){
                        $scope.comparativas.push($rootScope.comparativas[$scope.tipoSeleccionado.label][item][0]);
                    }
                    $scope.mostrarComparadores = true;
                    for(var i=0; i<2; i++){
                        $scope.comparadores[i] = $scope.selecciones[($scope.tipoSeleccionado.label.toLowerCase())][0];
                    }
                }else{
                    $scope.mostrarComparadores = false;
                }
            }
             
            // Método que genera las graficas
            // aunque el nombre es cambia tipo, en realidad la genera cada vez
            $scope.cambiaTipoGrafica = function(index){
                $scope.tipoGraficaActual = $scope.tiposGraficas[index];
                if( $scope.tipoGraficaActual.class === "chart-horizontal-bar"){
                    $scope.options = {
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: $filter("labelsFilter")($scope.comparativas[$scope.comparativas.length-1])
                                }
                                ,ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                  }
                            }]
                        }
                        ,legend: { display: true }
                    };
                }else{
                    $scope.options = {
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: $filter("labelsFilter")($scope.comparativas[$scope.comparativas.length-1])
                                }
                                ,ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                  }
                            }]
                        }
                        ,legend: { display: true } 
                    };
                }
                graficas.cambiaTipoGrafica($scope.tipoGraficaActual.class);
            };
            
            // Método para sacar la media de dos conjuntos de datos
            $scope.obtenerMedia = function(arrayData){
              if(Array.isArray(arrayData)){
                  if(arrayData.length > 0 && arrayData[0].length > 0){
                      // Serie que agrega la media de datos
                      var nuevaSerie = [];
                      for(var i in arrayData[0]){
                          nuevaSerie[i] = 0;
                          for(var j in arrayData){
                                nuevaSerie[i] += arrayData[j][i];
                          }
                          nuevaSerie[i] = (nuevaSerie[i]/arrayData.length);
                      }
                      return nuevaSerie; 
                  }else{
                      return [];
                  }
              }else{
                  console.log("debe mandar un arreglo de datos");
                  return [];
              }
            };
            
            // Pasos para imprimir pdfd de grafica
            $scope.printPdf = function (){

                // Generar imagen para el pdf
                var canvas = document.getElementById('graf_0');
                $scope.image = canvas.toDataURL("image/png");
                
                // Se genera el formulario si no existe
                if(typeof $scope.f === "undefined"){
                    $scope.generaFormularioPdf();
                }
                
                // Se asignan los valores a los input
                $scope.input_img.setAttribute('value', $scope.image);
                $scope.input_tipo_graf.setAttribute('value', $scope.tipoGraficaActual);  
                var comparadoresLabels = "";
                var inicio = true;
                for(var item in $scope.comparadores){
                    if(!inicio){
                        comparadoresLabels += ",";
                    }
                    inicio = false;
                    comparadoresLabels += $scope.comparadores[item].label;
                }
                $scope.input_comparadores.setAttribute("value", comparadoresLabels);

                $scope.f.submit();
            };
            
            // Manda los datos para generar el excel
            $scope.printExcel = function(){
                
//                $scope.generaFormularioExcel();
                
//                var urlConsulta = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + "index.php/exportar/print_pdf" ;
//                var urlConsulta = "http://localhost/tablero2/index.php/region/print_excel/comparativa";
                var urlConsulta = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + "index.php/"+$scope.tipoSeleccionado.id+"/print_excel/comparativa" 
                $scope.f2 = document.getElementById("formGetExcel");
                $scope.f2.setAttribute("action", urlConsulta);
                $scope.f2.submit();
            };
            
            $scope.generaFormularioPdf = function(){
                
                var urlConsulta = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + "index.php/exportar/print_pdf" ;
                
                $scope.f = document.createElement("form");
                $scope.f.setAttribute('method',"post");
                $scope.f.setAttribute('action',urlConsulta);
                $scope.f.setAttribute('id', "form_print_pdf" );
                $scope.f.style.display = "none";
                
                $scope.input_img = document.createElement("input");
                $scope.input_img.setAttribute('type', "text");
                $scope.input_img.setAttribute('name', 'imagen');
                $scope.f.appendChild($scope.input_img);
                
                $scope.input_tipo_graf = document.createElement("input");
                $scope.input_tipo_graf.setAttribute('type', "text");
                $scope.input_tipo_graf.setAttribute('name', 'tipo_grafica');
                $scope.f.appendChild($scope.input_tipo_graf);
                
                $scope.input_comparadores = document.createElement("input");
                $scope.input_comparadores.setAttribute("name", "comparadores");
                $scope.input_comparadores.setAttribute("type", "text");
                $scope.f.appendChild($scope.input_comparadores);
                
                document.getElementsByTagName('body')[0].appendChild($scope.f);
            }
            
            $scope.validaUnidad = function(index){
//                console.log("El comparador seleccionado es: ", $scope.comparadores[index]);
                if(typeof $scope.comparadores[index] !== "object"){
                    $scope.comparadores[index] = "";
                }
            };
                
        // Regiones ECP        
        }else if($location.path() === "/ed/regionalizacion"){
            
            $scope.panelSubTitle = "Mapa";
            $scope.radioTipoSeleccion = "DELEGACION";
            $scope.tiposSelecciones = ["DELEGACION", "REGION", "UMAE"];
            $scope.seleccinoadoId = "";
            $scope.seleccionadoLabel = "";
            $scope.umaesRegion = [];
            $scope.umaeSeleccionado = "";
            $scope.mostrarResultados = false;

             $scope.radioSelecciones = {
                "DELEGACION": Object.keys($rootScope.mapa.delegacion).length > 0
                , "REGION": Object.keys($rootScope.mapa.region).length > 0
                , "UMAES": Object.keys($rootScope.mapa.umae).length > 0
            }

            // Escucha los mensajes de la directiva de mapa
            $scope.$on("map-selection", function(event, data){
                $scope.seleccionadoId = data.seleccionadoId;
                $scope.seleccionadoLabel = data.seleccionadoLabel;
                if($scope.radioTipoSeleccion !== "UMAE"){
                    $scope.mostrarResultados = true
                    consultasMapa($scope.radioTipoSeleccion, "RESUMEN", $scope.seleccionadoId);
                }else{
                     $scope.umaeSeleccionado = "";
                     $scope.mostrarResultados = false;
                     $scope.seleccionadoLabel = "";
                    if($scope.umaesRegion.length === 0 && Object.keys($rootScope.mapa.umae).length > 1 ){
                        $scope.responseMapa = { };
                        for(var umae in $rootScope.mapa.umae){
                            $scope.umaesRegion.push($rootScope.mapa.umae[umae]);
                            $scope.umaesRegion[($scope.umaesRegion.length-1)].clave = umae;
                        }
                    }
                }
            });
            
            // cuando cambia la selecciÃ³n switch se reinician valores 
            $scope.$watch("radioTipoSeleccion" , function(oldValue, newValue){
                if(oldValue !== newValue ){
                        $scope.$broadcast("mapa-completo", {});
                        $scope.seleccionadoLabel = "";
                        $scope.mostrarResultados = false;
                        $scope.seleccinoadoId = 0;
                        $scope.umaesRegion = [];
                        $scope.umaesRegion.length = 0;
                        $scope.umaeSeleccionado = "";
                }
            });
            
            $scope.consultaUmae = function(clave){
                $scope.responseMapa = { };
                if( $rootScope.mapa.umae[clave].acceso > 0 ){
                    consultasMapa("UMAE", "RESUMEN", clave);
                    $scope.umaeSeleccionado = clave+" "+$rootScope.mapa.umae[clave].label;
                    $scope.mostrarResultados = true;
                }else{
                    console.warn("No tiene acceso a esa selección");
                    $rootScope.genericModal = {
                        activo: true
                        , txtBody: "No tiene acceso a esa selección"
                        , txtHead: "Error"
                        , colorClass: "warning"
                    }
                }
            };
            
            // FunciÃ³n que realiza la consulta de detalle o resumen de regiones, delegaciones o umaes
            // @param: tipoSeleccion {string} tipo de selecciÃ³n en el mapa: ["REGION", "DELEGACION", "UMAE"]
            // @param: tipoConsulta {string} tipo de consulta a realizar: ["RESUMEN", "DETALLE"]
            // @param: id {string}
            var consultasMapa = function(tipoSeleccion, tipoConsulta, id){
                
                $scope.responseMapa = { };
                var urlConsulta = TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT] + TABLERO_CONSTANTS.URL.ESPACIAL[tipoSeleccion][tipoConsulta] + "/" + id ; 
                
                console.log("urlConsulta:", urlConsulta);
                $http({
                    method: "POST"
                    , url: urlConsulta
                    , data:{
                        token: ""
                    }
                }).then(function(response){
                    if(response.data == null || typeof response.data === "undefined"){
                        console.warn("No se han encontrado datos")
                    }else{
                        if(typeof response.data === "object"){
                            if( typeof response.data.acceso !== "undefined" && !response.data.acceso){
                                $rootScope.genericModal = {
                                    activo: true
                                    , txtBody: response.data.msj
                                    , txtHead: "Error"
                                    , colorClass: response.data.tp_msg
                                    
                                }
                            }else{
                                console.log("Response de consulta Mapa", response);
                                for(var dato in response.data){
                                    $scope.responseMapa[dato] = response.data[dato];
                                }
                              
                                for(var dataset in $scope.responseMapa){
                                    if( Object.keys($scope.responseMapa[dataset]).length == 2 ){
                                        var maxData; // <- guarda el dato mallor (total)
                                        var minData; // <- guarda el dato menor (porcentaje)
                                        var arraydata = [];  
                                        for(dato in $scope.responseMapa[dataset]){
                                            arraydata.push(Number($scope.responseMapa[dataset][dato]));
                                        }
                                        maxData = Math.max.apply(null,arraydata);
                                        minData = Math.min.apply(null,arraydata);
                                        $scope.responseMapa[dataset].porcentaje = ((minData / maxData) * 100).toFixed(1);
                                    }    
                                }
                            }
                        }else{
                            console.warn("No tiene permiso o ha expirado la sesiÃ³n");
                        }
                    }          
                }, function(){
                    console.warn(TABLERO_CONSTANTS.MSG.ERROR.CONEXION);
                });
            };
            
           // FunciÃ³n que response al cambio de tipo de selecciÃ³n (REGION, DELEGACIÃ?N o UMAE)
            $scope.cambiaTipoSeleccion = function(seleccionado){
                $scope.radioTipoSeleccion = seleccionado;
            };
            
            // FunciÃ³n que regresa el mapa a su modo inicial.
            $scope.mapaPais = function(){
                $scope.radioTipoSeleccion = "DELEGACION";
                $scope.$broadcast("mapa-completo", {});
                $scope.seleccionadoLabel = "";
                $scope.mostrarResultados = false;
                $scope.seleccinoadoId = 0;
            };
                
                
        // Indicadores ECP    
        }else if($location.path() === "/ed/indicadores"){
            
            
        }
         
         
         
        // Funciones para efecto de llegada de panel 
        $scope.panelClass = {
            fadeInLeftBig: true
            ,fadeOutLeftBig: false
            ,animated: true
        };
        
        //  Se ajusta el tamaÃ?Â±o del contenedor general
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