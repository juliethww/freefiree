<?php
session_start();
require_once("../conexion/conexion.php");
// include("../../../controller/validarSesion.php");
$db = new Database();
$con = $db->conectar();

//empieza la consulta
$sql = $con->prepare("SELECT * FROM avatar WHERE id_avatar='" . $_GET['id'] . "'");
$sql->execute();
$fila = $sql->fetch();

//declaracion de variables de campos en la tabla

if (isset($_POST['actualizar'])) {

    $id_avatar = $_POST['id_avatar'];
    $avatar = $_POST['avatar'];
    $foto = '';
    if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) { // Verificar si se ha subido un archivo
        $file = $_FILES["foto"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        if ($dimensiones !== false) { // Verificar si se pudieron obtener las dimensiones de la imagen
            $widht = $dimensiones[0];
            $height = $dimensiones[1];
            $carpeta = "../images/";
            if ($tipo != 'image/jpg' && $tipo != 'image/JPG' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
                echo "error, el archivo no es una imagen";
            } else if ($size > 3 * 1024 * 1024) {
                echo "error, el tamaño maximo permititdo es un 3MB";
            } else {
                $src = $carpeta . $nombre;
                move_uploaded_file($ruta_provisional, $src);
                $foto = "../images/" . $nombre;
            }
        } else {
            echo "Error al obtener las dimensiones de la imagen.";
        }
    }

    $insert = $con->prepare("UPDATE avatar SET id_avatar='$id_avatar', avatar='$avatar', foto='$foto'  WHERE id_avatar = '" . $_GET['id'] . "'");
    $insert->execute();
    echo '<script> alert ("Registro actualizado exitosamente");</script>';
    echo '<script> window.close(); </script>';
} else if (isset($_POST['eliminar'])) {

    $id_avatar = $_POST['id_avatar'];
    $avatar = $_POST['avatar'];
    $foto = $_POST['foto'];

    $insert = $con->prepare("DELETE FROM avatar WHERE id_avatar = '" . $_GET['id'] . "'");
    $insert->execute();
    echo '<script> alert ("Registro eliminado exitosamente");</script>';
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

<body onload="centrar();">

    <table class="center">
        <form autocomplete="off" name="form_actualizar" method="POST" enctype="multipart/form-data">

            <tr>
                <td>ID </td>
                <td><input type="text" name="id_avatar" value="<?php echo $fila['id_avatar'] ?>" readonly></td>
            </tr>

            <tr>
                <td>Avatar</td>
                <td><input type="text" name="avatar" value="<?php echo $fila['avatar'] ?>"></td>
            </tr>

            <tr>
                <td>Foto</td>
                <td><input type="file" name="foto" value="<?php echo $fila['foto'] ?>"></td>
            </tr>

        

            <tr>
                <td><input type="submit" name="actualizar" value="Actualizar"></td>
                <td><input type="submit" name="eliminar" value="Eliminar"></td>
            </tr>
        </form>
    </table>

</body>

</html>
