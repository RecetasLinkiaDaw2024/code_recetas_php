<?php
require_once(__DIR__."/../security/controller/check_user.php");
//SIEMPRE, SIEMPRE, hay que poner un require_once de check_user.php o check_user_admin.php
//nos verifica que el usuario ha pasado por el login
require_once(__DIR__."/../data/recetas.php");
$detalle_receta=[];

if (isset($_GET['id-receta'])){
    $id_receta=$_GET['id-receta'];    
    $detalle_receta=getRecetaById($id_receta);
}else{
    die("Faltan parametros");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">

    <title><?= $detalle_receta['nombre']?> : Comentarios</title>
    <style>
        .detalle-receta {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        /* Estilos CSS */
        section {
            width: 70%;
            margin: 5px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .recipe-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
            padding: 20px;
        }
        .comment {
            margin-bottom: 20px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            justify-content: space-between;
        }
        .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .user-info span {
            font-weight: bold;
            font-style: italic;
            margin-right: 10px;
        }
        .comment-text {
            word-wrap: break-word;
        }
        .fecha-comentario{
            opacity: 0.5;
        }
    </style>
</head>
<body  class="detalle-receta">
<header>
        <?php require(__DIR__."/../public/header.php");?>
    </header>
    <article class="receta">
        <header class="recipe-header">
            <?= $detalle_receta['nombre']?> : <?php echo "2"; ///PONER EL NUMERO TOTAL DE COMENTARIOS ?>  Comentarios
        </header>
        <!-- Secciones de cada comentario -->
        <section class="comment">
            <div class="user-info">
                <div>
                <img src="user_icon1.png" alt="Usuario 1">
                <span>Nombre de Usuario 1</span>
                </div>
                <div>
                <span class="fecha-comentario">Fecha del Comentario 1</span>
                </div>
            </div>
            <div class="comment-text">
                <p>Comentario sobre la receta Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
            </div>
        </section>

        <section class="comment">
            <div class="user-info">
                <div>
                    <img src="user_icon2.png" alt="Usuario 1">
                    <span>Nombre de Usuario 2</span>
                </div>
                <div>
                    <span class="fecha-comentario">Fecha del Comentario 2</span>
                </div>
            </div>
            <div class="comment-text">
                <p>Otro comentario sobre la receta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
            </div>
        </section>
    </article>
    <footer class="footer">
        <?php require(__DIR__."/../public/footer.php");?>
    </footer>
</body>
</html>

