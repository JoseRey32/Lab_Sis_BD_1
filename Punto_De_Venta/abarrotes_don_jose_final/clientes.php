<?php
include "auth.php"; include "config/conexion.php"; $mensaje="";
if(isset($_POST["guardar"])){
    $id=$_POST["id_cliente"]; $nombre=$_POST["nombre"]; $telefono=$_POST["telefono"]; $correo=$_POST["correo"];
    if($id==""){ $stmt=$conn->prepare("INSERT INTO clientes(nombre,telefono,correo) VALUES(?,?,?)"); $stmt->bind_param("sss",$nombre,$telefono,$correo); }
    else{ $stmt=$conn->prepare("UPDATE clientes SET nombre=?, telefono=?, correo=? WHERE id_cliente=?"); $stmt->bind_param("sssi",$nombre,$telefono,$correo,$id); }
    $stmt->execute(); $mensaje="Cliente guardado";
}
if(isset($_GET["eliminar"])){ $id=$_GET["eliminar"]; $conn->query("DELETE FROM clientes WHERE id_cliente=$id"); $mensaje="Cliente eliminado"; }
$editar=null; if(isset($_GET["editar"])){ $id=$_GET["editar"]; $editar=$conn->query("SELECT * FROM clientes WHERE id_cliente=$id")->fetch_assoc(); }
$datos=$conn->query("SELECT c.*, IFNULL(SUM(v.total),0) AS total_compras FROM clientes c LEFT JOIN ventas v ON c.id_cliente=v.id_cliente GROUP BY c.id_cliente ORDER BY c.nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Clientes</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Clientes frecuentes</h1><p>Registro e historial de compras</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><form method="POST" class="form-grid">
<input type="hidden" name="id_cliente" value="<?php echo $editar["id_cliente"] ?? ""; ?>">
<input name="nombre" placeholder="Nombre del cliente" required value="<?php echo $editar["nombre"] ?? ""; ?>">
<input name="telefono" placeholder="Teléfono" value="<?php echo $editar["telefono"] ?? ""; ?>">
<input name="correo" placeholder="Correo" value="<?php echo $editar["correo"] ?? ""; ?>">
<button name="guardar">Guardar</button><a class="btn-secundario" href="clientes.php">Limpiar</a>
</form></section>
<section class="panel"><table><thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Total comprado</th><th>Acciones</th></tr></thead><tbody><?php while($r=$datos->fetch_assoc()){ ?><tr><td><?php echo $r["nombre"]; ?></td><td><?php echo $r["telefono"]; ?></td><td><?php echo $r["correo"]; ?></td><td>$<?php echo number_format($r["total_compras"],2); ?></td><td><a class="btn-editar" href="?editar=<?php echo $r["id_cliente"]; ?>">Editar</a> <a class="btn-eliminar" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?php echo $r["id_cliente"]; ?>">Eliminar</a></td></tr><?php } ?></tbody></table></section>
</main></body></html>
