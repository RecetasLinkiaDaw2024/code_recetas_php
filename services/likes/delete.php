<?php
/***
* SERVICIO DE Eliminar Like o Dislike
* JSON CON PARAMETROS ID-RECETA Y TIPO Y NOS CARGAMSO EL LIKE O  DISLIKE 
*/
require_once(__DIR__."/../../security/controller/check_user.php");
require_once(__DIR__."/../../data/likes.php");

// Verificar que se haya recibido una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON enviado en la solicitud POST
    $json_data = file_get_contents('php://input');
    
    // Decodificar el JSON recibido
    $request_data = json_decode($json_data, true);
    
    // Verificar si el JSON contiene el campo 'id-receta'
    if (isset($request_data['id-receta']) && isset($request_data['tipo'])) {

        $userid=getUserLogado()->getId();
        $num_likes = 0;
        deleteLikeODislike($userid,$request_data['id-receta']);
        if ($request_data['tipo'] == 'L'){
            $num_likes = contarLikesReceta($request_data['id-receta']);
        }else{
            $num_likes = contarDisLikesReceta($request_data['id-receta']);
        }
        // Aquí iría la lógica para obtener el número de likes de la receta con el id proporcionado
        // En este ejemplo, simplemente se devuelve un número aleatorio entre 0 y 100 como ejemplo
        
        
        // Crear un arreglo asociativo con el número de likes
        $response_data = array('num-likes' => $num_likes);
        
        // Convertir el arreglo asociativo a JSON
        $json_response = json_encode($response_data);
        
        // Establecer las cabeceras de respuesta para indicar que el contenido es JSON
        header('Content-Type: application/json');
        
        // Devolver el JSON como respuesta
        echo $json_response;
    } else {
        // Si el campo 'id-receta' no está presente en el JSON recibido, devolver un mensaje de error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array('error' => 'El campo \'id-receta\' es obligatorio en el JSON enviado.'));
    }
} else {
    // Si la solicitud no es POST, devolver un mensaje de error
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array('error' => 'Solo se permite el método POST.'));
}
?>
