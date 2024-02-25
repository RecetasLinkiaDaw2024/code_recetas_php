<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../../data/usuarios.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- TODO estilos de la aplicacion css -->

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- iconos de material icons de google, para ver los disaponibles mirar https://fonts.google.com/icons?icon.set=Material+Icons-->
<!-- TODO levar estos estilos css estilos-->
<style>

.resultados_busqueda{
    display: flex;
    flex-wrap: wrap;
    padding: 2px;
}
.buscador{
    display: flex;
    padding: 2px;
}

.panel_usuario{
    background: lightgrey;
    border: 1px;
    width: 150px;
    max-height: 150px;
    margin: 5px;
    text-align: center;


}

</style>
</head>
<body>
<header>
        <!-- TODO: insertar la cabecera -->

</header>
</body>
<article>
    <form action="" method="GET">
        <div class="buscador">
            <?php
                if (isset($_GET['busqueda'])){
                    echo "<input type=\"text\" name=\"busqueda\" value=\"".$_GET['busqueda']."\">";
                }else{
                    echo "<input type=\"text\" name=\"busqueda\">";
                }
            ?>            
            <button type="submit" name="buscar" value="Buscar">
            <i class="material-icons" title="Buscar">search</i>                
            </button>
            <button name="nuevo" value="Nuevo" onclick="window.location='view/formulario.php';return false;">
            <span class="material-icons"  title="Nuevo usuario">person_add</span>                
            </button>
            
        </div>
    </form>
<div class="resultados_busqueda">
<?php
        if (isset($_GET['busqueda'])){
            $usuarios = findUsuarios($_GET['busqueda']);
        }else{
            $usuarios = findUsuarios(null);
        }
        foreach ($usuarios as $usuario) {
        echo "<div class=\"panel_usuario\">";
        echo "<b>".$usuario['nombre']."</b>";
        echo "<p>".$usuario['email']."</p>";
        //TODO: poner botones eliminar y editar (font-awesome???)
        
        echo "</div>";
    }
?>
</div>
</article>
<footer>
        <!-- TODO: insertar el footer -->
</footer>

<?php
//logica para capturar que hay un mensaje que mostrar...
if (isset($_GET['mensaje']) && $_GET['mensaje']=="OkGrabar" ){
    echo "<script> alert(\"Los datos se han guardado correctamente\");</script>";//TODO: mejoraremos el mensaje con estuilos y funciones javascript   mas adelante....
}
?>
</html>