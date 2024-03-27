<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../security/controller/check_user_admin.php");
require_once(__DIR__."/../../data/comentarios.php");

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //hay que insertar un ingrediente
    //TODO ampliar con la edición
    $datos= array();
    $datos['txt_comentario']=$_POST['txt_comentario'];
    $datos['id_receta']=$_POST['id-receta'];
    $datos['id_usuario']=getUserLogado()->getId();

        if(empty($_POST['id-comentario'])){//sino hay id creamos
            createComentario($datos);
            header('Location: comentarios_receta.php?mensaje=OkGrabar&id-receta='.$datos['id_receta'].'&id_usuario='.$datos['id_usuario']);
        }else{
            editComentario($_POST['id-comentario'],$datos); //si hay id, actualizamos
            header('Location: comentarios_receta.php?mensaje=OkGrabar&id-receta='.$datos['id_receta'].'&id-comentario='.$_POST['txt_comentario']);
        }
}else{
    $data_comentario=[];
    if (isset($_GET['id-comentario'])){
        $data_comentario=getComentarioById($_GET['id-comentario']);
    }else{
        $data_comentario=array("txt_comentario"=>"");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body  class="detalle-receta">
    <header>
            <?php require(__DIR__."/../../public/header.php");?>
    </header>
    <article>
    <?php 
        if (!isset($_GET['id-comentario'])) { 
    ?>
        <section class="seccion"><h2>Nuevo comentario</h2></section>
    <?php 
        } else { 
    ?>
        <section class="seccion"><h2>Editar comentario</h2></section>
    <?php 
        } 
    ?>
    <section class="seccion">
        <form method="POST" class="formulario">             
            <label for="nombre">Texto:</label>
            <textarea name="txt_comentario" id="txt_comentario" ><?php echo $data_comentario['txt_comentario'] ?> </textarea>
            <div class="botonera">
            <button type="submit" value="Guardar">
                <span class="material-icons-outlined">save</span><span>GUARDAR</span>
            </button>
            <button value="Cancelar" onclick="window.location='./comentarios_receta.php?id-receta=<?php echo $_GET['id-receta']?>';return false;">
                <span class="material-icons-outlined">cancel</span><span>VOLVER</span>
            </button>
            </div>
            <?php
            if (isset($_GET['id-receta'])){
                echo "<input type=\"hidden\" name=\"id-receta\"  value=\"".$_GET['id-receta']."\"/>"; 
            }
            if (isset($data_comentario['id_comentario'])){
                echo "<input type=\"hidden\" name=\"id-comentario\"  value=\"".$data_comentario['id_comentario']."\"/>"; 
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