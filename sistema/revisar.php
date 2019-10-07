<?php
include "modules.php";

$elGet=$_GET["r"];
$parte=explode('?',base64_decode($elGet));
$idEvaluador=$parte[1];
$idTrabajo=$parte[2];

function comprobarLink($idE, $idT){
    $pdo=conecta();
    $sql = "SELECT * FROM evaluacion WHERE evaluacion.id=:ide AND e_trabajo = :idt";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':idt', $idT, PDO::PARAM_STR);
        $stmt->bindParam(':ide', $idE, PDO::PARAM_STR);
        $stmt->execute();
        $error="";
        $cantidad=$stmt->rowCount();
    }
    return $cantidad ==1;
    unset($stmt);
    unset($pdo);
}

if(!isset($_GET['r']) || !comprobarLink($idEvaluador, $idTrabajo) ){
    header("location: bye.php");
    exit;
}

if (restaV("2018-05-11 00:00:00") >=0){
    header("location: bye.php");
    exit;
}


function getArticulobyID($idTrabajo){
    $pdo=conecta();
    $sql = "SELECT * FROM trabajos WHERE id = :id";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':id', $param_id, PDO::PARAM_STR);
        $param_id = $idTrabajo;
        $stmt->execute();
        while($row = $stmt->fetch()){
            $parte="<div class='col-4'>";
            $parte.= "<div class='card'>";
            $parte.= "<div class='card-header'>"."<b>El trabajo que será evaluado</b> </div>";
            $parte.= "<div class='card-body'>";
            $parte.="<h5 class='card-title'>".acentos(utf8_encode ($row['t_nombre']))."</h5>";
            $parte.="<p class='card-text'>"."Descripción: ".acentos(utf8_encode ($row['t_descripcion']))."</p>";
            $parte.="<p class='card-text'>"."Tipo: ".getTipoTrabajo($row['t_tipo'])."</p>";
            $parte.="<p class='card-text'>"."Categoría: ".getAreaTematica($row['t_categoria'])."</p>";
            $parte.="<p class='card-text text-info'>"."Última actualización: ".buenaFecha($row['t_create'])."</p>";
            $parte.= "<a class='btn btn-dark' href='{$row['t_ubicacion']}'>";
            $parte.= "Ver archivo";
            $parte.="</a>";
            $parte.="</div></div></div>";
            echo $parte;
            
        }
    }
    unset($stmt);
    unset($pdo);
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>CIIDDI 2018</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>CIIDDI - Evaluación</b></h1>
        </div>
    </div>
    <!--
    <div class="alert alert-danger" role="alert">
        
        <p>
            La plataforma recibirá evaluaciones hasta el 27/04/18 00:00:00 hs UTC-3
        </p>
        
    </div>
    -->
    <div class="container-fluid row">
        <?php getArticulobyID($idTrabajo); ?>
                <!-- Agregar evaluador-->
        <div class='col-8'>

            <form action="revisar-res.php" method="post" enctype="multipart/form-data" class='card'>
                <div class='card-header'>
                    <b> Formulario de Evaluación </b>
                </div>
                <div class='card-body'>

                    <h5> Criterios </h5></br>
                    <div class="row">
                        
                    <!--Originalidad-->
                        <div class="col-6 form-group">
                            <label for="originalidad" class="control-label">Originalidad</label>
                                <div class="">
                                    <select name="originalidad" class="form-control" aria-describedby="hb1">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb1" class="form-text text-muted">
                                    No conocido o visto anteriormente. Es una técnica o método no
                                    utilizado anteriormente. ¿Ha sido éste trabajo o similares reportados
                                    previamente? ¿Son completamente nuevos los problemas o aproximaciones de
                                    este paper? 
                                </small>
                        </div>

                        <!--Novedad-->
                        <div class="col-6 form-group">
                            <label for="novedad" class="control-label">Novedad</label>
                                <div class="">
                                    <select name="novedad" class="form-control" aria-describedby="hb2">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb2" class="form-text text-muted">
                                    De acuerdo a este criterio, no es necesario que el trabajo
                                    desarrolle nuevas técnicas, o genere nuevo conocimiento, sino que debe, por
                                    lo menos, aplicarlas o combinarlas de una manera novedosa o proporcionar
                                    nueva luz en su aplicabilidad en cierto dominio.
                                </small>
                        </div>

                        <!--Innovación -->
                        <div class="col-6 form-group">
                            <label for="innovacion" class="control-label">Innovación</label>
                                <div class="">
                                    <select name="innovacion" class="form-control" aria-describedby="hb3">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb3" class="form-text text-muted">
                                    Un nuevo producto, proceso o servicio basado en nuevas (o
                                    conocidas), tecnologías, métodos o metodologías. Las tecnologías y las
                                    técnicas conocidas pudieron combinarse para generar el nuevo producto o
                                    servicio con usuarios potenciales en el mercado. Lo que define una
                                    innovación es una nueva clase de usuarios posibles de un producto o de un
                                    servicio, no necesariamente nuevo conocimiento, nuevas técnicas, nuevas
                                    tecnologías, nuevos métodos, o nuevas aplicaciones. La innovación se
                                    relaciona con las nuevas aplicaciones o los nuevos mercados.
                                </small>
                        </div>

                        <!--Relevancia-->
                        <div class="col-6 form-group">
                            <label for="relevancia" class="control-label">Relevancia</label>
                                <div class="">
                                    <select name="relevancia" class="form-control" aria-describedby="hb4">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb4" class="form-text text-muted">
                                    Importancia, utilidad, y/o aplicabilidad de las ideas, de los
                                    métodos y/o de las técnicas descritas en el Trabajo.
                                </small>
                        </div>


                        <!--Conveniencia-->
                        <div class="col-6 form-group">
                            <label for="conveniencia" class="control-label">Conveniencia</label>
                                <div class="">
                                    <select name="conveniencia" class="form-control" aria-describedby="hb5">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb5" class="form-text text-muted">
                                    Conveniencia, concordancia, compatibilidad, congruencia, y
                                    suficiencia del trabajo a las áreas y temáticas de la conferencia. ¿El
                                    trabajo ha sido presentado en la conferencia adecuada?
                                </small>
                        </div>

                        <!--Significancia-->
                        <div class="col-6 form-group">
                            <label for="significancia" class="control-label">Significancia</label>
                                <div class="">
                                    <select name="significancia" class="form-control" aria-describedby="hb6">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb6" class="form-text text-muted">
                                    Validez científica, técnica y/o metodológica del artículo.
                                    Corrección de resultados, de pruebas y/o de reflexiones. Inclusión de
                                    detalles en los artículos que permiten el comprobar la corrección de los
                                    resultados o de las citaciones de los artículos donde se puede encontrar la
                                    prueba o partes de ella.  
                                </small>
                        </div>

                        <!--Calidad-->
                        <div class="col-6 form-group">
                            <label for="calidad" class="control-label">Calidad</label>
                                <div class="">
                                    <select name="calidad" class="form-control" aria-describedby="hb7">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb7" class="form-text text-muted">
                                    Validez científica, técnica y/o metodológica del artículo.
                                    Corrección de resultados, de pruebas y/o de reflexiones. Inclusión de
                                    detalles en los artículos que permiten el comprobar la corrección de los
                                    resultados o de las citaciones de los artículos donde se puede encontrar la
                                    prueba o partes de ella
                                </small>
                        </div>

                        <!--Presentación-->
                        <div class="col-6 form-group">
                            <label for="presentacion" class="control-label">Presentación</label>
                                <div class="">
                                    <select name="presentacion" class="form-control" aria-describedby="hb8">
                                        <option value="Excelente" selected="">Excelente</option>
                                        <option value="Aceptable">Aceptable</option>
                                        <option value="No Aceptable">No Aceptable</option>
                                        <option value="Sin decisión">Sin decisión</option>
                                    </select>
                                </div>
                                <small id="hb8" class="form-text text-muted">
                                    Organización adecuada del artículo y el lenguaje utilizado,
                                    en cuanto a claridad de contenido, fácilmente legible y comprensible.
                                    Claridad que ha sido alcanzada por el autor del artículo. Incluso los
                                    papeles técnicos en un pequeño tópico, deben ser escritos de manera tal
                                    que los no expertos puedan comprender la contribución principal del trabajo
                                    y de los métodos empleados. El trabajo no debería ser solamente una
                                    letanía de teoremas obscuros y profundos. La información del paper debe
                                    estar disponible para el lector con un mínimo esfuerzo.
                                </small>
                        </div>
                    </div>

                    <h5> Conclusión </h5></br> 
                    <div class="form-group required">
                        <label for="decision" class="control-label">¿El trabajo debería ser aceptado?*</label>
                            <div class="">
                                <select name="decision" class="form-control" required="">
                                    <option value="Acepta" selected="">Aceptar Trabajo</option>
                                    <option value="No Acepta">No Aceptar Trabajo</option>
                                    <option value="Sin decisión">Sin decisión</option>
                                </select>
                            </div>
                    </div>

                    <div class="form-group required">
                        <label for="comentario" class=" control-label">Comentario*</label>
                        <textarea type="text" name="comentario" class="form-control" size="200" maxlength="200" required="" data-error="Especificar los motivos de la decisión"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                    <input type="hidden" name="listo" value="true">
                    <input type="hidden" name="evaluacion" value="<?php echo $idEvaluador;?>">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
</body>
</html>