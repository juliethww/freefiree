<?php
// Iniciamos la sesión para mantener la información del usuario
session_start();

// Incluimos el archivo de conexión a la base de datos
require_once("../conexion/conexion.php");
$db = new Database(); // Creamos una instancia de la clase Database para la conexión
$con = $db->conectar(); // Establecemos la conexión con la base de datos

// Obtenemos el ID de la sala desde el parámetro de la URL
$id_sala = $_GET['id'];

// Obtenemos el nombre de usuario del jugador actual de la sesión
$username_actual = $_SESSION['username'];

// Obtenemos el ID del usuario actual consultando la base de datos
$sql_user_id = "SELECT id_usuario FROM usuarios WHERE username = :username_actual";
$stmt_user_id = $con->prepare($sql_user_id);
$stmt_user_id->bindParam(':username_actual', $username_actual);
$stmt_user_id->execute();
$user_id_row = $stmt_user_id->fetch(PDO::FETCH_ASSOC);
$user_id = $user_id_row['id_usuario'];

// Verificamos si el usuario está registrado en la sala
$sql_check_user_in_room = "SELECT COUNT(*) AS count FROM partida WHERE id_mundo = :id_sala AND id_usuario = :user_id";
$stmt_check_user_in_room = $con->prepare($sql_check_user_in_room);
$stmt_check_user_in_room->bindParam(':id_sala', $id_sala);
$stmt_check_user_in_room->bindParam(':user_id', $user_id);
$stmt_check_user_in_room->execute();
$user_in_room = $stmt_check_user_in_room->fetch(PDO::FETCH_ASSOC);
$is_registered = $user_in_room['count'] > 0;

if (!$is_registered) {
    // Si el usuario no está registrado en la sala, mostramos un mensaje y redireccionamos
    echo '<script>alert("No estás registrado en esta sala. Por favor, intenta nuevamente."); window.location.href = "mundo.php";</script>';
    exit; // Terminamos la ejecución del script
}

// Consultamos los usuarios presentes en la sala, excluyendo al usuario actual
$sql_users = "SELECT p.id_usuario, u.username, u.vida, u.id_puntos
            FROM partida p
            INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE p.id_mundo = :id_sala AND p.id_usuario != :user_id";
$stmt_users = $con->prepare($sql_users);
$stmt_users->bindParam(':id_sala', $id_sala);
$stmt_users->bindParam(':user_id', $user_id);
$stmt_users->execute();
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Consultamos las armas disponibles que tengan menos o igual puntos que el usuario actual
$sql_armas = "SELECT id_arma, nombre_ar, cant_balas, dano FROM armas WHERE id_puntos <= (SELECT id_puntos FROM mundo WHERE id_mundo = :id_sala) AND id_tipo IN (1, 2, 3, 4)";
$stmt_armas = $con->prepare($sql_armas);
$stmt_armas->bindParam(':id_sala', $id_sala);
$stmt_armas->execute();
$armas = $stmt_armas->fetchAll(PDO::FETCH_ASSOC);

// Verificamos y eliminamos usuarios con vida <= 0 o id_puntos diferente al del mundo
$eliminados = [];
foreach ($users as $user) {
    if ($user['vida'] <= 0 || $user['id_puntos'] != $id_sala) {
        // Eliminamos al usuario de la partida
        $sql_delete_user_from_room = "DELETE FROM partida WHERE id_usuario = :user_id AND id_mundo = :id_sala";
        $stmt_delete_user_from_room = $con->prepare($sql_delete_user_from_room);
        $stmt_delete_user_from_room->bindParam(':user_id', $user['id_usuario']);
        $stmt_delete_user_from_room->bindParam(':id_sala', $id_sala);
        $stmt_delete_user_from_room->execute();
        $eliminados[] = $user['username'];
    }
}

// Mostramos una alerta si se eliminaron usuarios de la sala
if (!empty($eliminados)) {
    $mensaje_alerta = 'Jugador(es) eliminado(s) de la sala: ' . implode(', ', $eliminados) . '. Motivo: Vida <= 0 y/o id_puntos diferente al del mundo.';
    echo "<script>alert('$mensaje_alerta');</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sala</title>
    <link rel="stylesheet" href="../css/sala.css">
    <script>
        window.onload = function() {
            // Ocultamos el div de selección de arma y el botón de atacar al cargar la página
            document.getElementById("div-ataque").style.display = "none";
            document.getElementById("espera-ataque").style.display = "block";

            // Contador para mostrar el div de selección de arma y el botón de atacar después de 30 segundos
            var segundosRestantes = 30;
            var contadorRegresivo = setInterval(function() {
                segundosRestantes--;
                document.getElementById("espera-ataque").innerText = "Espera (" + segundosRestantes + " segundos para atacar)";
                if (segundosRestantes == 0) {
                    clearInterval(contadorRegresivo);
                    document.getElementById("div-ataque").style.display = "block";
                    document.getElementById("espera-ataque").style.display = "none";
                }
            }, 1000);

            // Contador para redireccionar a jugaro.php después de 5 minutos
            var tiempoRestante = 300; // 5 minutos en segundos
            var contadorTiempo = setInterval(function() {
                tiempoRestante--;
                document.getElementById("tiempo-restante").innerText = "Tiempo restante de partida: " + formatTime(tiempoRestante);
                if (tiempoRestante <= 0) {
                    clearInterval(contadorTiempo);
                    window.location.href = "jugador.php";
                }
            }, 1000);

            // Función para formatear el tiempo en formato mm:ss
            function formatTime(seconds) {
                var minutos = Math.floor(seconds / 60);
                var segundos = seconds % 60;
                return minutos.toString().padStart(2, '0') + ":" + segundos.toString().padStart(2, '0');
            }
        }
    </script>
</head>

<body>
    <?php include("../nav/nav_jugador.php") ?> <!-- Incluimos la barra de navegación -->
    <div class="container">
        <h1>Usuarios en la sala</h1>
        <!-- Formulario para el ataque -->
        <form action="procesar_ataque.php" method="post" id="div-ataque">
            <select name="id_atacado" id="id_atacado">
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user['id_usuario']; ?>"><?php echo $user['username']; ?></option>
                <?php } ?>
            </select>
            <h1>Seleccionar arma</h1>
            <input type="hidden" name="id_atacante" value="<?php echo $user_id; ?>">
            <input type="hidden" name="id_sala" value="<?php echo $id_sala; ?>">
            <select name="id_arma" id="id_arma">
                <?php foreach ($armas as $arma) { ?>
                    <option value="<?php echo $arma['id_arma']; ?>"><?php echo $arma['nombre_ar']; ?>
                        <?php echo 'Daño: ' . $arma['dano'] . '%'; ?> <?php echo 'balas: ' . $arma['cant_balas']; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="id_mundo" value="<?php echo $id_sala; ?>">
            <input type="hidden" name="id_atacante" value="<?php echo $user_id; ?>">

            <input type="submit" value="Atacar">
        </form>
        <!-- Div para mostrar el tiempo de espera para atacar -->
        <div id="espera-ataque">Espera (30 segundos para atacar)</div>
        <!-- Div para mostrar el tiempo restante de la partida -->
        <div id="tiempo-restante">Tiempo restante de partida: 05:00</div>
    </div>
</body>

</html>
