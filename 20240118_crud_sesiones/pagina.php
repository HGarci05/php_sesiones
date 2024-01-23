<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo "No hay sesión activa. Redirigiendo a la página de login...";
    header("Location: login.php");
    exit();
}

// Resto del código de la página privada
echo "Bienvenido, " . $_SESSION['usuario'] . "! Esta es tu página privada.";
?>


