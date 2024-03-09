<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../../../data/usuarios.php");
require_once(__DIR__."/../../../security/controller/check_user_admin.php");

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
.buscador > button{
    margin-left: 2px;
}
.buscador > input{
    min-width: 300px;
}

.panel_usuario{
    background: lightgrey;
    border: 1px;
    width: 200px;
    min-height: 120px;
    max-height: 160px;
    margin: 5px;
    text-align: center;
    position: relative;
}
button.link{
  reset: all;
  border: none;
  padding: 0;
  background: transparent;
  cursor: pointer;
  color: #333333;
  text-decoration: underline;
  position: absolute;
  bottom: 2px;
  right: 2px;
}
button.link-editar{
    margin-right: 20px;
}
button.link:hover{
  text-decoration: none;
  background: #CCCCCC;
}

</style>
</head>
<body>
<header>
        <!-- TODO: insertar la cabecera -->

</header>
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
            if($usuario['es_administrador'] == true){
                echo "<p><b>Administrador<b></p>"; //TODO: darle una vuelta con colores o iconos, no solo la palabra
            }
            echo "<br/>";
            echo "<form method=\"POST\" action=\"view/eliminar_usuario.php\" onsubmit=\"return confirm('¿Esta seguro de querer borrar a ".$usuario['nombre']."?');\">";
            echo "<button class=\"link link-editar\" name=\"editar\" value=\"editar\" onclick=\"window.location='view/formulario.php?id-user=".$usuario['id_usuario']."';return false;\">";
            echo "    <span class=\"material-icons\"  title=\"Editar usuario\">edit</span>                ";
            echo "</button>";
            echo "<button type=\"submit\" class=\"link\" name=\"eliminar\" value=\"Eliminar\" \">";
            echo "    <span class=\"material-icons\"  title=\"Editar usuario\">delete</span>                ";
            echo "</button>";
            echo "<input type=\"hidden\" name=\"id_usuario\"  value=\"".$usuario['id_usuario']."\"/>"; 
            echo "</form>";
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
    echo "<script> window.addEventListener('load', function() {
        alert(\"Los datos se han guardado correctamente\");
      });</script>";
}
if (isset($_GET['mensaje']) && $_GET['mensaje']=="OkErase" ){
    echo "<script> window.addEventListener('load', function() {
        alert(\"Se ha eliminado el usuario correctamente\");
      });</script>";
}
if (isset($_GET['mensaje']) && $_GET['mensaje']=="NoOkEmail" ){
    echo "<script> window.addEventListener('load', function() {
        alert(\"No se ha podido grabar: el email ya existe en el sistema\");
      });</script>";
}

?>
</body>

</html>