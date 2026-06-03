-- AREA
CREATE TABLE Area (
    id_area INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL
);

-- CATEGORIA
CREATE TABLE Categoria (
    id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    id_area INTEGER,
    FOREIGN KEY (id_area) REFERENCES Area(id_area)
);

-- CLIENTE
CREATE TABLE Cliente (
    id_cliente INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    direccion TEXT
);

-- EMPLEADO
CREATE TABLE Empleado (
    id_empleado INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    puesto TEXT,
    telefono TEXT
);

-- PROVEEDOR
CREATE TABLE Proveedor (
    id_proveedor INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    direccion TEXT
);

-- PRODUCTO
CREATE TABLE Producto (
    id_producto INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    precio REAL NOT NULL,
    stock INTEGER NOT NULL,
    id_categoria INTEGER,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria)
);

-- COMPRAS
CREATE TABLE Compras (
    id_compra INTEGER PRIMARY KEY AUTOINCREMENT,
    id_producto INTEGER,
    id_proveedor INTEGER,
    cantidad INTEGER NOT NULL,
    fecha TEXT DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor)
);

-- VENTAS
CREATE TABLE Ventas (
    id_venta INTEGER PRIMARY KEY AUTOINCREMENT,
    id_producto INTEGER,
    id_cliente INTEGER,
    id_empleado INTEGER,
    cantidad INTEGER NOT NULL,
    total REAL,
    fecha TEXT DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado)
);