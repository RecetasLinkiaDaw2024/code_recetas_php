<?php
require_once("conexion_db.php");

/**
 * Devuelve el tipo de Like: 'L' si es like y 'D' si es dislike
 */
function getTipoLike($id_usuario, $id_receta){
    $conn = conectar_db();
    $query = "select * from LIKES where id_usuario = ? and id_receta= ?";
    $retorno = null;
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    
    $stmt->bind_param("ii", $id_usuario, $id_receta);

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();    
    $rows = array();
    if ($row = $result->fetch_assoc()) {
        $retorno = $row['tipo'];
    }

    $stmt->close();
    $conn->close();
    return $retorno;
}

function contarLikesReceta($id_receta){
    $data=getRegistroByID("select count(*) as contado from LIKES where tipo = 'L' and id_receta = ? ",$id_receta);
    return $data['contado'];
}

function contarDisLikesReceta($id_receta){
    $data=getRegistroByID("select count(*) as contado from LIKES where tipo = 'D' and id_receta = ? ",$id_receta);
    return $data['contado'];
}

/** 
* Inserta like / dioslike o edita el que ya tenia el usuario
*/
function insertOrEditLikeDis($id_usuario, $id_receta,$tipo){
    //vamos a ver si esto ya existe primero y hacemos insert o update en función
    $sql="";
    if (is_null(getTipoLike($id_usuario, $id_receta))){
        $sql = "INSERT INTO LIKES (tipo,id_receta, id_usuario) VALUES(?,?,?)";
    }else{
        $sql = "UPDATE LIKES SET tipo=? WHERE id_receta=? AND id_usuario=?";
    }
    $conn = conectar_db();
    $stmt = $conn->prepare( $sql );
    $stmt->bind_param("sii",$tipo, $id_receta, $id_usuario);
    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}


function likeAReceta($id_usuario, $id_receta){
    insertOrEditLikeDis($id_usuario, $id_receta,'L');
}

function disLikeAReceta($id_usuario, $id_receta){
    insertOrEditLikeDis($id_usuario, $id_receta,'D');
}


/**
 * Elimina like o dislike por parte de una receta o usuario
 */
function deleteLikeODislike($id_usuario, $id_receta){
    $conn = conectar_db();
    $stmt = $conn->prepare("DELETE FROM LIKES WHERE id_receta=? AND id_usuario=?");

    if ($stmt === false) {
        die("Error al preparar el borrado: " . $mysqli->error);
    }
    $stmt->bind_param("ii",  $id_receta, $id_usuario); 
    if (!$stmt->execute()) {
        die("Error al ejecutar el borrado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}

?>