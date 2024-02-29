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

    if(empty($_POST['id_usuario'])){//sino hay id creamos
        createUsuario($datos);
    }else{
        editUsuario($_POST['id_usuario'],$datos); //si hay id, actualizamos
    }
    header('Location: ../?mensaje=OkGrabar');
}else{
    $data_usuario=[];
    if (isset($_GET['id-user'])){
        $data_usuario=getUsuarioById($_GET['id-user']);
    }else{
        $data_usuario=array("nombre"=>"", "email"=>"", "clave_acceso"=>"");
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
<!-- TODO estilos de la aplicacion css -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
<!-- iconos de material icons de google, para ver los disaponibles mirar https://fonts.google.com/icons?icon.set=Material+Icons-->
<!-- TODO levar estos estilos css estilos-->
<style>
    .formulario{
        display: flex;
        flex-direction: column;     
    }
    .botonera{
        display: flex;
        flex-direction: row; 
       
    }
    .botonera >button{
        margin-top: 3px;     
        min-width: 50%;   
    }
    .seccion{
        padding: 25px;
        max-width: 250px;
    }
</style>
</head>
<body>
<header>
        <!-- TODO: insertar la cabecera -->
</header>
<article>
<section class="seccion"><h2>Nuevo usuario</h2></section><!-- TODO: cambiar cuando editamos-->
<section class="seccion">
    <form method="POST" class="formulario">                
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $data_usuario['nombre'] ?>" required>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $data_usuario['email'] ?>" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <div class="botonera">
        <button type="submit" value="Guardar">
            <span class="material-icons-outlined">save</span><span>GUARDAR</span>
        </button>
        <button value="Cancelar" onclick="window.location='../';return false;">
            <span class="material-icons-outlined">cancel</span><span>VOLVER</span>
        </button>
        </div>
        <?php
        if (isset($data_usuario['id_usuario'])){
            echo "<input type=\"hidden\" name=\"id_usuario\"  value=\"".$data_usuario['id_usuario']."\"/>"; 
        }
        ?>
    </form>
</section>
</article>

<footer>
        <!-- TODO: insertar el footer -->
</footer>
</body>

</html>