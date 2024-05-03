<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "free";

$conexion = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST["correo"];
    $contrasena_enviada = $_POST["contrasena_enviada"];
    $nueva_contrasena = $_POST["nueva_contrasena"];

    // Validar si los campos no están vacíos
    if (empty($correo) || empty($contrasena_enviada) || empty($nueva_contrasena)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Validar si el ID es válido
    if (!is_numeric($correo)) {
        echo "ID de usuario no válido.";
        exit;
    }

    // Verificar si los datos coinciden con la base de datos
    $query = "SELECT correo FROM usuario WHERE id_usuario = ? AND contrasena = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ss", $correo, $contrasena_enviada);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Los datos coinciden, actualizar la contraseña
        $update_query = "UPDATE usuario SET contrasena = ? WHERE correo = ?";
        $update_stmt = mysqli_prepare($conexion, $update_query);
        $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($update_stmt, "si", $nueva_contrasena_hashed, $id_usuario);
        mysqli_stmt_execute($update_stmt);

        echo '<script>alert("Contraseña actualizada exitosamente.");</script>';
        echo '<script>window.location.href = "../login.html";</script>';

    } else {
        echo '<script>alert("Los datos proporcionados no coinciden.");</script>';
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body style="background-image: url('../images/fondo2.jpg');">   
    <div class="login-form">
        
        <div class="logo"><img src="../images/free4.png" alt="logo"></div>

        <h6>Recuperar Contraseña</h6>

        <form method="post">
            
            <div class="textbox">
                <input type="text" name="correo" id="correo"  placeholder="Correo">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="textbox">
                <input type="password" name="contrasena_enviada" id="contrasena_enviada"  placeholder="Contraseña Enviada por Correo" id="password">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="textbox">
                <input type="password" name="nueva_contrasena" id="nueva_contrasena"  placeholder="Contraseña Nueva" id="password">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="options">
                <label class="remember-me">
                    <span class="checkbox">
                        <input type="checkbox">
                        <span class="checked"></span>
                    </span>
                </label>
            </div>

            <input type="submit" value="iniciar" name="inicio" class="login-btn">
            <input type="hidden" name="MM_insert" value="formreg">

            <div class="privacy-link">
                <a href="">Politicas de Privacidad</a>
            </div>
        </form>


        <div class="name">
            ~ Julian Daniel Andrea ~
        </div>
    </div>


</body>
</html>