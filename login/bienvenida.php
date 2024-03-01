<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario de la sesión
$user = $_SESSION['user'];
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
            <h2>Bienvenido, <?php echo $user['nombre']; ?>!</h2>
            <!-- Aquí puedes agregar más contenido de bienvenida si lo deseas -->
            <a href="logout.php">Cerrar sesión</a>
        </section>
    </main>
</body>
</html>
