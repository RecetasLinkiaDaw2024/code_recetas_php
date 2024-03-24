<?php
$timeout = 30 * 60; // 30 minutes in seconds
session_set_cookie_params($timeout);
session_start();
require_once(__DIR__."/../../config/settings.php");
require_once(__DIR__."/../model/usuario.php");



// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION[SESSION_USER])) {
    header("Location: ".DEPLOY_PATH."/login/login.html");//TODO: nos planteamos una pantalla intermedia de mensaje de redirección??
    exit();
}
//vamos a definir dos metodos para trabajar el usuario en sesion

function getUserLogado(){
    if (isset($_SESSION[SESSION_USER])){
        $usuario_recuperado = new Usuario(null,null,null,null);
        $usuario_recuperado->unserialize($_SESSION[SESSION_USER]);
        return $usuario_recuperado;
    }else{
        return null;
    }
}

function updateUserData($Usuario){


}
?>