<?php
session_start();
include "config/conexion.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND activo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $user = $resultado->fetch_assoc();

        if ($password == $user["password"]) {
            $_SESSION["id_usuario"] = $user["id_usuario"];
            $_SESSION["nombre"] = $user["nombre"];
            $_SESSION["rol"] = $user["rol"];
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado o inactivo";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Abarrotes Don José</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-logo">🛒</div>
        <h1>Abarrotes Don José</h1>
        <p>Sistema web de punto de venta</p>

        <?php if ($error != "") { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar sesión</button>
        </form>

        <small>Administrador: admin / admin123<br>Cajero: cajero / 12345</small>
    </div>
</body>
</html>
