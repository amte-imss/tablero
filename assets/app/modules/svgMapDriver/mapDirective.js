// Directiva con componenetes necesarios para presentar manejar Mapas SVG SVG de México, Regiones y Delegaciones
angular.module('svgMapModule', [])
    // Directiva para crear el componente de mapas SVG
    .directive('svgMapDriver', ["$rootScope", "TABLERO_CONSTANTS", "mapDriverFactory", "MAP_CONSTANTS","$timeout", "$document"
    , function($rootScope, TABLERO_CONSTANTS, mapDriverFactory, MAP_CONSTANTS, $timeout, $document){
        // Declaración de parámetros de directiva
        return {
            restict: "E"
            ,replace: false
            ,templateUrl: TABLERO_CONSTANTS.URL.BASE[TABLERO_CONSTANTS.ENVIRONMENT]+"/assets/app/modules/svgMapDriver/views/svgMapDriver.html"
            ,scope: {
                // Tipo de mapa a mostrar 
                // @acept: PAIS, REGION, DELEGACION, UMAE
                tipoSeleccion:"=tiposeleccion"
                // REGION, DELEGACIÓN o UMAE SELECCIONADA
                // @acept: id de región, delegación o umae
                , seleccionActual:"=seleccionactual"
                // Determina si el mapa tendrá interación al click
                // @acept: boolean
                , interactive: "="
                // Pinta el mapa de color gris
                // @acept: boolean
                , mapaGris: "=mapagris"
            }
            // Función controlador de la directiva
            ,link: function(scope, element, attr){
                var gris;
                gris = ( typeof scope.mapaGris === 'undefined' ? false : scope.mapaGris );
                var interactive;
                interactive = ( typeof scope.interactive === 'undefined' ? true : scope.interactive );
                
                // Se crea un objeto manejador de los arreglos del mapa
                scope.map = {};
                scope.seleccionHover = "";
                scope.zoomM = 1;
                scope.zoom_disabled = false;
                scope.map = mapDriverFactory();
                scope.id = scope.map.get_id();
                scope.idContainerMap = scope.map.get_id_container();
                scope.idContainerDirective = scope.map.get_id_container_dorective();
                scope.map.set_regiones($rootScope.mapa.region);
                scope.map.set_delegaciones_data($rootScope.mapa.delegacion);
                
                // Checar optimización hacer este proceso mediante bindeo de funciones "&"
                scope.$on("mapa-completo", function(event, data){
//                    scope.tipoSeleccion = "PAIS";
                    scope.seleccionGeo("");
                    scope.zoomM = 1;
                    scope.zoom_disabled = false;
                });
                
                scope.$watch("zoomM", function(oldValue, newValue){
                    if(oldValue !== newValue){
                        var contenedor = document.getElementById(scope.idContainerMap)
                        contenedor.style.transform = "scale("+scope.zoomM+")";
                            contenedor.style.top = "-"+( (scope.zoomM-1) * 27)+"%"
                            contenedor.style.left = "-"+( (scope.zoomM-1) * 10)+"%"
                    }
                });
                
                // Función de click en alguno de poligonos SVG
                scope.svgClick = function(event){
                    if(interactive){
                        scope.zoomM = 1;
                        var seleccionadoId = "0";
                        var seleccionadoLabel = "";
                        scope.zoom_disabled = true;
                        if(scope.tipoSeleccion === "REGION"){
                            if( scope.map.region[scope.map.delegacion[event.delegateTarget.id].region].acceso > 0 ){
                                seleccionadoId = scope.map.delegacion[event.delegateTarget.id].region;
                                seleccionadoLabel = scope.map.region[scope.map.delegacion[event.delegateTarget.id].region].label;
                            }else{
                                console.warn("No tiene acceso a esa selección");
                                $rootScope.genericModal = {
                                    activo: true
                                    , txtBody: "No tiene acceso a esa selección"
                                    , txtHead: "Error"
                                    , colorClass: "warning"
                                }
                            }
                        }else if(scope.tipoSeleccion === "DELEGACION"){
                            if(scope.map.delegacion[event.delegateTarget.id].acceso  > 0){
                                seleccionadoId = event.delegateTarget.id;
                                seleccionadoLabel = scope.map.delegacion[event.delegateTarget.id].label;
                            }else{
                                console.warn("No tiene acceso a esa selección");
                                $rootScope.genericModal = {
                                    activo: true
                                    , txtBody: "No tiene acceso a esa selección"
                                    , txtHead: "Error"
                                    , colorClass: "warning"
                                }
                            }
                        }else if(scope.tipoSeleccion === "UMAE"){
                            seleccionadoId = scope.map.delegacion[event.delegateTarget.id].region;
                            seleccionadoLabel = "UMAES " + scope.map.region[scope.map.delegacion[event.delegateTarget.id].region].label;
                        }
                        scope.seleccionGeo(event.delegateTarget.id);
                        scope.$emit('map-selection', {seleccionadoId: seleccionadoId, seleccionadoLabel: seleccionadoLabel });
                    }
                };
                
                // Función que determina si se centrará un poligono o grupo de poligonos, o si se mostrará todo el mapa
                // (Delegaciones, Regiones o mapa)
                // @param: idPoligono {opcional string} id del poligono a centrar, opcional si se muestra todo el país.
                scope.seleccionGeo = function(idPoligono){
                    if(idPoligono === ""){
                        scope.centraPoligonos("", true);
                        $timeout(function(){
                            scope.ocultaPoligonos("", false);
                        }, 100);
                    }else{
                        if(scope.tipoSeleccion === "DELEGACION"){
                            scope.ocultaPoligonos(idPoligono, false);
                            // Si se seleccionó un poligono correspondiente a CDMX se centra en toda la cuidad
                            if(idPoligono == 35 || idPoligono == 36 || idPoligono == 37 || idPoligono == 38 ){
                                idPoligono = ["35", "36", "37", "38"];
                            }else 
                            // Si se selecciona un poligono del Edo Mex. se centra en todo el estado    
                            if(idPoligono == 15 || idPoligono == 16){
                                idPoligono = ["15", "16"];
                            }else
                            // Si se selecciona un poligono del Ver. se centra en todo el estado    
                            if(idPoligono == 31 || idPoligono == 32){
                                idPoligono = ["31", "32"];
                            }
                            scope.centraPoligonos(idPoligono);
                        }else if(scope.tipoSeleccion === "REGION" || scope.tipoSeleccion === "UMAE" ){
                            var delegacionesRegion = []; 
                            for(delegacion in scope.map.delegacion){
                                if(scope.map.delegacion[delegacion].region == scope.map.delegacion[idPoligono].region) delegacionesRegion.push(delegacion);
                            }
                            scope.centraPoligonos(delegacionesRegion);
                            $timeout(function(){
                                scope.ocultaPoligonos(delegacionesRegion, false);
                            }, 100);
                        }
                    }
                };
                
                // Función que oculta un polígono o grupo de estos
                // @param idPligono [string|string array] id del poligono a seleccionar o arreglos de id's de poligonos, si se manda un array 
                // @param directo [boolean] indicador que dice si se oculta el polígono indicado o todos los demás eceptro el indicado
                // Si se recibe en idPoligono un array vacio "" y en directo false se muestran de nuevo todos los poligonos
                scope.ocultaPoligonos = function(idPoligono, directo){
                    if(Array.isArray( idPoligono) ){
                        // Ocultar todos los poligonos en el arreglo
                        if(directo){
                            for(poligono in idPoligono){
                                scope.mostrarColor(scope.map.delegacion[idPoligono[poligono]], "gris");
                            }
                        // Ocultar todos los poligonos que no están en el arreglo    
                        }else{
                            for(delegacion in scope.map.delegacion){
                                var encontrado;
                                encontrado = false;
                                for(poligono in idPoligono){
                                    if(delegacion === idPoligono[poligono]) encontrado = true;
                                }
                                if(encontrado){
                                    scope.mostrarColor(scope.map.delegacion[delegacion], "color");
                                }else{
                                    scope.mostrarColor(scope.map.delegacion[delegacion], "gris");
                                }
                            }
                        }
                    }else if (typeof idPoligono === "string"){
                        // Cuando "directo" es true, se oculta ese elemento seleccionado.
                        if(directo){
                            scope.mostrarColor(scope.map.delegacion[delegacion], "gris");
                        }
                        // Cuando "directo" es false, se ocultan los demás elementos.
                        else{
                            // Muestra todos en color
                            if(idPoligono === ""){
                                for(delegacion in scope.map.delegacion){
                                    scope.mostrarColor(scope.map.delegacion[delegacion], "color");
                                }
                            // Muestra en gris todos excepto el seleccinado    
                            }else{
                                for(delegacion in scope.map.delegacion){
                                    if(delegacion !== idPoligono){ 
                                        scope.mostrarColor(scope.map.delegacion[delegacion], "gris");
                                    }else{
                                        scope.mostrarColor(scope.map.delegacion[delegacion], "color");
                                    }
                                }
                            }
                        }
                    }
                };
                
                // Función que puede colocar el color a un poligono (según la region), colocarle color gris u ocultarlo (display: none|block)
                // @param object [objeto] objeto al cual se le aplicará el cambio de color o display
                // @param opcion [string] {"color", "gris", "none", "block"} cadena que indica si se coloca color, gris, o display
                scope.mostrarColor = function(object, opcion){
                    switch(opcion){
                        case "color":
                            if(typeof scope.map.region[object.region] === "undefined" ){
                                if(object.estilos.fill === null){
                                   object.estilos.fill = MAP_CONSTANTS.ESTILO_BASE.fill;
                                }
                            }else{
                                object.estilos.fill = scope.map.region[object.region].estilos.fill;
                            }
                            object.estilos.display = "block";
                        break;
                        case "gris":
                            object.estilos.fill = MAP_CONSTANTS.ESTILO_BASE.fill;
                            object.estilos.display = "block";
                        break;
                        case "block":
                            object.estilos.display = "block";
                        break;
                        case "none":
                            object.estilos.display = "none";
                        break;
                    }
                }
                
                // Función que centra un poligono o grupo de poligonos (regiones o delegaciones)
                // @param: idPoligono [string|string array], id la delefación o arreglo con los id´s de las delegaciones a centrar
                // @param: mapaCompleto {opcional boolean}, en caso de ser true regresa a mostrar el mapa completo
                scope.centraPoligonos = function(idPoligono, mapaCompleto){
                    var mapaSvg = document.getElementById(scope.id);
                    if(typeof mapaCompleto === "boolean" && mapaCompleto){
                        mapaSvg.setAttribute("viewBox", "0 0 739.463 526.473");
                        return; 
                    }
                    var puntos = {};
                    puntos = minMaxPoligonArray(idPoligono);
                    
                    var tamX = puntos.maxX - puntos.minX;
                    var tamY = puntos.maxY - puntos.minY;
                    mapaSvg.setAttribute("viewBox", puntos.minX+" "+puntos.minY+" "+tamX+" "+tamY);
                };
                
                // Función que debuelve los valores minimos y maximos de los puntos del o los poligonos entregados 
                // (Una delegación o una región)
                function minMaxPoligonArray(poligonos){
                    var puntos = {
                        minX: 0
                        , maxX: 0
                        , minY: 0
                        , maxY: 0
                    }
                    // Es un solo poligono (Delegación) 
                    // Obitne los puntos mayores y menores del poligono indicado
                    if(typeof poligonos === "string"){
                        var poligono = document.getElementById(poligonos);
                        var arrayX = [];
                        var arrayY = [];
                        if(poligono !== null){
                            for(var i=0; i < poligono.points.numberOfItems; i++ ){
                                arrayX.push(poligono.points.getItem(i).x);
                                arrayY.push(poligono.points.getItem(i).y);
                            }   
                            puntos.minX = Math.min.apply(null, arrayX);
                            puntos.maxX = Math.max.apply(null, arrayX);
                            puntos.minY = Math.min.apply(null, arrayY);
                            puntos.maxY = Math.max.apply(null, arrayY);
                        }else{
                            puntos.minX = 1000000;
                            puntos.maxX = 0;
                            puntos.minY = 1000000;
                            puntos.maxY = 0;
                        }
                    }
                    // Es un array de poligonos (Región)
                    // Obtiene los puntos de cada poligono y resume a los puntos mayores y menores totales
                    else if(Array.isArray(poligonos)){
                        var puntosGrupo = {
                            minX:[]
                            , maxX: []
                            , minY: []
                            , maxY: []
                        };
                        for(x in poligonos){
                            var resultados = minMaxPoligonArray(poligonos[x]);
                            puntosGrupo.minX.push(resultados.minX);
                            puntosGrupo.maxX.push(resultados.maxX);
                            puntosGrupo.minY.push(resultados.minY);
                            puntosGrupo.maxY.push(resultados.maxY);
                        }
                        puntos.minX = Math.min.apply(null, puntosGrupo.minX);
                        puntos.minY = Math.min.apply(null, puntosGrupo.minY);
                        puntos.maxX = Math.max.apply(null, puntosGrupo.maxX);
                        puntos.maxY = Math.max.apply(null, puntosGrupo.maxY);
                    }
                    return puntos;
                };
                
                // Función que marca las selecciones  onHover
                scope.opacoHover = function(event){
                    if(scope.tipoSeleccion === "PAIS" || scope.tipoSeleccion === "DELEGACION"){
                        if(scope.map.delegacion[event.delegateTarget.id].estilos.fill !== MAP_CONSTANTS.ESTILO_BASE.fill ){
                            scope.map.delegacion[event.delegateTarget.id].estilos.opacity = "1";
                        }
                        scope.seleccionHover = scope.map.delegacion[event.delegateTarget.id].label;
                    }else if(scope.tipoSeleccion === "REGION" || scope.tipoSeleccion === "UMAE"){
                        for(var delegacion in scope.map.delegacion){
                            if(scope.map.delegacion[delegacion].region == scope.map.delegacion[event.delegateTarget.id].region && scope.map.delegacion[delegacion].estilos.fill !== MAP_CONSTANTS.ESTILO_BASE.fill ){
                                scope.map.delegacion[delegacion].estilos.opacity = "1"; 
                                scope.seleccionHover = scope.map.region[scope.map.delegacion[delegacion].region].label;
//                                $(".map-tooltip").css("visivility": "show")
                            }   
                        }
                    }
                };
                
                // Función que desmarca las funciones al salir del onHover
                scope.opacoLeave = function(event){
                    scope.seleccionHover = "";
                    if(scope.tipoSeleccion === "PAIS" || scope.tipoSeleccion === "DELEGACION"){
                        scope.map.delegacion[event.delegateTarget.id].estilos.opacity = MAP_CONSTANTS.ESTILO_BASE.opacity;
                    }else if(scope.tipoSeleccion === "REGION" || scope.tipoSeleccion === "UMAE"){
                        for(delegacion in scope.map.delegacion){
                            if(scope.map.delegacion[delegacion].region == scope.map.delegacion[event.delegateTarget.id].region) scope.map.delegacion[delegacion].estilos.opacity = MAP_CONSTANTS.ESTILO_BASE.opacity; 
                        }
                    }
                };
                
                // Función de apollo para definir color de poligonos
                scope.cambiaCss = function(delegacion){
                    if(gris){
                        return {
                            "fill": "#cccccc"
                            , "opacity": "1"
                        }
                    }else{
                        return scope.map.delegacion[delegacion].estilos;
                    }
                };
                
                ;(function(){
                    $timeout(function(){
                        
                        var contendorDirectiva = $("#" + scope.idContainerDirective);
                        var contenedorMapa = $("#" + scope.idContainerMap);
                        var svg = $("#"+scope.id);
                        
                        contenedorMapa.css("max-height", contenedorMapa.height() );
                        svg.css("max-height", svg.height() );
                        contenedorMapa.css("min-height", contenedorMapa.height() );
                        svg.css("min-height", svg.height() );
                        contenedorMapa.css("max-width", contenedorMapa.width() );
                        svg.css("max-width", svg.width() );
                        contenedorMapa.css("min-width", contenedorMapa.width() );
                        svg.css("min-width", svg.width() );
                        
                        contendorDirectiva.css("width", contendorDirectiva.width() );
                        contendorDirectiva.css("height", contendorDirectiva.height() );
                        
                    }, 500);
                })();
            }
        }
    }]);