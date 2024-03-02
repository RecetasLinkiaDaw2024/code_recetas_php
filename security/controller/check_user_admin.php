<?php
require_once(__DIR__."/check_user.php");

// Verificar si el usuario ha iniciado sesión
$usuario = getUserLogado();
if (!isset($usuario) || $usuario->getIsAdmin()==false) {//ver que retorna esto        
    header("Location: ".DEPLOY_PATH."/security/view/no_tiene_permisos.html");
    exit();
}

?>