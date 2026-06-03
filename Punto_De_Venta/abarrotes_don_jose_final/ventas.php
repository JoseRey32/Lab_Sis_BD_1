<?php
include "auth.php"; include "config/conexion.php";
$productos=$conn->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.id_categoria=c.id_categoria WHERE p.stock > 0 ORDER BY p.nombre");
$clientes=$conn->query("SELECT * FROM clientes ORDER BY nombre");
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Ventas</title><link rel="stylesheet" href="assets/css/estilos.css"></head><body><?php include "menu.php"; ?>
<main class="main"><header class="topbar"><div><h1>Nueva venta</h1><p>Escanea con celular, busca productos y cobra al cliente</p></div></header>
<section class="venta-layout"><div>
<section class="panel"><h2>Buscar producto</h2>
<div class="busqueda"><input id="codigo" placeholder="Código de barras o nombre"><button onclick="buscarProducto()">Agregar</button><button class="btn-verde" onclick="abrirEscanerZXing()">📷 Escanear celular</button></div>
<div id="scanner" class="scanner oculto">
    <video id="video" autoplay muted playsinline></video>
    <p id="estadoScanner">Apunta la cámara al código de barras</p>
    <button onclick="cerrarEscanerZXing()">Cerrar cámara</button>
</div>
</section>
<section class="panel"><h2>Productos disponibles</h2><div class="grid-productos"><?php while($p=$productos->fetch_assoc()){ ?><div class="producto-card"><div class="producto-img">📦</div><h3><?php echo $p["nombre"]; ?></h3><small><?php echo $p["codigo_barras"]; ?> | <?php echo $p["categoria"]; ?></small><div class="producto-info"><strong>$<?php echo number_format($p["precio"],2); ?></strong><span>Stock: <?php echo $p["stock"]; ?></span></div><button onclick='agregarProducto(<?php echo json_encode($p); ?>)'>Agregar</button></div><?php } ?></div></section>
</div>
<aside class="panel ticket"><h2>🧾 Ticket</h2>
<label>Cliente frecuente</label><select id="id_cliente"><option value="">Público general</option><?php while($c=$clientes->fetch_assoc()){ ?><option value="<?php echo $c["id_cliente"]; ?>"><?php echo $c["nombre"]; ?></option><?php } ?></select>
<div id="carrito"></div><label>Pago del cliente</label><input type="number" id="pago" step="0.01" oninput="calcularCambio()"><div class="totales"><p>Subtotal: <strong id="subtotal">$0.00</strong></p><p>Total: <strong id="total">$0.00</strong></p><p>Cambio: <strong id="cambio">$0.00</strong></p></div><button class="btn-finalizar" onclick="finalizarVenta()">Finalizar venta</button><button class="btn-secundario" onclick="limpiarCarrito()">Cancelar</button></aside>
</section></main>
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script src="assets/js/ventas.js"></script>
</body></html>
