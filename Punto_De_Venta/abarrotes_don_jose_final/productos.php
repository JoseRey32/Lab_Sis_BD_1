<?php
include "auth.php"; include "config/conexion.php"; $mensaje="";
if(isset($_POST["guardar"])){
    $id=$_POST["id_producto"]; $codigo=$_POST["codigo_barras"]; $nombre=$_POST["nombre"]; $cat=$_POST["id_categoria"]; $prov=$_POST["id_proveedor"]; $precio=$_POST["precio"]; $stock=$_POST["stock"]; $min=$_POST["stock_minimo"];
    if($id==""){
        $stmt=$conn->prepare("INSERT INTO productos(codigo_barras,nombre,id_categoria,id_proveedor,precio,stock,stock_minimo) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssiidii",$codigo,$nombre,$cat,$prov,$precio,$stock,$min); $stmt->execute(); $nuevo=$conn->insert_id;
        $stmt=$conn->prepare("INSERT INTO movimientos_inventario(fecha,id_producto,tipo,cantidad,descripcion,id_usuario) VALUES(NOW(),?,'Entrada',?,'Alta inicial de producto',?)");
        $stmt->bind_param("iii",$nuevo,$stock,$_SESSION["id_usuario"]); $stmt->execute();
    } else {
        $stmt=$conn->prepare("UPDATE productos SET codigo_barras=?,nombre=?,id_categoria=?,id_proveedor=?,precio=?,stock=?,stock_minimo=? WHERE id_producto=?");
        $stmt->bind_param("ssiidiii",$codigo,$nombre,$cat,$prov,$precio,$stock,$min,$id); $stmt->execute();
    }
    $mensaje="Producto guardado";
}
if(isset($_GET["eliminar"])){ $id=$_GET["eliminar"]; $conn->query("DELETE FROM productos WHERE id_producto=$id"); $mensaje="Producto eliminado"; }
$editar=null; if(isset($_GET["editar"])){ $id=$_GET["editar"]; $editar=$conn->query("SELECT * FROM productos WHERE id_producto=$id")->fetch_assoc(); }
$categorias=$conn->query("SELECT * FROM categorias ORDER BY nombre"); $proveedores=$conn->query("SELECT * FROM proveedores ORDER BY nombre");
$productos=$conn->query("SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor FROM productos p LEFT JOIN categorias c ON p.id_categoria=c.id_categoria LEFT JOIN proveedores pr ON p.id_proveedor=pr.id_proveedor ORDER BY p.nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Productos</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Productos</h1><p>Inventario de Abarrotes Don José</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><h2>Producto</h2><form method="POST" class="form-grid">
<input type="hidden" name="id_producto" value="<?php echo $editar["id_producto"] ?? ""; ?>">
<input name="codigo_barras" placeholder="Código de barras" required value="<?php echo $editar["codigo_barras"] ?? ""; ?>">
<input name="nombre" placeholder="Nombre" required value="<?php echo $editar["nombre"] ?? ""; ?>">
<select name="id_categoria" required><option value="">Categoría</option><?php while($c=$categorias->fetch_assoc()){ ?><option value="<?php echo $c["id_categoria"]; ?>" <?php if(($editar["id_categoria"]??"")==$c["id_categoria"]) echo "selected"; ?>><?php echo $c["nombre"]; ?></option><?php } ?></select>
<select name="id_proveedor" required><option value="">Proveedor</option><?php while($p=$proveedores->fetch_assoc()){ ?><option value="<?php echo $p["id_proveedor"]; ?>" <?php if(($editar["id_proveedor"]??"")==$p["id_proveedor"]) echo "selected"; ?>><?php echo $p["nombre"]; ?></option><?php } ?></select>
<input type="number" step="0.01" name="precio" placeholder="Precio venta" required value="<?php echo $editar["precio"] ?? ""; ?>">
<input type="number" name="stock" placeholder="Stock" required value="<?php echo $editar["stock"] ?? ""; ?>">
<input type="number" name="stock_minimo" placeholder="Stock mínimo" required value="<?php echo $editar["stock_minimo"] ?? "5"; ?>">
<button name="guardar">Guardar</button><a class="btn-secundario" href="productos.php">Limpiar</a>
</form></section>
<section class="panel"><h2>Lista de productos</h2><table><thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Proveedor</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr></thead><tbody><?php while($r=$productos->fetch_assoc()){ ?><tr><td><?php echo $r["codigo_barras"]; ?></td><td><?php echo $r["nombre"]; ?></td><td><?php echo $r["categoria"]; ?></td><td><?php echo $r["proveedor"]; ?></td><td>$<?php echo number_format($r["precio"],2); ?></td><td><span class="<?php echo $r["stock"] <= $r["stock_minimo"] ? "badge-rojo":"badge-verde"; ?>"><?php echo $r["stock"]; ?></span></td><td><a class="btn-editar" href="?editar=<?php echo $r["id_producto"]; ?>">Editar</a> <a class="btn-eliminar" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?php echo $r["id_producto"]; ?>">Eliminar</a></td></tr><?php } ?></tbody></table></section>
</main></body></html>
