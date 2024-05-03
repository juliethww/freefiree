<?php
require_once("../conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $nombre = $_POST['nombre'];
    $maxi_jugadores = $_POST['maxi_jugadores'];
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
            echo "error, el archivo no es una imagen";
        } else if ($size > 3*1024*1024) {
            echo "error, el tamaño máximo permitido es 3MB";
        } else {
            $src = $carpeta.$nombre;
            move_uploaded_file($ruta_provisional, $src);
            $foto = "../images/".$nombre;
        }
    }

    $sql = $con->prepare("SELECT * FROM mundo where nombre='$nombre'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($nombre == "") {
        echo '<script>alert ("COMPLETE EL CAMPO NOMBRE"); </script>';
        echo '<script>window.location="registro.php"</script>';
    } else {
        $insertSQL = $con->prepare("INSERT INTO mundo(nombre,maxi_jugadores,foto) VALUES ('$nombre','$maxi_jugadores','$foto')");
        $insertSQL->execute();
        echo '<script>alert ("registro exitoso"); </script>';
        echo '<script>window.location="crear_mundo.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registro.css">
    <title>MUNDO</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body style="background-image: url('../images/fondo1.jpg');">   
    <div class="login-form">       
        <div class="logo"><img src="../images/free4.png" alt="logo"></div>
        <h6>CREAR MUNDO</h6>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="textbox">
                <input type="text" name="nombre" placeholder="Nombre Mundo">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <div class="textbox">
                <input type="number" name="maxi_jugadores" placeholder="Maximo de Jugadores">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <br>
            <div class="">
                <input type="file" name="foto" placeholder="Foto">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <input type="submit" value="Registrarse" name="inicio" class="login-btn">
            <input type="hidden" name="MM_insert" value="formreg">
            <div class="dont-have-account">
                ¿Tienes una Cuenta?
                <a href="index.php">Inicia Sesión</a>
            </div>
            <div class="name">
                ~ Julian Daniel Andrea ~
            </div>
        </form>
    </div>
</body>
</html>
