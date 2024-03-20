<?php
require_once(__DIR__."/../../../data/ingredientes.php");

if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['id_ingrediente'])){

    //recojemos el usuaario
    deleteIngrediente($_POST['id_ingrediente']);
    header('Location: ../?mensaje=OkErase');
}else{
    header('Location: ../');
}

?>