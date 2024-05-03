<?php 
session_start(); 
require_once("../conexion/conexion.php"); 
$db = new Database(); 
$con = $db->conectar(); 
include("../controller/validar.php"); 

// Obtener el nombre de usuario del jugador actual
$username_actual = $_SESSION['username'];

// Consulta SQL para obtener los mundos y contar el número de jugadores en cada uno
$sql = "SELECT m.id_mundo, m.nombre_fo, m.maxi_jugadores, m.foto, COUNT(p.id_usuario) AS jugadores_actuales
        FROM mundo m
        LEFT JOIN partida p ON m.id_mundo = p.id_mundo
        WHERE m.id_puntosm = (SELECT id_puntos FROM usuarios WHERE username = :username_actual)
        GROUP BY m.id_mundo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':username_actual', $username_actual);
$stmt->execute();

// Crear un array con los datos de los mundos
$worlds = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Mundo</title>
    <link rel="stylesheet" href="../css/mundo.css">
    <style>
        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>
<body>
<?php include("../nav/nav_jugador.php") ?>
    <div class="container">
        <h1>Seleccionar Mundo</h1>
        <div class="card-deck">
        <?php foreach ($worlds as $world) { ?>
            <div class="card">
                <!-- Mostrar imagen del mapa -->
                <img src="<?php echo $world['foto']; ?>" alt="<?php echo $world['nombre_fo']; ?>">
                <!-- Mostrar botón para unirse a la sala -->
                <form action="unirse_sala.php" method="post">
                    <input type="hidden" name="username" value="<?php echo $username_actual; ?>">
                    <input type="hidden" name="id_mundo" value="<?php echo $world['id_mundo']; ?>">
                    <input type="submit" value="Unirse a la Sala" class="<?php echo $world['jugadores_actuales'] >= 5 ? 'disabled' : ''; ?>">
                    <?php if ($world['jugadores_actuales'] >= $world['maxi_jugadores']) { ?>
                        <!-- Mostrar mensaje de sala llena -->
                        <span>¡La sala está llena!</span>
                    <?php } ?>
                </form>
                <!-- Mostrar botón para redireccionar a sala.php -->
                <form action="sala.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $world['id_mundo']; ?>">
                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario_actual; ?>">
                    <input type="submit" value="Ingresar Sala">
                </form>
            </div>
        <?php } ?>
        </div>
    </div>
</body>
</html>