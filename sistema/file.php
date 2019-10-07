<?php 
require 'modules.php';
session_start();

if (restaV("2018-05-11 00:00:00") >=0){
    header("location: bye.php");
    exit;
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Formulario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Subir un nuevo trabajo</h1>
        </div>
    </div>
    <div class="centrar card">
        <div class="alert alert-danger" role="alert">
            <!--
            <p>
            La plataforma recibirá trabajos hasta el 13/04/18 00:00:00 hs UTC-3 (extensión)
            </p>
            -->
            <p>
            Antes de subir el trabajo recuerde leer las <a href="http://www.ucasal.edu.ar/ciiddi2018/instrucciones.html">instrucciones</a>.
            </p>
        </div>
        <form class="card-body" action="file-res.php" method="post" enctype="multipart/form-data">
            <!--nombre del trabajo -->
            <div class="form-group">
                <label>Nombre del trabajo</label>
                <input name="nombre" type="text" class="form-control" placeholder="Nombre" required>
            </div>
            <!--descripcion--> 
            <div class="form-group">
                <label>Breve descripción del artículo</label>
                <input name="descripcion" type="text" class="form-control" placeholder="Descripción" maxlength="200" required  aria-describedby="ddescripcion">
                <small id="ddescripcion" class="text-muted">  long. máxima: 200 caracteres </small>
            </div>

            <!--autores--> 
            <div class="form-group">
                <label>Autores</label>
                <input name="autores" type="text" class="form-control" placeholder="Autores" maxlength="50" required aria-describedby="dautores">
                <small id="dautores" class="text-muted">  long. máxima: 50 caracteres </small>
            </div>
          
           <input type="hidden" name="estado" value="Pendiente">


            <div class="form-group">
                <label>Tipo de trabajo</label>
                <select class="custom-select" name="tipo" required>
                    <option selected value="TIC">Trabajo de Investigación - Artículo Completo</option>
                    <option selected value="TIP">Trabajo de Investigación - Póster</option>
                    <option selected value="TIO">Trabajo de Investigación - Comunicación Oral (Resumen)</option>
                    <option value="TAG">Trabajo de Alumno - Proyecto de Grado</option>
                    <option value="TAC">Trabajo de Alumno - Trabajo de Cátedra</option>
                    <option value="TAI">Trabajo de Alumno - Trabajo de Investigación</option>
                </select>
            </div>

            <div class="form-group">
                <label>Área Temática</label>
                <select class="custom-select" name="categoria" required>
                    <option selected value="NT">Las nuevas tecnologías y el derecho</option>
                    <option value="ED">Educación</option>
                    <option value="DP">Datos personales - confidencialidad y privacidad</option>
                    <option value="DI">Delitos informáticos - pericias e informática forense</option>
                    <option value="RL">Regulación y legislación informática actual: Nuevos desafíos</option>
                    <option value="GO">Gobierno y TI</option>
                </select>
            </div>

            <div class="form-group">
                <label>Archivo</label>
                <input name="file_pdf" id="fileSelect" type="file" class="form-control" placeholder="Archivo" required>
                <span class="help-block"> Solo se aceptarán pdf, tamaño máximo 25MB</span>
           </div>
            
            <input type="submit" class="btn btn-primary" name="submit" value="Enviar">      
            <a href="portal.php" class="btn btn-primary">Cancelar</a>   
        </form>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>
</body>
</html>