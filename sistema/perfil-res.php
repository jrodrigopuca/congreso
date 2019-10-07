<?php
include 'modules.php';
$resultado ="";

session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}

header('Content-Type: text/html; charset=utf-8');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'conexion.php';
    $sql = "UPDATE users SET user_tipo=:tipo,user_nombre=:nombre,user_apellido=:apellido,user_fecnac=:fecnac,user_ocup=:ocup,user_inst=:inst,user_domr=:domr,user_locr=:locr,user_tel1=:tel1,user_tel2=:tel2,user_email1=:email1,user_email2=:email2 where user_name=:name";

    $tipo=(isset($_POST["tipo"]))?$_POST["tipo"]:"";
    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    $apellido=(isset($_POST["apellido"]))?$_POST["apellido"]:"";

    $fecnac=(isset($_POST["fecnac"]))?$_POST["fecnac"]:"1970-01-01 00:33:38";
    $fecnac=date ("Y-m-d H:i:s", strtotime(str_replace('/','-',$fecnac)));

    $ocup=(isset($_POST["ocup"]))?$_POST["ocup"]:"";
    $inst=(isset($_POST["inst"]))?$_POST["inst"]:"";
    $domr=(isset($_POST["domr"]))?$_POST["domr"]:"";
    $locr=(isset($_POST["locr"]))?$_POST["locr"]:"";
    $tel1=(isset($_POST["tel1"]))?$_POST["tel1"]:"";
    $tel2=(isset($_POST["tel2"]))?$_POST["tel2"]:"";
    $email1=(isset($_POST["email1"]))?$_POST["email1"]:"";
    $email2=(isset($_POST["email2"]))?$_POST["email2"]:"";


    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':fecnac', $fecnac, PDO::PARAM_STR);
    $stmt->bindParam(':ocup', $ocup, PDO::PARAM_STR);
    $stmt->bindParam(':inst', $ocup, PDO::PARAM_STR);
    $stmt->bindParam(':domr', $domr, PDO::PARAM_STR);
    $stmt->bindParam(':locr', $locr, PDO::PARAM_STR);
    $stmt->bindParam(':tel1', $tel1, PDO::PARAM_STR);
    $stmt->bindParam(':tel2', $tel2, PDO::PARAM_STR);
    $stmt->bindParam(':email1', $email1, PDO::PARAM_STR);
    $stmt->bindParam(':email2', $email2, PDO::PARAM_STR);

    $stmt->bindParam(':name', $_SESSION['username'], PDO::PARAM_STR);	



    $result=$stmt->execute();

    if ($result){
        $resultado= "Muchas Gracias, los datos han sido enviado correctamente";
    }else{
        $resultado= "Hubo un error";
    }
    unset($stmt);
    unset($pdo); 
}

?>
<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="alert alert-dark" role="alert">
        <h3>
        <?php echo $resultado; ?>
        </h3>
        <p class="btn-group" role="group">
            <a href="portal.php" class="btn btn-secondary">Ir a inicio</a>
            <a href="soporte.php" class="btn btn-secondary">Informar error</a>
        </p>
    </div>
</body>


