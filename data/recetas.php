<?php
require_once("conexion_db.php");

function getRecetaById($id){
    return getRegistroByID("select r.*,u.nombre as nombre_autor from RECETAS r inner join USUARIOS u on (u.id_usuario=r.id_autor) where id_receta = ?",$id);
}


//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findRecetas($id_autor){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($id_autor)){
        $condiciones ="where id_autor = ?";
    }
//

    $query = "select * from RECETAS $condiciones order by id_receta ASC";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($id_autor)){
        $stmt->bind_param("i", $id_autor);
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
function createReceta($data){
    $conn = conectar_db();
    $stmt = $conn->prepare("insert INTO RECETAS (tiempo, comensales, dificultad, preparacion, id_autor, nombre, categoria) VALUES( ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("i", $data['tiempo']);
    $stmt->bind_param("i", $data['comensales']);
    $stmt->bind_param("s", $data['dificultad']);
    $stmt->bind_param("s", $data['preparacion']);
    $stmt->bind_param("i", $data['id_autor']);
    $stmt->bind_param("s", $data['nombre']);
    $stmt->bind_param("s", $data['categoria']);
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
function editReceta($id, $data){
    ksort($data);
    $conn = conectar_db();
    $seteosArray=array();
    foreach ($data as $clave => $valor) {
        array_push($seteosArray, "$clave = ?");
    }
    $seteos=""; //TODO :terminar
    $stmt = $conn->prepare("update RECETAS SET $seteos where id_receta = ?");
    
//estos binds hay quye ponerlos en orden alfabetico    
    bindIfExist("categoria",$data,"s",$stmt);
    bindIfExist("comensales",$data,"i",$stmt);
    bindIfExist("dificultad",$data,"s",$stmt);
    bindIfExist("id_autor",$data,"i",$stmt);
    bindIfExist("nombre",$data,"s",$stmt);
    bindIfExist("preparacion",$data,"s",$stmt);
    bindIfExist("tiempo",$data,"i",$stmt);

    $stmt->bind_param("i", $id);//el ultimo es el id
    
    $conn->close();
}

function deleteReceta($id){
    return deleteRegistroByID("delete FROM RECETAS WHERE id_receta = ? CASCADE",$id);
}

?>