<?php
require_once(__DIR__."/../security/controller/check_user.php");
//SIEMPRE, SIEMPRE, hay que poner un require_once de check_user.php o check_user_admin.php
//nos verifica que el usuario ha pasado por el login
require_once(__DIR__."/../data/recetas.php");
require_once(__DIR__."/../data/ingredientes.php");
//pantalla de solo lectura para ver cualquier receta, sea tuya o no
//mostraremos varias secciones:
    // nombre y categoria
    // dificultad, tiempo y comensales
    // ingredientes
    // modo de preparacion
    // autor

//hay que hacer metodos que nos den todos estos datos
//se asume que el id de la receta nos llega por parametro id-receta.
$listado_ingredientes=[];
$detalle_receta=[];

if (isset($_GET['id-receta'])){
    $id_receta=$_GET['id-receta'];
    $listado_ingredientes=getIngredientesByIdReceta($id_receta);
    $detalle_receta=getRecetaById($id_receta);
}else{
    die("Faltan parametros");
}

?>

<html>
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LasRecetasDeMaria</title>
        <link rel="stylesheet" href="../public/css/style.css">

        <style>
        .detalle-receta {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        article.receta {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        section.receta {
            margin-bottom: 20px;
        }

        section.receta > h1, h2 {
            color: #333;
        }

        section.receta > ul {
            list-style-type: none;
            padding: 2px;
        }

        section.receta > li {
            margin-bottom: 5px;
        }

    </style>
</head>
<body class="detalle-receta">
    <header>
        <?php require(__DIR__."/../public/header.php");?>
    </header>

    <article class="receta">
        <section class="receta">
            <h1><?= $detalle_receta['nombre']?></h1>
            <p>Categoría: <?= $detalle_receta['categoria']?></p>
        </section>

        <section class="receta">
            <p>Dificultad: <?= $detalle_receta['dificultad']?></p>
            <p>Tiempo: <?= $detalle_receta['tiempo']?> minutos</p>
            <p>Para <?= $detalle_receta['comensales']?> comensales</p>
        </section>

        <section class="receta">
            <h2>Ingredientes</h2>
            <ul>
    <?php
            foreach ($listado_ingredientes as $ingrediente){
                echo "<li>";//nombre_ingrediente, tipo, cantidad, unidad_medida
                echo $ingrediente['nombre_ingrediente']." (".$ingrediente['tipo']."), ".str_replace(".00","",$ingrediente['cantidad'])." ".$ingrediente['unidad_medida'].".";
                echo "</li>";
            }

    ?>
            </ul>
        </section>

        <section class="receta">
            <h2>Modo de Preparación</h2>
            <p><?= str_replace(". ",".<br>",$detalle_receta['preparacion'])?></p>
        </section>

        <section class="receta">
            <p>Receta de <?= $detalle_receta['nombre_autor']?></p>
        </section>
    </article>
    <footer>
        <?php require(__DIR__."/../public/footer.php");?>
    </footer>
</body>

</html>