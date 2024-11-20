<?php 
if ($_SESSION['nombre'] != "" && $_SESSION['clave'] != "" && $_SESSION['tipo'] == "admin") { 
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <img src="./img/msj.png" alt="Image" class="img-responsive animated tada">
            </div>
            <div class="col-sm-10">
                <p class="lead text-info">Bienvenido administrador, aquí se muestran todos los Tickets de CEAA, los cuales podrá eliminar, modificar e imprimir.</p>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['id_del'])) {
        $id = MysqlQuery::RequestPost('id_del');
        if (MysqlQuery::Eliminar("ticket", "id='$id'")) {
            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">TICKET ELIMINADO</h4>
                    <p class="text-center">El ticket fue eliminado del sistema con éxito</p>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">No hemos podido eliminar el ticket</p>
                </div>
            '; 
        }
    }

    // Consulta para mostrar los tickets
    if (isset($_GET['ticket_id'])) {
        $ticket_id = $_GET['ticket_id'];
        $consulta = "SELECT * FROM ticket WHERE serie='$ticket_id'";
    } else {
        $consulta = "SELECT * FROM ticket";
    }

    $selticket = Mysql::consulta($consulta);

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <?php if (mysqli_num_rows($selticket) > 0): ?>
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Serie</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ct = 1; // Contador
                                while ($row = mysqli_fetch_array($selticket, MYSQLI_ASSOC)): 
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $ct; ?></td>
                                        <td class="text-center"><?php echo $row['fecha']; ?></td>
                                        <td class="text-center"><?php echo $row['serie']; ?></td>
                                        <td class="text-center"><?php echo $row['estado_ticket']; ?></td>
                                        <td class="text-center"><?php echo $row['nombre_usuario']; ?></td>
                                        <td class="text-center"><?php echo $row['email_usuario']; ?></td>
                                        <td class="text-center"><?php echo $row['departamento']; ?></td>
                                        <td class="text-center">
                                            <a href="./lib/pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                                            <a href="admin.php?view=ticketedit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <form action="" method="POST" style="display: inline-block;">
                                                <input type="hidden" name="id_del" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                $ct++;
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2 class="text-center">No se encontraron tickets</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="./img/Stop.png" alt="Image" class="img-responsive animated slideInDown"/><br>
                <img src="./img/SadTux.png" alt="Image" class="img-responsive"/>
            </div>
            <div class="col-sm-7 animated flip">
                <h1 class="text-danger">Lo sentimos, esta página es solamente para administradores de CEAA</h1>
                <h3 class="text-info text-center">Inicia sesión como administrador para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>
