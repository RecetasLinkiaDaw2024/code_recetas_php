<?php
require_once("conexion_db.php");

function getUsuarioById($id){
    return getRegistroByID("select * from USUARIOS where id_usuario = ?",$id);
}


//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findUsuarios($email){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($email)){
        $condiciones ="where email LIKE ?";
    }
//

    $query = "select * from USUARIOS $condiciones order by id_usuario ASC";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($email)){
        $stmt->bind_param("s", $email);
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
function createUsuario($data){
    $conn = conectar_db();
    $stmt = $conn->prepare("insert INTO USUARIOS (nombre, clave_acceso, email) VALUES(?,?,?)");
    $stmt->bind_param("s", $data['nombre']);
    $stmt->bind_param("s", $data['clave_acceso']);
    $stmt->bind_param("s", $data['email']);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}
/**
 * en $id esta el id de la Usuario a cambiar
 * en $data, array asociativo con lo que quiere cambiar en formato campo -> nuevo valor
 * Si un campo no está en el array, se ignora y no se cambia ese valor.
 * 
*/
function editUsuario($id, $data){
    ksort($data);
    $conn = conectar_db();
    $seteosArray=array();
    foreach ($data as $clave => $valor) {
        array_push($seteosArray, "$clave = ?");
    }
    $seteos="";
    $stmt = $conn->prepare("update USUARIOS SET $seteos where id_usuario = ?");
    
//estos binds hay quye ponerlos en orden alfabetico    
    bindIfExist("clave_acceso",$data,"s",$stmt);
    bindIfExist("email",$data,"s",$stmt);
    bindIfExist("nombre",$data,"s",$stmt);    
    $stmt->bind_param("i", $id);//el ultimo es el id
    $conn->close();
}

function deleteUsuario($id){
    return deleteRegistroByID("delete FROM USUARIOS WHERE id_usuario = ? CASCADE",$id);
}

?>