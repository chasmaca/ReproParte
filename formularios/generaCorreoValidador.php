<?php
include '../utiles/connectDBUtiles.php';
include '../utiles/phpmailer/class.phpmailer.php';
include '../dao/select/autorizador.php';
include 'generaInformeDetalladoCierre.php';

$listadoResult = mysqli_query($mysqlCon,'SELECT * FROM departamento');

if (!$listadoResult) {
	echo "No se pudo ejecutar con exito la consulta (SELECT * FROM departamento) en la BD: " . mysqli_error();
	exit;
}

if (mysqli_num_rows($listadoResult) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	exit;
}
else{
	echo mysqli_num_rows($listadoResult);
}

$row=mysqli_fetch_assoc($listadoResult);
$filename='departamento.xls';
$fp=fopen($filename,"w");
$seperator="";
$comma="";

foreach($row as $name =>$value){
	
	$seperator.=$comma.''.str_replace('','""',$name);
	$comma=",";

}

$seperator.="\n";

fputs($fp,$seperator);

mysqli_data_seek($listadoResult,0);

while($row=mysqli_fetch_assoc($listadoResult)){

	$comma="";
	foreach($row as $name =>$value){
		$seperator.=$comma.''.str_replace('','""',$value);
		$comma=",";
	}
	$seperator.="\n";
	fputs($fp,$seperator);
}

fclose($fp);
$my_file = $filename;

$from_name = "hhhhh";

$from_mail = "abc@gmail.com";

$mailto = "abc@gmail.com";

$subject = "This is a mail with attachment.";

$message = "Este es el contenido del attachment?";

$file = $my_file;
$file_size = filesize($file);

$handle = fopen($file, "r");

$content = fread($handle, $file_size);

fclose($handle);

$content = chunk_split(base64_encode($content));

$header = "From: ".$from_name." <".$from_mail.">\r\n";

$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 

mail($mailto, $subject, $seperator, $header)

?>