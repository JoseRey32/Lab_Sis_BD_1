<?php
include "auth.php"; include "config/conexion.php";
$id=$_GET["id"];
$venta=$conn->query("SELECT v.*,u.nombre AS cajero,c.nombre AS cliente FROM ventas v INNER JOIN usuarios u ON v.id_usuario=u.id_usuario LEFT JOIN clientes c ON v.id_cliente=c.id_cliente WHERE id_venta=$id")->fetch_assoc();
$det=$conn->query("SELECT d.*,p.nombre FROM detalle_venta d INNER JOIN productos p ON d.id_producto=p.id_producto WHERE id_venta=$id");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Ticket</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body class="ticket-body">
<div class="ticket-print"><h2>Abarrotes Don José</h2><p>Ticket #<?php echo $venta["id_venta"]; ?></p><p>Fecha: <?php echo $venta["fecha"]; ?></p><p>Cajero: <?php echo $venta["cajero"]; ?></p><p>Cliente: <?php echo $venta["cliente"] ?? "Público general"; ?></p><hr><table><tr><th>Producto</th><th>Cant.</th><th>Sub.</th></tr><?php while($d=$det->fetch_assoc()){ ?><tr><td><?php echo $d["nombre"]; ?></td><td><?php echo $d["cantidad"]; ?></td><td>$<?php echo number_format($d["subtotal"],2); ?></td></tr><?php } ?></table><hr><h3>Total: $<?php echo number_format($venta["total"],2); ?></h3><p>Pago: $<?php echo number_format($venta["pago"],2); ?></p><p>Cambio: $<?php echo number_format($venta["cambio"],2); ?></p><p class="centro">Gracias por comprar en Abarrotes Don José</p><button onclick="window.print()">Imprimir / Guardar PDF</button> <a href="ventas.php">Nueva venta</a></div>
</body></html>
