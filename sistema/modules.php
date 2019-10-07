<?php
    require_once 'conexion.php';

    function subirArchivo($file){
        $ubicacion ="";
        if(isset($file) && $file["error"] == 0){
            $allowed = array("pdf" => "application/pdf");
            $filename = $file["name"];
            $filetype = $file["type"];
            $filesize = $file["size"];
        
            // Verificar extensión
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Error: No es un formato de archivo válido");
        
            // Verificar tamaño máximo
            $maxsize = 25 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: El archivo tiene un tamaño muy grande");
        
            // Verificar tipo de archivo
            if(in_array($filetype, $allowed)){
                $nombreArchivo= rand().".pdf";
                $nuevoNombre = "upload/".rand().".pdf";
                move_uploaded_file($file["tmp_name"],  $nuevoNombre);
                echo "Archivo enviado exitosamente";
                $ubicacion=$nuevoNombre;
            } else{
                echo "Error: Hubo un problema al subir el archivo, intentar nuevamente"; 
            }
        } else{
            echo "Error: " . $file["error"];
        }
        return $ubicacion;
    }

    function subirArchivoV($file, $extension, $folder){
        $ubicacion ="";
        if(isset($file) && $file["error"] == 0){
            $allowed="";
            if ($extension == "pdf"){
                $allowed = array("pdf" => "application/pdf");
            }
            if ($extension == "jpg"){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
            }
            
            $filename = $file["name"];
            $filetype = $file["type"];
            $filesize = $file["size"];
        
            // Verificar extensión
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Error: No es un formato de archivo válido");
        
            // Verificar tamaño máximo
            $maxsize = 25 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: El archivo tiene un tamaño muy grande");
        
            // Verificar tipo de archivo
            if(in_array($filetype, $allowed)){
                $nombreArchivo= rand().".".$extension;
                $nuevoNombre = $folder."/".rand().".".$extension;
                move_uploaded_file($file["tmp_name"],  $nuevoNombre);
                echo "<div class='alert alert-success' role='alert'>Archivo enviado exitosamente </div>";
                $ubicacion=$nuevoNombre;
            } else{
                echo "<div class='alert alert-danger' role='alert'> Error: Hubo un problema al subir el archivo, intentar nuevamente </div>"; 
            }
        } else{
            echo "Error: " . $file["error"];
        }
        return $ubicacion;
    }


function emailAviso($destinatario, $motivo, $mensaje)
{
    $url = 'https://api.elasticemail.com/v2/email/send';

    try{
            $post = array('from' => 'juan@yardev.net',
            'fromName' => 'CIIDDI',
            'apikey' => 'fa3649e3-4c2d-4371-94d1-abdeca6f0b48',
            'subject' => $motivo,
            'to' => $destinatario,
            'bodyHtml' => $mensaje,
            'bodyText' => 'Text Body',
            'isTransactional' => false);
            
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));
            
            $result=curl_exec ($ch);
            curl_close ($ch);
            //echo "Hemos enviado un mail para "
            //echo $result;	
    }
    catch(Exception $ex){
        echo "Hubo un error al enviar el mail";
    }
}

function conecta(){
    /* Intentar conectar */
    try{
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e){
        
        die("ERROR: No hay conexión ");
    }
}

function cambiarEstado($idTrabajo, $estado){
    $pdo=conecta();
    $sql = "UPDATE trabajos SET t_estado=:estado where trabajos.id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idTrabajo, PDO::PARAM_STR);	
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);	
    $resp=$stmt->execute();


    unset($stmt);
    unset($pdo);
}

function existeUser($userName){
    $pdo=conecta();
    $sql = "SELECT id FROM users WHERE user_name = :username";
    $resultado=false;
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $userName;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $resultado=($stmt->rowCount() == 1);
            }
        }
    // Close statement
    unset($stmt);
    return $resultado;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function acentos($cadena) 
{
   $search = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã­,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ­,ÃÃ³,ÃÃº,ÃÃ±,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü");
   $replace = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;");
   $cadena= str_replace($search, $replace, $cadena);
 
   return $cadena;
}

function coloresEstado($estado){
    $devolver="";
    switch ($estado) {
        case "Pendiente":
            $devolver="red-light";
            break;
        case "Asignado":
            $devolver="yellow-light";
            break;
        case "Aceptado":
            $devolver="green-light";
            break;
        case "Rechazado":
            $devolver="grey-light";
            break;
    }
    return $devolver;
}

function getTipoTrabajo($nombre){
    $devolver="";
    switch ($nombre) {
        case "TIC":
            $devolver="Trabajo de Investigación - Artículo Completo";
            break;
        case "TIP":
            $devolver="Trabajo de Investigación - Póster";
            break;
        case "TIO":
            $devolver="Trabajo de Investigación - Comunicación Oral (Resumen)";
            break;
        case "TAG":
            $devolver="Trabajo de Alumno - Proyecto de Grado";
            break;
        case "TAC":
            $devolver="Trabajo de Alumno - Trabajo de Cátedra";
            break;
        case "TAI":
            $devolver="Trabajo de Alumno - Trabajo de Investigación";
            break;
    }
    return $devolver;
}

function getAreaTematica($nombre){
    $devolver="";
    switch ($nombre) {
        case "NT":
            $devolver="Las nuevas tecnologías y el derecho";
            break;
        case "ED":
            $devolver="Educación";
            break;
        case "DP":
            $devolver="Datos personales - confidencialidad y privacidad";
            break;
        case "DI":
            $devolver="Delitos informáticos - pericias e informática forense";
            break;
        case "RL":
            $devolver="Regulación y legislación informática actual: Nuevos desafíos";
            break;
        case "GO":
            $devolver="Gobierno y TI";
            break;
    }
    return $devolver;
}




function resta($fecha){
    $now = time(); 
    $date = strtotime($fecha);
    $datediff = $now - $date;
    $devolver=round($datediff / (60 * 60 * 24));
    return $devolver; //devuelve un entero en cantidad de días
}

function restaV($fecha){
    $now = time(); 
    $date = strtotime($fecha);
    $datediff = $now - $date;
    $devolver=round($datediff);
    return $devolver; //devuelve un entero en cantidad de días
}


function buenaFecha($fecha){
    $redondeado=resta($fecha);  
    $devolver="";
    switch ($redondeado) {
        case 0:
            $devolver= "Hoy";
            break;
        case 1:
            $devolver="Ayer";
            break;
        default:
            $devolver="Hace ".$redondeado." días";
    }
    return $devolver;
}



?>