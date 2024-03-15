<?php
require_once(__DIR__."/../security/controller/check_user.php");
//SIEMPRE, SIEMPRE, hay que poner un require_once de check_user.php o check_user_admin.php
//nos verifica que el usuario ha pasado por el login
require_once(__DIR__."/../data/usuarios.php");
require_once(__DIR__."/../../data/ingredientes.php");


//pantalla de solo lectura para ver datos de usuario
//mostraremos varias secciones:
    //id usuario
    // nombre
    // correo
    // recetas publicadas
    
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Las Recetas de Maria</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap">
    
        <style>
        .panel_usuario {
            display: flex; /* Utilizamos flexbox para alinear los elementos horizontalmente */
            flex-direction: column; /* Los elementos se colocan en una columna */
            border: 2px solid #ccc; /* Borde para cada ficha */
            border-radius: 8px; /* Bordes redondeados */
            padding: 10px; /* Espaciado interno */
            margin-bottom: 20px; /* Espacio entre las fichas */
            font-family: 'Comic Neue', sans-serif;
        }
        
        .panel_usuario article {
            background-color: #f0f0f0; /* Color de fondo para cada ficha */
            border-radius: 8px; /* Bordes redondeados */
            padding: 10px; /* Espaciado interno */
            margin-bottom: 10px; /* Espacio entre las fichas */
            font-family: 'Comic Neue', sans-serif;
        }
        </style>
    </head>
    <body class="detalle-datos">
        <header>
            <?php require(__DIR__ . "/../public/header.php"); ?>
        </header>
    
        <h1>Los Users de las Recetas</h1>
    
        <?php
        if (isset($_GET['id-usuario'])) {
            $_usuario = $_GET['id-usuario'];
            $detalle_usuario = getUsuarioById($_usuario);
            if (!$detalle_usuario) {
                die("El usuario con el ID $_usuario no fue encontrado");
            }
        } else {
            die("Por favor, regístrese para seguir disfrutando de la página");
        }
        ?>


    
        <div class="panel_usuario">
            <article class="usuario_info">
                <section>ID Usuario</section>
                <p><?= $detalle_usuario['id_usuario']; ?></p>
            </article>
    
            <article class="usuario_info">
                <section>Nombre Usuario</section>
                <p><?= $detalle_usuario['nombre']; ?></p>
            </article>
    
            <article class="usuario_info">
                <section>Correo Electrónico</section>
                <p><?= $detalle_usuario['email']; ?></p>
            </article>
    
            <article class="usuario_info">
            <p>Numero de recetas publicadas: <?= $detalle_usuario['count_recetas']; ?> </p>
            </section>

    <footer class="footer">
        <?php require(__DIR__."/../public/footer.php");?>
    </footer>
</body>

</html>