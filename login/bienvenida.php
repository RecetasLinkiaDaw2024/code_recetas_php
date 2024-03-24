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
        </div>    </header>
    <main class="container">
        <section class="welcome-container">
            <h2>Bienvenido, <?php echo $user->getNombre(); ?>!</h2>

            <div class="mb-3 botonera" >
                <button type="submit" class="dos-botones" onclick="window.location='logout.php'">Cerrar Sesión</button>
                <?php 
                if ($user->getIsAdmin() == true){

                    echo "<button type=\"button\" class=\"dos-botones\" onclick=\"window.location='../admin/usuarios'\">Administrar Usuarios</button>";
                    echo "<button type=\"button\" class=\"dos-botones\" onclick=\"window.location='../admin/ingredientes'\">Administrar Ingredientes</button>";
                    echo "<button type=\"button\" class=\"dos-botones\" onclick=\"window.location='../recetas'\">Administrar Recetas</button>";
                }
                ?>
                </div>


        </section>
    </main>
</body>
</html>
