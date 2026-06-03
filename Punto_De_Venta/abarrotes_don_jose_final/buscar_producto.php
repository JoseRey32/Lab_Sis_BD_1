<?php
include "config/conexion.php";
$codigo=$_GET["codigo"] ?? "";
$like="%".$codigo."%";
$stmt=$conn->prepare("SELECT * FROM productos WHERE stock > 0 AND (codigo_barras=? OR nombre LIKE ?) LIMIT 1");
$stmt->bind_param("ss",$codigo,$like);
$stmt->execute();
$res=$stmt->get_result();
echo json_encode($res->num_rows?$res->fetch_assoc():null);
?>
