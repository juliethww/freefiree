<?php
session_start(); // Iniciar sesión

// Conectar a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "free";
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el usuario ya está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio de sesión si no hay sesión activa
    exit();
}

// Obtener información del jugador de la base de datos
$username = $_SESSION['username'];
$sql = "SELECT usuarios.username, usuarios.id_puntos, usuarios.puntos, avatar.foto, puntos.rango,
        (SELECT mundo.nombre_fo FROM sala
         JOIN mundo ON sala.id_mundo = mundo.id_mundo
         WHERE sala.username = usuarios.username) AS mundo
        FROM usuarios
        LEFT JOIN puntos ON usuarios.id_puntos = puntos.id_puntos
        LEFT JOIN avatar ON usuarios.id_avatar = avatar.id_avatar
        WHERE usuarios.username = '$username'";
$result = $conn->query($sql);

$row = null; // Inicializar $row como null

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Obtener la ruta de la imagen del avatar del usuario
    $foto = $row['foto'];

    // Obtener los puntos del jugador
    $puntos = $row['puntos'];

    // Actualizar el id_puntos según los puntos del jugador
    if ($puntos < 500) {
        $id_puntos = 1;
    } elseif ($puntos >= 500 && $puntos < 750) {
        $id_puntos = 2;
    } elseif ($puntos >= 750 && $puntos < 1000) {
        $id_puntos = 3;
    } elseif ($puntos >= 1000 && $puntos < 1250) {
        $id_puntos = 4;
    } else {
        $id_puntos = 5;
    }

    // Actualizar el id_puntos en la base de datos
    $sql_update_puntos = "UPDATE usuarios SET id_puntos = '$id_puntos' WHERE username = '$username'";
    $conn->query($sql_update_puntos);
}

// Procesar y guardar la imagen subida si existe
if (isset($_FILES["foto"])) {
    $file = $_FILES["foto"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $widht = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "../images/";
    if ($tipo != 'image/jpg' && $tipo != 'image/JPG' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
        echo "error, el archivo no es una imagen";
    } else if ($size > 3 * 1024 * 1024) {
        echo "error, el tamaño máximo permitido es de 3MB";
    } else {
        $src = $carpeta . $nombre;
        move_uploaded_file($ruta_provisional, $src);
        $foto = "../images/" . $nombre;

        // Guardar la ruta de la imagen en la base de datos para el usuario actual
        $sql_update_avatar = "UPDATE usuarios SET id_avatar = (SELECT id_avatar FROM avatar WHERE avatar = '$foto') WHERE username = '$username'";
        $conn->query($sql_update_avatar);
    }
}

$conn->close();
?>

<?php include ("../controller/validar.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Jugador</title>
    <link rel="stylesheet" href="../css/jugador.css">
</head>

<body>
    <?php include ("../nav/nav_jugador.php") ?>

    <div class="player-info">
        <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
        <?php if ($row) { ?>
            <div class="avatar-container">
                <?php if ($foto) { ?>
                    <img src="<?php echo $foto; ?>" alt="Avatar" width="200">
                <?php } else { ?>
                    <!-- Si no se encontró la imagen del avatar, puedes mostrar una imagen por defecto o un mensaje -->
                    <img src="../images/default_avatar.png" alt="Avatar" width="200">
                <?php } ?>
            </div>
            <div class="info-item">
                <span>Username:</span>
                <span><?php echo $row['username']; ?></span>
            </div>
            <div class="info-item">
                <span>Puntos:</span>
                <span><?php echo $row['puntos']; ?></span>
            </div>
            <div class="info-item">
                <span>Rango:</span>
                <span><?php echo $row['rango']; ?></span>
            </div>
            <form action="ver_estadisticas.php" method="post">
                <input type="submit" value="Ver estadísticas">
            </form>
        <?php } else { ?>
            <p>No se encontró información del jugador.</p>
        <?php } ?>
    </div>

    <script src="script.js"></script>
</body>

</html>
