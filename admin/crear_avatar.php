<?php
require_once("../conexion/conexion.php");
$db = new Database();
$con =$db->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $avatar= $_POST['avatar'];
    $foto= $_POST['foto'];
    

    $sql = $con -> prepare ("SELECT * FROM avatar where avatar='$avatar'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if($avatar=="") {
        echo '<script>alert ("COMPLETE EL CAMPO NOMBRE"); </script>';
        echo '<script>window.location="registro.php"</script>';
    } 
    else {
        $insertSQL = $con->prepare ("INSERT INTO avatar(avatar,foto) 
        VALUES ('$nombre','$correo')");
        $insertSQL->execute();
        echo '<script>alert ("registro exitoso"); </script>';
        echo '<script>window.location="index.php"</script>';
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/registro.css">
        <title>Avatar</title>
        <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    </head>
    <body style="background-image: url('../images/fondo1.jpg');">   
        <div class="login-form">
            
            <div class="logo"><img src="../images/free4.png" alt="logo"></div>


            <h6>CREAR AVATAR</h6>

            <form action="" method="post">

            

            <div class="textbox">
    <input type="text" name="avatar" placeholder="Nombre Avatar">
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
        </div>

        
        </form>
    </body>
    </html>