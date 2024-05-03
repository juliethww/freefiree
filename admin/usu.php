<?php
        session_start();
        require_once("../conexion/conexion.php");
        // include("../../../controller/validarSesion.php");
        $db = new Database();
        $con = $db -> conectar();

    //empieza la consulta
    $sql = $con -> prepare("SELECT * FROM usuarios WHERE id ='".$_GET['id']."'");
    $sql -> execute();
    $fila = $sql -> fetch ();

    //declaracion de variables de campos en la tabla

    if (isset($_POST['actualizar'])){

          
    $nom_usu= $_POST['nom_usu'];
    $gmail= $_POST['gmail'];
    $contrasena= $_POST['contrasena'];
    $avatar= $_POST['avatar'];
    $nivel= $_POST['nivel'];
    $puntos= $_POST['puntos'];
    

            $insert= $con -> prepare ("UPDATE usuarios SET nom_usu='$nom_usu', gmail='$gmail' , contrasena='$contrasena', avatar='$avatar', nivel='$nivel', puntos='$puntos' WHERE id = '".$_GET['id']."'");
            $insert -> execute();
            echo '<script> alert ("Registro actualizado exitosamente");</script>';
            echo '<script> window.close(); </script>';
                
        }

        else if (isset($_POST['eliminar'])){
               
            $nom_usu= $_POST['nom_usu'];
            $gmail= $_POST['gmail'];
            $contrasena= $_POST['contrasena'];
            $avatar= $_POST['avatar'];
            $nivel= $_POST['nivel'];
            $puntos= $_POST['puntos'];
            
            
                $insert= $con -> prepare ("DELETE FROM usuarios WHERE id = '".$_GET['id']."'");
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
                    <td><input name="nom_usu" value="<?php echo $fila['nom_usu'] ?>" ></td>                 
                </tr>

                <tr>
                    <td>gmail</td>
                    <td><input type="" name="gmail" value="<?php echo $fila['gmail'] ?>"></td>                 
                </tr>

                <tr>
                    <td>contraseña </td>
                    <td><input type="" name="contrasena" value="<?php echo $fila['contrasena'] ?>"></td>                 
                </tr>

                <tr>
                    <td>avatar</td>
                    <td><input type="" name="avatar" value="<?php echo $fila['avatar'] ?>"></td>                 
                </tr>

                <tr>
                    <td>nivel</td>
                    <td><input type="" name="nivel" value="<?php echo $fila['nivel'] ?>"></td>                 
                </tr>

                <tr>
                    <td>puntos</td>
                    <td><input type="" name="puntos" value="<?php echo $fila['puntos'] ?>"></td>                 
                </tr>


                <tr>
                    <td><input type="submit" name="actualizar" value="Actualizar"></td>
                    <td><input type="submit" name="eliminar" value="Eliminar"></td>
                </tr>
            </form>
        </table>
    


</body>
</html>