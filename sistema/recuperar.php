<?php
require 'modules.php';
require_once 'conexion.php';
 
// Define variables and initialize with empty values
$error="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $error = 'Por favor ingrese un email.';
    } else{
        $username = trim($_POST["email"]);
    }

    if(empty($error) && !empty($username) && existeUser($username)){
        // Prepare a select statement
        $sql = "UPDATE users SET user_pass = :userpass WHERE user_name = :username";
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $stmt->bindParam(':userpass', $param_password, PDO::PARAM_STR);
            
            $param_username = $username;

            $randomPass=randomPassword();
            $param_password = password_hash($randomPass, PASSWORD_DEFAULT);


            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                $error= "Éxito! Enviamos un mail con sus nuevos datos de acceso.";
                $motivo="CIIDDI - Cambio de datos de acceso";
                $mensaje="<h3> Nuevos datos de acceso a la plataforma de trabajos </h3>";
                $mensaje.="<p>tu nueva contraseña: ".$randomPass." </p>";
                emailAviso($username, $motivo, $mensaje);

            } else{
                $error= "Un error ha ocurrido, por favor intentar más tarde.";
            }
        }
    } 
    else{
        $error="el mail no es correcto";
    }
    // Close statement
    unset($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Recuperar cuenta</h1>
        </div>
    </div>
    <div class="container-fluid wrapper">
        <p>Por favor ingrese los datos para recuperar su cuenta</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="">
                <span class="help-block"><?php echo $error; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Recuperar">
                <a href="login.php" class="btn btn-primary"> Volver al Login </a>
            </div>
        </form>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>
</body>
</html>