<?php
//Metodos basicos para acceder a BBDD y alguno generico
require_once (__DIR__."/../config/database.php");

function conectar_db(){
    $servername = DB_SERVER;
    $username = DB_USER;
    $password = DB_PASS;   
    $database=DB_DATABASE;
    $puerto=DB_PORT;
    // Crear conexión
    $conn = new mysqli($servername, $username, $password,$database,$puerto);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

function getRegistroByID($sql,$id){
    $conn = conectar_db();
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }    
    $stmt->bind_param("i", $id);
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

function deleteRegistroByID($sql,$id){
    $conn = conectar_db();
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar el borrado: " . $mysqli->error);
    }
    $stmt->bind_param("i", $id); 
    if (!$stmt->execute()) {
        die("Error al ejecutar el borrado: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}

function bindIfExist($nombreVar,$data,$tipo,$stmt){
    if (array_key_exists($nombreVar, $data)) {
        $stmt->bind_param($tipo, $data[$nombreVar]);
    }
}

?>