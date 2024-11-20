<!-- Contenedor principal sin imágenes ni carrusel -->
<div id="login-form-container" class="container">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3 thumbnail">
            <h3 class="text-center">Iniciar Sesión</h3>
            
            <!-- Formulario de login -->
            <form action="" method="POST" style="margin: 20px;">
                <div class="form-group">
                    <label><span class="glyphicon glyphicon-user"></span>&nbsp;Nombre</label>
                    <input type="text" class="form-control" name="nombre_login" placeholder="Escribe tu nombre" required=""/>
                </div>
                <div class="form-group">
                    <label><span class="glyphicon glyphicon-lock"></span>&nbsp;Contraseña</label>
                    <input type="password" class="form-control" name="contrasena_login" placeholder="Escribe tu contraseña" required=""/>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm">Iniciar sesión</button>
                    <button type="reset" class="btn btn-danger btn-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Si tienes otro script que necesite inicializar algo, colócalo aquí
    });
</script>
