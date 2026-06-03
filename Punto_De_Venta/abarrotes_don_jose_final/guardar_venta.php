<?php
session_start();
include "config/conexion.php";
$data=json_decode(file_get_contents("php://input"),true);

if(!$data || count($data["productos"])==0){
    echo json_encode(["ok"=>false,"mensaje"=>"No hay productos"]);
    exit;
}

$id_usuario=$_SESSION["id_usuario"];
$id_cliente = $data["id_cliente"] == "" ? null : $data["id_cliente"];
$total=$data["total"];
$pago=$data["pago"];
$cambio=$data["cambio"];

$conn->begin_transaction();

try{
    $stmt=$conn->prepare("INSERT INTO ventas(fecha,total,pago,cambio,id_usuario,id_cliente) VALUES(NOW(),?,?,?,?,?)");
    $stmt->bind_param("dddii",$total,$pago,$cambio,$id_usuario,$id_cliente);
    $stmt->execute();
    $id_venta=$conn->insert_id;

    foreach($data["productos"] as $p){
        $id=$p["id_producto"];
        $cant=$p["cantidad"];
        $precio=$p["precio"];
        $sub=$precio*$cant;

        $stmt=$conn->prepare("INSERT INTO detalle_venta(id_venta,id_producto,cantidad,precio_unitario,subtotal) VALUES(?,?,?,?,?)");
        $stmt->bind_param("iiidd",$id_venta,$id,$cant,$precio,$sub);
        $stmt->execute();

        $stmt=$conn->prepare("UPDATE productos SET stock=stock-? WHERE id_producto=? AND stock>=?");
        $stmt->bind_param("iii",$cant,$id,$cant);
        $stmt->execute();

        if($stmt->affected_rows==0){
            throw new Exception("Stock insuficiente");
        }

        $desc = "Salida por venta ticket #" . $id_venta;
        $stmt=$conn->prepare("INSERT INTO movimientos_inventario(fecha,id_producto,tipo,cantidad,descripcion,id_usuario) VALUES(NOW(),?,'Salida',?,?,?)");
        $stmt->bind_param("iisi",$id,$cant,$desc,$id_usuario);
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(["ok"=>true,"id_venta"=>$id_venta]);
}catch(Exception $e){
    $conn->rollback();
    echo json_encode(["ok"=>false,"mensaje"=>$e->getMessage()]);
}
?>
