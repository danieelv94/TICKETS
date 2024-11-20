<?php
session_start(); // Asegúrate de que la sesión está iniciada

if (!isset($_SESSION['email'])) {
    echo '<div class="alert alert-danger">Por favor, inicia sesión para ver tus tickets.</div>';
    exit();
}

$email_usuario = $_SESSION['email']; // Usuario logueado
?>

<div class="container">
    <div class="row well">
        <div class="col-sm-3">
            <img src="img/ceaalogo.png" class="img-responsive" alt="Logo CEAA">
        </div>
        <div class="col-sm-9 lead">
            <h2 class="text-info">Bienvenido al centro de soporte de CEAA</h2>
            <p>
                Es muy fácil de usar, si tiene problemas con alguno de nuestros productos, puede enviar un nuevo ticket y nosotros le ayudaremos.
                También puede consultar el estado de tickets generados anteriormente mediante su <strong>Ticket ID</strong>.
            </p>
        </div>
    </div><!-- Fin row 1 -->

    <div class="row">
        <!-- Nuevo Ticket -->
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading text-center">
                    <i class="fa fa-file-text"></i>&nbsp;<strong>Nuevo Ticket</strong>
                </div>
                <div class="panel-body text-center">
                    <img src="./img/new_ticket.png" alt="Nuevo Ticket">
                    <h4>Abrir un nuevo ticket</h4>
                    <p class="text-justify">
                        Si tiene un problema con cualquiera de nuestros productos, repórtelo creando un nuevo ticket.
                        Solo los <strong>usuarios registrados</strong> pueden abrir un nuevo ticket.
                    </p>
                    <a type="button" class="btn btn-info" href="./index.php?view=ticket">Nuevo Ticket</a>
                </div>
            </div>
        </div><!-- Fin col-md-6 -->

        <!-- Consultar estado de Ticket -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <div class="panel-heading text-center">
                    <i class="fa fa-link"></i>&nbsp;<strong>Consultar estado de Ticket</strong>
                </div>
                <div class="panel-body text-center">
                    <img src="./img/old_ticket.png" alt="Consultar Ticket">
                    <h4>Consultar estado de tickets</h4>
                    <form class="form-horizontal" role="form" method="GET" action="./admin.php">
                        <input type="hidden" name="view" value="ticketadmin">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Selecciona un Ticket</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="ticket_id" required>
                                    <?php
                                    // Consulta para obtener los tickets del usuario logueado
                                    $result = Mysql::consulta("SELECT serie, asunto FROM ticket WHERE email_usuario='$email_usuario'");

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . htmlspecialchars($row['serie']) . '">' . htmlspecialchars($row['asunto']) . ' (' . htmlspecialchars($row['serie']) . ')</option>';
                                        }
                                    } else {
                                        echo '<option value="">No tienes tickets generados</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success">Consultar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Fin col-md-6 -->
    </div>
</div>
