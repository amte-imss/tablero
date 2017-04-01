<div ng-class="panelClass" class="row">
    <div class="col col-sm-12">
        <div class="panel panel-default imss-main-panel">
            <div class="panel-heading">
              <h3 class="panel-title">{{panelTitle}} : {{panelSubTitle}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-sm-12 col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <svg-map-driver tiposeleccion="radioTipoSeleccion"  ></svg-map-driver>
                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col col-sm-4 col-md-12">
                                    <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Filtros selección
                                    </div>
                                    <div class="panel-body">
                                        <div ng-show="radioSelecciones['REGION']" >
                                            <label for="rd3" class="switch-container dec"> &nbsp;&nbsp;Región
                                                <label class="switch" >
                                                    <input id="rd3" type="radio" ng-model="radioTipoSeleccion" value="REGION" name="rd-map-type-select">
                                                    <div class="slider round"></div>
                                                </label>
                                            </label>
                                        </div>
                                        <div ng-show="radioSelecciones['DELEGACION']">
                                            <label for="rd2" class="switch-container dec"> &nbsp;&nbsp;Delegación
                                                <label class="switch" >
                                                    <input id="rd2" type="radio" ng-model="radioTipoSeleccion" value="DELEGACION" name="rd-map-type-select">
                                                    <div class="slider round"></div>
                                                </label>
                                            </label>
                                        </div>
                                        <div ng-show="radioSelecciones['UMAES']">
                                            <label for="rd1" class="switch-container dec"> &nbsp;&nbsp;UMAE
                                                <label class="switch" >
                                                    <input id="rd1" type="radio" ng-model="radioTipoSeleccion" value="UMAE" name="rd-map-type-select">
                                                    <div class="slider round"></div>
                                                </label>
                                            </label>
                                        </div>
                                        <button class="btn btn-large btn-primary " ng-click="mapaPais();" >Reiniciar País</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="radioTipoSeleccion === 'UMAE' ">
                            <div class="col col-md-12 col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        &nbsp; {{seleccionadoLabel}}
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-group umaes-group">
                                            <li class="list-group-item" ng-repeat="umae in umaesRegion  | filter:{region: seleccionadoId}  track by $index" ng-click="consultaUmae(umae.clave)"  > 
                                                {{umae.label}} <span style="font-size: 1em">{{ umae.clave }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col col-sm-12 ">
                        <div class="panel panel-default" ng-if="mostrarResultados">
                            <div class="panel-heading">
                                    <span ng-if="umaeSeleccionado === '' " >Selección actual: {{seleccionadoLabel}}</span>
                                <span ng-if="umaeSeleccionado !== '' " >{{umaeSeleccionado}}</span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col  col-sm-12 col-md-4 indicadores-regionales" ng-repeat="(campo, valor) in responseMapa track by $index">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <h4>{{campo | labelsFilter }}</h4>
                                                <ul >
                                                    <li ng-repeat-start="(nombreDato, valorDato) in valor" ng-if="nombreDato !== 'porcentaje'">{{nombreDato | labelsFilter}} : <span class="label label-info">{{valorDato}}</span></li>
                                                    <li ng-repeat-end ng-if="nombreDato === 'porcentaje'"><uib-progressbar animate="false" value="valor.porcentaje" type="success"><b>{{valorDato}}%</b></uib-progressbar></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
      </div>       
    </div>
</div>