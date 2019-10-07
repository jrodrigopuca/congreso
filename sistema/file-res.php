<?php
include 'modules.php';

session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}

header('Content-Type: text/html; charset=utf-8');

function registrarArchivo($nombre, $ubicacion, $propietario, $descripcion, $estado, $autores,$categoria, $tipo ){
    $pdo=conecta();
    $sql = "INSERT INTO trabajos(t_nombre,t_ubicacion, t_propietario, t_descripcion, t_estado, t_autores,t_categoria, t_tipo) VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $resp=$stmt->execute(array($nombre, $ubicacion, $propietario, $descripcion, $estado, $autores,$categoria, $tipo));

    unset($stmt);
    unset($pdo);

    if ($resp){
        $send=$_SESSION['username'].";";
        $text= "<h2> Recepción de Trabajo </h2>"; 
        $text.= "<h3> Estimado/a: </h3>"; 
        $text.= "<p>Tenemos el agrado de dirigirnos a Ud. a los fines de comunicar la recepción de su trabajo ".$nombre.", el cuál será evaluado por el comité correspondiente. El resultado de dicha evaluación será comunicado oportunamente.</p>";
        $text.= "<p><b>Atentamente Comité Académico de CIIDDI 2018</b></p>";
        $text.= "<p>Para responder este mail, realizarlo desde <a href='mailto:ciiddi@ucasal.edu.ar'>ciiddi@ucasal.edu.ar</></p>";
        emailAviso($send,"Recepción de Trabajo",$text);
    }
    
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $ubicacionArchivo= subirArchivo($_FILES["file_pdf"]);
    //echo "ubic".$ubicacionArchivo;
    
        if ($ubicacionArchivo!=""){
            registrarArchivo($_POST["nombre"], $ubicacionArchivo, $_SESSION['username'],$_POST["descripcion"],$_POST["estado"], $_POST["autores"], $_POST["categoria"],$_POST["tipo"]  );
        }
        else{
            echo "error al subir datos";
        }
    
}

?>



<p><a href="portal.php" class="btn btn-info">Volver a inicio</a></p>