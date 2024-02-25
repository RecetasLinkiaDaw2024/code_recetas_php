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
    header('Location: listado.php');
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
<!-- TODO estilos de la aplicacion css -->

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
        <input type="submit" value="Guardar">
    </form>
</section>
</article>

<footer>
        <!-- TODO: insertar el footer -->
</footer>
</html>