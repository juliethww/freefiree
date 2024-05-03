<?php 
session_start(); 
require_once("../conexion/conexion.php"); 
$db = new Database(); 
$con = $db->conectar(); 
include("../controller/validar.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/sesion.css">
</head>
<body style="background-image: url('../images/fondo3.jpeg');">
    <header>
        <h1 class="center">.</h1>
        <a href="cerrar_sesion.php" class="logout-btn">Cerrar Sesión</a>
    </header>
    <nav>
        <ul class="menu">
            <li>
                <a href="tabla_juga.php">JUGADORES</a>
                <ul class="menu_ver">
                    <li><a href="jugadores_activos.php">Jugadores Activos</a></li>
                </ul>
            </li>
            <li>
                <a href="tabla_armas.php">ARMAS</a>
                <ul class="menu_ver">
                    <li><a href="tabla_armas.php">Tabla Armas</a></li>
                </ul>
            </li>
            <li>
                <a href="tabla_avatar.php">AVATAR</a>
                <ul class="menu_ver">
                    <li><a href="tablas/tabla_perso.php">Avatar</a></li>
                </ul>
            </li>
            <li>
                <a href="tabla_mundo.php">MUNDO</a>
                <ul class="menu_ver">
                    <li><a href="tablas/regis_part.php">Registro Partidas</a></li>
                </ul>
            </li>
            <li>
                <a href="formulario.php">INGRESO DE DATOS</a>
                <ul class="menu_ver">
                    <li><a href="formulario/formulario.php">Formularios</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</body>
</html>