<?php
require_once(__DIR__."/../../security/controller/check_user_admin.php");
require_once(__DIR__."/../../data/comentarios.php");

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['id_comentario'])){

    //recojemos el comentario
    deleteComentario($_POST['id_comentario']);
    header('Location: comentarios_receta.php?mensaje=OkErase&id-receta=' . $_GET['id-receta']);
}else{
    header('Location: comentarios_receta.php?id-receta=' . $_GET['id-receta']);
}

?>