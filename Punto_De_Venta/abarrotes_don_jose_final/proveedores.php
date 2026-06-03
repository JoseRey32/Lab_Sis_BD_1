<?php
include "auth.php"; include "config/conexion.php"; $mensaje="";
if(isset($_POST["guardar"])){
    $id=$_POST["id_proveedor"]; $nombre=$_POST["nombre"]; $telefono=$_POST["telefono"]; $correo=$_POST["correo"]; $direccion=$_POST["direccion"];
    if($id==""){ $stmt=$conn->prepare("INSERT INTO proveedores(nombre,telefono,correo,direccion) VALUES(?,?,?,?)"); $stmt->bind_param("ssss",$nombre,$telefono,$correo,$direccion); }
    else{ $stmt=$conn->prepare("UPDATE proveedores SET nombre=?, telefono=?, correo=?, direccion=? WHERE id_proveedor=?"); $stmt->bind_param("ssssi",$nombre,$telefono,$correo,$direccion,$id); }
    $stmt->execute(); $mensaje="Proveedor guardado";
}
if(isset($_GET["eliminar"])){ $id=$_GET["eliminar"]; $conn->query("DELETE FROM proveedores WHERE id_proveedor=$id"); $mensaje="Proveedor eliminado"; }
$editar=null; if(isset($_GET["editar"])){ $id=$_GET["editar"]; $editar=$conn->query("SELECT * FROM proveedores WHERE id_proveedor=$id")->fetch_assoc(); }
$datos=$conn->query("SELECT * FROM proveedores ORDER BY nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Proveedores</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Proveedores</h1><p>Control de proveedores de Abarrotes Don José</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><form method="POST" class="form-grid">
<input type="hidden" name="id_proveedor" value="<?php echo $editar["id_proveedor"] ?? ""; ?>">
<input name="nombre" placeholder="Nombre" required value="<?php echo $editar["nombre"] ?? ""; ?>">
<input name="telefono" placeholder="Teléfono" value="<?php echo $editar["telefono"] ?? ""; ?>">
<input name="correo" placeholder="Correo" value="<?php echo $editar["correo"] ?? ""; ?>">
<input name="direccion" placeholder="Dirección" value="<?php echo $editar["direccion"] ?? ""; ?>">
<button name="guardar">Guardar</button><a class="btn-secundario" href="proveedores.php">Limpiar</a>
</form></section>
<section class="panel"><table><thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Dirección</th><th>Acciones</th></tr></thead><tbody><?php while($r=$datos->fetch_assoc()){ ?><tr><td><?php echo $r["nombre"]; ?></td><td><?php echo $r["telefono"]; ?></td><td><?php echo $r["correo"]; ?></td><td><?php echo $r["direccion"]; ?></td><td><a class="btn-editar" href="?editar=<?php echo $r["id_proveedor"]; ?>">Editar</a> <a class="btn-eliminar" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?php echo $r["id_proveedor"]; ?>">Eliminar</a></td></tr><?php } ?></tbody></table></section>
</main></body></html>
