<?php
require_once(__DIR__."/../../security/controller/check_user_admin.php");
//SIEMPRE, SIEMPRE, hay que poner un require_once de check_user.php o check_user_admin.php
//nos verifica que el usuario ha pasado por el login
require_once(__DIR__."/../../data/recetas.php");
require_once(__DIR__."/../../data/comentarios.php");
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
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
        .botonera {
            text-align: center;
        }
        .imagen-redonda {
        width: 100px; /* Ajusta el tamaño según sea necesario */
        height: 100px; /* Ajusta el tamaño según sea necesario */
        border-radius: 50%; /* Hace que la imagen tenga forma de círculo */
        overflow: hidden; /* Recorta cualquier contenido que sobresalga de la forma */
        align: center;
        background-color: transparent;
        
    }

    img.imagen-redonda {
        height: auto;
        width: 100px;
        background: transparent;
    }

    </style>
</head>
<body  class="detalle-receta">
<header>
        <?php require(__DIR__."/../../public/header.php");?>
    </header>
    <article class="receta">
        <header class="recipe-header">
            <?= $detalle_receta['nombre']?> : <?php echo $detalle_receta['num_comentarios']; ?>  Comentarios
            <button name="nuevo" value="Nuevo" onclick="window.location='formulario.php?id-receta=<?php echo $detalle_receta['id_receta']; ?>';return false;">
                <span class="material-icons"  title="Nuevo comentario">note_add</span>                
            </button>
        </header>
        <!-- Secciones de cada comentario -->
        <?php
            if($detalle_receta['num_comentarios'] > 0){
                $comentarios = findComentarios($detalle_receta['id_receta']);
                foreach ($comentarios as $key => $value) {
                    ?>

                        <section class="comment">
                            <div class="user-info">
                                <div>
                                <div class="imagen-redonda">
                                <?php if (isset($value['foto_autor'])){
                                    echo "<img class=\"imagen-redonda\" src=\"../../services/fotos?id=".$value['foto_autor']."\" alt=\"Imagen Usuario\">";
                                }else{
                                    echo "<img class=\"imagen-redonda\" src=\"../../public/images/no-image-av.png\" alt=\"Sin Imagen\">";
                                }
                                ?>
                                </div>
                                <span><?php echo $value['nombre_autor']; ?></span>
                                </div>
                                <div>
                                <span class="fecha-comentario"><?php echo $value['f_creacion']; ?></span>
                                </div>
                            </div>
                            <div class="comment-text">
                                <p><?php echo $value['txt_comentario']; ?></p>
                            </div>
                            <div class="botonera_comentario">
                                <form method="POST" action="./eliminar_comentario.php?id-receta=<?php echo $detalle_receta['id_receta']; ?>" onsubmit="return confirm('¿Esta seguro de querer borrar el comentario?');">
                                <button class="link link-editar" name="editar" value="editar" onclick="window.location='formulario.php?id-receta=<?php echo $detalle_receta['id_receta']; ?>&id-comentario=<?php echo $value['id_comentario']; ?>';return false;">
                                    <span class="material-icons"  title="Editar comentario">edit</span>
                                </button>
                                <button type="submit" class="link" name="eliminar" value="Eliminar">
                                    <span class="material-icons"  title="Eliminar comentario">delete</span>
                                </button>
                                <input type="hidden" name="id_comentario"  value="<?php echo $value['id_comentario']; ?>"> 
                            </div>
                        </section>


                    <?php
                }
            } else {
                ?>
                <p style='text-align: center'>No hay comentarios</p>
                <?php
            }
        ?>
    </article>

    <footer class="footer">
        <?php require(__DIR__."/../../public/footer.php");?>
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
        alert(\"Se ha eliminado el comentario correctamente\");
      });</script>";
}

?>

</body>
</html>

