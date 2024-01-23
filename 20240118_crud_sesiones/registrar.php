<?php
session_start();

// Inicializar variables
$mensaje = "";
$cookie_name = "usuario_registrado";

// Procesar el formulario de registro si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $carpetaDestino = "uploads/";

    // Verificar si se subió un archivo JPG
    if (isset($_FILES["archivoJPG"]) && isset($_FILES["archivoJPG"]["name"])) {
        $archivoJPG = $carpetaDestino . basename($_FILES["archivoJPG"]["name"]);
        if (move_uploaded_file($_FILES["archivoJPG"]["tmp_name"], $archivoJPG)) {
            echo "Archivo JPG subido correctamente.<br>";
        } else {
            echo "Error al subir el archivo JPG.<br>";
        }
    } else {
        echo "No se seleccionó ningún archivo JPG.<br>";
    }

    // Verificar si se subió un archivo PDF
    if (isset($_FILES["archivoPDF"]) && isset($_FILES["archivoPDF"]["name"])) {
        $archivoPDF = $carpetaDestino . basename($_FILES["archivoPDF"]["name"]);
        if (move_uploaded_file($_FILES["archivoPDF"]["tmp_name"], $archivoPDF)) {
            echo "Archivo PDF subido correctamente.<br>";
        } else {
            echo "Error al subir el archivo PDF.<br>";
        }
    } else {
        echo "No se seleccionó ningún archivo PDF.<br>";
    }

    // Obtener datos del formulario
    $correo = $conn->real_escape_string($_POST["correo"]); // Prevenir inyección SQL
    $contrasena = md5($_POST["contrasena"]); // Usar MD5 para encriptar la contraseña (no recomendado)

    // Insertar datos en la base de datos
    $sql = "INSERT INTO usuarios (correo, contrasena, archivoJPG, archivoPDF) VALUES ('$correo', '$contrasena', '$archivoJPG', '$archivoPDF')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Registro exitoso";

        // Añadir una cookie después de un registro exitoso
        setcookie($cookie_name, $correo, time() + (86400 * 30), "/"); // Cookie válida por 30 días
    } else {
        $mensaje = "Error al ejecutar la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
</head>
<body>
<h2>Registro de Usuario</h2>
<?php echo $mensaje; ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    Correo: <input type="text" name="correo" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    Archivo JPG: <input type="file" name="archivoJPG" accept=".jpg"><br>
    Archivo PDF: <input type="file" name="archivoPDF" accept=".pdf"><br>
    <input type="submit" value="Registrar">
</form>
</body>
</html>



