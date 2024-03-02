<?php
require_once(__DIR__."/../security/controller/check_user.php");

// Obtener datos del usuario de la sesión
$user =getUserLogado();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <!-- Aquí va el contenido del encabezado si es necesario -->
    </header>
    <main class="container">
        <section class="welcome-container">
            <h2>Bienvenido, <?php echo $user->getNombre(); ?>!</h2>
            <!-- Aquí puedes agregar más contenido de bienvenida si lo deseas -->
            <a href="logout.php">Cerrar sesión</a>
            <!-- vamos a meter un enlace a la gestion de usuarios solo si eres administrador-->
            <?php 
            if ($user->getIsAdmin() == true){
                echo '<a href="../admin/usuarios">Administrar usuarios</a>';
            }
            ?>

        </section>
    </main>
</body>
</html>
