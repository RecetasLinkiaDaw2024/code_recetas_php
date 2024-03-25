<?php
/***
* SERVICIO DE Eliminar Like o Dislike
* JSON CON PARAMETROS ID-RECETA Y TIPO Y NOS CARGAMSO EL LIKE O  DISLIKE 
*/
require_once(__DIR__."/../../security/controller/check_user.php");
require_once(__DIR__."/../../data/likes.php");

// Verificar que se haya recibido una solicitud POST
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id-receta']) ){
//hay que ver que eligio el tipo
    $userid=getUserLogado()->getId();
    $tipo=getTipoLike($userid, $_GET['id-receta']);
     // Crear un arreglo asociativo con el número de likes
     $response_data = array('tipo' => $tipo);
        
     // Convertir el arreglo asociativo a JSON
     $json_response = json_encode($response_data);
     
     // Establecer las cabeceras de respuesta para indicar que el contenido es JSON
     header('Content-Type: application/json');
     
     // Devolver el JSON como respuesta
     echo $json_response;
}
else {
    // Si la solicitud no es POST, devolver un mensaje de error
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array('error' => 'Solo se permite el método POST o GET con los parametros id-receta y tipo.'));
}
?>
