<?php
    require_once 'modules.php';

    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: login.php");
        exit;
    }
    $resultado="";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Formulario de Consulta</h1>
        </div>
    </div>
    <div class="container-fluid wrapper">
    <p>Por favor ingrese su consulta sobre la plataforma: </p>
        <form action="https://formspree.io/juan@yardev.net" method="POST">
            <div class='form-group'>
                <textarea class="form-control" id='textarea1' name='mensaje' required='true'></textarea>
            </div>
            <input type="hidden" name="_next" value="http://yardev.net/congreso/portal.php" />
            <input type="hidden" name="_subject" value="Consulta sobre trabajos" />
            <input type="hidden" name="_language" value="es" />
            <input type="hidden" name="_replyto" value="<?php echo $_SESSION['username']; ?>">
            <input class="btn btn-primary" type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>
