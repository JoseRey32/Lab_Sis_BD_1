<?php
include "config/conexion.php";
$data = [];
$sql = "SELECT DAY(fecha) AS dia, SUM(total) AS total
        FROM ventas
        WHERE MONTH(fecha)=MONTH(CURDATE()) AND YEAR(fecha)=YEAR(CURDATE())
        GROUP BY DAY(fecha)
        ORDER BY dia";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
?>
