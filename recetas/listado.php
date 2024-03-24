<?php
//TODO: seguridad, aplicar para admistrador
require_once(__DIR__."/../data/recetas.php");
require_once(__DIR__."/../data/ingredientes.php");
require_once(__DIR__."/../public/componentes.php");
require_once(__DIR__."/../security/controller/check_user_admin.php");

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
    height: 100%;
    padding: 2px;
}
.buscador{
    display: inline-block;
    padding: 2px;
}
.buscador > button{
    margin-left: 2px;
}
.buscador > input{
    min-width: 300px;
}

.panel_recetas{
    background: lightgrey;
    border: 1px;
    width: 200px;
    min-height: 120px;
    max-height: 160px;
    margin: 5px;
    text-align: center;
    position: relative;
}

.panel_recetas:hover{
    background: lightblue;
    cursor: help;
}

.container {
  position: relative;
}

.select-wrapper {
  display: inline-block;
}

.picklist {
  width: 234px;
  height: 100px;
  padding: 10px 0;
  border: solid 1px #c7c8ca;
}

option {
  padding: 12px;
}

option {
  color: black;
  
  &:focus,
  &:active,
  &:checked
  {
      background: linear-gradient(#f4f4f4,#f4f4f4);
      color: black;
  }
}

.left-header, .right-header {
  background-color: #e6e6e6;
  border: solid 1px #c7c8ca;
  padding: 12px 16px;
  width: 200px;
}

.button-container {
  display: inline-block;
  position: relative;
  width: 100px;
  height: 100px;
  text-align: center;
  padding-left: 80px;
  button {
    display: block;
    margin-bottom: 10px;
  }
}

.circle {
  width: 28px;
  height: 28px;
  border: solid 1px #939598;
  border-radius: 50%;
  text-align: center;
  position: relative;
  
  .center {
    color: #939598;
  }
}

.center {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

 /* Tooltip container */
 .tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 240px;
  background-color: #555;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
   
  position: absolute;
  z-index: 1;
  top: -5px;
  left: 125%;
  margin-left: -60px;

  /* Fade in tooltip */
  opacity: 0;
  transition: opacity 0.3s;
}

/* Tooltip arrow */
.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 10%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
} 

.panel_filtro{
  height:100%;
  width: 20%;
  background-color:#fff;
  float:left;
  z-index:1;
  overflow:auto
}

.panel_resultado{
  height:100%;
  width:80%;
  float: right;
  background-color:#fff;
  z-index:1;
}
</style>

</head>
<body>
<header>
        <!-- TODO: insertar la cabecera -->

</header>
<article>
  <div class="panel_filtro">

  <form action="" method="GET">
       <div class="buscador">
            Busqueda por texto :
            <?php
                if (isset($_GET['busqueda'])){
                    echo "<input type=\"text\" name=\"busqueda\" value=\"".$_GET['busqueda']."\">";
                }else{
                    echo "<input type=\"text\" name=\"busqueda\">";
                }
            ?>            

            <BR /> Dificultad :
            <?php 
                $valores = array ( '' => '', 'Facil' => 'Facil', 'Media' => 'Media', 'Elevada' => 'Elevada');
                generaCombo('dificultad', $valores);
            ?>
            <BR />
            <?php 
                $combo = getComboIngredientes();
                $seleccionados = array();
                if ($_GET) {
                  if (isset($_GET['addValue'])) {
                    if (isset($_GET['seleccion'])){
                      foreach($_GET['seleccion'] as $sel){
                        foreach(array_keys($combo) as $elem){
                          if($combo[$elem] == $sel){
                            $seleccionados[$elem] = $combo[$elem];
                          }
                        }
                     }
                    }
                    if(isset($_GET['ingrediente']) && $_GET['ingrediente'] != ''){
                      $extra = getIngredienteById($_GET['ingrediente']);
                      $seleccionados[$extra['nombre']]=$extra['id_ingrediente'];
                    }
                  } elseif (isset($_GET['removeValue'])) {
                    if (isset($_GET['seleccion'])){
                      foreach($_GET['seleccion'] as $sel){
                        foreach(array_keys($combo) as $elem){
                          if($combo[$elem] == $sel && (!isset( $_GET['listaEliminar']) || $combo[$elem] != $_GET['listaEliminar'])){
                            $seleccionados[$elem] = $combo[$elem];
                          }
                        }
                     }
                    }
              
                  } else {
                    if (isset($_GET['seleccion'])){
                      foreach($_GET['seleccion'] as $sel){
                        foreach(array_keys($combo) as $elem){
                          if($combo[$elem] == $sel){
                            $seleccionados[$elem] = $combo[$elem];
                          }
                        }
                     }
                    }
                  }
  
                  generaAddList('ingrediente', $combo, $seleccionados, 'Ingredientes disponibles', 'Filtro por ingredientes');
                }
              
            ?>

            <button type="submit" name="buscar" value="Buscar">
            <i class="material-icons" title="Buscar">search</i>                
            </button>
            
        </div>
    </form>
  </div>

  <div class="panel_resultado">
      <div class="resultados_busqueda">
        <?php
            $recetas = findRecetasFiltrado(isset($_GET['busqueda'])?$_GET['busqueda']:null, isset($_GET['dificultad'])?$_GET['dificultad']:null, isset($_GET['seleccion'])?$_GET['seleccion']:null);

            foreach ($recetas as $receta) {
                echo "<div class=\"panel_recetas tooltip\" onclick=\"window.location='./detalle_receta.php?id-receta=" .$receta['id_receta'] . "'\">";
                echo "<b>".$receta['nombre']."</b>";
                echo "<hr/>";
                echo "<span class='tooltiptext'>";
                echo "<p>INGREDIENTES : </p>";
                foreach(explode(',',$receta['ingredientes']) as $ing){
                  echo "<p>".$ing."</p>";
                }
                echo "</span>";
                echo "<p>TIEMPO : ".$receta['tiempo']."</p>";
                echo "<p>DIFICULTAD: ".$receta['dificultad']."</p>";
                echo "<p>AUTOR: ".$receta['nombre_autor']."</p>";
                echo "<br/>";
                echo "<input type=\"hidden\" name=\"id_receta\"  value=\"".$receta['id_receta']."\"/>"; 
                echo "</form>";
                echo "</div>";
            }
    ?>
    </div>
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

</body>

</html>