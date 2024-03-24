<?php
require_once(__DIR__."/../../../security/controller/check_user_admin.php");
require_once(__DIR__."/../../../data/usuarios.php");
require_once(__DIR__."/../../../data/almacenamiento.php");

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //hay que insertar un usuario
    //TODO ampliar con la edición
    $datos= array();
    $datos['nombre']=$_POST['nombre'];
    $datos['email']=$_POST['email'];
    $datos['clave_acceso']=$_POST['password'];
    if (isset($_POST['administrador']) && $_POST['administrador'] == "es_administrador"){
        $datos['es_administrador']=true;
    }else{
        $datos['es_administrador']=false;
    }

    if (verifica_email($datos['email'],$_POST['id_usuario'])==false){
        header('Location: ../?mensaje=NoOkEmail');
    }else{

        $hay_archivo_subido=false;
        $directorio_destino = null;
        $nombre_aleatorio = null;
        $extension  =null;
        $id_usuario_foto = null;
        //procesamos la subida de archivos
        //y lo tenemos en cuenta de cara al usuario
        if ($_FILES["fileToUpload"]["error"] <= 0) {                            
                $anio = date("Y");
                $mes = date("m");
                $nombre_sub_carpeta = $anio . "_" . $mes;
                $ruta_carpeta=RUTA_ALMACEN_ARCHIVOS;
                if (!file_exists($ruta_carpeta."/".$nombre_sub_carpeta)) {
                    if (!mkdir($ruta_carpeta."/".$nombre_sub_carpeta, 0777, true)) { // 0777 es el modo de permisos (puedes ajustarlo según tus necesidades)
                        die("Error al crear la carpeta $nombre_sub_carpeta");
                    }
                }
                // Información del archivo subido
                //"Nombre del archivo: " . $_FILES["fileToUpload"]["name"] . "<br>";
                //"Tipo de archivo: " . $_FILES["fileToUpload"]["type"] . "<br>";
                //"Tamaño del archivo: " . ($_FILES["fileToUpload"]["size"] / 1024) . " KB<br>";
                //"Nombre temporal: " . $_FILES["fileToUpload"]["tmp_name"] . "<br>";
                //Directorio donde se guardará el archivo
                $nombre_aleatorio = uniqid();
                $directorio_destino = RUTA_ALMACEN_ARCHIVOS."/".$nombre_sub_carpeta;                
                $extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
                // Mover el archivo del directorio temporal al destino
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $directorio_destino."/" . $nombre_aleatorio.".".$extension)) {
                    // "El archivo ha sido subido correctamente.";
                    $hay_archivo_subido=true;
                } else {
                    die ("Error al subir el archivo.");
                }
            }
        
        if(empty($_POST['id_usuario'])){//sino hay id creamos
            $id_usuario_foto=createUsuario($datos);
            header('Location: ../?mensaje=OkGrabar');
        }else{
            $id_usuario_foto=$_POST['id_usuario'];
            removeFotoUsuario($_POST['id_usuario']);
            editUsuario($_POST['id_usuario'],$datos); //si hay id, actualizamos
            header('Location: ../?mensaje=OkGrabar');
        }
        //le metemos foto
        if (isset($id_usuario_foto) && $hay_archivo_subido == true){
            $id_foto=createAlmacenamiento($directorio_destino,$nombre_aleatorio.".".$extension);
            addFotoUsuario($id_usuario_foto,$id_foto);
        }


    }
}else{
    $data_usuario=[];
    if (isset($_GET['id-user'])){
        $data_usuario=getUsuarioById($_GET['id-user']);
    }else{
        $data_usuario=array("nombre"=>"", "email"=>"", "clave_acceso"=>"","es_administrador"=>"");
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
    <form method="POST" class="formulario" enctype="multipart/form-data">                
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $data_usuario['nombre'] ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $data_usuario['email'] ?>" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <div>
            <input type="checkbox" id="administrador" name="administrador" value="es_administrador" <?php
            if ($data_usuario['es_administrador'] == true){
                echo " checked ";
            }
            ?>>
            <label for="administrador">Marcar como administrador</label>
        </div>
        <label for="fileToUpload">Imagen:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
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