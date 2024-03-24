<?php
require_once(__DIR__."/../config/settings.php");
require_once(__DIR__."/../images/botonMenú.php");
?>
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