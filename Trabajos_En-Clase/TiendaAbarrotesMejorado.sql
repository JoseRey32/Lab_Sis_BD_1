CREATE DATABASE IF NOT EXISTS abarrotes;
USE abarrotes;

-- AREA
CREATE TABLE Area (
    id_area INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

-- CATEGORIA
CREATE TABLE Categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    id_area INT NOT NULL,

    FOREIGN KEY (id_area)
    REFERENCES Area(id_area)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- CLIENTE
CREATE TABLE Cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    telefono VARCHAR(20),
    correo VARCHAR(100) UNIQUE,
    direccion VARCHAR(255),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- EMPLEADO
CREATE TABLE Empleado (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    puesto VARCHAR(100),
    telefono VARCHAR(20),
    salario DECIMAL(10,2),
    fecha_contratacion DATE
);

-- PROVEEDOR
CREATE TABLE Proveedor (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(150) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion VARCHAR(255)
);

-- PRODUCTO
CREATE TABLE Producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255),
    precio_compra DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT DEFAULT 10,
    codigo_barras VARCHAR(50) UNIQUE,
    fecha_caducidad DATE,
    id_categoria INT NOT NULL,

    FOREIGN KEY (id_categoria)
    REFERENCES Categoria(id_categoria)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- COMPRAS
CREATE TABLE Compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    cantidad INT NOT NULL,
    costo_unitario DECIMAL(10,2) NOT NULL,

    id_producto INT NOT NULL,
    id_proveedor INT NOT NULL,

    FOREIGN KEY (id_producto)
    REFERENCES Producto(id_producto)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,

    FOREIGN KEY (id_proveedor)
    REFERENCES Proveedor(id_proveedor)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

-- VENTAS
CREATE TABLE Ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    iva DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,

    id_producto INT NOT NULL,
    id_cliente INT NOT NULL,
    id_empleado INT NOT NULL,

    FOREIGN KEY (id_producto)
    REFERENCES Producto(id_producto)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,

    FOREIGN KEY (id_cliente)
    REFERENCES Cliente(id_cliente)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,

    FOREIGN KEY (id_empleado)
    REFERENCES Empleado(id_empleado)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);