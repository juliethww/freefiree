<?php
session_start();

require_once("../conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

// Verificar si se recibieron los datos del formulario
if (isset($_POST['id_atacante'], $_POST['id_atacado'], $_POST['id_sala'], $_POST['id_arma'])) {
    // Obtener los datos del formulario
    $id_atacante = $_POST['id_atacante'];
    $id_atacado = $_POST['id_atacado'];
    $id_sala = $_POST['id_sala'];
    $id_arma = $_POST['id_arma'];

    // Consulta para obtener el tipo de arma y su daño
    $sql_arma = "SELECT id_tipo, dano FROM armas WHERE id_arma = :id_arma";
    $stmt_arma = $con->prepare($sql_arma);
    $stmt_arma->bindParam(':id_arma', $id_arma);
    $stmt_arma->execute();
    $arma = $stmt_arma->fetch(PDO::FETCH_ASSOC);

    if ($arma) {
        // Insertar los datos en la tabla detalles_partida
        $sql_insert = "INSERT INTO detalles_partida (id_atacante, id_atacado, id_arma, id_mundo) VALUES (:id_atacante, :id_atacado, :id_arma, :id_sala)";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bindParam(':id_atacante', $id_atacante);
        $stmt_insert->bindParam(':id_atacado', $id_atacado);
        $stmt_insert->bindParam(':id_arma', $id_arma);
        $stmt_insert->bindParam(':id_sala', $id_sala);

        if ($stmt_insert->execute()) {
            // Restar el daño del arma a la vida del usuario atacado
            $dano_arma = $arma['dano'];
            $sql_restar_vida = "UPDATE usuarios SET vida = vida - :dano_arma WHERE id_usuario = :id_atacado";
            $stmt_restar_vida = $con->prepare($sql_restar_vida);
            $stmt_restar_vida->bindParam(':dano_arma', $dano_arma);
            $stmt_restar_vida->bindParam(':id_atacado', $id_atacado);
            $stmt_restar_vida->execute();

            // Sumar puntos al usuario atacante dependiendo del tipo de arma
            $puntos_a_sumar = 0;
            switch ($arma['id_tipo']) {
                case 1:
                    $puntos_a_sumar = 1;
                    break;
                case 2:
                    $puntos_a_sumar = 2;
                    break;
                case 3:
                    $puntos_a_sumar = 10;
                    break;
                case 4:
                    $puntos_a_sumar = 20;
                    break;
                default:
                    $puntos_a_sumar = 0;
            }

            // Actualizar puntos del usuario atacante
            $sql_update_puntos = "UPDATE usuarios SET puntos = puntos + :puntos WHERE id_usuario = :id_atacante";
            $stmt_update_puntos = $con->prepare($sql_update_puntos);
            $stmt_update_puntos->bindParam(':puntos', $puntos_a_sumar);
            $stmt_update_puntos->bindParam(':id_atacante', $id_atacante);
            $stmt_update_puntos->execute();

            echo "¡Ataque procesado correctamente!";
        } else {
            echo "Error al procesar el ataque.";
        }
    } else {
        echo "Error: El arma seleccionada no existe.";
    }
} else {
    echo "Error: No se recibieron todos los datos necesarios.";
}
?>
