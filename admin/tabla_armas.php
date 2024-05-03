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
    <title>Registro Armas</title>
    <link rel="stylesheet" href="../css/tabla.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php include("../nav/nav_tablas.php") ?>
    <header>
    
    </header>

    <main>
        <h1 class="title">Tabla Armas</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Municion</th>
                    <th>Daño</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
             
                  $query = $con -> prepare("SELECT * FROM armas, tipo_arma
                  where armas.id_tipo=tipo_arma.id_tipo");
                  $query -> execute ();
                  $resultados = $query -> fetchAll(PDO::FETCH_ASSOC);

                  foreach ($resultados as $fila){
            ?>
            <tr>
                <td><?php echo $fila['nombre_ar']?></td>
                <td><?php echo $fila['tipo']?></td>
                <td><?php echo $fila['cant_balas']?></td>
                <td><?php echo $fila['dano']?></td>
                <td><img src="<?php echo $fila['foto']?>" alt=" Foto" width="100"></td>
                <td>
                            <a href="" onclick="window.open('update_armas.php?id=<?php echo $fila['id_arma'] ?>','','width=500, height=400, toolbar=NO'); void(null);">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                
            </tr>
            <?php
                  }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
