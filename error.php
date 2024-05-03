<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>ERROR</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body style="background-image: url('images/fondo2.jpg');">   
    <div class="login-form">
        
        <div class="logo"><img src="images/free4.png" alt="logo"></div>

        <div class="social-media">
            <button class="fb"><img src="images/fb.png" alt="facebook"></button>
            <button class="google"><img src="images/google.png" alt="google"></button>
            <button class="ps"><img src="images/vk5.png" alt="ps"></button>
            <button class="xbox"><img src="images/apple.png" alt="xbox"></button>
            <button class="switch"><img src="images/twt.png" alt="switch"></button>
        </div>

        <h6>ERROR DE INICIO DE SESION</h6>

        <form action="controller/inicio.php" method="post">
            
            <div class="textbox">
                <input type="text" placeholder="Username">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="textbox">
                <input type="password" name="password" placeholder="Contraseña" id="password">
                <span class="check-message hidden">Obligatorio</span>
            </div>

            <div class="options">
                <label class="remember-me">
                    <span class="checkbox">
                        <input type="checkbox">
                        <span class="checked"></span>
                    </span>
                    Recuerdame
                </label>
                <a href="">Olvidaste tu contraseña</a>
            </div>

            <input type="submit" value="iniciar" name="inicio" class="login-btn">
            <input type="hidden" name="MM_insert" value="formreg">

            <div class="privacy-link">
                <a href="">Politicas de Privacidad</a>
            </div>
        </form>

        <div class="dont-have-account">
           ¿No tienes una Cuenta? 
            <a href="registro.php">Registrarse</a>
        </div>

        <div class="name">
            ~ Julian Daniel Andrea ~
        </div>
    </div>


</body>
</html>