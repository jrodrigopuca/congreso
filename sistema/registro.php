<?php
// Include config file
require_once 'modules.php';
 
// Define variables and initialize with empty values
$username = $password=$confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$password=randomPassword();

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //echo "pass:".$password;
    //echo "conf:".$confirm_password;
    $pdo=conecta();
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese un email";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE user_name = :username";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Existe un usuario con ese mail, probar con otro.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ups! Algo no ha salido bien, por favor probar de nuevo.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Por favor ingrese una contraseña";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "La contraseña debe tener más de 6 caracteres";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Por favor confirmar contraseña';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'La contraseña no es igual';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_name, user_pass) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Un error ha ocurrido, por favor intentar más tarde.";
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
    <title>Registrar nuevo usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Email</h1>
        </div>
    </div>

    <div class="container-fluid wrapper">
        <p>Por favor ingrese los datos para crear un nuevo usuario</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña (Autogenerada)</label>
                <input type="text" name="password" class="form-control" value="<?php echo $password; ?>" readonly>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Repetir contraseña</label>
                <input type="text" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
                <input type="reset" class="btn btn-default" value="Limpiar">
            </div>
            <p>¿Ya tienes una cuenta? <a href="login.php">iniciar sesión</a>.</p>
        </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </div>    
</body>
</html>