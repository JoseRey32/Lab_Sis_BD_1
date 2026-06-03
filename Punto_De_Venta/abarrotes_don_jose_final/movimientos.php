<?php
include "auth.php"; include "config/conexion.php";
$mov=$conn->query("SELECT m.*,p.nombre AS producto,u.nombre AS usuario FROM movimientos_inventario m INNER JOIN productos p ON m.id_producto=p.id_producto INNER JOIN usuarios u ON m.id_usuario=u.id_usuario ORDER BY m.fecha DESC");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Movimientos</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Movimientos de inventario</h1><p>Entradas y salidas registradas automáticamente</p></div></header>
<section class="panel"><table><thead><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Descripción</th><th>Usuario</th></tr></thead><tbody><?php while($m=$mov->fetch_assoc()){ ?><tr><td><?php echo $m["fecha"]; ?></td><td><?php echo $m["producto"]; ?></td><td><span class="<?php echo $m["tipo"]=="Entrada"?"badge-verde":"badge-rojo"; ?>"><?php echo $m["tipo"]; ?></span></td><td><?php echo $m["cantidad"]; ?></td><td><?php echo $m["descripcion"]; ?></td><td><?php echo $m["usuario"]; ?></td></tr><?php } ?></tbody></table></section>
</main></body></html>
