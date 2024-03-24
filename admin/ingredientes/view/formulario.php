<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../../data/ingredientes.php");

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //hay que insertar un ingrediente
    //TODO ampliar con la edición
    $datos= array();
    $datos['nombre']=$_POST['nombre'];
    $datos['tipo']=$_POST['tipo'];

        if(empty($_POST['id-ingrediente'])){//sino hay id creamos
            createIngrediente($datos);
            header('Location: ../?mensaje=OkGrabar');
        }else{
            editIngrediente($_POST['id-ingrediente'],$datos); //si hay id, actualizamos
            header('Location: ../?mensaje=OkGrabar');
        }
}else{
    $data_ingrediente=[];
    if (isset($_GET['id-ingrediente'])){
        $data_ingrediente=getIngredienteById($_GET['id-ingrediente']);
    }else{
        $data_ingrediente=array("nombre"=>"", "tipo"=>"");
    }
}

$tipos_ingredientes = [
"lacteos","especies","condimento","espesantes","fruta",
"frutos secos","legumbres","licor","marisco","masas","pescado","salsa","verdura","vino","otros"];


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
<section class="seccion"><h2>Nuevo ingrediente</h2></section><!-- TODO: cambiar cuando editamos-->
<section class="seccion">
    <form method="POST" class="formulario">             
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $data_ingrediente['nombre'] ?>" required>
        <label for="email">Tipo:</label>
        
        <select name="tipo" id="tipo" required>
            <?php
                foreach ($tipos_ingredientes  as $valor){
                    if ($valor == $data_ingrediente['tipo']){
                        echo "<option value=\"$valor\" selected>$valor</option>";
                    }else{
                        echo "<option value=\"$valor\">$valor</option>";
                    }
                }
            ?>
        </select>
        <div class="botonera">
        <button type="submit" value="Guardar">
            <span class="material-icons-outlined">save</span><span>GUARDAR</span>
        </button>
        <button value="Cancelar" onclick="window.location='../';return false;">
            <span class="material-icons-outlined">cancel</span><span>VOLVER</span>
        </button>
        </div>
        <?php
        if (isset($data_ingrediente['id_ingrediente'])){
            echo "<input type=\"hidden\" name=\"id-ingrediente\"  value=\"".$data_ingrediente['id_ingrediente']."\"/>"; 
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