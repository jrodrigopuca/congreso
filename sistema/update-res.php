<?php
include 'modules.php';
session_start();
header('Content-Type: text/html; charset=utf-8');

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
  }

function actualizarArchivo($ubicacion, $id){
    $pdo=conecta();
    $sql = "UPDATE trabajos SET trabajos.t_ubicacion=:ubicacion where trabajos.id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);	
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);	
    $resp=$stmt->execute();

    unset($stmt);
    unset($pdo);

    if ($resp){
        $send=$_SESSION['username'].";";
        $text= "<h2> Actualización de Trabajo <h2>"; 
        $text.= "<h3> Estimado/a: <h3>"; 
        $text.= "<p>Tenemos el agrado de dirigirnos a Ud. a los fines de comunicar la actualización de su trabajo, el cuál será evaluado por el comité correspondiente. El resultado de dicha evaluación será comunicado oportunamente.</p>";
        $text.= "<p><b>Atentamente Comité Académico de CIIDDI 2018</b></p>";
        $text.= "<p>Para responder este mail, realizarlo desde <a href='mailto:ciiddi@ucasal.edu.ar'>ciiddi@ucasal.edu.ar</></p>";
        emailAviso($send,"Actualización de Trabajo",$text);
    }
    else{
        echo "Lamentablemente no hemos logrado enviarle un mail sobre la actualización"; 
    }


}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $ubicacionArchivo= subirArchivo($_FILES["file_pdf"]);
    //echo "ubic".$ubicacionArchivo;
    
        if ($ubicacionArchivo!=""){
            actualizarArchivo($ubicacionArchivo,$_POST["indice"]  );
        }
        else{
            echo "error al subir datos";
        }
    
}
?>

<p><a href="portal.php" class="btn btn-info">Volver a inicio</a></p>
