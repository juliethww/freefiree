<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "free";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO en excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Establecer el conjunto de caracteres a UTF-8
    $conexion->exec("SET CHARACTER SET utf8");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se enviaron ambos campos: correo y contraseña
        if (isset($_POST["username"]) && isset($_POST["contrasena"])) {
            try {
                // Escapar los valores para evitar inyección SQL
                $ID = $_POST["username"];
                $password = $_POST["contrasena"];

                // Consulta SQL para obtener el tipo de usuario
                $sql = "SELECT username, contrasena, id_tip_user FROM usuarios WHERE username = :username";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(":username", $ID);
                
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // Obtener los datos del usuario
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stored_username = $row["username"];
                    $stored_password = $row["contrasena"];
                    $ID_Roll = $row["id_tip_user"];

                    // Verificar la contraseña
                    if (password_verify($password, $stored_password)) {
                        // La contraseña es correcta
                        // Iniciar sesión y redireccionar según el tipo de usuario
                        session_start();
                        $_SESSION["username"] = $stored_username;
                        $_SESSION["id_tip_user"] = $ID_Roll;

                        switch ($ID_Roll) {
                            case 1:
                                header("Location: ../admin/admin.php");
                                exit();
                            case 2:
                                header("Location: ../jugador/jugador.php");
                                exit();
                            case 3:
                                header("Location: index3.php");
                                exit();
                            default:
                                // Manejar el caso en que el tipo de usuario no está definido
                                echo '<script>alert("Username incorrecto.");</script>';
                                header("Location: ../index.php");
                                exit();
                        }
                    } else {
                        // Contraseña incorrecta
                        echo '<script>alert("Contraseña incorrectos.");</script>';
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    // Usuario no encontrado
                    echo '<script>alert("Username o contraseña no encontrados.");</script>';
                    header("Location: ../index.php");
                    exit();
                }
            } catch (PDOException $e) {
                // Manejar cualquier error de base de datos
                echo "Error: " . $e->getMessage();
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Manejar el caso en que no se enviaron ambos campos
            echo '<script>alert("No se puede iniciar sesión sin enviar datos.");</script>';
            header("Location: ../index.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    header("Location: index.php");
    exit();
}
?>
