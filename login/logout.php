<?php
session_start();
require_once(__DIR__."/../config/settings.php");

session_destroy();
unset($_SESSION[SESSION_USER]);
// Redirecciona a la página de inicio de sesión
header('Location: login.php');
?>