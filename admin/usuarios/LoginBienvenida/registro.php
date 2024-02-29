<?php
// Verificar si se recibieron datos del formulario de registro
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
            // Realizar cualquier otra validación necesaria, como verificar el formato del correo electrónico, longitud de la contraseña, etc.

            // Aquí puedes agregar la lógica para guardar los datos del usuario en la base de datos
            // Por ejemplo, puedes usar consultas preparadas para evitar la inyección SQL

            // Conexión a la base de datos
            $servername = "localhost";
            $username = "tu_usuario";
            $password_db = "tu_contraseña";
            $dbname = "tu_base_de_datos";

            // Crear conexión
            $conn = new mysqli($servername, $username, $password_db, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Insertar datos en la base de datos (ejemplo)
            $sql = "INSERT INTO usuarios (nombre, apellidos, email, contraseña) VALUES ('$name', '$lastname', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registro exitoso";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Cerrar conexión
            $conn->close();
        } else {
            echo "Las contraseñas no coinciden";
        }
    } else {
        echo "Por favor, complete todos los campos";
    }
} else {
    echo "Acceso denegado";
}
?>
