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

require_once 'PHPExcel.php';

$objPHPExcel = new PHPExcel();
$archivo = "phpexcel.xls";

$mysqlCon = new mysqli("localhost:3306", "root", "acceso01", "229564reproenea");

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
			->setCellValue("A".$y,'Usuario')
			->setCellValue("A".$y,'Password');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:B1')
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
			->getStyle('A1:B1')
			->applyFromArray($borders);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');

exit;

?>