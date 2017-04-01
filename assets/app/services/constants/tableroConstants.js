// Configuración de la aplicación
angular.module('tableroApp')
    .constant("TABLERO_CONSTANTS", {
        // constante para configurar el ambiente en el que se encuentra
        ENVIRONMENT: "DESARROLLO_LOCAL2" // <- DESARROLLO_LOCAL(1,2) | DESAROLLO_GRUPO | PRODUCCION | TESTING
        ,URL: {
            BASE: {
                 DESARROLLO_LOCAL1: "http://localhost/tablero_control_back_local/"
                ,DESARROLLO_LOCAL2: configApp.url_base
                ,DESAROLLO_GRUPO: "http://11.32.41.86/tablero/tablero/control/"
                ,TESTING: ""
                ,PRODUCCION: ""
            }
            ,LOGIN: "index.php/sesion/"
            ,EXIT: "index.php/sesion/cerrar_sesion"
            ,ESPACIAL: {
                REGION: {
                    DETALLE: "index.php/region/detalle"
                    , RESUMEN: "index.php/region/resumen"
                    , ACCESO: "index.php/region/acceso"
                    , COMPARATIVA: "index.php/region/comparativa"
                    , SERVICIO_COMPARATIVA: "index.php/region/servicio_comparativa"
                }
                ,DELEGACION: {
                    DETALLE: "index.php/delegacion/detalle"
                    , RESUMEN: "index.php/delegacion/resumen"
                    , ACCESO: "index.php/delegacion/acceso"
                    , COMPARATIVA: "index.php/delegacion/comparativa"
                    , SERVICIO_COMPARATIVA: "index.php/delegacion/servicio_comparativa"
                }
                ,UMAE: {
                    DETALLE: "index.php/umae/detalle"
                    , RESUMEN: "index.php/umae/resumen"
                    , ACCESO: "index.php/umae/acceso"
                    , COMPARATIVA: "index.php/umae/comparativa"
                    , SERVICIO_COMPARATIVA: "index.php/umae/servicio_comparativa"
                }
                ,UNIDAD: {
                    DETALLE: "index.php/unidad/detalle"
                    , RESUMEN: "index.php/unidad/resume"
                    , ACCESO: "index.php/unidad/acceso"
                    , COMPARATIVA: "index.php/unidad/comparativa"
                    , SERVICIO_COMPARATIVA: "index.php/unidad/servicio_comparativa"
                }
            }
        }
        ,MSG: {
            ERROR: {
                CONEXION: "No se ha podido realizar la conexión"
            }
        }
    });