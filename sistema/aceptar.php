<?php
include 'modules.php';
session_start();

// Si no esta logeado
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}

if ($_SESSION['username']!="ciiddi2018@ucasal.edu.ar"){
    header("location: portal.php");
    exit;
}


function getEvaluaciones($idt){
    $pdo=conecta();
    $sql="SELECT * FROM evaluacion as e WHERE e.e_trabajo=:idt and e_listo='true';"; 
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':idt', $idt, PDO::PARAM_STR);
        $stmt->execute();

        $parte="<h4> Revisiones: </h4>";
        $i=1;
        while($row = $stmt->fetch()){
            $parte.="<b>Revisión ".$i.":</b>";
            $parte.="<p> Decisión: ".$row["e_decision"]."</p>";
            $parte.="<p> Comentario: ".$row["e_comentario"]."</p>";
            $parte.="<b>Criterios: </b><ul>";
            $parte.="<li>Originalidad:</b> ".$row["e_c1"]."</li>";
            $parte.="<li>Novedad: ".$row["e_c2"]."</li>";
            $parte.="<li>Innovación: ".$row["e_c3"]."</li>";
            $parte.="<li>Relevancia: ".$row["e_c4"]."</li>";
            $parte.="<li>Conveniencia: ".$row["e_c5"]."</li>";
            $parte.="<li>Significancia: ".$row["e_c6"]."</li>";
            $parte.="<li>Calidad: ".$row["e_c7"]."</li>";
            $parte.="<li>Presentación: ".$row["e_c8"]."</li></ul>";

            $parte.="</br>"; 
            $i+=1;   
        }    
       
    }
    unset($stmt);
    unset($pdo);
    return $parte;
}


function getData($idTrabajo){
    $pdo=conecta();
    $sql = "SELECT * FROM trabajos as t INNER JOIN users as u on t.t_propietario=u.user_name where t.id=:id;";
    $row="";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':id', $idTrabajo, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
    }
    unset($stmt);
    unset($pdo);
    return $row;
}



$error="";
try{
    $idTrabajo=$_GET["i"];
    $resolucion=$_GET["d"];
    $estado="";
    $data=getData($idTrabajo);
    $trabajo=$data["t_nombre"];
    $nombre=isset($data["user_nombre"])?$data["user_nombre"]: $data["t_propietario"];
    $destinatario=$data["t_propietario"];
    $texto="";

    if ($resolucion=="true"){
        $estado="Aceptado";

        $texto='<h2> Estimado/a '.$nombre.'</h2>';
        $texto.='<h3> ¡Felicitaciones! </h3>';
        $texto.='<p> Tenemos el agrado de informarle que ha finalizado la revisión de su envío 
        con el título <i>'.$trabajo.'</i> y que el mismo ha sido aceptado
        para ser presentado en la octava edición del CIIDDI, que tendrá lugar
        los días 10 al 12 de mayo de 2018, en la Universidad Católica de Salta. </p>';

        $texto.='<p>Deberá enviarnos por la plataforma el documento de su propuesta con las modificaciones
        sugeridas al final de este e-mail, si las hubiera (Versión Camera-Ready),
        en formato de documento portátil (PDF), siguiendo '."<a href='http://www.ucasal.edu.ar/ciiddi2018/instrucciones.html'>"
        .'las normas indicadas'.'</a>'.' y CON LA FILIACIÓN COMPLETA DE SUS AUTORES, antes del 
        día 20-Abril-2018.</p>';


        $texto.="<p>Para enviarnos el documento solicitado, por favor realice los siguientes pasos:";
        $texto.="<ul>";
        $texto.="<li>"."Ingrese en el sistema de envíos, con el mismo usuario que utilizó para
        remitir la propuesta.</li>";
        $texto.="<li> Visualize al trabajo con el título <i>".$trabajo."</i>. Notesé que ahora su trabajo ha cambiado de estado y posee la opción de subir la versión de Camera Ready y el comprobante de inscripción.</li>";
        $texto.="<li> Seleccione la opción 'Enviar Camera-Ready' </li>";
        $texto.="</ul></p>";

        $texto.="<p>De acuerdo a lo informado en la página "."<a href='http://www.ucasal.edu.ar/ciiddi2018'>"."principal 
        del congreso"."</a>".", para garantizar la inclusión de este artículo en la publicación digital del CIIDDI 2018, por lo menos un
        autor debe inscribirse en la conferencia antes del 20-Abril-2018.</p>";

        $texto.="<p> Oportunamente se publicará en el sitio web del congreso, el cronograma de
        desarrollo de actividades indicando fecha y lugar para la presentación oral. </p>";

        $texto.="<p>Agradecemos su interés en el CIIDDI 2018 y esperamos verlos en Salta.</p>";

        $texto.="<p>Cordiales saludos.</p>";
        $texto.="<p>Comisión Organizadora CIIDDI 2018</p>";     
        
    }else{
        $estado="Rechazado";
        $texto='<h2> Estimado/a '.$nombre.'</h2>';
        $texto.='<p> Nosotros hemos finalizado la revisión de su envío 
        con el título <i>'.$trabajo.'</i>. Desafortunadamente el artículo no ha sido aceptado 
        para ser presentado en la octava edición del CIIDDI.</p>';
        $texto.="<p>Le agredecemos su participación y esperamos que las revisiones sean útiles para continuar mejorando su artículo.</p>";
        $texto.="<p>Agradecemos su interés en el CIIDDI 2018 y esperamos verlos en Salta.</p>";

        $texto.="<p>Cordiales saludos.</p>";
        $texto.="<p>Comisión Organizadora CIIDDI 2018</p>";    
    }
        $texto.="<p>";
        $texto.="============================</br>";
        $texto.="<p> Le agradeceremos no responder este mail, ya que esta dirección es utilizada
        sólo para envíos. Por cualquier duda o consulta, utilice el siguiente e-mail: <a href='mailto:ciiddi2018@ucasal.edu.ar'>ciiddi2018@ucasal.edu.ar</a></p>". 
        "<p>Para información sobre el Congreso visite:"."<a href='http://www.ucasal.edu.ar/ciiddi2018'>http://www.ucasal.edu.ar/ciiddi2018</a></p>";
        $texto.="============================</br>";
        $texto.="</p>";
        $texto.=getEvaluaciones($idTrabajo);
        $mensaje=$texto;
        $motivo="CIIDDI - Trabajo ".$estado;
        emailAviso($destinatario, $motivo, $mensaje);
        cambiarEstado($idTrabajo, $estado);
}
catch (Exception $e) {
    $error= $e->getMessage();
}



$resultado="";
if ($error!=""){
    $resultado="Hubo un error al cambiar el estado: ".$error;
}
else{
    $resultado="Éxito, El trabajo ha sido ".$estado;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceptar trabajo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="alert alert-dark" role="alert">
        <h3>
        <?php echo $resultado; ?>
        </h3>
        <p class="btn-group" role="group">
            <a href="admin.php" class="btn btn-secondary">Volver al panel de Administración</a>
        </p>
    </div>
</body>
