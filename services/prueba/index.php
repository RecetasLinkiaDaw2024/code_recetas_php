<?php
require_once(__DIR__."/../../data/usuarios.php");

//prueba para servicios REST
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        die("Operacion no permitida");
        break;
    case 'POST':
        die("Operacion no permitida");
        break;
    case 'PUT':
        actualizarUsuario($data, $_GET['id']);
        break;
    case 'DELETE':
        eliminarUsuario($_GET['id']);
        break;
}

function actualizarUsuario($data, $id) {
    // Validar los datos
    // ...
    if (!isset($id) || empty($id)) {
        echo json_encode(array('error' => 'ID no especificado'));
        return;
    }    
    if (!isset($data['nombre']) || empty($data['nombre'])) {
        echo json_encode(array('error' => 'Nombre no especificado'));
        return;
    }
    if (!isset($data['email']) || empty($data['email'])) {
        echo json_encode(array('error' => 'Email no especificado'));
        return;
    }
    if (!isset($data['clave_usuario']) || empty($data['clave_usuario'])) {
        echo json_encode(array('error' => 'Nombre no especificado'));
        return;
    }
    // Actualizar el usuario en la base de datos
    editUsuario($id,$data);
    echo json_encode(array('success' => true));
}

function eliminarUsuario($id) {
    // Eliminar el usuario con el ID especificado de la base de datos
    // ...

    echo json_encode(array('success' => true));
}
?>