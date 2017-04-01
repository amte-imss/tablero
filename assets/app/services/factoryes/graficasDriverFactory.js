angular.module("tableroApp")
    .service("graficasDriverFactory", function($compile){
        var cont = 0;
        var grafObj = function(idContenedor, scope){
            this.idGrafica = "graf_"+cont;
            this.labels = [];
            this.series = [];
            this.data = [];
            this.backgroundColor = [];
//            this.tipoGraficaActual = 0;
//            this.datasetOverride = [
//                    {
//                      label: "Bar chart1",
//                      borderWidth: 1,
//                      type: 'bar'
//                    },
//                    {
//                      label: "Bar chart2",
//                      borderWidth: 1,
//                      type: 'bar'
//                    },
//                    {
//                      label: "Media",
//                      borderWidth: 3,
//                      hoverBackgroundColor: "rgba(255,0,132,0.4)",
//                      hoverBorderColor: "rgba(255,0,132,1)",
//                      type: 'line'
//                    }
//                  ];
            this.tiposGraficas = [ 
                 {"class": "chart-bar", "label": "Barras"}
//                , {"class": "chart-bar", "label": "Barras + linea media"}
                ,{ "class": "chart-line", "label": "Lineal"}
                , {"class": "chart-horizontal-bar", "label": "Barras Horizontal"}
//                , {"class": "chart-radar", "label": "Radar"}
            ];
            this.cambiaTipoGrafica = function(classTipo){
                $('iframe.chartjs-hidden-iframe').remove();
                $("#"+this.idGrafica).remove(); 
                var grafica = '<canvas id="'+this.idGrafica+'" ng-class="tipoGrafica" class="chart '+ classTipo + ' " '+
                                        'chart-labels="labels" '+
                                        'legend="true" '+
                                        'chart-series="series" '+
                                        'chart-colors="backgroundColor" '+
                                        'chart-data="data" '+
                                        'chart-options="options" '+
                                        '> '+
                                '</canvas>';
                var directive = angular.element(grafica);
                $compile(directive)(scope);
                $('#'+idContenedor).append(directive);
            };
            return this;
        };
        return grafObj;
    })
