<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);

$departamento = htmlspecialchars($_POST["departamento"]);
$subDepartamentoDesc = utf8_decode(htmlspecialchars($_POST["nombreSubDepartamento"]));
$treinta = htmlspecialchars($_POST["treintabarra"]);



if ($stmt = $mysqlCon->prepare($sentenciaInsertSubDepartamento)) {
    $idSubdepartamento = recuperaMaxSubDpto($departamento);
    
    if ($idSubdepartamento == null)
        $idSubdepartamento = 1;
    
    
	$stmt->bind_param('iiss',$departamento, $idSubdepartamento, trim($subDepartamentoDesc),trim($treinta));
	$stmt->execute();
} else {
// 	header("Location: ../../formularios/confirmacion.php?mensaje=8");
// 	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();


header("Location: ../../formularios/confirmacion.php?mensaje=7");
exit;


function recuperaMaxSubDpto($departamento){
    
    global $recuperaMaxSubDptoQuery,$mysqlCon;
    $idMaximo = 1;
    
    /*Prepare Statement*/
    if ($stmt = $mysqlCon->prepare($recuperaMaxSubDptoQuery)) {
        /*Asociacion de parametros*/
        $stmt->bind_param('i',$departamento);
        /*Ejecucion*/
        $stmt->execute();
        /*Asociacion de resultados*/
        $stmt->bind_result($col1);
        /*Recogemos el resultado en la variable*/
        while ($stmt->fetch()) {
            if ($col1!=null)
                $idMaximo = $col1;
        }
        /*Cerramos la conexion*/
        $stmt->close();
    }else{
        echo $stmt->error;
    }
    
    return $idMaximo;
}


?>