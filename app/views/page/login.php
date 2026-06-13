<div class="limiter">
    <div class="login-page">
        <div class="login-box">
            <div class="logo">
                <!-- <img src="public/img/logo/2.png"> -->
            </div>
            <div class="card">
                <div class="body">
                    <!-- <div class="logo1"></div>
                    <div class="logo2"></div> -->
                    <form id="sign_in" method="POST">
                        <div class="msg">Iniciar Sesión</div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password"  id="password" placeholder="Password" required>
                            </div>
                            <span class="input-group-addon">
                                <div class="switch">
                                    <label>  <input type="checkbox" id="mostrar2"><span class="lever switch-col-blue"></span>Mostrar</label>
                                </div>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-block bg-success waves-effect waves-light pull-right" type="button" id="Ingresar" >Ingresar</button>
                            </div>
                        </div>
                        <div class="row m-t-15 m-b--20">
                            <div class="col-xs-12 align-left">
                                <i class="material-icons">help</i><a href="#">¿Olvidó su Contraseña?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>    
</div> 
<script src="resources/library/plugins/jquery/jquery.min.js"></script>
<script src="public/js/login.js"></script>