angular.module('svgMapModule')
        // Valores constantes para los objetos mapa que se instancian
        .constant('MAP_CONSTANTS', {
            // Estilos base
           ESTILO_BASE: {
               opacity: "0.75"
               , fill: "#cccccc"
               ,display: "block"
           }
           // Valores iniciales de las delegaciones
           ,DELEGACION: {
               "03": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Baja California Sur"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "02": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label : "Baja California"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "27": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Sonora"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "08": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Chihuahua"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "06": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Colima"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "20": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Nuevo León"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "29": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Tamaulipas"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "25": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "San Luis Potosí"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "34": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Zacatecas"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "10": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Durango"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "26": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Sinaloa"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "19": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Nayarit"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "11": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Guanajuato"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "01": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Aguascalientes"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "14": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Jalisco"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "05": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Coahuila"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "31": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Veracruz Norte"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "32": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Veracruz Sur"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "35": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Ciudad de México Norte 1"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "36": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Ciudad de México Norte 2"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "37": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Ciudad de México Sur 1"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "38": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Ciudad de México Sur 2"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "15": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Estado de México OTE"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "16": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Estado de México PTE"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "18": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Morelos"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "30": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Tlaxcala"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "24": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Quintana Roo"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "13": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Hidalgo"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "23": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Querétaro"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "33": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Yucatán"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "04": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Campeche"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "07": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Chiapas"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "28": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Tabasco"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "21": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Oaxaca"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "12": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Guerrero"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "22": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Puebla"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              },
              "17": {
                region: null
                , mostrar: true
                , acceso: 0
                ,label: "Michoacán"
                ,estilos: {
                    fill: null
                    ,display: "block"
                    ,opacity: "0.75"
                }
              }
           }
        });       