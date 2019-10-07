<?php
/* Remoto 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
*/
//LOCAL
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'congresoloc');

/* Intentar conectar */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME.";charset=utf8", DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: No hay conexión " . $e->getMessage());
}
?>