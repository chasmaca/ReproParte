<?php

	function generaDetalladoCierreValidador(){
		
		date_default_timezone_set("Europe/Madrid");
		include_once("../utiles/connectDBUtiles.php");
		include_once("../dao/select/consultaInforme.php");
		require_once '../Classes/PHPExcel.php';
		
		$objPHPExcel = new PHPExcel();
		$archivo = "Cierre Mes.xls";
		
		$objPHPExcel->getProperties()->setCreator("Eneasp")
		->setLastModifiedBy("Eneasp")
		->setTitle("informe de gastos del Cierre de Mes")
		->setSubject("Informe de gastos del Cierre de Mes")
		->setDescription("Informe de gastos del Cierre de Mes")
		->setKeywords("Eneasp")
		->setCategory("Cierre Mensual");
		
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getRowDimension('A')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getRowDimension('B')->setRowHeight(20);
		
		$y = 1;
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$y,'ESB')
		->setCellValue("B".$y,'CODIGO')
		->setCellValue("C".$y,'DEPARTAMENTO')
		->setCellValue("D".$y,'BLANCO Y NEGRO')
		->setCellValue("E".$y,'COLOR')
		->setCellValue("F".$y,'ENCUADERNACIONES')
		->setCellValue("G".$y,'VARIOS')
		->setCellValue("H".$y,'TOTAL');
		
		$objPHPExcel->getActiveSheet()
		->getStyle('A1:H1')
		->getFill()
		->getFillType(PHPExcel_Style_Fill::FILL_SOLID);
		
		$borders = array('borders'=>array(
				'allborders' => array(
						'style'=>PHPExcel_Style_Border::BORDER_THIN,
						'color'=>array('argb'=>'FF000000'),
				)
		),
		);
		
		$objPHPExcel->getActiveSheet()
		->getStyle('A1:H1')
		->applyFromArray($borders);

		if( isset($_POST['anioParam']) && isset($_POST['depParametro'])){
			$anio = htmlspecialchars($_POST["anioParam"]);
			$dpto = htmlspecialchars($_POST["depParametro"]);
			$recuperaInforme = recuperaInformesGlobalMes($mysqlCon,$anio,$dpto);
		}else{
			$anio = "10/2016";
			$dpto = "265";
			$recuperaInforme = recuperaInformesGlobalMes($mysqlCon,$anio,$dpto);
		}
		
		$rowCount = 2;
		while($fila = mysqli_fetch_assoc($recuperaInforme)){
			$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'];
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $fila['codigo']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $fila['CeCo']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $fila['departamentos_desc']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $fila['byn']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $fila['color']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $fila['encuadernacion']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $fila['varios']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total);
		
			$rowCount++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$archivo.'"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		//$objWriter->save('php://output');
		return $objWriter;
	}

?>