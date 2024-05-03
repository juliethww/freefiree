<?php
session_start(); // Inicia la sesión (si no está iniciada)
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión actual
header("Location: ../index.php"); // Redirige a la página de inicio de sesión o a donde desees
exit(); // Asegura que no haya más ejecución de código después de la redirección
?>