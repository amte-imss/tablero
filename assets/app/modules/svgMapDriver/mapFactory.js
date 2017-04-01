angular.module('svgMapModule')
        // La función de esta factoria es crear los objetos para el mapa usando como modelo las constantes pero generando objetos independientes en cada ocación
        .factory('mapDriverFactory', function(MAP_CONSTANTS){ 
            
            var cont = 0;
    
            return function(){    
                cont++;
                var mapObj = {
                    region:{}
                    , delegacion:{}
                    , umae:{}
                    // general el identificador para el elemento svg
                    ,get_id: function(){ 
                        return "svgMap"+cont;
                    }
                    // genera el identificador para el contenedor del svg
                    ,get_id_container: function(){
                        return "containerMap"+cont;
                    }
                    // Genera el identificador para el contenedor general (separa el select range)
                    ,get_id_container_dorective: function(){
                        return "containerParent"+cont;
                    }
                    // Asigna las regiones que llegan de la primera carga (login)
                    , set_regiones: function(regiones){
                        this.region = regiones;
                    }
                    // Asigna las unidades que llegan de pimera carga (login)
                    , set_umaes: function(umaes){
                        this.umae = umaes;
                    }
                    // Asigna los permisos y las regiones a las delegaciones como llegan en la primera carga.
                    , set_delegaciones_data: function(delegaciones_permisos){
                        for(var del in this.delegacion){
                            if(typeof delegaciones_permisos[del] !== "undefined"){
                                this.delegacion[del].region = delegaciones_permisos[del].region;
                                if(typeof delegaciones_permisos[del].label !== "undefined"){
                                    this.delegacion[del].label = delegaciones_permisos[del].label;
                                }
                                // Si se manda un estilo particular para una delegación se carga
                                if(typeof delegaciones_permisos[del].estilos !== "undefined"){
                                    this.delegacion[del].estilos = delegaciones_permisos[del].estilos;
                                }
                                // Se asignan permisos si viene de servidor en caso contraro se asigna "0"
                                this.delegacion[del].acceso = (typeof delegaciones_permisos[del].acceso !== "undefined" ? delegaciones_permisos[del].acceso : 0 );
                            }
                        }
                        this.set_delegaciones_color();
                    }
                     // Asigna los colores a las delegaciones según la región
                    , set_delegaciones_color: function(){
                        // Asigna gris a todas las delegaciones que no tengan color desde el paso anteior (solo por seguridad)
                        for(var item in this.delegacion){
                            if(this.delegacion[item].estilos.fill === null){
                                this.delegacion[item].estilos.fill = MAP_CONSTANTS.ESTILO_BASE.fill;
                            }
                        }
                        // Se asguna el color de la reguión a cada delegación
                        for( var del in this.delegacion){
                            if(this.delegacion[del].estilos.fill === MAP_CONSTANTS.ESTILO_BASE.fill){
                                this.delegacion[del].estilos.fill = ( typeof this.region[this.delegacion[del].region] !== "undefined" ? this.region[this.delegacion[del].region].estilos.fill : MAP_CONSTANTS.ESTILO_BASE.fill );
                            }
                            this.delegacion[del].estilos.opacity = MAP_CONSTANTS.ESTILO_BASE.opacity;
                        }
                    }
                };
                
                mapObj.delegacion = MAP_CONSTANTS.DELEGACION;

                return mapObj;
            }
        });
