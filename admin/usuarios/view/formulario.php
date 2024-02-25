<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../../data/usuarios.php");

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //hay que insertar un usuario
    //TODO ampliar con la edición
    $datos= array();
    $datos['nombre']=$_POST['nombre'];
    $datos['email']=$_POST['email'];
    $datos['clave_acceso']=$_POST['password'];
    createUsuario($datos);
    header('Location: ../?mensaje=OkGrabar');
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
<!-- TODO estilos de la aplicacion css -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
<!-- iconos de material icons de google, para ver los disaponibles mirar https://fonts.google.com/icons?icon.set=Material+Icons-->
<!-- TODO levar estos estilos css estilos-->
</style>
</head>
<body>
<header>
        <!-- TODO: insertar la cabecera -->
</header>
</body>
<article>
<section><h2>Nuevo usuario</h2></section><!-- TODO: cambiar cuando editamos-->
<section>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <button type="submit" value="Guardar">
            <span class="material-icons-outlined">save</span><span>GUARDAR</span>
        </button>
        <button value="Cancelar" onclick="window.location='../';return false;">
            <span class="material-icons-outlined">cancel</span><span>VOLVER</span>
        </button>

    </form>
</section>
</article>

<footer>
        <!-- TODO: insertar el footer -->
</footer>
</html>