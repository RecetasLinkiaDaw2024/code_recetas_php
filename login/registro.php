<?php
require_once(__DIR__."/../config/settings.php");
require_once(__DIR__."/../data/usuarios.php");
// Verificar si se recibieron datos del formulario de registro
$mensaje="";
$estilo="error-message";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si todos los campos requeridos están presentes y no están vacíos
    if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password']) &&
        !empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])) {

        // Recuperar datos del formulario
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        // Verificar si las contraseñas coinciden
        if ($password === $confirmPassword) {

            if (verifica_email($email,0)==true){
            
                $datos= array();
                $datos['nombre']=$name . " " . $lastname ;
                $datos['email']=$email;
                $datos['clave_acceso']=$password;
                $datos['es_administrador']=true;//lo ponemos true para el ejercicio
                createUsuario($datos);
            
                $mensaje= "Registro exitoso";
                $estilo="ok-message";
            }else{
               $mensaje= "El email ".$email." ya lo esta usando otro usuario";
               $estilo="error-message";
            }
        } else {
            $mensaje= "Las contraseñas no coinciden";
            $estilo="error-message";
        }
    } else {
        $mensaje= "Por favor, complete todos los campos";
        $estilo="error-message";

    }
} else {
    $mensaje= "Acceso denegado: Metodo GET no permitido";
    $estilo="error-message";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LasRecetasdeMaría.com</title>
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
            <h2>
                Registro de usuario
            </h2>
                <div class="mb-3">
                <div class="<?= $estilo?>"><?= $mensaje?></div>
                </div>
                <button type="button" onclick="window.location='login.html'">Volver</button>
            </section>
    </main>
</body>
</html>

