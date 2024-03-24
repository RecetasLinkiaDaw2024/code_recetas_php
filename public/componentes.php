<?php 
function generaCombo($nombre, $listaValores){
    
    echo "<select name='" . $nombre . "'>";
    foreach ($listaValores as $etiqueta => $valor) {
        echo "<option value='" . $valor . "' ";
        if(isset($_GET[$nombre]) && $_GET[$nombre] == $valor) { 
            echo "selected"; 
        } 
        echo ">" . $etiqueta. "</option>";
    }
    echo "</select>";
}

function generaAddList($nombre, $listaValores, $listaSeleccionados, $titulo1, $titulo2){
  echo "<div class='select-wrapper'>";
  echo "<div class='left-header'>". $titulo1."</div>";
  echo "<select id='left' name='" . $nombre . "'>";
  echo "<option value=''>Seleccione ... </option>";
  foreach ($listaValores as $etiqueta => $valor) {
      echo "<option value='" . $valor . "' ";
      echo ">" . $etiqueta. "</option>";
  }
  echo "</select>";
  echo "</div>";
  echo "<button type='submit' name='addValue' value='addValue'> + </button>";
  echo "<div class='select-wrapper'>";  
  echo "<div class='right-header'>".$titulo2."</div>";
  echo "<select multiple class='picklist' id='right' name='listaEliminar'>";
      foreach ($listaSeleccionados as $etiqueta => $valor) {
          echo "<option value='" . $valor . "' ";
          echo ">" . $etiqueta. "</option>";
      }
  echo "</select>";
  echo "<button type='submit' name='removeValue' value='removeValue'> - </button>";
  echo "</div>";
  foreach ($listaSeleccionados as $etiqueta => $valor) {
    echo "<input type='hidden' name='seleccion[]' value='" . $valor . "' />";
  }

}
?>