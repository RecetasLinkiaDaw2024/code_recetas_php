<?php
require_once(__DIR__."/../../../data/usuarios.php");

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['id_usuario'])){

    //recojemos el usuaario
    deleteUsuario($_POST['id_usuario']);
    header('Location: ../?mensaje=OkErase');
}else{
    header('Location: ../');
}

?>