<?php
require_once("../../conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $avatar = $_POST['avatar'];

    // Procesamiento de la imagen
    $foto = $_FILES['foto']['name'];
    $foto_temp = $_FILES['foto']['tmp_name'];
    $ruta_foto = "../../ruta/donde/guardar/" . $foto; // Ruta donde guardar la imagen

    // Mueve la imagen del directorio temporal al directorio deseado
    move_uploaded_file($foto_temp, $ruta_foto);

    $sql = $con->prepare("SELECT * FROM avatar where avatar='$avatar'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($avatar == "") {
        echo '<script>alert ("COMPLETE EL CAMPO AVATAR "); </script>';
        echo '<script>window.location="registro.php"</script>';
    } else if ($foto == "") {
        echo '<script>alert ("SELECCIONE UNA IMAGEN"); </script>';
        echo '<script>window.location="registro.php"</script>';
    } else {
        $insertSQL = $con->prepare("INSERT INTO avatar(avatar,foto) VALUES ('$avatar','$ruta_foto')");
        $insertSQL->execute();
        echo '<script>alert ("Registro exitoso"); </script>';
        echo '<script>window.location="../formulario/formulario.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/regis.css">
    <title>Personajes</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
    
<body style="background-image: url('../../images/fondo1.jpg');">  
     
<div class="login-form">
    <div class="logo"><img src="../../imagenes/free4.png" alt="logo"></div>
    <form method="POST" enctype="multipart/form-data" autocomplete="off" class="formulario" id="formulario">
        <input type="submit" value="Regresar" name="regresar" id="regresar">
        <?php 
        if (isset($_POST['regresar'])){
            header('Location: ../formulario/formulario.php');
        }
        ?>
        <h6>Ingrese Avatar</h6>
        <div class="textbox">
            <input type="text" name="avatar" placeholder="Avatar">
            <span class="check-message hidden">Obligatorio</span>
        </div>
        <div class="textbox">
            <input type="file" name="foto" placeholder="Foto">
            <span class="check-message hidden">Obligatorio</span>
        </div>
        <input type="submit" value="Registrarse" name="inicio" class="login-btn">
        <input type="hidden" name="MM_insert" value="formreg">
        <div class="name">
            ~ Julian Daniel Andrea ~
        </div>
    </div>
</body>
</html>
