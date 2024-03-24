<?php
require_once("conexion_db.php");

function getAlmacenamientoById($id){
    return getRegistroByID("select * from ALMACENAMIENTO where id_almacenamiento = ?",$id);
}

/**
 * $data es un array asociativo con los siguientes campos.
 * Si un campo es vacio, hay qwue mandarlo tb
 * 
 */
function createAlmacenamiento($ruta,$nombre){
    $conn = conectar_db();
    $stmt = $conn->prepare("INSERT INTO ALMACENAMIENTO (ruta, nombre) 
    VALUES(?, ?);");

    $stmt->bind_param("ss", $ruta,$nombre);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }

    $id_insertado = mysqli_insert_id($conn);

    $stmt->close();
    $conn->close();

    return $id_insertado;
}
/**
 * en $id esta el id de la Almacenamiento a cambiar
 * en $data, array asociativo con lo que quiere cambiar en formato campo -> nuevo valor
 * Si un campo no está en el array, se ignora y no se cambia ese valor.
 * 
*/
function editAlmacenamiento($id, $data){
    ksort($data);
    $conn = conectar_db();
    $seteosArray=array();
    foreach ($data as $clave => $valor) {
        array_push($seteosArray, "$clave = ?");
    }
    $seteos=implode(", ", $seteosArray);

    $stmt = $conn->prepare("update ALMACENAMIENTO SET $seteos where id_almacenamiento = ?");
    
    //estos binds hay quye ponerlos en orden alfabetico    
    $stmt->bind_param("ssi", $data['nombre'],$data['ruta'],$id);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}

function deleteAlmacenamiento($id){
    return deleteRegistroByID("delete FROM ALMACENAMIENTO WHERE id_almacenamiento = ? ",$id);
}


function removeFotoUsuario ($id_usuario){
    //obtengo el id_foto
    $foto = getRegistroByID("select id_foto from USUARIOS where id_usuario = ?",$id);
    //melo cargo
    deleteRegistroByID("update USUARIOS set id_foto=null where id_usuario = ?",$id_usuario);
    //me cargo el registro
    return deleteAlmacenamiento($foto['id_foto']);
} 
?>