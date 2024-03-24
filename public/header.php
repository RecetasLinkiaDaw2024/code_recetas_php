<?php
require_once(__DIR__."/../config/settings.php");
?>

<!-- dos opciones, con usuario logado y sin el.
    una tiene el menu y la otra los botones de login-->

<?php if (isset($_SESSION[SESSION_USER])) { ?> 
    <!-- OPCION con USUARIO-->
<div class="back">
    <div class="menu container">
        <div class="logo">
            <img src="<?= DEPLOY_PATH?>/public/images/logofinal.jpg" alt="logo">
        </div>
        <input type="checkbox" id="menu" />
        <label for="menu">
            &#9776
        </label>
        <nav class="navbar">
            <ul>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Menú de la aplicación</a>
                    <div class="dropdown-content">
                        <a href="misDatos.php">Mis datos</a>
                        <a href="detalle_receta.php">Mis recetas</a>
                        <a href="#">Buscador de recetas</a>
                        <?php
                            // Verificar si el usuario es administrador
                            $isAdmin = false; // Supongamos que esta es la lógica para determinar si el usuario es administrador o no
                            if ($isAdmin) {
                                echo '<a href="#" id="adminOption">Administración de usuarios</a>';
                            }
                        ?>
                        <a href="#">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php } else { ?> 
<!-- OPCION SIN USUARIO-->
    <div class="back">
            <div class="menu container">
                <div class="logo">
                    <img src="<?= DEPLOY_PATH?>/public/images/logofinal.jpg" alt="logo">
                </div>
                <input type="checkbox" id="menu" />
                <label for="menu">
                    <img src="<?= DEPLOY_PATH?>/public/images/menu.png" class="menu-icono" alt="">
                </label>
                <nav class="navbar">
                    <ul>
                        <li><a href="../login/login.php">Inicia Sesión</a></li>
                        <li><a href="../login/login.html">Registrate</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php } ?>         