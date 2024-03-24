<?php
require_once(__DIR__."/../login/login.php");
require_once(__DIR__."/../login/registro.php");
require_once(__DIR__."/../misDatos/misdatos.php");
require_once(__DIR__."/../recetas/detalle_receta.php");
?>

<div class="back">
    <div class="menu container">
        <div class="logo">
            <img src="images/logofinal.jpg" alt="logo">
        </div>
        <input type="checkbox" id="menu" />
        <label for="menu">
            &#9776
        </label>
        <nav class="navbar">
            <ul>
                <li><a href="login.php">Inicia Sesión</a></li>
                <li><a href="registro.php">Regístrate</a></li>
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