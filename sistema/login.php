<?php
// Include config file
require_once 'conexion.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Por favor ingrese un email.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Por favor ingrese un password';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_name, user_pass, user_nombre FROM users WHERE user_name = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $hashed_password = $row['user_pass'];
                        $nombreUsuario= $row['user_nombre'];
                        $esAdmin=$row['user_name']=="r@geeks.ms"; // <-- Aquí cambiar el correo del admin
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $esAdmin?"r@geeks.ms":$username; 
                            $_SESSION['nombre'] = $nombreUsuario;
                            $date = new DateTime();
                            $date = $date->format("c");
                            $q= $date." user: ".$username.PHP_EOL; 
                            file_put_contents("logs/acceso.txt",$q, FILE_APPEND);
                            if ($esAdmin){
                                header("location: admin.php");
                            }
                            else{
                                header("location: portal.php");
                            }
                              

                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'La contraseña no es válida';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'La cuenta no existe';
                }
            } else{
                echo "Oops! Algo estuvo mal, vuelva a intentarlo";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
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
            <h1>Iniciar sesión</h1>
        </div>
    </div>
    <div class="container-fluid wrapper">
        <p>Por favor ingrese los datos para iniciar sesión</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar sesión">
            </div>
            <p>¿Aún no tienes una cuenta? <a href="registro.php">Registrarse ahora</a>.</p>
            <p><a href="recuperar.php">Recuperar cuenta</a>.</p>
            <p> Recomendamos Mozilla Firefox para la utilización de este sitio.</p>
        </form>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>
</body>
</html>