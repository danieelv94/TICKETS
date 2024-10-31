<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo inicia la sesión si no hay ninguna activa
}

if (!empty($_SESSION['nombre']) && !empty($_SESSION['tipo'])) { 

    // Script para eliminar cuenta
    if (isset($_POST['usuario_delete']) && isset($_POST['clave_delete'])) {
        $usuario_delete = MysqlQuery::RequestPost('usuario_delete');
        $clave_delete = md5(MysqlQuery::RequestPost('clave_delete'));

        $sql = Mysql::consulta("SELECT * FROM usuario WHERE nombre_usuario= '$usuario_delete' AND clave='$clave_delete'");

        if (mysqli_num_rows($sql) >= 1) {
            MysqlQuery::Eliminar("usuario", "nombre_usuario='$usuario_delete' and clave='$clave_delete'");
            echo '<script type="text/javascript"> window.location="eliminar.php"; </script>';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">No hemos podido eliminar la cuenta porque los datos son incorrectos</p>
                </div>
            '; 
        }
    }

    // Script para actualizar datos de cuenta
    if (isset($_POST['name_complete_update'], $_POST['old_user_update'], $_POST['new_user_update'], $_POST['old_pass_update'], $_POST['new_pass_update'])) {
        $nombre_complete_update = MysqlQuery::RequestPost('name_complete_update');
        $old_user_update = MysqlQuery::RequestPost('old_user_update');
        $new_user_update = MysqlQuery::RequestPost('new_user_update');
        $old_pass_update = md5(MysqlQuery::RequestPost('old_pass_update'));
        $new_pass_update = md5(MysqlQuery::RequestPost('new_pass_update'));
        $email_update = MysqlQuery::RequestPost('email_update');

        $sql = Mysql::consulta("SELECT * FROM usuario WHERE nombre_usuario= '$old_user_update' AND clave='$old_pass_update'");
        
        // Verificar si se encontró el usuario
        if (mysqli_num_rows($sql) >= 1) {
            // Actualizar los datos del usuario
            $result = MysqlQuery::Actualizar("usuario", "nombre_completo='$nombre_complete_update', nombre_usuario='$new_user_update', email_usuario='$email_update', clave='$new_pass_update'", "nombre_usuario='$old_user_update' and clave='$old_pass_update'");

            if ($result) {
                $_SESSION['nombre'] = $new_user_update; // Actualiza la sesión
                $_SESSION['clave'] = $new_pass_update;

                echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">ÉXITO</h4>
                    <p class="text-center">Cambios realizados correctamente.</p>
                </div>
                ';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">No se pudo actualizar la cuenta. Por favor, intente nuevamente.</p>
                </div>';
            }
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                <p class="text-center">Asegúrese que los datos ingresados son válidos. Por favor intente nuevamente.</p>
            </div>';
        }
    }
?>

<div class="container">
    <div class="row well">
        <div class="col-sm-3">
            <img src="img/settings.png" alt="Image" class="img-responsive">
        </div>
        <div class="col-sm-9 lead">
            <h2 class="text-info">Bienvenido a la configuración de cuenta CEAA</h2>
            <p>Puedes <strong>actualizar los datos</strong> de tu cuenta ó puedes <strong>eliminar tu cuenta</strong> permanentemente si ya no deseas ser usuario de CEAA</p>
        </div>
    </div><!--Fin row well-->
    
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-info">
                <div class="panel-heading text-center"><i class="fa fa-retweet"></i>&nbsp;&nbsp;<strong>Actualizar datos de cuenta</strong></div>
                <div class="panel-body">
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label class="text-primary"><i class="fa fa-male"></i>&nbsp;&nbsp;Nombre completo</label>
                            <input type="text" class="form-control" placeholder="Nombre completo" name="name_complete_update" required="" pattern="[a-zA-Z ]{1,40}" title="Nombre Apellido" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label class="text-danger"><i class="fa fa-user"></i>&nbsp;&nbsp;Nombre de usuario actual</label>
                            <input type="text" class="form-control" placeholder="Nombre de usuario actual" name="old_user_update" required="" pattern="[a-zA-Z0-9 ]{1,30}" title="Ejemplo7" maxlength="20">
                        </div>
                        <div class="form-group  has-success has-feedback">
                            <label class="text-primary"><i class="fa fa-user"></i>&nbsp;&nbsp;Nombre de usuario nuevo</label>
                            <input type="text" class="form-control" id="input_user" placeholder="Nombre de usuario nuevo" name="new_user_update" required="" pattern="[a-zA-Z0-9 ]{1,30}" title="Ejemplo7" maxlength="20">
                            <div id="com_form"></div>
                        </div>
                        <div class="form-group">
                            <label class="text-danger"><i class="fa fa-key"></i>&nbsp;&nbsp;Contraseña actual</label>
                            <input type="password" class="form-control" placeholder="Contraseña actual" name="old_pass_update" required="">
                        </div>
                        <div class="form-group">
                            <label class="text-primary"><i class="fa fa-unlock-alt"></i>&nbsp;&nbsp;Contraseña nueva</label>
                            <input type="password" class="form-control" placeholder="Nueva Contraseña" name="new_pass_update" required="">
                        </div>
                        <div class="form-group">
                            <label class="text-primary"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Email</label>
                            <input type="email" class="form-control"  placeholder="Escriba su email" name="email_update" required="">
                        </div>
                        <button type="submit" class="btn btn-info">Actualizar datos</button>
                    </form>
                </div>
            </div>
        </div><!--Fin col 8-->
        <div class="col-sm-4 text-center well">
            <br><br><br><br><br><br><br><br>
            <img src="img/delete_user.png" alt="Image"><br><br><br>
            <button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm">Eliminar cuenta</button>
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center text-danger" id="myModalLabel">Confirmación</h4>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <p class="text-center">Por favor confirma que deseas eliminar tu cuenta</p>
                                <div class="form-group">
                                    <label><i class="fa fa-user"></i>&nbsp;Usuario</label>
                                    <input type="text" class="form-control" name="usuario_delete" placeholder="Nombre de usuario" required="">
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-key"></i>&nbsp;Contraseña</label>
                                    <input type="password" class="form-control" name="clave_delete" placeholder="Contraseña" required="">
                                </div>
                                <button type="submit" class="btn btn-danger btn-block">Eliminar cuenta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--Fin col 4-->
    </div><!--Fin row-->
</div><!--Fin container-->

<?php
} else {
    // Si la sesión no está activa, redirigir a la página de inicio de sesión
    echo '<script type="text/javascript"> window.location="index.php"; </script>';
}
?>
