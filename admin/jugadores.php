<?php
session_start();
require_once("../conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM usuarios WHERE id_usuario=:id_usuario");
$sql->bindParam(':id_usuario', $_GET['id']);
$sql->execute();
$fila = $sql->fetch();

if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $username = $_POST['username'];
    $avatar = $_POST['avatar'];
    $nivel = $_POST['nivel'];
    $puntos_id = $_POST['puntos']; // Se obtiene el ID de los puntos
    $estado = $_POST['estado'];

    // Obtener los puntos correspondientes al ID seleccionado
    $puntos_sql = $con->prepare("SELECT puntos FROM puntos WHERE id_puntos=:puntos_id");
    $puntos_sql->bindParam(':puntos_id', $puntos_id);
    $puntos_sql->execute();
    $puntos_fila = $puntos_sql->fetch();
    $puntos = $puntos_fila['puntos'];

    $insert = $con->prepare("UPDATE usuarios SET nombre=?, correo=?, username=?, id_avatar=?, nivel=?, id_puntos=?, puntos=?, id_estado=? WHERE id_usuario = ?");
    $insert->execute([$nombre, $correo, $username, $avatar, $nivel, $puntos_id, $puntos, $estado, $_GET['id']]);

    // Mostrar la cantidad de puntos asociados
    echo '<script> alert("Registro actualizado exitosamente. Puntos asociados: ' . $puntos . '");</script>';
    echo '<script> window.close(); </script>';
} else if (isset($_POST['eliminar'])) {
    $insert = $con->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $insert->execute([$_GET['id']]);
    echo '<script> alert("Registro eliminado exitosamente");</script>';
    echo '<script> window.close(); </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Articulos</title>
    <link rel="stylesheet" href="../../../css/tablaedi.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6375/6375816.png">
</head>

<body>
    <table class="center">
        <form autocomplete="off" name="form_actualizar" method="POST">
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="nombre" value="<?php echo $fila['nombre'] ?>"></td>
            </tr>

            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo $fila['username'] ?>"></td>
            </tr>

            <tr>
                <td>Correo </td>
                <td><input type="text" name="correo" value="<?php echo $fila['correo'] ?>"></td>
            </tr>

            <tr>
                <td>Avatar</td>
                <td>
                    <select class="form-control" name="avatar" id="avatar">
                        <option value="">Seleccione un Avatar</option>
                        <?php
                        $control = $con->prepare("SELECT * FROM avatar");
                        $control->execute();
                        while ($fila_avatar = $control->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila_avatar['id_avatar'] . "'>" . $fila_avatar['avatar'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Nivel</td>
                <td><input type="text" name="nivel" value="<?php echo $fila['nivel'] ?>"></td>
            </tr>

            <tr>
                <td>Puntos</td>
                <td>
                    <select class="form-control" name="puntos" id="puntos">
                        <option value="">Seleccione los Puntos</option>
                        <?php
                        $puntos_control = $con->prepare("SELECT * FROM puntos ");
                        $puntos_control->execute();
                        while ($fila_puntos = $puntos_control->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($fila_puntos['puntos'] == $fila['puntos']) ? 'selected' : ''; // Verifica si este punto es el seleccionado
                            echo "<option value='" . $fila_puntos['id_puntos'] . "' $selected>" . $fila_puntos['puntos'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Estado</td>
                <td>
                    <select class="form-control" name="estado" id="estado">
                        <option value="">Seleccione un Estado</option>
                        <?php
                        $control_estado = $con->prepare("SELECT * FROM estado");
                        $control_estado->execute();
                        while ($fila_estado = $control_estado->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $fila_estado['id_estado'] . "'>" . $fila_estado['estado'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><input type="submit" name="actualizar" value="Actualizar"></td>
                <td><input type="submit" name="eliminar" value="Eliminar"></td>
            </tr>
        </form>
    </table>
</body>

</html>
