<?php
include "auth.php"; include "config/conexion.php";
if($_SESSION["rol"]!="Administrador"){ die("Acceso solo para administrador"); }
$mensaje="";
if(isset($_POST["guardar"])){
    $id=$_POST["id_usuario"]; $nombre=$_POST["nombre"]; $usuario=$_POST["usuario"]; $password=$_POST["password"]; $rol=$_POST["rol"]; $activo=isset($_POST["activo"])?1:0;
    if($id==""){ $stmt=$conn->prepare("INSERT INTO usuarios(nombre,usuario,password,rol,activo) VALUES(?,?,?,?,?)"); $stmt->bind_param("ssssi",$nombre,$usuario,$password,$rol,$activo); }
    else{ $stmt=$conn->prepare("UPDATE usuarios SET nombre=?, usuario=?, password=?, rol=?, activo=? WHERE id_usuario=?"); $stmt->bind_param("ssssii",$nombre,$usuario,$password,$rol,$activo,$id); }
    $stmt->execute(); $mensaje="Usuario guardado";
}
$editar=null; if(isset($_GET["editar"])){ $id=$_GET["editar"]; $editar=$conn->query("SELECT * FROM usuarios WHERE id_usuario=$id")->fetch_assoc(); }
$datos=$conn->query("SELECT * FROM usuarios ORDER BY nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Usuarios</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?><main class="main"><header class="topbar"><div><h1>Usuarios</h1><p>Administradores y cajeros</p></div></header>
<?php if($mensaje!=""){ ?><div class="mensaje"><?php echo $mensaje; ?></div><?php } ?>
<section class="panel"><form method="POST" class="form-grid">
<input type="hidden" name="id_usuario" value="<?php echo $editar["id_usuario"] ?? ""; ?>">
<input name="nombre" placeholder="Nombre" required value="<?php echo $editar["nombre"] ?? ""; ?>">
<input name="usuario" placeholder="Usuario" required value="<?php echo $editar["usuario"] ?? ""; ?>">
<input name="password" placeholder="Contraseña" required value="<?php echo $editar["password"] ?? ""; ?>">
<select name="rol"><option <?php if(($editar["rol"]??"")=="Administrador") echo "selected"; ?>>Administrador</option><option <?php if(($editar["rol"]??"")=="Cajero") echo "selected"; ?>>Cajero</option></select>
<label><input type="checkbox" name="activo" <?php if(!isset($editar["activo"]) || $editar["activo"]==1) echo "checked"; ?>> Activo</label>
<button name="guardar">Guardar</button><a class="btn-secundario" href="usuarios.php">Limpiar</a>
</form></section>
<section class="panel"><table><thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Activo</th><th>Acciones</th></tr></thead><tbody><?php while($r=$datos->fetch_assoc()){ ?><tr><td><?php echo $r["nombre"]; ?></td><td><?php echo $r["usuario"]; ?></td><td><?php echo $r["rol"]; ?></td><td><?php echo $r["activo"]?"Sí":"No"; ?></td><td><a class="btn-editar" href="?editar=<?php echo $r["id_usuario"]; ?>">Editar</a></td></tr><?php } ?></tbody></table></section>
</main></body></html>
