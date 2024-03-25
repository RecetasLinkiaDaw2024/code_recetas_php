<?php
require_once(__DIR__."/../security/controller/check_user.php");
//SIEMPRE, SIEMPRE, hay que poner un require_once de check_user.php o check_user_admin.php
//nos verifica que el usuario ha pasado por el login
require_once(__DIR__."/../data/recetas.php");
require_once(__DIR__."/../data/ingredientes.php");
//require_once(__DIR__."/../public/botonMenu.php");
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="js/likes.js"></script> 
        <script>
            const idReceta = "<?= $_GET['id-receta']?>";
            window.onload = function() {
                obtenerLikeODislikes(idReceta,'L').then(numLikes => {
                     console.log('Número de likes:', numLikes);
                     const botonUno = document.getElementById("span-like");
                     botonUno.innerHTML = numLikes;
                })
                .catch(error => {
                    console.error('Error al obtener el número de likes:', error);
                });
                obtenerLikeODislikes(idReceta,"D").then(numLikes => {
                     console.log('Número de dislikes:', numLikes);
                     const botonUno = document.getElementById("span-dislike");
                     botonUno.innerHTML = numLikes;
                })
                .catch(error => {
                    console.error('Error al obtener el número de likes:', error);
                });
                //hay que saber la preferencia del usuario
                obtenerEleccionUsuario(idReceta).then(tipo => {
                     console.log('tipo:', tipo);               
                     const elementoLike = document.getElementById("boton-like");
                     const elementoDisLike = document.getElementById("boton-dislike");      
                     if (tipo!=null && tipo=='D'){
                        elementoLike.classList.remove("boton-marcado");
                        elementoDisLike.classList.add("boton-marcado");
                     }else if (tipo!=null && tipo=='L'){
                        elementoDisLike.classList.remove("boton-marcado");
                        elementoLike.classList.add("boton-marcado");
                     }else{
                        elementoDisLike.classList.remove("boton-marcado");
                        elementoLike.classList.remove("boton-marcado");
                     }
                })
                .catch(error => {
                    console.error('Error al obtener el número de likes:', error);
                });
            };

            function hacerLike(){
                insertOrEditLikeDis
            }

        </script>
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
            list-style-type: disc;
            padding: 2px;
        }
    li.ingrediente{
        margin-bottom: 5px;
        list-style-type: disc;
        list-style: inside;
    }

    section.imagen-receta{                
        width: 100%;        
    }

    img.imagen-receta{
        width: auto; 
        max-height: 400px; 
        border: 4px solid #ddd; 
        border-radius: 5px; 
        align: center;
    }

    img.no-disp{
        max-height: 200px !important; 
        width: auto; 
        opacity: 0.5;        
    }
    label.no-disp{
       padding-left: 10px;
    }

    .receta > h1{
        text-transform: uppercase;
        }

    div.separador {
        width: 100%;
        height: 1px;
        background-color: #ccc; /* Color gris */
        margin: 10px 0; /* Espacio entre secciones */
    }
    .pie{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .boton {
        /* Propiedades generales */
        display: inline-block;
        padding: 8px 8px;
        border-radius: 10px;
        text-align: center;
        font-style: italic;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
        background-color: #B5CEBD;
        color: black; /* Blanco */
  
        /* Icono Material Icon */
        &::before {
            display: inline-block;
            width: 16px;
            height: 16px;
            font-family: 'Material Icons'; /* Importar la fuente de Material Icons */
            font-weight: normal; /* Quitar negrita del icono */
            font-style: normal; /* Quitar cursiva del icono */
            text-transform: none; /* Evitar mayúsculas automáticas */
            speak: none; /* Evitar que el lector de pantalla lea el icono */
            line-height: 1; /* Alinear verticalmente el icono */
            color: inherit; /* Color blanco heredado del botón */
        }  
    }

    .boton-marcado{
        background-color: rgb(81, 115, 81);
        color: #ffffff; /* Blanco */
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
            <p><b>Categoría:</b> <?= $detalle_receta['categoria']?></p>
        </section>
        <section class="receta imagen-receta">            
            <?php 
            if (isset($detalle_receta['id_foto'])){
                echo "<img class=\"imagen-receta\" src=\"../services/fotos?id=".$detalle_receta['id_foto']."\" alt=\"Foto\">";
               }else{
                echo "<div class=\"no-disp\">";
                echo "<img id=\"no-foto\" class=\"imagen-receta no-disp\" src=\"../public/images/no-image-av.png\" alt=\"Foto no disponible\">";                
                echo "<br/>";
                echo "<label class=\"no-disp\">Foto No disponible</label>";
                echo "</div>";
               }
            ?>
            
        </section>
        <div class="separador"></div>
        <section class="receta">
            <p><b>Dificultad:</b> <?= $detalle_receta['dificultad']?></p>
            <p><b>Tiempo:</b> <?= $detalle_receta['tiempo']?> minutos</p>
            <p><b>Para <?= $detalle_receta['comensales']?> comensales</b></p>
        </section>

        <section class="receta">
            <h2>Ingredientes</h2>
            <ul>
    <?php
            foreach ($listado_ingredientes as $ingrediente){
                echo "<li class='ingrediente'>";//nombre_ingrediente, tipo, cantidad, unidad_medida
                echo ucfirst($ingrediente['nombre_ingrediente'])." (".ucfirst($ingrediente['tipo'])."), ".str_replace(".00","",$ingrediente['cantidad'])." ".$ingrediente['unidad_medida'].".";
                echo "</li>";
            }
    ?>
            </ul>
        </section>
        
        
        <div class="separador"></div>
        <section class="receta">
            <h2>Modo de Preparación</h2>
            <p><?= str_replace(". ",".<br>",$detalle_receta['preparacion'])?></p>
        </section>
        <div class="separador"></div>
        <section class="receta pie">
        <div class="botonera">
        <button id="boton-like" value="Guardar" class="boton">
            <span class="material-icons">thumb_up</span><span id="span-like">0</span>
        </button>
        <button value="Cancelar" id="boton-dislike" onclick="window.location='../';return false;" class="boton">
            <span class="material-icons">thumb_down</span><span id="span-dislike">0</span>
        </button>
        </div>        
            <p>Receta de <?= $detalle_receta['nombre_autor']?></p>
        </section>
    </article>
    <footer class="footer">
        <?php require(__DIR__."/../public/footer.php");?>
    </footer>
</body>

</html>