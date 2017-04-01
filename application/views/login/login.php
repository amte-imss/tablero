<div class="login-form-container">
    <header class="header-login">
        <img src="assets/img/header/logos3.png" alt="">
    </header>
    <div class="row">
        <div class="col col-sm-8 col-sm-push-2">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h2>Acceso al sistema de reportes IMSS</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">Usuario: <span class="required">*</span>
                        </label>
                        <div class="col-md-7">
                          <input ng-model="userName" type="text" id="first-name2" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3" for="last-name">Password: <span class="required">*</span>
                        </label>
                        <div class="col-md-7">
                          <input ng-model="password" type="password" id="last-name2" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-3 col-md-push-3">
                          <button ng-click="accesoLogin()" type="submit" class="btn btn-warning"> Entrar </button> 
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            
</div>
