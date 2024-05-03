<?php
session_start();
require_once("../conexion/conexion.php");
// include("../../../controller/validarSesion.php");
$db = new Database();
$con = $db->conectar();

//empieza la consulta
$sql = $con->prepare("SELECT * FROM armas WHERE id_arma='" . $_GET['id'] . "'");
$sql->execute();
$fila = $sql->fetch();

//declaracion de variables de campos en la tabla

if (isset($_POST['actualizar'])) {

    $id_arma = $_POST['id_arma'];
    $nombre_ar = $_POST['nombre_ar'];
    $id_tipo = $_POST['id_tipo'];
    $cant_balas = $_POST['cant_balas'];
    $dano = $_POST['dano'];
    $foto = '';
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
            echo "erorr, el archivo no es una imagen";
        } else if ($size > 3 * 1024 * 1024) {
            echo "error, el tamaño maximo permititdo es un 3MB";
        } else {
            $src = $carpeta . $nombre;
            move_uploaded_file($ruta_provisional, $src);
            $foto = "../images/" . $nombre;
        }
    }

    $insert = $con->prepare("UPDATE armas SET id_arma='$id_arma', nombre_ar='$nombre_ar', id_tipo='$id_tipo', cant_balas='$cant_balas', dano='$dano', foto='$foto'  WHERE id_arma = '" . $_GET['id'] . "'");
    $insert->execute();
    echo '<script> alert ("Registro actualizado exitosamente");</script>';
    echo '<script> window.close(); </script>';
} else if (isset($_POST['eliminar'])) {

    $id_arma = $_POST['id_arma'];
    $nombre_ar = $_POST['nombre_ar'];
    $id_tipo = $_POST['id_tipo'];
    $cant_balas = $_POST['cant_balas'];
    $dano = $_POST['dano'];
    $foto = $_POST['foto'];

    $insert = $con->prepare("DELETE FROM armas WHERE id_arma = '" . $_GET['id'] . "'");
    $insert->execute();
    echo '<script> alert ("Registro actualizado exitosamente");</script>';
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
                <td><input type="text" name="id_arma" value="<?php echo $fila['id_arma'] ?>" readonly></td>
            </tr>

            <tr>
                <td>Nombre Arma</td>
                <td><input type="text" name="nombre_ar" value="<?php echo $fila['nombre_ar'] ?>" readonly></td>
            </tr>

            <tr>
                <td>Tipo Arma</td>
                <td>
            <select class="textbox" name="id_tipo" id="id_tipo" require>
                        <option value="">Seleccione uno</option>
                        <?php
							$control = $con->prepare("SELECT * FROM armas");
							$control->execute();
							while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $fila['id_arma'] . "'>" . $fila['id_tipo'] . "</option>";
							}
							?>
                    </select> 
                </td>
            </tr>


            <tr>
                <td>Cantidad de balas</td>
                <td><input type="number" name="cant_balas" value="<?php echo $fila['cant_balas'] ?>" ></td>
            </tr>

            <tr>
                <td>Daño</td>
                <td><input type="number" name="dano" value="<?php echo $fila['dano'] ?>" ></td>
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
