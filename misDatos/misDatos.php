<?php
require_once(__DIR__."../../code_recode_recetas_php/config/database.php");
// Acceder a las constantes definidas en database.php
$servername = DB_SERVER;
$username = DB_USER;
$password = DB_PASS;
$dbname = DB_DATABASE;
$port = DB_PORT;

// Usar variables para crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
} else {
    echo "Conexión exitosa!";
}

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT nombre, apellidos, correo FROM usuarios WHERE id = 1"; // Aquí deberíamos cambiar 'id = 1' por la condición que corresponda a nuestro caso

$result = $conn->query($sql);

// Verifica si se encontraron resultados
if ($result->num_rows > 0) {
    // Muestra los datos en el formulario
    while ($row = $result->fetch_assoc()) {
        $nombre = $row["nombre"];
        $apellidos = $row["apellidos"];
        $correo = $row["correo"];
    }
} else {
    echo "No se encontraron resultados";
}

// Cierra la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LasRecetasdeMaría.com</title>
    <link rel="stylesheet" href="estilo.css">
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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Link
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link</a>
                        </li>
                        </ul>
                        <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
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
        <section class="form-container">
            <h2>Editar perfil</h2>
            <form action="actualizarPerfil.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $nombre; ?>">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $apellidos; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $correo; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar perfil</button>
            </form>
        </section>
    </main>
</body>
</html>
