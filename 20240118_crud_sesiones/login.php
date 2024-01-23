<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de login si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $correo = $conn->real_escape_string($_POST["correo"]);
    $contrasena = md5($_POST["contrasena"]); // Recuerda, MD5 no es seguro

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        if (md5($_POST["contrasena"]) == $fila["contrasena"]) {
            // Iniciar sesión y redirigir a la página privada
            $_SESSION['usuario'] = $correo;
            header("Location: pagina.php");
            exit();
        } else {
            $mensajeError = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    } else {
        $mensajeError = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Login</title>
</head>
<body>
<?php
if (isset($mensajeError)) {
    echo "<p>$mensajeError</p>";
}
?>

<h2>Iniciar Sesión</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Correo: <input type="text" name="correo" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>
</body>
</html>
