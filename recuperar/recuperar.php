<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body style="background-image: url('../images/fondo2.jpg');">   
    <div class="login-form">
        
        <div class="logo"><img src="../images/free4.png" alt="logo"></div>

        <h6>Recuperar Contraseña</h6>

        <form action="contra.php" method="post">
            
            <div class="textbox">
                <input type="text" name="correo" id="correo"  placeholder="Correo">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="textbox">
                <input type="password" name="contrasena" id="contrasena"  placeholder="Contraseña" id="password">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="options">
                <label class="remember-me">
                    <span class="checkbox">
                        <input type="checkbox">
                        <span class="checked"></span>
                    </span>
                </label>
            </div>

            <input type="submit" value="iniciar" name="inicio" class="login-btn">
            <input type="hidden" name="MM_insert" value="formreg">

            <div class="privacy-link">
                <a href="">Politicas de Privacidad</a>
            </div>
        </form>


        <div class="name">
            ~ Julian Daniel Andrea ~
        </div>
    </div>


</body>
</html>