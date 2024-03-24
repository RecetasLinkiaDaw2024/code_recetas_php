<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LasRecetasDeMaria</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
    <?php
    include('header.php');
    ?>
    </header>
    
    <section class="nosotros">
        <div class="nosotros-info container">
        <div class="nosotros-img">
            <img src="images/prueba2.JPG" alt="">
        </div>
        <div class="nosotros-txt">
            <span>DESCUBRENOS</span>
            <h2>Regístrate</h2>
            <p>En nuestra página, puedes disfrutar de recetas de multitud de recetas gratuitas y darle tu valoraión.</p>
            <span>ES GRATUITO</span>
            </div>
        </div>
    </section>
    <section class="slider">
        <div class="galeria">
            <div class="galeria-images">
                <img src="images/slid1.jpg" alt="">
                <img src="images/slid2.jpg" alt="">
                <img src="images/slid3.jpg" alt="">
                <img src="images/slid4.jpg" alt="">
            </div>
        </div>
    </section>
    <section class="info container">
        <div class="info">
            <h3>Para más información</h3>
            <P>Puedes enviarnos un email a <a href="mailto:recetasdemaria@linkia.com">recetasdemaria@linkia.com</a> o bién contactarnos en la sección de contacto.</P>
        </div>
        <hr>
    </section>
        <footer class="footer">
            <?php
                include ('footer.php');
            ?>
        </footer>
    </body>
</html>