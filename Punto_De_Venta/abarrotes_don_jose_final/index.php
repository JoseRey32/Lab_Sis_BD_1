<?php
include "auth.php";
include "config/conexion.php";

$ventas_hoy = $conn->query("SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE DATE(fecha)=CURDATE()")->fetch_assoc()["total"];
$ventas_mes = $conn->query("SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE MONTH(fecha)=MONTH(CURDATE()) AND YEAR(fecha)=YEAR(CURDATE())")->fetch_assoc()["total"];
$total_productos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()["total"];
$stock_bajo = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE stock <= stock_minimo")->fetch_assoc()["total"];
$clientes = $conn->query("SELECT COUNT(*) AS total FROM clientes")->fetch_assoc()["total"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Abarrotes Don José</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<?php include "menu.php"; ?>
<main class="main">
    <header class="topbar hero">
        <div>
            <h1>Abarrotes Don José</h1>
            <p>Panel principal del sistema de punto de venta</p>
        </div>
        <a class="btn-rojo" href="logout.php">Salir</a>
    </header>

    <section class="resumen">
        <div class="card azul"><span>💵</span><div><p>Ventas de hoy</p><h3>$<?php echo number_format($ventas_hoy,2); ?></h3></div></div>
        <div class="card verde"><span>📅</span><div><p>Ventas del mes</p><h3>$<?php echo number_format($ventas_mes,2); ?></h3></div></div>
        <div class="card morado"><span>📦</span><div><p>Productos</p><h3><?php echo $total_productos; ?></h3></div></div>
        <div class="card naranja"><span>⚠️</span><div><p>Stock bajo</p><h3><?php echo $stock_bajo; ?></h3></div></div>
        <div class="card rosa"><span>👥</span><div><p>Clientes</p><h3><?php echo $clientes; ?></h3></div></div>
    </section>

    <section class="panel">
        <h2>Accesos rápidos</h2>
        <div class="acciones">
            <a href="ventas.php">🧾 Nueva venta</a>
            <a href="productos.php">📦 Productos</a>
            <a href="clientes.php">👥 Clientes</a>
            <a href="compras.php">📥 Compras</a>
            <a href="reportes.php">📊 Reportes</a>
        </div>
    </section>

    <section class="panel">
        <h2>Gráfica de ventas del mes</h2>
        <canvas id="graficaVentas"></canvas>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/grafica.js"></script>
</body>
</html>
