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

date_default_timezone_set("Europe/Madrid");

$path  = "../utiles/connectDBUtiles.php";
$pathImpresoras = "../dao/select/impresoras.php";

require_once '../Classes/PHPExcel.php';
include($path);
include_once ($pathImpresoras);

$recuperaImpresoras = recuperaImpresoras();

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
->setCellValue("A".$y,'ID IMPRESORA')
->setCellValue("B".$y,'MODELO')
->setCellValue("C".$y,'EDIFICIO')
->setCellValue("D".$y,'UBICACION')
->setCellValue("E".$y,'FECHA')
->setCellValue("F".$y,'SERIE')
->setCellValue("G".$y,'NUMERO');


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
->getStyle('A1:G1')
->applyFromArray($borders);

$rowCount = 2;

while($fila = mysqli_fetch_assoc($recuperaImpresoras)){
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $fila['IMPRESORA_ID']);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $fila['MODELO']);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $fila['EDIFICIO']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $fila['UBICACION']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $fila['FECHA']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $fila['SERIE']);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $fila['NUMERO']);
	
	$rowCount++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');

?>