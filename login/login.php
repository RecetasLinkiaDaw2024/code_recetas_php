<?php
session_start();
require_once(__DIR__."/../config/settings.php");
require_once(__DIR__."/../data/usuarios.php");
require_once(__DIR__."/../security/model/usuario.php");
require_once(__DIR__."/../images/botonMenu.php");

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
    <title> LasRecetasdeMaría.com - Login </title>
    <link rel="stylesheet" href="../public/css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <header>
    <div class="header-content">
            <div style="margin-right: 50px;">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                    <a class="navbar-brand" href="#">RecetasdeMaría.com</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        
                        </ul>
                       
                    </div>
                    </div>
                </nav>
            </div>
            <div>
                <h1 class="title">
                <img src="logo.jpg" alt="Logo" class="logo">
                RecetasdeMaría.com
                </h1>
                <div class="spacer"></div> 
            </div>
        </div>
</header>
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
                <div class="mb-3 botonera" >
                <button type="submit" class="dos-botones">Iniciar Sesión</button>
                <button type="button" class="dos-botones" onclick="window.location='login.html'">Volver</button>
            </div>
            </form>
        </section>
    </main>
</body>
</html>
