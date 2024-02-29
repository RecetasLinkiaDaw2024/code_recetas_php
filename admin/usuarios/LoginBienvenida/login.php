<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "usuario";
    $password = "contraseña";
    $dbname = "nombre_base_de_datos";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recuperar datos del formulario
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND clave_acceso='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso
        $row = $result->fetch_assoc();

        // Guardar datos del usuario en la sesión
        $_SESSION['user'] = $row;

        // Redirigir a la pantalla de bienvenida
        header("Location: welcome.php");
        exit();
    } else {
        // Credenciales incorrectas, mostrar mensaje de error
        $error_message = "Usuario o contraseña incorrectos";
    }

    $conn->close();
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
