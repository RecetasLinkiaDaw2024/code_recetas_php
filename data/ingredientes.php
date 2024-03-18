<?php
require_once("conexion_db.php");

function getIngredienteById($id){
    return getRegistroByID("select * from INGREDIENTES where id_ingrediente = ?",$id);
}

//obtenemos todos los ingredientes de una receta
function getIngredientesByIdReceta($idReceta){
  $query="select ir.*,i.tipo, i.nombre as nombre_ingrediente from 
   INGREDIENTES_RECETA ir inner join INGREDIENTES i ON (i.id_ingrediente=ir.id_ingrediente) 
   where ir.id_receta = ?";
  $conn = conectar_db();

  $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    

//BLOQUE DE BIND FILTROS , hay que hacerlo en el mismo oreden que las condiciones
    if (!empty($idReceta)){
        $stmt->bind_param("i", $idReceta);
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

//TODO: Pendiente ver que filtros pueden hacer falta, por ahora solo el autor
//TODO: Necesita una ordenación?
function findIngredientes($busqueda){
    $conn = conectar_db();

//BLOQUE DE CONDICIONES  
    $condiciones ="";
    if (!empty($busqueda)){
        $condiciones ="where tipo LIKE ? or nombre LIKE ?";
    }
//

    $query = "select * from INGREDIENTES $condiciones order by id_ingrediente ASC";
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
    $stmt = $conn->prepare("insert INTO INGREDIENTES (tipo, nombre) VALUES(?,?)");
    $stmt->bind_param("ss", $data['tipo'], $data['nombre']);

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
    $seteos=implode(", ", $seteosArray);

    $stmt = $conn->prepare("update INGREDIENTES SET $seteos where id_ingrediente = ?");
    
    //estos binds hay quye ponerlos en orden alfabetico    
    $stmt->bind_param("ssi", $data['nombre'],$data['tipo'],$id);

    if (!$stmt->execute()) {
        die("Error al ejecutar el guardado: " . $stmt->error);
    }

    $conn->close();
}

function deleteIngrediente($id){
    return deleteRegistroByID("delete FROM INGREDIENTES WHERE id_ingrediente = ? ",$id);
}

?>