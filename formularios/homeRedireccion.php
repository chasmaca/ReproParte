<?php
session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$path  = "../utiles/connectDBUtiles.php";
include_once($path);

$pathUsuario = "../dao/select/usuario.php";

include_once($pathUsuario);

if ($_SESSION["role_session"] == null){
	header("Location: ../index.php?error=1");
	exit;
}

//Administrador
if ($_SESSION["role_session"]=="1"){
	header("Location: homeAdministrador.php");
	exit;
}

//Gestor
if ($_SESSION["role_session"]=="2"){
	header('Location: homeGestor.php?id='.$_SESSION["userId_session"]);
	exit;
}

//Autorizador
if ($_SESSION["role_session"]=="3"){
	header("Location: homeValidador.php");
	exit;
}

//Plantilla
if ($_SESSION["role_session"]=="4"){
	header("Location: homeTrabajo.php");
	exit;
}

//Impresoras
if ($_SESSION["role_session"]=="6"){
	header("Location: homeImpresora.php");
	exit;
}

?>