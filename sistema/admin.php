<?php
// Initialize the session
require_once 'modules.php';
session_start();

 
// Si no esta logeado
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}

if ($_SESSION['username']!="r@geeks.ms"){
    header("location: portal.php");
    exit;
}

function getTrabajosAll(){
    $pdo=conecta();
    $sql = "SELECT * FROM trabajos";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo "<div class='row'>";
    while($row = $stmt->fetch()){
        $color=coloresEstado($row['t_estado']);
        $parte="<div class='col-6'>";
        $parte.= "<div class='card'>";
        $parte.= "<div class='card-header {$color}'>"."Revisión: ".utf8_encode ($row['t_estado'])."</div>";
        $parte.= "<div class='card-body'>";
        $parte.="<h5 class='card-title'>".acentos(utf8_encode($row['t_nombre']))."</h5>";
        $parte.="<p class='card-text'>"."Descripción: ".acentos(utf8_encode($row['t_descripcion']))."</p>";
        $parte.="<p class='card-text'>"."Tipo: ".getTipoTrabajo($row['t_tipo'])."</p>";
        $parte.="<p class='card-text'>"."Categoría: ".getAreaTematica($row['t_categoria'])."</p>";
        $parte.="<p class='card-text'>"."Propietario: ".utf8_encode ($row['t_propietario'])."</p>";
        $parte.="<p class='card-text'>"."Autores: ".acentos(utf8_encode ($row['t_autores']))."</p>";
        $parte.= "<p class='card-text'>"."cod de ref: ".utf8_encode ($row['id'])."</p>";
        $parte.="<p class='card-text'>"."Última actualización: ".buenaFecha($row['t_create'])."</p>";
        /*
        $parte.= "<a class='btn btn-light' data-toggle='collapse' href='#colapsar{$row['id']}' role='button' aria-expanded='false' aria-controls='colapsar{$row['id']}'>";
        $parte.= "Ver archivo";
        $parte.="</a>";
        */
        $parte.= "<a class='btn btn-dark btn-block' href='{$row['t_ubicacion']}'>";
        $parte.= "Ver archivo";
        $parte.="</a>";
        $parte.= "<a class='btn btn-danger btn-block' href='asignar.php?trabajo={$row['id']}'>";
        $parte.= "Revisar";
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

        //$parte.= "<a class='btn btn-light' href='update.php?ref={$row['id']}'>";
        //$parte.= "Actualizar trabajo";
        //$parte.="</a>";
        /*
        $parte.="<div id='colapsar{$row['id']}' class='collapse'>";
        $parte.="<embed class='embed-responsive-item' src='{$row['t_ubicacion']}' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'/></div>";
        */
        $parte.="</div></div></div>";

        echo $parte;
    }
    echo "</div>";

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
            <h1><b>Administrador</b></h1>
        </div>
    </div>
    <p class="container-fluid">
        <div class="btn-group" role="group" aria-label="...">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </p>

    <div class="container-fluid">
        <h2> Todos los artículos </h2>
        <?php getTrabajosAll(); ?>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>