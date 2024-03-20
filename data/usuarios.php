<?php
require_once("conexion_db.php");

function getUsuarioById($id){
    $query = "select u.*, COUNT(r.id_receta) as count_recetas from USUARIOS u left join RECETAS r on (r.id_autor=u.id_usuario) where id_usuario = ? group by 
    u.id_usuario,
    u.nombre,
    u.clave_acceso,
    u.email,
    u.es_administrador
     order by u.id_usuario ASC";
    return getRegistroByID($query ,$id);
}


//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findUsuarios($busqueda){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($busqueda)){
        $condiciones ="where u.email LIKE ? or u.nombre LIKE ?";
    }
//

    $query = "select u.*, COUNT(r.id_receta) as count_recetas from USUARIOS u left join RECETAS r on (r.id_autor=u.id_usuario) $condiciones group by 
    u.id_usuario,
    u.nombre,
    u.clave_acceso,
    u.email,
    u.es_administrador
     order by u.id_usuario ASC";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($busqueda)){
        $patron = "%".$busqueda."%";
        $stmt->bind_param("ss", $patron,$patron );
    }
//  

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();    
    $array_de_retorno = array();
    while ($row = $result->fetch_assoc()) {
        array_push($array_de_retorno, $row);
    }

//cerramos todo    
    $stmt->close();
    $conn->close();
    return $array_de_retorno;
}

/**
 * $data es un array asociativo con los siguientes campos.
 * Si un campo es vacio, hay qwue mandarlo tb
 * 
 */
function createUsuario($data){
    $conn = conectar_db();
    $stmt = $conn->prepare("insert INTO USUARIOS (nombre, clave_acceso, email,es_administrador) VALUES(?,?,?,?)");
    $es_admin=false;
    if (isset($data['es_administrador']) && $data['es_administrador']==true){
        $es_admin=true;
    }
    $stmt->bind_param("sssi", $data['nombre'], $data['clave_acceso'], $data['email'],$es_admin);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}


function verifica_email($email,$id){
    $conn = conectar_db();
    $stmt = $conn->prepare("select count(*) as cantidad from USUARIOS where email = ? and id_usuario<>?");
    $idParam=0;
    $retorno=false;
    if (isset($id) && !empty($id)){
        $idParam=$id;
    }
    $stmt->bind_param("si", $email,$idParam);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();    
    
    //solo se espera un resultado
    if ($result->num_rows === 0) {
        $retorno= false;
    }else{
        $cantidad = intval(($result->fetch_assoc())['cantidad']);
        $retorno= $cantidad<=0;
    }
    $stmt->close();
    $conn->close();
    return $retorno;
}
/**
 * en $id esta el id de la Usuario a cambiar
 * en $data, array asociativo con lo que quiere cambiar en formato campo -> nuevo valor
 * Si un campo no está en el array, se ignora y no se cambia ese valor.
 * 
*/
function editUsuario($id, $data){
    if (!isset($data['es_administrador'])){
        $data['es_administrador']=false;//falso por omision
    }
    ksort($data);
    $conn = conectar_db();
    $seteosArray=array();
    foreach ($data as $clave => $valor) {
        array_push($seteosArray, "$clave = ?");
    }
    $seteos=implode(", ", $seteosArray);
    $stmt = $conn->prepare("update USUARIOS SET $seteos where id_usuario = ?");
    
//estos binds hay quye ponerlos en orden alfabetico    
    $esadmin=$data['es_administrador']==true?1:0;
    $stmt->bind_param("ssisi", $data['clave_acceso'],$data['email'],$esadmin,$data['nombre'],$id);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $conn->close();
}

function deleteUsuario($id){ //TODO: eliminar lo que ha hecho el usuario???
    return deleteRegistroByID("delete FROM USUARIOS WHERE id_usuario = ?",$id);
}


//login de usuario. busca en BBDD un usuario con un email y clave y lo retorna si lo encuentra.
function login($email,$clave){
    $sql = "SELECT u.* FROM USUARIOS u WHERE u.email= ? AND u.clave_acceso=?"; //TODO: cifrar
    $conn = conectar_db();
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    
    $stmt->bind_param("ss", $email,$clave);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();    
    
    //solo se espera un resultado
    if ($result->num_rows === 0) {
        $row = null;//no hay datos
    }else{
        $row = $result->fetch_assoc();
    }

//cerramos todo    
    $stmt->close();
    $conn->close();
    return $row;
}

?>