<div ng-class="panelClass" class="row" >
    <div class="col col-xs-12">
        <div class="panel panel-default imss-main-panel">
            <div class="panel-heading">
              <h1 class="panel-title">{{panelTitle}} : {{panelSubTitle}}</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="x_panel panel">
                            <div class="x_title panel-heading">
                              <h2>Parametros para comparativa </h2>
                              <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                 <li><a ><i class="fa fa-question-circle"></i></a>
                                </li>
                              </ul>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content panel-body">
                                <div class="row p-relative">
                                    <div class="col col-xs-12 col-md-3">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                Nivel de comparación:
                                                <br>
                                                <select  class="margin-top" ng-model="tipoSeleccionado"
                                                        ng-options="option.label for option in tipoSeleccion track by option.id "
                                                        ng-change="seleccionTipoComarativa()"
                                                >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                Año:
                                                <br>
                                                <select class="margin-top" ng-model="annioSeleccinoado" >
                                                    <option ng-repeat="item in annios  | orderBy:'-'" value="{{item}}" >{{item}}</option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col col-xs-12 col-md-9" ng-if="mostrarComparadores">
                                        <div class="row margin-top" ng-if="tipoSeleccionado.label === 'UNIDAD' ">
                                            <div class="col-xs-12">
                                                COMPARAR
                                                <input style="margin-top: 15px" type="text" placeholder="ESCRIBA SU SELECCIÓN" ng-model="comparadores[0]" uib-typeahead="compara as compara.label for compara in selecciones[tipoSeleccionado.id] | filter:{label:$viewValue} " typeahead-min-length="4" ng-blur="validaUnidad(0)" >
                                                CON
                                                <input style="margin-top: 15px" type="text" placeholder="ESCRIBA SU SELECCIÓN" ng-model="comparadores[1]" uib-typeahead="compara as compara.label for compara in selecciones[tipoSeleccionado.id] | filter:{label:$viewValue} " typeahead-min-length="4" ng-blur="validaUnidad(1)" >
                                            </div>
                                        </div>
                                        <div class="row margin-top" ng-if="tipoSeleccionado.label !== 'UNIDAD' ">
                                            <div class="col-xs-12">
                                                COMPARAR
                                                <select ng-model="comparadores[0]"
                                                        ng-options="option.label for option in selecciones[tipoSeleccionado.id] "
                                                        ng-change="selectComparador(0)"
                                                    >    
                                                </select>
                                                <span> CON </span>
                                                <select ng-model="comparadores[1]"
                                                            ng-options="option.label for option in selecciones[tipoSeleccionado.id] "
                                                            ng-change="selectComparador(1)"
                                                    >    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <br>
                                            <div class="col col-xs-12 col-md-6 " ng-repeat="(nombre, valor) in $root.comparativas[tipoSeleccionado.label]">
                                                {{nombre | labelsFilter }}:
                                                <br>
                                                <select ng-model="comparativas[$index]">
                                                    <option ng-repeat="item in valor" value="{{item}}" >{{item | labelsFilter }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-xs-1 p-absolute botom-right" ng-if="mostrarComparadores">
                                        <button class="btn btn-success float-right" ng-disabled="false" ng-click="comparar()">Comparar</button>
                                    </div>
                            </div>
                          </div>
                    </div>
                </div>
<!--                <div class="row">
                    <div class="col col-xs-12">  
                        <div class="x_panel panel" ng-if="muestraPanelGrafica">
                            <div class="x_content panel-body">
                                <p> <span ng-repeat-start="comp in comparadores">{{tipoSeleccionado.label}} {{ comp.label  | uppercase }}</span>
                                        <span ng-repeat-end ng-if="!$last" > CON </span>
                                </p>
                                <p>A&Ntilde;O {{annioSeleccinoado}}</p>
                                <p ng-repeat="(nombre, valor) in $root.comparativas[tipoSeleccionado.label]">
                                    <span  >{{nombre | labelsFilter | uppercase}} {{comparativas[$index] | labelsFilter  | uppercase}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col col-xs-12">
                         <div class="x_panel panel" ng-if="muestraPanelGrafica">
                            <div class="x_title panel-heading">
                                <h2>GR&Aacute;FICA </h2>              
                                <ul class="nav navbar-right panel_toolbox">
                                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                  <li class="dropdown">
                                    <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                      <li ng-repeat="tipo in tiposGraficas" ng-click="cambiaTipoGrafica($index)">
                                          <a>{{tipo.label}}</a>
                                      </li>
                                    </ul>
                                  </li>
                                  <li>
                                      <a ng-click="printPdf()">
                                          <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                      </a>
                                  </li>
                                </ul>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content panel-body">
                                <div id="graficaContainer">

                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div class="col col-xs-12">
                        
                         <div class="x_panel panel" ng-if="muestraPanelGrafica">
                         <!--<div class="x_panel panel" >-->
                            <div class="x_title panel-heading">
                              <h2>Tabla </h2>
                              <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li>
                                    
                                    <a ng-click="printExcel()">
                                        <i class="fa fa-file-excel-o" ></i>
                                    </a>
                                    <form id="formGetExcel" method="post" style="display: none">
                                        <input type="text" name="año" ng-model="annioSeleccinoado">
                                        <input ng-repeat="(nombre, valor) in $root.comparativas[tipoSeleccionado.label]" type="text" name="{{nombre}}" ng-model="dataSend[nombre]">
                                        <input type="text" name="series_nombres" ng-model="series">s
                                        <input type="text" name="series" ng-model="dataSend.series">
                                    </form>
                                </li>
                              </ul>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content panel-body">
                                <div class="table-container-fluid" style="width: 100%; overflow-x: scroll">
                                    <table id="tablaGenerada" class="table table-bordered table-hover table-responsive">
                                        <thead >
                                            <tr>
                                                <td>#</td>
                                                <td ng-repeat="title in labels">{{title}}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="serie in series" >
                                                <td ng-init="lugar = $index" >{{serie}}</td>
                                                <td ng-repeat="d in data[lugar] track by $index"  >{{d}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>