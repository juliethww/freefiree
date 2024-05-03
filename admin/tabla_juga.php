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
    <title>Jugadores Activos</title>
    <link rel="stylesheet" href="../css/tabla.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php include("../nav/nav_tablas.php") ?>
    <header>
    
    </header>

    <main>
        <h1 class="title">Jugadores Activos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Username</th>
                    <th>Correo</th>
                    <th>Avatar</th>
                    <th>Nivel</th>
                    <th>Puntos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $query = $con->prepare("SELECT usuarios.*, estado.estado, avatar.avatar, puntos.puntos AS puntos
                FROM usuarios
                LEFT JOIN estado ON usuarios.id_estado = estado.id_estado
                LEFT JOIN avatar ON usuarios.id_avatar = avatar.id_avatar
                LEFT JOIN puntos ON usuarios.id_puntos = puntos.id_puntos");
                $query->execute();
                $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach($resultados as $fila){
            ?>
                    <tr>
                        <td><?php echo $fila['nombre'] ?></td>
                        <td><?php echo $fila['username'] ?></td>
                        <td><?php echo $fila['correo'] ?></td>
                        <td><?php echo $fila['avatar'] ?></td>
                        <td><?php echo $fila['nivel'] ?></td>
                        <td><?php echo $fila['id_puntos'] ?></td>
                        <td><?php echo $fila['estado'] ?></td>
                        <td>
                            <a href="" onclick="window.open('jugadores.php?id=<?php echo $fila['id_usuario'] ?>','','width=500, height=400, toolbar=NO'); void(null);">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>
