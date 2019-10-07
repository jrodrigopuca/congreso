<?php
// Initialize the session
require_once 'modules.php';
session_start();
 
// Si no esta logeado
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

if($_SESSION['username'] == "ciiddi2018@ucasal.edu.ar"){
    header("location: admin.php");
    exit;
  }


function getTrabajos($user){
    $pdo=conecta();
    $sql = "SELECT * FROM trabajos WHERE t_propietario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($user));

    if ($stmt->rowCount() == 0){
        echo "<p> Todavía no has agregado ningún trabajo </p>";
    }
    else{
        echo "<h2> Mis artículos subidos </h2><div class='row'>";
        while($row = $stmt->fetch()){
    
            $color=coloresEstado($row['t_estado']);
            $parte="<div class='col-6'>";
            $parte.= "<div class='card'>";
            $parte.= "<div class='card-header {$color}'>"."Revisión: ".utf8_encode ($row['t_estado'])."</div>";
            $parte.= "<div class='card-body'>";
            $parte.="<h5 class='card-title'>".acentos(utf8_encode ($row['t_nombre']))."</h5>";
            $parte.="<p class='card-text'>"."Descripción: ".acentos(utf8_encode ($row['t_descripcion']))."</p>";
            $parte.="<p class='card-text'>"."Tipo: ".getTipoTrabajo($row['t_tipo'])."</p>";
            $parte.="<p class='card-text'>"."Categoría: ".getAreaTematica($row['t_categoria'])."</p>";
            $parte.="<p class='card-text'>"."Autores: ".acentos(utf8_encode ($row['t_autores']))."</p>";
            //$parte.= "<p class='card-text'>"."cod de ref: ".utf8_encode ($row['id'])."</p>";
            $parte.="<p class='card-text'>"."Última actualización: ".buenaFecha($row['t_create'])."</p>";
            /*
            $parte.= "<a class='btn btn-light' data-toggle='collapse' href='#colapsar{$row['id']}' role='button' aria-expanded='false' aria-controls='colapsar{$row['id']}'>";
            $parte.= "Ver archivo";
            $parte.="</a>";
            */
                $parte.= "<a class='btn btn-dark btn-block' href='{$row['t_ubicacion']}'>";
                $parte.= "Ver archivo";
                $parte.="</a>";
    
            if ($row['t_camera'] != ""){
                $parte.= "<a class='btn btn-success btn-block' href='{$row['t_camera']}'>";
                $parte.= "Ver versión final";
                $parte.="</a>";
            }
    
            if ($row['t_comprobante'] != ""){
                $parte.= "<a class='btn btn-success btn-block' href='{$row['t_comprobante']}'>";
                $parte.= "Ver comprobante de pago";
                $parte.="</a>";
            }
    
    
            if ($row['t_estado'] == "Aceptado"){
                $parte.= "<a class='btn btn-light btn-block' href='camera.php?ref={$row['id']}'>";
                $parte.= "Enviar versión Camera Ready";
                $parte.="</a>";
                $parte.= "<a class='btn btn-light btn-block' href='comprobante.php?ref={$row['id']}'>";
                $parte.= "Enviar Comprobante de Pago";
                $parte.="</a>";
            }
            if ($row['t_estado'] == "Pendiente"){
                $parte.= "<a class='btn btn-light btn-block' href='update.php?ref={$row['id']}'>";
                $parte.= "Actualizar trabajo";
                $parte.="</a>";
            }
    
    
            /*
            $parte.="<div id='colapsar{$row['id']}' class='collapse'>";
            $parte.="<embed class='embed-responsive-item' src='{$row['t_ubicacion']}' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'/></div>";
            */
            $parte.="</div></div></div>";
    
            echo $parte;
        }
        echo "</div>";
    }
    unset($pdo);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <?php if ($_SESSION['nombre'] == ""):?>
            <h1>Bienvenido/a!</h1>
            <p> No olvides completar tus datos personales. </p>
            <?php else: ?>
            <h1>Bienvenido/a <b><?php echo htmlspecialchars($_SESSION['nombre']); ?></b></h1>
            <?php endif;?>
        </div>
    </div>
    <p class="container-fluid">
        <div class="btn-group" role="group" aria-label="...">
            <a href="perfil.php" class="btn btn-info">Actualizar mis datos</a>
            <a href="file.php" class="btn btn-dark">Enviar trabajo</a>
            <a href="soporte.php" class="btn btn-warning">Soporte</a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </p>

    <div class="container-fluid">
        <?php getTrabajos($_SESSION['username']) ?>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>