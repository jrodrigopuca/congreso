<?php 
require_once "modules.php";
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
  }


if (restaV("2018-05-11 00:00:00") >=0){
    header("location: bye.php");
    exit;
}

function getOwner($id){
    $pdo=conecta();
    $sql = "SELECT t_propietario FROM trabajos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($id));
    $row = $stmt->fetch();

    return $row['t_propietario'];
}

$elVerdaderoPropietario=getOwner($_GET['ref']);
if($_SESSION['username']!=$elVerdaderoPropietario){
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Actualizar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Actualizar</h1>
        </div>
    </div>
   
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

    <div class="centrar card">

        <form class="card-body" action="update-res.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="indice" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : 0;?>">
            <div class="form-group">
                <label>Archivo</label>
                <input name="file_pdf" id="fileSelect" type="file" class="form-control" placeholder="Archivo" required>
                <span class="help-block"> Solo se aceptarán pdf, tamaño máximo 25MB</span>
           </div>

            <input type="submit" class="btn btn-primary" name="submit" value="Enviar">         
        </form>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
</body>
</html>