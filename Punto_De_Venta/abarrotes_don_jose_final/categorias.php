<?php
include "auth.php"; include "config/conexion.php"; $mensaje="";
if(isset($_POST["guardar"])){
    $id=$_POST["id_categoria"]; $nombre=$_POST["nombre"]; $descripcion=$_POST["descripcion"];
    if($id==""){ $stmt=$conn->prepare("INSERT INTO categorias(nombre,descripcion) VALUES(?,?)"); $stmt->bind_param("ss",$nombre,$descripcion); }
    else{ $stmt=$conn->prepare("UPDATE categorias SET nombre=?, descripcion=? WHERE id_categoria=?"); $stmt->bind_param("ssi",$nombre,$descripcion,$id); }
    $stmt->execute(); $mensaje="Categoría guardada";
}
if(isset($_GET["eliminar"])){ $id=$_GET["eliminar"]; $conn->query("DELETE FROM categorias WHERE id_categoria=$id"); $mensaje="Categoría eliminada"; }
$editar=null; if(isset($_GET["editar"])){ $id=$_GET["editar"]; $editar=$conn->query("SELECT * FROM categorias WHERE id_categoria=$id")->fetch_assoc(); }
$datos=$conn->query("SELECT * FROM categorias ORDER BY nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Categorías</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main">
<header class="topbar"><div><h1>Categorías</h1><p>Clasificación de productos</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><form method="POST" class="form-grid">
<input type="hidden" name="id_categoria" value="<?php echo $editar["id_categoria"] ?? ""; ?>">
<input name="nombre" placeholder="Nombre" required value="<?php echo $editar["nombre"] ?? ""; ?>">
<input name="descripcion" placeholder="Descripción" value="<?php echo $editar["descripcion"] ?? ""; ?>">
<button name="guardar">Guardar</button><a class="btn-secundario" href="categorias.php">Limpiar</a>
</form></section>
<section class="panel"><table><thead><tr><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr></thead><tbody><?php while($r=$datos->fetch_assoc()){ ?><tr><td><?php echo $r["nombre"]; ?></td><td><?php echo $r["descripcion"]; ?></td><td><a class="btn-editar" href="?editar=<?php echo $r["id_categoria"]; ?>">Editar</a> <a class="btn-eliminar" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?php echo $r["id_categoria"]; ?>">Eliminar</a></td></tr><?php } ?></tbody></table></section>
</main></body></html>
