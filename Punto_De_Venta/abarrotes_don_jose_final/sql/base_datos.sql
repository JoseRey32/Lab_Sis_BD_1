CREATE DATABASE IF NOT EXISTS abarrotes_don_jose;
USE abarrotes_don_jose;

DROP TABLE IF EXISTS detalle_venta;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS compras;
DROP TABLE IF EXISTS movimientos_inventario;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS proveedores;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    rol ENUM('Administrador','Cajero') NOT NULL,
    activo TINYINT NOT NULL DEFAULT 1
);

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    descripcion VARCHAR(255)
);

CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion VARCHAR(200)
);

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    id_categoria INT NOT NULL,
    id_proveedor INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    stock_minimo INT NOT NULL DEFAULT 5,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);

CREATE TABLE movimientos_inventario (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    id_producto INT NOT NULL,
    tipo ENUM('Entrada','Salida') NOT NULL,
    cantidad INT NOT NULL,
    descripcion VARCHAR(255),
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    id_producto INT NOT NULL,
    id_proveedor INT NOT NULL,
    cantidad INT NOT NULL,
    costo_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);

CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    pago DECIMAL(10,2) NOT NULL,
    cambio DECIMAL(10,2) NOT NULL,
    id_usuario INT NOT NULL,
    id_cliente INT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

CREATE TABLE detalle_venta (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

INSERT INTO usuarios(nombre, usuario, password, rol, activo) VALUES
('Administrador General','admin','admin123','Administrador',1),
('Cajero Principal','cajero','12345','Cajero',1);

INSERT INTO categorias(nombre, descripcion) VALUES
('Bebidas','Refrescos, jugos y agua'),
('Botanas','Papas, frituras y snacks'),
('Galletas','Galletas dulces y saladas'),
('Lácteos','Leche, yogurt y derivados'),
('Abarrotes','Productos básicos'),
('Limpieza','Productos de limpieza');

INSERT INTO proveedores(nombre, telefono, correo, direccion) VALUES
('Distribuidora Fresnillo','4931002000','ventas@disfres.com','Centro, Fresnillo'),
('Abarrotera del Norte','4931203030','contacto@norte.com','Col. Industrial'),
('Lácteos Zacatecas','4925551000','pedidos@lacteoszac.com','Zacatecas'),
('Proveedor LimpioMax','4931010101','ventas@limpiomax.com','Guadalupe');

INSERT INTO clientes(nombre, telefono, correo) VALUES
('Público frecuente','4930000000','cliente@correo.com'),
('María López','4931112233','maria@correo.com'),
('Juan Hernández','4932223344','juan@correo.com');

INSERT INTO productos(codigo_barras,nombre,id_categoria,id_proveedor,precio,stock,stock_minimo) VALUES
('7501055300016','Coca Cola 600ml',1,1,18.00,30,5),
('7501000111111','Sabritas Original',2,2,20.00,25,5),
('7502000222222','Galletas Marías',3,2,16.00,40,5),
('7503000333333','Leche Lala 1L',4,3,28.00,15,5),
('7504000444444','Pan Blanco Bimbo',5,1,45.00,10,5),
('7505000555555','Huevo 12 piezas',5,1,42.00,12,5),
('7506000666666','Arroz 1kg',5,2,26.00,20,5),
('7507000777777','Frijol 1kg',5,2,35.00,18,5),
('7508000888888','Azúcar 1kg',5,2,29.00,22,5),
('7509000999999','Aceite 1L',5,1,48.00,14,5),
('7501111222233','Cloro 1L',6,4,19.00,8,5),
('7502222333344','Jabón en polvo 500g',6,4,24.00,7,5);
