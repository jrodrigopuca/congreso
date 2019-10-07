<?php
include 'modules.php';

function registrarRespuesta($id, $listo, $decision, $comentario,$orig,$nove,$inno,$rele,$conv,$sign,$cali,$pres){
    $pdo=conecta();
    $sql = "UPDATE evaluacion SET e_listo=:listo, e_decision=:decision, e_comentario=:comentario, e_c1=:c1,e_c2=:c2,e_c3=:c3,e_c4=:c4,e_c5=:c5,e_c6=:c6,e_c7=:c7,e_c8=:c8  where evaluacion.id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);	
    $stmt->bindParam(':listo', $listo, PDO::PARAM_STR);	
    $stmt->bindParam(':decision', $decision, PDO::PARAM_STR);	
    $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
    $stmt->bindParam(':c1', $orig, PDO::PARAM_STR);	
    $stmt->bindParam(':c2', $nove, PDO::PARAM_STR);	
    $stmt->bindParam(':c3', $inno, PDO::PARAM_STR);	
    $stmt->bindParam(':c4', $rele, PDO::PARAM_STR);	
    $stmt->bindParam(':c5', $conv, PDO::PARAM_STR);	
    $stmt->bindParam(':c6', $sign, PDO::PARAM_STR);	
    $stmt->bindParam(':c7', $cali, PDO::PARAM_STR);	
    $stmt->bindParam(':c8', $pres, PDO::PARAM_STR);	

    	
    $resp=$stmt->execute();
    unset($stmt);
    unset($pdo);

    return $resp;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id=$_POST["evaluacion"];
    $listo=$_POST["listo"];
    $decision=$_POST["decision"];
    $comentario=$_POST["comentario"];

    $orig=$_POST["originalidad"];
    $nove=$_POST["novedad"];
    $inno=$_POST["innovacion"];
    $rele=$_POST["relevancia"];
    $conv=$_POST["conveniencia"];
    $sign=$_POST["significancia"];
    $cali=$_POST["calidad"];
    $pres=$_POST["presentacion"];

    $sinError=registrarRespuesta($id, $listo, $decision, $comentario,$orig,$nove,$inno,$rele,$conv,$sign,$cali,$pres);
    if ($sinError){
        echo "Muchas Gracias. La evaluación ha sido enviada";
    }
    else{
        echo "Hubo un error.";
    }

}

?>
