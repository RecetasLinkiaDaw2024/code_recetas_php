<?php
require_once(__DIR__."/../../data/recetas.php");
require_once(__DIR__."/../../data/usuarios.php");
require_once(__DIR__."/../../data/ingredientes.php");
?>

<html>
<head>
    <title>pruebas basicas : recetas</title>
    </head>
<body>

    <header>
        <h2>Pruebas de lectura de tablas</h2>
    </header>

<section>
<table border="1">
        <tr><th colspan="4"><h2>Listado de Usuarios</h2></th></tr>
            <tr><th>clave_acceso</th>
            <th>email</th>
            <th>id_usuario</th>
            <th>nombre</th>
            </tr>
            <?php
            //vamos pintar una tabla con los usuarios
            $datos = findUsuarios(null);//puedes filtrar por cualquier email
            foreach ($datos as $fila) {
                echo "<tr>";
                ksort($fila);//nor aprovechamos que ordenamos alfabeticamente los campos
                foreach ($fila as $clave => $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
</section>
<br/>
<section>
<table border="1">
        <tr><th colspan="4"><h2>Listado de Ingredientes</h2></th></tr>
            <tr><th>id_ingrediente</th>
            <th>ingrediente</th>
            <th>tipo</th>
            </tr>
            <?php
            //vamos pintar una tabla con los usuarios
            $datos = findIngredientes(null);//puedes filtrar por cualquier tipo
            foreach ($datos as $fila) {
                echo "<tr>";
                ksort($fila);//nor aprovechamos que ordenamos alfabeticamente los campos
                foreach ($fila as $clave => $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
</section>
<br/>
<section>
<table border="1">
    <tr><th colspan="8"><h2>Listado de Recetas</h2></th></tr>
            <tr><th>categoria</th>
            <th>comensales</th>
            <th>dificultad</th>
            <th>id_autor</th>
            <th>id_receta</th>
            <th>nombre</th>
            <th>preparacion</th>
            <th>tiempo</th>
            </tr>
            <?php
            //vamos pintar una tabla con las recetas
            $datos = findRecetas(null);//puedes filtrar por cualquiera
            foreach ($datos as $fila) {
                echo "<tr>";
                ksort($fila);//nor aprovechamos que ordenamos alfabeticamente
                foreach ($fila as $clave => $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
</section>
</body>
</html>


