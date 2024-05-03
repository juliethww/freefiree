<?php
session_start();

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

// Obtener el ID de usuario de sesión activa
$username = $_SESSION['username'];
$sql_user_id = "SELECT id_usuario FROM usuarios WHERE username = '$username'";
$result_user_id = $conn->query($sql_user_id);

if ($result_user_id->num_rows > 0) {
    $row_user_id = $result_user_id->fetch_assoc();
    $id_usuario = $row_user_id['id_usuario'];
} else {
    echo "Error: No se encontró el ID de usuario.";
    exit();
}

// Consulta SQL para obtener los detalles de la partida del usuario
$sql = "SELECT detalles_partida.id_detalle, 
               atacante.username AS atacante_username, 
               atacante_avatar.foto AS atacante_foto,
               atacado.username AS atacado_username, 
               atacado_avatar.foto AS atacado_foto,
               armas.nombre_ar AS nombre_arma,
               armas.foto AS arma_foto,
               mundo.nombre_fo AS nombre_mapa,
               mundo.foto AS mundo_foto,
               detalles_partida.fecha
        FROM detalles_partida
        INNER JOIN usuarios AS atacante ON detalles_partida.id_atacante = atacante.id_usuario
        INNER JOIN avatar AS atacante_avatar ON atacante.id_avatar = atacante_avatar.id_avatar
        INNER JOIN usuarios AS atacado ON detalles_partida.id_atacado = atacado.id_usuario
        INNER JOIN avatar AS atacado_avatar ON atacado.id_avatar = atacado_avatar.id_avatar
        INNER JOIN armas ON detalles_partida.id_arma = armas.id_arma
        INNER JOIN mundo ON detalles_partida.id_mundo = mundo.id_mundo
        WHERE detalles_partida.id_atacante = $id_usuario OR detalles_partida.id_atacado = $id_usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los detalles de la partida del usuario
    echo "<h2>Estadísticas de la partida</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID de Detalle</th>
                <th>Atacante</th>
                <th>Foto de Atacante</th>
                <th>Atacado</th>
                <th>Foto de Atacado</th>
                <th>Arma</th>
                <th>Foto de Arma</th>
                <th>Mapa</th>
                <th>Foto de Mapa</th>
                <th>Hora</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_detalle'] . "</td>";
        echo "<td>" . $row['atacante_username'] . "</td>";
        echo "<td><img src='" . $row['atacante_foto'] . "' width='50'></td>";
        echo "<td>" . $row['atacado_username'] . "</td>";
        echo "<td><img src='" . $row['atacado_foto'] . "' width='50'></td>";
        echo "<td>" . $row['nombre_arma'] . "</td>";
        echo "<td><img src='" . $row['arma_foto'] . "' width='50'></td>";
        echo "<td>" . $row['nombre_mapa'] . "</td>";
        echo "<td><img src='" . $row['mundo_foto'] . "' width='50'></td>";
        echo "<td>" . $row['fecha'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron detalles de la partida.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Estilos de la tabla de estadísticas */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffffff;
        }

         th,
         td {
            padding: 12px;
            border: 1px solid #dddddd;
            text-align: left;
        }

         th {
            background-color: #f2f2f2;
            color: #333333;
        }

         tr:nth-child(even) {
            background-color: #f9f9f9;
        }

         tr:hover {
            background-color: #f2f2f2;
        }

        table img {
            width: 50px;
            height: auto;
        }
    </style>
</head>

<body>

</body>

</html>