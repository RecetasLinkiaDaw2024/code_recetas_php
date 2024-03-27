<?php
require_once("conexion_db.php");

function getComentarioById($id){
    return getRegistroByID("select c.*,u.nombre as nombre_autor, u.id_foto as foto_autor from COMENTARIOS c inner join USUARIOS u on (u.id_usuario=c.id_usuario) where id_comentario = ?",$id);
}


//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findComentarios($id_receta){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($id_receta)){
        $condiciones ="where id_receta = ?";
    }
//

    $query = "select c.*,u.nombre as nombre_autor, u.id_foto as foto_autor from COMENTARIOS c left join USUARIOS u on (u.id_usuario=c.id_usuario) $condiciones order by c.id_receta ASC";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($id_receta)){
        $stmt->bind_param("i", $id_receta);
    }
//

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();    
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        array_push($rows, $row);
    }

//cerramos todo    
    $stmt->close();
    $conn->close();
    return $rows;
}

/**
 * $data es un array asociativo con los siguientes campos.
 * Si un campo es vacio, hay qwue mandarlo tb
 * 
 */
function createComentario($data){
    $conn = conectar_db();
    $stmt = $conn->prepare("insert INTO COMENTARIOS (id_receta, id_usuario, txt_comentario) VALUES( ?, ?, ? )");
    $stmt->bind_param("iis", $data['id_receta'], $data['id_usuario'], $data['txt_comentario']);
    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}
/**
 * en $id esta el id de la receta a cambiar
 * en $data, array asociativo con lo que quiere cambiar en formato campo -> nuevo valor
 * Si un campo no está en el array, se ignora y no se cambia ese valor.
 * 
*/
function editComentario($id, $data){
    ksort($data);
    $conn = conectar_db();

    $stmt = $conn->prepare("update COMENTARIOS SET txt_comentario = ? where id_comentario = ?");
    
    $stmt->bind_param("si", $data['txt_comentario'], $id);//el ultimo es el id
    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $conn->close();
}

function deleteComentario($id){
    return deleteRegistroByID("delete FROM COMENTARIOS WHERE id_comentario = ? ",$id);
}

?>