<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
	
	session_start();

	date_default_timezone_set("Europe/Madrid");
	
	$path  = "../utiles/connectDBUtiles.php";
	$pathinforme = "../dao/select/consultaInforme.php";
	$pathCabecera = "../utiles/cabecera_formulario.php";
	
	include_once($path);
	include_once($pathinforme);
	require_once '../Classes/PHPExcel.php';
	
	$usuario = $_SESSION["userId_session"];
	
	$objPHPExcel = new PHPExcel();
	$archivo = "phpexcel.xls";
	
	$objPHPExcel->getProperties()->setCreator("Eneasp")
	->setLastModifiedBy("Eneasp")
	->setTitle("informe")
	->setSubject("Informe de gastos")
	->setDescription("Informe de gastos")
	->setKeywords("Eneasp")
	->setCategory("");
		
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
	->setCellValue("D".$y,'FECHA DE CIERRE')
	->setCellValue("E".$y,'BLANCO Y NEGRO')
	->setCellValue("F".$y,'COLOR')
	->setCellValue("G".$y,'ENCUADERNACIONES')
	->setCellValue("H".$y,'VARIOS')
	->setCellValue("I".$y,'TOTAL');

	$objPHPExcel->getActiveSheet()
	->getStyle('A1:I1')
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
	->getStyle('A1:I1')
	->applyFromArray($borders);
	
	if( isset($_POST['anioParam']) && isset($_POST['depParametro'])){
		
		$anio = htmlspecialchars($_POST["anioParam"]);
		$dpto = htmlspecialchars($_POST["depParametro"]);
		
		if ($anio != 0 && $dpto != 0)
			$resultValida = recuperaGlobalMesValidador($mysqlCon,$usuario,$anio,$dpto);
		else 
			$resultValida = null;
		
		$rowCount = 2;
		$totalFinal = 0;
		
		if ($resultValida!=null)
		while ($fila = mysqli_fetch_assoc($resultValida)) {
			$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'];
			$totalFinal = $totalFinal + $total;
					
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $fila['esb']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $fila['codigo']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $fila['departamento']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $fila['fecha']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $fila['byn']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $fila['color']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $fila['encuadernacion']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $fila['varios']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $total);
		
			$rowCount++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$archivo.'"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
	}else{
		
	}
	

