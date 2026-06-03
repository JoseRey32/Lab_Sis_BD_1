<?php
include "config/conexion.php";

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=ventas_abarrotes_don_jose.csv");

$salida = fopen("php://output", "w");
fputcsv($salida, ["Ticket","Fecha","Total","Pago","Cambio","Cajero","Cliente"]);

$sql = "SELECT v.*, u.nombre AS cajero, c.nombre AS cliente
        FROM ventas v
        INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        ORDER BY v.fecha DESC";
$res = $conn->query($sql);

while($v = $res->fetch_assoc()){
    fputcsv($salida, [
        $v["id_venta"],
        $v["fecha"],
        $v["total"],
        $v["pago"],
        $v["cambio"],
        $v["cajero"],
        $v["cliente"] ?? "Público general"
    ]);
}

fclose($salida);
?>
