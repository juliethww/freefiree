<?php
session_start();
require_once("conexion/conexion.php");
$db = new Database();
$con = $db->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $username = $_POST['username'];
    $contrasena = $_POST['contrasena'];
    $avatar = $_POST['avatar'];
    $puntos = 0; // Valor inicial de puntos

    // Establecer automáticamente el rol de jugador
    $tip_user = 2; // ID de jugador

    // Obtener el nivel para un nuevo usuario desde la tabla puntos
    $nivelQuery = $con->prepare("SELECT nivel FROM puntos WHERE nivel = 1");
    $nivelQuery->execute();
    $nivelInfo = $nivelQuery->fetch(PDO::FETCH_ASSOC);

    // Valor de vida inicial
    $vida_inicial = 125;

    // Hash de la contraseña
    $pass_cifrado = password_hash($contrasena, PASSWORD_DEFAULT, array("pass" => 12));

    // Insertar los datos del usuario con el nivel, los puntos y la vida correspondientes
    $insertSQL = $con->prepare("INSERT INTO usuarios(nombre, correo, username,  contrasena, id_avatar, id_tip_user, nivel, puntos, vida) 
                                VALUES (:nombre, :correo, :username,  :contrasena, :avatar, :tip_user, :nivel, :puntos, :vida)");
    $insertSQL->bindParam(':nombre', $nombre);
    $insertSQL->bindParam(':correo', $correo);
    $insertSQL->bindParam(':username', $username);
    $insertSQL->bindParam(':contrasena', $pass_cifrado);
    $insertSQL->bindParam(':avatar', $avatar);
    $insertSQL->bindParam(':tip_user', $tip_user);
    $insertSQL->bindParam(':nivel', $nivelInfo['nivel']);
    $insertSQL->bindParam(':puntos', $puntos); // Insertar el valor de puntos
    $insertSQL->bindParam(':vida', $vida_inicial);
    $insertSQL->execute();

    if ($nombre == "" || $correo == "" || $username == "" || $contrasena == "" || $avatar == "") {
        echo '<script>alert ("Por favor complete todos los campos"); </script>';
        echo '<script>window.location="registro.php"</script>';
    } else {
        echo '<script>alert ("Registro exitoso"); </script>';
        echo '<script>window.location="index.php"</script>';
    }
}
?>

 <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/registro.css">
        <title>Registrarse</title>
        <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    </head>
    <body style="background-image: url('images/fondo1.jpg');">   
        <div class="login-form">
            
            <div class="logo"><img src="images/free4.png" alt="logo"></div>

            <div class="social-media">
                <button class="fb"><img src="images/fb.png" alt="facebook"></button>
                <button class="google"><img src="images/google.png" alt="google"></button>
                <button class="ps"><img src="images/vk5.png" alt="ps"></button>
                <button class="xbox"><img src="images/apple.png" alt="xbox"></button>
                <button class="switch"><img src="images/twt.png" alt="switch"></button>
            </div>

            <h6>Registrese</h6>

            <form action="" method="post">

            

            <div class="textbox">
    <input type="text" name="nombre" placeholder="Nombre">
    <span class="check-message hidden">Obligatorio</span>
</div>

<div class="textbox">
    <input type="email" name="correo" placeholder="Correo">
    <span class="check-message hidden">Obligatorio</span>
</div>

<div class="textbox">
    <input type="text" name="username" placeholder="Username">
    <span class="check-message hidden">Obligatorio</span>
</div>

<div class="textbox">
    <input type="password" name="contrasena" placeholder="Contraseña" id="password">
    <span class="check-message hidden">Obligatorio</span>
</div>

<div class="textbox">
<select class="textbox" name="avatar" id="avatar" require>
                        <option value="">Seleccione uno</option>
                        <?php
                            $control = $con -> prepare ("select * from avatar where id_avatar");
                            $control -> execute();

                            while ($fila = $control -> fetch(PDO::FETCH_ASSOC))
                            {
                                echo "<option value=" . $fila['id_avatar'] . ">" . $fila['avatar'] . "</option>";
                            }
                        ?>
                    </select>
    <span class="check-message hidden">Obligatorio</span>
</div>

<input type="submit" value="Registrarse" name="inicio" class="login-btn">
<input type="hidden" name="MM_insert" value="formreg">

            <div class="dont-have-account">
            ¿Tienes una Cuenta?
                <a href="index.php">Inicia Sesión</a>
            </div>

            <div class="name">
                ~Daniel Andrea ~
            </div>
        </div>

        
        </form>
    </body>
    </html>
