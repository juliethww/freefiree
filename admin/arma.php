<?php
        session_start();
        require_once("../conexion/conexion.php");
        // include("../../../controller/validarSesion.php");
        $db = new Database();
        $con = $db -> conectar();

    //empieza la consulta
    $sql = $con -> prepare("SELECT * FROM id_armas WHERE id_armas='".$_GET['id']."'");
    $sql -> execute();
    $fila = $sql -> fetch ();

    //declaracion de variables de campos en la tabla

    if (isset($_POST['actualizar'])){

          
    $nombre= $_POST['nombre'];
    $tipo= $_POST['tipo'];
    $cant_balas= $_POST['cant_balas'];
    $dano= $_POST['dano'];
        
            $insert= $con -> prepare ("UPDATE id_armas SET nombre='$nombre', tipo='$tipo' , cant_balas='$cant_balas', dano='$dano'  WHERE id_armas = '".$_GET['id']."'");
            $insert -> execute();
            echo '<script> alert ("Registro actualizado exitosamente");</script>';
            echo '<script> window.close(); </script>';
                
        }

        else if (isset($_POST['eliminar'])){
               
    $nombre= $_POST['nombre'];
    $tipo= $_POST['tipo'];
    $cant_balas= $_POST['cant_balas'];
    $dano= $_POST['dano'];
            
                $insert= $con -> prepare ("DELETE FROM id_armas WHERE id_armas = '".$_GET['id']."'");
                $insert -> execute();
                echo '<script> alert ("Registro actualizado exitosamente");</script>';
                echo '<script> window.close(); </script>';
                    
            }
?>

<!DOCTYPE html>
<html lang="en">
    <script>
        function centrar() {
            iz=(screen.width-document.body.clientWidth) / 2;
            de=(screen.height-document.body.clientHeight) / 3;
            moveTo(iz,de);
        }
    </script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Articulos</title>
    <link rel="stylesheet" href="../../../css/tablaedi.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6375/6375816.png">
</head>
<body onload="centrar();">
    
        <table class="center">
            <form autocomplete="off" name="form_actualizar" method="POST">

                <tr>
                    <td>Nombre</td>
                    <td><input name="nombre" value="<?php echo $fila['nombre'] ?>" ></td>                 
                </tr>

                <tr>
                    <td>tipo</td>
                    <td><input type="" name="tipo" value="<?php echo $fila['tipo'] ?>"></td>                 
                </tr>

                <tr>
                    <td>cantidad de balas </td>
                    <td><input type="" name="cant_balas" value="<?php echo $fila['cant_balas'] ?>"></td>                 
                </tr>

                <tr>
                    <td>daño</td>
                    <td><input type="" name="dano" value="<?php echo $fila['dano'] ?>"></td>                 
                </tr>

                <tr>
                    <td><input type="submit" name="actualizar" value="Actualizar"></td>
                    <td><input type="submit" name="eliminar" value="Eliminar"></td>
                </tr>
            </form>
        </table>
    


</body>
</html>