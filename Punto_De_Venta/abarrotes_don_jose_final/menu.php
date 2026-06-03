<aside class="sidebar">
    <div class="logo">
        <div class="logo-icono">🛒</div>
        <div>
            <h2>Don José</h2>
            <span>Abarrotes POS</span>
        </div>
    </div>

    <nav>
        <a href="index.php">🏠 Inicio</a>
        <a href="ventas.php">🧾 Nueva venta</a>
        <a href="productos.php">📦 Productos</a>
        <a href="clientes.php">👥 Clientes</a>
        <a href="categorias.php">🏷️ Categorías</a>
        <a href="proveedores.php">🚚 Proveedores</a>
        <a href="compras.php">📥 Compras</a>
        <a href="movimientos.php">🔄 Movimientos</a>
        <a href="reportes.php">📊 Reportes</a>
        <?php if ($_SESSION["rol"] == "Administrador") { ?>
            <a href="usuarios.php">🔐 Usuarios</a>
        <?php } ?>
        <a href="logout.php">🚪 Salir</a>
    </nav>

    <div class="usuario">
        <div class="avatar"><?php echo strtoupper(substr($_SESSION["nombre"],0,1)); ?></div>
        <div>
            <strong><?php echo $_SESSION["nombre"]; ?></strong>
            <small><?php echo $_SESSION["rol"]; ?></small>
        </div>
    </div>
</aside>
