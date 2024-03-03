<?php
session_start();
require_once(__DIR__."/../config/settings.php");
require_once(__DIR__."/../data/usuarios.php");
require_once(__DIR__."/../security/model/Usuario.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = login($_POST['login-email'],$_POST['login-password']);
    if (isset($data)) {
        $usuario = new Usuario($data['id_usuario'],$data['nombre'],$data['email'],$data['es_administrador']);

        // Guardar datos del usuario en la sesión
        $_SESSION[SESSION_USER] = $usuario->serialize();

        // Redirigir a la pantalla de bienvenida
        header("Location: bienvenida.php");
        exit();
    } else {
        // Credenciales incorrectas, mostrar mensaje de error
        $error_message = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    
    <main class="container">
        <section class="login-container">
            <h2>Inicio de sesión</h2>
            <?php if(isset($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
            <form action="#" method="post">                          
                <div class="mb-3">
                    <label for="login-email" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" name="login-email" required>
                </div>
                <div class="mb-3">
                    <label for="login-password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="login-password" required>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </section>
    </main>
</body>
</html>
