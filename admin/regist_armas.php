<?php
    session_start();
    require_once("../../conexion/conexion.php");
    $db = new Database();
    $con = $db -> conectar();
    

  if (isset($_POST['validar']))
   {

       
    $nombre= $_POST['nombre'];
    $tipo= $_POST['tipo'];
    $cant_balas= $_POST['cant_balas'];
    $dano= $_POST['dano'];
 
   

     $sql= $con -> prepare ("SELECT * FROM id_armas ");
     $sql -> execute();
     $fila = $sql -> fetchAll(PDO::FETCH_ASSOC);

    
        
        
   
   
     if ( $nombre=="" || $tipo=="" || $cant_balas=="" || $dano=="" )
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
         
      }
      
      else{

        
        $insertSQL = $con->prepare("INSERT INTO id_armas( nombre, tipo, cant_balas, dano) VALUES( '$nombre', '$tipo', '$cant_balas', '$dano')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
       
     }  
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="../../css/consulta.css">
   
    <title>armamento</title>
</head>
<body>
    
<form  method="POST" autocomplete="off" class="formulario" id="formulario">
<input type="submit" value="Regresar" name="regresar" id="regresar">
<?php 
if (isset($_POST['regresar'])){
    header('Location: ../formulario/formulario.php');

}
?>
             <h1>registro de armas</h1>
        <div class="conte" id="conte">
                    <h2>nombre del arma</h2>
             <input type="" class="inter" name="nombre" id="nombre" placeholder="ingrese nombre">
                        
                        <br>

                    <h2>tipo de arma</h2>
             <input type="text" class="inter" name="tipo" id="tipo" placeholder="tipo de arma">
             <br>

                    <h2>cantidad de balas </h2>
            <input type="number" class="inter" name="cant_balas" id="cant_balas" placeholder="cantidad de balas">
             <br>

             <h2>cantidad de daño</h2>
            <input type="number" class="inter" name="dano" id="dano" placeholder="daño">
             <br>

             

             <input class="b"     type="submit" name="validar" value="Registro">
            
             

                        </div>
         
              

                      
                      
    </form>

</body>
</html>