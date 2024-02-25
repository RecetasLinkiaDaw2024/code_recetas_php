<?php
require_once("conexion_db.php");

function getIngredienteById($id){
    return getRegistroByID("select * from INGREDIENTES where id_ingrediente = ?",$id);
}


//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findIngredientes($tipo){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($tipo)){
        $condiciones ="where tipo LIKE ?";
    }
//

    $query = "select * from INGREDIENTES $condiciones order by id_ingrediente ASC";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($tipo)){
        $stmt->bind_param("s", $tipo);
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
function createIngrediente($data){
    $conn = conectar_db();
    $stmt = $conn->prepare("insert INTO INGREDIENTES (tipo, ingredientes) VALUES(?,?)");
    $stmt->bind_param("s", $data['tipo']);
    $stmt->bind_param("s", $data['ingredientes']);    

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}
/**
 * en $id esta el id de la Ingrediente a cambiar
 * en $data, array asociativo con lo que quiere cambiar en formato campo -> nuevo valor
 * Si un campo no está en el array, se ignora y no se cambia ese valor.
 * 
*/
function editIngrediente($id, $data){
    ksort($data);
    $conn = conectar_db();
    $seteosArray=array();
    foreach ($data as $clave => $valor) {
        array_push($seteosArray, "$clave = ?");
    }
    $seteos="";
    $stmt = $conn->prepare("update INGREDIENTES SET $seteos where id_ingrediente = ?");
    
//estos binds hay quye ponerlos en orden alfabetico    
    bindIfExist("ingredientes",$data,"s",$stmt);
    bindIfExist("tipo",$data,"s",$stmt);  
    $stmt->bind_param("i", $id);//el ultimo es el id
    $conn->close();
}

function deleteIngrediente($id){
    return deleteRegistroByID("delete FROM INGREDIENTES WHERE id_ingrediente = ? CASCADE",$id);
}

?>