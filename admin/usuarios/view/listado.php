<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../../data/usuarios.php");



?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- TODO estilos de la aplicacion css -->

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
            <input type="submit" name="buscar" value="Buscar">
            <input type="submit" name="nuevo" value="Nuevo" onclick="window.location='view/formulario.php';return false;">
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
</html>