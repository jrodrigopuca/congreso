<?php
include "modules.php";
header('Content-type: text/html; charset=utf-8' , true );
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



$owner="";
$nombreTrabajo="";

function getArticulobyID($idTrabajo){
    $pdo=conecta();
    $sql = "SELECT * FROM trabajos WHERE id = :id";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':id', $param_id, PDO::PARAM_STR);
        $param_id = $idTrabajo;
        $stmt->execute();
        while($row = $stmt->fetch()){
            $GLOBALS["nombreTrabajo"]=$row['t_nombre'];
            $color=coloresEstado($row['t_estado']);
            $parte="<div class='col-6'>";
            $parte.= "<div class='card'>";
            $parte.= "<div class='card-header {$color}'>"."<b>El trabajo que será evaluado</b> </div>";
            $parte.= "<div class='card-body'>";
            $parte.="<h5 class='card-title'>".$row['t_nombre']."</h5>";
            $parte.="<p class='card-text'>"."Descripción: ".utf8_encode ($row['t_descripcion'])."</p>";
            $parte.="<p class='card-text'>"."Tipo: ".getTipoTrabajo($row['t_tipo'])."</p>";
            $parte.="<p class='card-text'>"."Categoría: ".getAreaTematica($row['t_categoria'])."</p>";
            $parte.="<p><b class='card-text'>"."Propietario: ".utf8_encode ($row['t_propietario'])."</b></p>";
            $parte.="<p><b class='card-text'>"."Autores: ".utf8_encode ($row['t_autores'])."</b></p>";
            $parte.="<p class='card-text text-info'>"."cod de ref: ".utf8_encode ($row['id'])."</p>";
            $parte.="<p class='card-text {$color}'>"."Estado de revisión: ".utf8_encode ($row['t_estado'])."</p>";
            $parte.="<p class='card-text'>"."Última actualización: ".buenaFecha($row['t_create'])."</p>";

            //$parte.= "<input type='hidden' name='nombreTrabajo' value'{$row['t_nombre']}'>";

            $parte.= "<a class='btn btn-light' href='{$row['t_ubicacion']}'>";
            $parte.= "Ver archivo";
            $parte.="</a>";

            $parte.="</div></div></div>";
        
            echo $parte;
            
        }
    }
    unset($stmt);
    unset($pdo);
}

function getEvaluadoresbyID($idTrabajo){
    $pdo=conecta();
    $sql = "SELECT * FROM evaluacion WHERE e_trabajo = :id";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':id', $param_id, PDO::PARAM_STR);
        $param_id = $idTrabajo;
        $stmt->execute();

        echo "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Evaluador</th>
                        <th scope='col'>Revisado?</th>
                        <th scope='col'>Criterios</th>
                        <th scope='col'>Decisión</th>
                        <th scope='col'>Comentario</th>
                        <th scope='col'>Fechas</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $stmt->fetch()){
            $parte="<tr>";
            $parte.="<th scope='row'>".$row["id"]."</th>";
            $parte.="<td scope='row'>".$row["e_evaluador"]."</td>";
            $parte.="<td scope='row'>".$row["e_listo"]."</td>";

            $parte.="<td scope='row'>";
            $parte.="<p><b>Originalidad:</b> ".$row["e_c1"]."</p>";
            $parte.="<p><b>Novedad:</b> ".$row["e_c2"]."</p>";
            $parte.="<p><b>Innovación:</b> ".$row["e_c3"]."</p>";
            $parte.="<p><b>Relevancia:</b> ".$row["e_c4"]."</p>";
            $parte.="<p><b>Conveniencia:</b> ".$row["e_c5"]."</p>";
            $parte.="<p><b>Significancia:</b> ".$row["e_c6"]."</p>";
            $parte.="<p><b>Calidad:</b> ".$row["e_c7"]."</p>";
            $parte.="<p><b>Presentación:</b> ".$row["e_c8"]."</p>";
            $parte.="</td>";

            $parte.="<td scope='row'>".$row["e_decision"]."</td>";
            $parte.="<td scope='row'><p>".$row["e_comentario"]."</p></td>";

            $parte.="<td scope='row'>";
            $parte.="<p> <b>Asignación:</b> ".buenaFecha($row["e_create"])."</p>";
            $parte.="<p> <b>Última actualización:</b> ".buenaFecha($row["e_update"])."</p>";
            $parte.="</td>";


            $parte.="</tr>";
            echo $parte;    
        }
        echo "</tbody></table>";

    }
    unset($stmt);
    unset($pdo);
}

$resultadoPOST="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $evaluador= $_POST["evaluador"];
    $trabajo=$_GET["trabajo"];
    $listo="false";
    $elTrabajo=$_POST["nTrabajo"];

    $pdo=conecta();
    $sql = "INSERT INTO evaluacion (e_trabajo, e_listo, e_evaluador) VALUES (:trabajo, :listo, :evaluador)";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':trabajo', $trabajo, PDO::PARAM_STR);
        $stmt->bindParam(':listo', $listo, PDO::PARAM_STR);
        $stmt->bindParam(':evaluador', $evaluador, PDO::PARAM_STR);
        if ($stmt->execute()){
            $resultadoPOST= "<div class='alert alert-success' role='alert'>Éxito! Asignación correcta </div>";

            $destinatario=$evaluador;
            $rid= $pdo->lastInsertId();
            $superRid="?".$rid."?".$_GET["trabajo"];

            $path="www.yardev.net/congreso/";
            $link=$path."revisar.php"."?r=".base64_encode($superRid)."";
            $motivo="CIIDDI - Evaluación de trabajo";
            $mensaje="<h3>Estimado Evaluador:</h3>";
            $mensaje.="<p>Consideramos que usted será un excelente revisor de la propuesta <b>".$elTrabajo."</b> la cual ha sido enviada a la plataforma de trabajos del CIIDDI.</p>"; 
            $mensaje.="<p>Podrá acceder al artículo a través del <a href='".$link."'> link </a>; y esperamos que considere aceptar esta importante tarea.</p>";
            $mensaje.="<p>En caso de aceptar llevar a cabo la tarea de revisión, tiene tiempo hasta la fecha <b>27-abr-2018</b> para emitir una opinión favorable del mismo para su presentación o en el caso contrario que detalle brevemente los motivos de su exclusión.</p>";
            $mensaje.="<p>Muchas gracias por considerar este pedido.</p>";
            $mensaje.="<p>Comité Organizador CIIDDI 2018 - Salta - Argentina</p>";
            $mensaje.= "<p>Para responder este mail, realizarlo desde <a href='mailto:ciiddi@ucasal.edu.ar'>ciiddi@ucasal.edu.ar</></p>";

            cambiarEstado($trabajo, "Asignado");
            emailAviso($destinatario, $motivo, $mensaje);
        }
        else{
            $resultadoPOST= "<div class='alert alert-danger' role='alert'>Error: No se logró asignar</div>";
        }
    }
}   


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>CIIDDI2018</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Asignar Evaluadores a trabajo</b></h1>
        </div>
    </div>
    <p class="container-fluid">
        <div class="btn-group" role="group" aria-label="...">
            <a href="admin.php" class="btn btn-info">Volver al Panel de Administración</a>
        </div>
    </p>
    <div class="container-fluid row">
        <!-- El trabajo que será evaluado -->
        <?php getArticulobyID($_GET["trabajo"]) ?>

        <!-- Agregar evaluador-->
        <div class='col-6'>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?trabajo=".$_GET["trabajo"]); ?>" method="post" class='card'>
                <div class='card-header'>
                    <b> Agregar evaluador </b>
                </div>
                <div class='card-body'>
                    <div class="form-group required">
                        <label for="evaluador" class="control-label">Evaluador*</label>
                            <div class="">
                                <select name="evaluador" class="form-control" required="">
                                    <option value="jarp@outlook.com" selected="">jarp@outlook.com - Juan (para pruebas)</option>
                                    <option value="asantiago.alegre@gmail.com">asantiago.alegre@gmail.com - Santiago (para pruebas)</option>
                                    <option value="faprile@yahoo.com">faprile@yahoo.com - Fredi Aprile </option>
                                    <option value="aires.rover@gmail.com">aires.rover@gmail.com - Aires José Rover </option>
                                    <option value="mdmasseno@gmail.com">mdmasseno@gmail.com - Manuel David Masseno </option>
                                    <option value="cfa@unizar.es">cfa@unizar.es - Fernando Galindo </option>
                                    <option value="marialauraspina@gmail.com">marialauraspina@gmail.com - María Laura Spina </option>
                                    <option value="rolealdasilva@gmail.com">rolealdasilva@gmail.com - Rosane Leal da Silva </option>
                                    <option value="sappendino@ucasal.net">sappendino@ucasal.net - Sergio Appendino </option>
                                    <option value="yarinamoroso@gmail.com">yarinamoroso@gmail.com - Yarina Amoroso</option>
                                    <option value="rpagesll@gmail.com">rpagesll@gmail.com - Roberto Pagés Lloveras </option>
                                    <option value="aidanoblia@gmail.com">aidanoblia@gmail.com - Aída Noblia </option>
                                    <option value="rede.pepe@gmail.com">rede.pepe@gmail.com - José Eduardo Resende Chavez Junior </option>
                                    <option value="luzbibianaclara@gmail.com">luzbibianaclara@gmail.com - Bibiana Luz Clara </option>
                                    <option value="patricia.reyes@uv.cl"> patricia.reyes@uv.cl - Patricia Reyes </option>
                                    <option value="fernandag@ufasta.edu.ar">fernandag@ufasta.edu.ar - Giaccaglia, María Fernanda </option>
                                </select>
                            </div>
                    </div>
                    <input type='hidden' name='nTrabajo' value='<?php echo $nombreTrabajo; ?>'>
                    <div class="form-group">
                        <input type="submit" class="btn btn-warning" value="Agregar">
                    </div>
                    <?php echo $resultadoPOST;?>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    <b> Definir estado final </b>
                </div>

                <div class="card-body">
                    <p>
                        En base a los datos enviados por los Evaluadores, la publicación del trabajo se deberá ..
                    </p>
                    <a href="<?php echo 'aceptar.php?i='.$_GET["trabajo"].'&d=true';?>" class="btn btn-success">Aceptar </a>
                    <a href="<?php echo 'aceptar.php?i='.$_GET["trabajo"].'&d=false';?>" class="btn btn-secondary">Rechazar </a>
                </div>
            </div>
        </div>
    </div>
    </br>
        <!-- Lista de evaluadores-->
        <div class='col-12'>
        <div class="card">
            <div class="card-header">
                <b>
                Evaluadores Asignados
                </b>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php getEvaluadoresbyID($_GET["trabajo"]) ?>
                </div>
            </div>
        </div>
        </div>
        




    
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
</body>
</html>
