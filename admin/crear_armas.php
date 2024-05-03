<?php
require_once("../conexion/conexion.php");
$db = new Database();
$con =$db->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $nombre= $_POST['nombre'];
    $id_tipo= $_POST['id_tipo'];
    $cant_balas= $_POST['cant_balas'];
    $dano= $_POST['dano'];
    $foto= $_POST['foto'];


    $sql = $con -> prepare ("SELECT * FROM armas where nombre='$nombre'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if($nombre=="") {
        echo '<script>alert ("COMPLETE EL CAMPO NOMBRE"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    } else if($id_tipo=="") {
        echo '<script>alert ("COMPLETE EL CAMPO TIPO ARMA"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    } else if($cant_balas=="") {
        echo '<script>alert ("COMPLETE EL CAMPO CANTIDAD ARMAS"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    } else if($dano=="") {
        echo '<script>alert ("COMPLETE EL CAMPO DAÑO"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    } else if($foto=="") {
        echo '<script>alert ("COMPLETE EL CAMPO FOTO"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    } else if($fila){
        echo '<script>alert ("USUARIO YA REGISTRADO"); </script>';
        echo '<script>window.location="crear_armas.php"</script>';
    }
    else {
        $insertSQL = $con->prepare ("INSERT INTO armas(nombre,id_tipo,cant_balas,dano,foto) 
        VALUES ('$nombre','$tipo','$cant_balas','$dano','$foto')");
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
    <title>Arma</title>
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body style="background-image: url('../images/fondo1.jpg');">   
    <div class="login-form">
        <div class="logo"><img src="../images/free4.png" alt="logo"></div>
        <h6>CREAR ARMA</h6>
        <form action="" method="post">
            <div class="textbox">
                <input type="text" name="nombre" placeholder="Nombre Arma">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <div class="textbox">
                <select class="textbox" name="id_tipo" id="id_tipo" required>
                    <?php
                    require_once("../conexion/conexion.php");
                    $db = new Database();
                    $con =$db->conectar();

                    $control = $con->prepare("SELECT * FROM tipo_arma WHERE id_tipo");
                    $control->execute();
                    while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $fila['id_tipo'] . "'>" . $fila['tipo'] . "</option>";
                    }
                    ?>
                </select>
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <br>
            <div class="textbox">
                <input type="number" name="cant_balas" placeholder="Cantidad Balas">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <div class="textbox">
                <input type="number" name="dano" placeholder="Daño">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <br>
            <div class="">
                <input type="file" name="foto" placeholder="Foto">
                <span class="check-message hidden">Obligatorio</span>
            </div>
            <input type="submit" value="Registrarse" name="inicio" class="login-btn">
            <input type="hidden" name="MM_insert" value="formreg">
            <div class="name">
                ~ Julian Daniel Andrea ~
            </div>
        </form>
    </div>
</body>
</html>
