<?php
include "auth.php"; include "config/conexion.php"; $mensaje="";
if(isset($_POST["guardar"])){
    $id_producto=$_POST["id_producto"]; $id_proveedor=$_POST["id_proveedor"]; $cantidad=$_POST["cantidad"]; $costo=$_POST["costo_unitario"]; $total=$cantidad*$costo;
    $stmt=$conn->prepare("INSERT INTO compras(fecha,id_producto,id_proveedor,cantidad,costo_unitario,total) VALUES(NOW(),?,?,?,?,?)");
    $stmt->bind_param("iiidd",$id_producto,$id_proveedor,$cantidad,$costo,$total); $stmt->execute();
    $stmt=$conn->prepare("UPDATE productos SET stock=stock+? WHERE id_producto=?"); $stmt->bind_param("ii",$cantidad,$id_producto); $stmt->execute();
    $desc = "Entrada por compra a proveedor";
    $stmt=$conn->prepare("INSERT INTO movimientos_inventario(fecha,id_producto,tipo,cantidad,descripcion,id_usuario) VALUES(NOW(),?,'Entrada',?,?,?)");
    $stmt->bind_param("iisi",$id_producto,$cantidad,$desc,$_SESSION["id_usuario"]); $stmt->execute();
    $mensaje="Compra registrada y stock actualizado";
}
$productos=$conn->query("SELECT * FROM productos ORDER BY nombre"); $proveedores=$conn->query("SELECT * FROM proveedores ORDER BY nombre");
$compras=$conn->query("SELECT c.*,p.nombre AS producto,pr.nombre AS proveedor FROM compras c INNER JOIN productos p ON c.id_producto=p.id_producto INNER JOIN proveedores pr ON c.id_proveedor=pr.id_proveedor ORDER BY c.fecha DESC");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Compras</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Compras a proveedores</h1><p>Entradas de inventario</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><form method="POST" class="form-grid"><select name="id_producto" required><option value="">Producto</option><?php while($p=$productos->fetch_assoc()){ ?><option value="<?php echo $p["id_producto"]; ?>"><?php echo $p["nombre"]; ?></option><?php } ?></select><select name="id_proveedor" required><option value="">Proveedor</option><?php while($pr=$proveedores->fetch_assoc()){ ?><option value="<?php echo $pr["id_proveedor"]; ?>"><?php echo $pr["nombre"]; ?></option><?php } ?></select><input type="number" name="cantidad" placeholder="Cantidad" required><input type="number" step="0.01" name="costo_unitario" placeholder="Costo unitario" required><button name="guardar">Registrar compra</button></form></section>
<section class="panel"><table><thead><tr><th>Fecha</th><th>Producto</th><th>Proveedor</th><th>Cantidad</th><th>Costo</th><th>Total</th></tr></thead><tbody><?php while($c=$compras->fetch_assoc()){ ?><tr><td><?php echo $c["fecha"]; ?></td><td><?php echo $c["producto"]; ?></td><td><?php echo $c["proveedor"]; ?></td><td><?php echo $c["cantidad"]; ?></td><td>$<?php echo number_format($c["costo_unitario"],2); ?></td><td>$<?php echo number_format($c["total"],2); ?></td></tr><?php } ?></tbody></table></section>
</main></body></html>
