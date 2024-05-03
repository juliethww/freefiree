<?php
session_start();
require_once ("../conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

// Verificar si se recibieron los datos del formulario
if (isset($_POST['username'], $_POST['id_mundo'])) {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $id_mundo = $_POST['id_mundo'];

    // Consulta para verificar si el usuario ya está unido al mapa
    $sql_check = "SELECT COUNT(*) AS count FROM partida WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE username = :username) AND id_mundo = :id_mundo";
    $stmt_check = $con->prepare($sql_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':id_mundo', $id_mundo);
    $stmt_check->execute();
    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // Si el usuario ya está unido al mapa, mostrar un mensaje y redirigir
        echo "<script>alert('¡Ya estás unido a este mapa! Ingresa a la sala.');</script>";
        echo "<script>window.location.href = 'mundo.php';</script>";
    } else {
        // Si el usuario no está unido al mapa, insertar los datos en la tabla partida
        $sql_insert = "INSERT INTO partida (id_usuario, id_mundo) VALUES ((SELECT id_usuario FROM usuarios WHERE username = :username), :id_mundo)";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bindParam(':username', $username);
        $stmt_insert->bindParam(':id_mundo', $id_mundo);

        if ($stmt_insert->execute()) {
            echo "¡Te has unido a la sala correctamente!";
        } else {
            echo "Error al unirse a la sala.";
        }
    }
} else {
    echo "Error: No se recibieron todos los datos necesarios.";
}
?>
