<?php
// Solución para evitar el error de session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solución para el error de timezone
date_default_timezone_set('America/Mexico_City');

if ($_SESSION['nombre'] != "" && $_SESSION['tipo'] == "admin") {
    if (isset($_POST['user_reg']) && isset($_POST['clave_reg']) && isset($_POST['nom_complete_reg'])) {
        $nombre_reg = MysqlQuery::RequestPost('nom_complete_reg');
        $user_reg = MysqlQuery::RequestPost('user_reg');
        $clave_reg = md5(MysqlQuery::RequestPost('clave_reg'));
        $clave_reg2 = MysqlQuery::RequestPost('clave_reg');
        $email_reg = MysqlQuery::RequestPost('email_reg');

        $asunto = "Registro de cuenta en CEAA";
        $cabecera = "From: Daniel Lopez Vega <daniel.lopez@hidalgo.gob.mx>";
        $mensaje_mail = "Hola " . $nombre_reg . ", Gracias por registrarte en CEAA El Salvador. Los datos de cuenta son los siguientes:\nNombre Completo: " . $nombre_reg . "\nNombre de usuario: " . $user_reg . "\nClave: " . $clave_reg2 . "\nEmail: " . $email_reg . "\n Página principal: http://ceaa.hidalgo.gob.mx/";

        if (MysqlQuery::Guardar("usuario", "nombre_completo, nombre_usuario, email_usuario, clave", "'$nombre_reg', '$user_reg', '$email_reg', '$clave_reg'")) {
            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">REGISTRO EXITOSO</h4>
                    <p class="text-center">
                        Cuenta creada exitosamente, ahora puedes iniciar sesión, ya eres usuario de CEAA.
                    </p>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        ERROR AL REGISTRARSE: Por favor intente nuevamente.
                    </p>
                </div>
            ';
        }
    }
?>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <div class="panel panel-success">
        <div class="panel-heading text-center"><strong>Para poder registrarte debes de llenar todos los campos de este formulario</strong></div>
        <div class="panel-body">
            <form role="form" action="" method="POST">
            <div class="form-group">
              <label><i class="fa fa-male"></i>&nbsp;Nombre completo</label>
              <input type="text" class="form-control" name="nom_complete_reg" placeholder="Nombre completo" required="" pattern="[a-zA-Z ]{1,40}" title="Nombre Apellido" maxlength="40">
            </div>
            <div class="form-group has-success has-feedback">
              <label class="control-label"><i class="fa fa-user"></i>&nbsp;Nombre de usuario</label>
              <input type="text" id="input_user" class="form-control" name="user_reg" placeholder="Nombre de usuario" required="" pattern="[a-zA-Z0-9]{1,15}" title="Ejemplo7 maximo 15 caracteres" maxlength="20">
              <div id="com_form"></div>
            </div>
            <div class="form-group">
              <label><i class="fa fa-key"></i>&nbsp;Contraseña</label>
              <input type="password" class="form-control" name="clave_reg" placeholder="Contraseña" required="">
            </div>
            <div class="form-group">
              <label><i class="fa fa-envelope"></i>&nbsp;Email</label>
              <input type="email" class="form-control"  name="email_reg"  placeholder="Escriba su email" required="">
            </div>
            <button type="submit" class="btn btn-danger">Crear cuenta</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-sm-4 text-center hidden-xs">
      <img src="img/ceaalogo.png" class="img-responsive" alt="Image">
    </div>

  </div>
</div>

<script>
    $(document).ready(function(){
        $("#input_user").keyup(function(){
            $.ajax({
                url:"./process/val.php?id="+$(this).val(),
                success:function(data){
                    $("#com_form").html(data);
                }
            });
        });
    });
</script>

<?php
} else {
    // Manejo del caso en el que no es administrador o no hay sesión activa
    echo 'No tienes permiso para ver esta página.';
}
?>
