<?php

$_SESSION["role_session"] = null;
$_SESSION["nombre_session"] = null;
$_SESSION["userId_session"] = null;

// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("Location: ../index.php");

?>