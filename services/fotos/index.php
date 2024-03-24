<?php
/***
* SERVICIO DE DESCARGA DE FOTOS.
* SI PONES UN HTML IMG CON SRSC APUNTANDO A ESTA URL CON ID PASADO POR PARAMETROS, 
* TIENES LA IMAGEN. HAY UN EJEMPLO EN /admin/usuarios/view/listado.php
* echo "<img src=\"../../services/fotos?id=".$usuario['id_foto']."\" alt=\"Imagen Usuario\">";
*/
require_once(__DIR__."/../../security/controller/check_user.php");
require_once(__DIR__."/../../data/almacenamiento.php");


function lanza_error_404(){
     // Si el archivo no existe, devolver un código de estado 404
     http_response_code(404);
     echo "La imagen no se encontró.";
}

if (isset($_GET['id'])){

    $id=$_GET['id'];

    $data=getAlmacenamientoById($id);
    if (!isset($data)){
        lanza_error_404();
        die();
    }

    // Ruta del archivo de imagen
    $ruta_archivo = APP_ROOT."/".$data['ruta']."/".$data['nombre'];
    $extension = pathinfo($data['nombre'], PATHINFO_EXTENSION);

    // Verificar si el archivo existe
    if (isset($_GET['id']) && file_exists($ruta_archivo)) {
        // Establecer las cabeceras para indicar que se trata de una imagen
        switch ($extension) {
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'jpg':
                header('Content-Type: image/jpeg');
                break;
            case 'svg':
                header('Content-Type: image/svg');
                break;            
        }
        header('Content-Disposition: filename="'.$data['nombre'].'"');
        header('Content-Length: ' . filesize($ruta_archivo));

        // Leer y enviar el contenido del archivo
        readfile($ruta_archivo);
    } else {
        lanza_error_404();
    }
} else {
    lanza_error_404();
}

?>