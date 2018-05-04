<?php

include ('query.php');

/**
 * Recuperamos todos los subdepartamentos
 */
function recuperaTodosSubDepartamentos(){
 
}


/**
 * Recuperamos todos los subdepartamentos de un departamento pasado por parametro
 * @param unknown $dpto
 */
function recuperaSubXDpto($dpto){
    global $recuperaSubdptoXDpto,$mysqlCon;
    $valores = "";
    $valoresArray =  array();
    
   
    /*Prepare Statement*/
    if ($stmt = $mysqlCon->prepare($recuperaSubdptoXDpto)) {

        /*Asociacion de parametros*/
        $stmt->bind_param('i',$dpto);

        /*Ejecucion*/
        $stmt->execute();

        /*Asociacion de resultados*/
        /*Id Departamento, Id SubDepartamento, Descripcion SubDepartamento, treintabarra*/
        $stmt->bind_result($col1,$col2,$col3,$col4);

        /*Recogemos el resultado en la variable*/
      	while ($stmt->fetch()) {
			$valores = array($col1,$col2,$col3,$col4);
			array_push($valoresArray,$valores);
			
		}

        /*Cerramos la conexion*/
        $stmt->close();

    }else{
        echo $stmt->error;
    }
    
    return $valoresArray;
}

/**
 * Recupera unicamente los id de subdepartamentos existentes, 
 * @param unknown $dpto
 */
function recuperaIdSubXDpto($dpto){
    global $recuperaIdSubdptoXDpto,$mysqlCon;
    $valores = "";
    
    /*Prepare Statement*/
    if ($stmt = $mysqlCon->prepare($recuperaIdSubdptoXDpto)) {
    
        /*Asociacion de parametros*/
        $stmt->bind_param('i',$dpto);
    
        /*Ejecucion*/
        $stmt->execute();
    
        /*Asociacion de resultados*/
        /*Id Departamento, Id SubDepartamento, Descripcion SubDepartamento, treintabarra*/
        $stmt->bind_result($col1);
    
        /*Recogemos el resultado en la variable*/
        while ($stmt->fetch()) {
            if ($valores == "")
                $valores = $col1;
            else 
                $valores .= "," . $col1;
        }
    
        /*Cerramos la conexion*/
        $stmt->close();
    
    }else{
        echo $stmt->error;
    }
    
    return $valores;
}

/**
 * 
 */
function recuperaSubdepartamentoXId($id){
	
	global $recuperaSubdepartamentoPorIdQuery,$mysqlCon;
	$valores = "";

	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubdepartamentoPorIdQuery)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('i',$id);
		
		/*Ejecucion*/
		$stmt->execute();

		/*Asociacion de resultados*/
		/*Id Departamento, Id SubDepartamento, Descripcion SubDepartamento, treintabarra*/
		$stmt->bind_result($col1);
		
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			if ($valores == "")
				$valores = $col1;
				else
					$valores .= "," . $col1;
		}
		
		/*Cerramos la conexion*/
		$stmt->close();
		
		}else{
			echo $stmt->error;
		}
		
		return $valores;

}

?>