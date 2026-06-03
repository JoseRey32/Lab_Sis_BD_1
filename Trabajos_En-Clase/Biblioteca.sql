-- CATEGORIA
CREATE TABLE Categoria (
    id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL
);

-- AUTOR
CREATE TABLE Autor (
    id_autor INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    nacionalidad TEXT,
    fecha_nacimiento TEXT
);

-- EDITORIAL
CREATE TABLE Editorial (
    id_editorial INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    direccion TEXT
);

-- LIBRO
CREATE TABLE Libro (
    id_libro INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    isbn TEXT,
    anio_publicacion INTEGER,
    paginas INTEGER,
    stock INTEGER NOT NULL,
    id_autor INTEGER,
    id_categoria INTEGER,
    id_editorial INTEGER,
    FOREIGN KEY (id_autor) REFERENCES Autor(id_autor),
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria),
    FOREIGN KEY (id_editorial) REFERENCES Editorial(id_editorial)
);

-- USUARIO
CREATE TABLE Usuario (
    id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    correo TEXT,
    direccion TEXT
);

-- EMPLEADO
CREATE TABLE Empleado (
    id_empleado INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    puesto TEXT,
    telefono TEXT
);

-- PRESTAMO
CREATE TABLE Prestamo (
    id_prestamo INTEGER PRIMARY KEY AUTOINCREMENT,
    id_libro INTEGER,
    id_usuario INTEGER,
    id_empleado INTEGER,
    fecha_prestamo TEXT DEFAULT CURRENT_DATE,
    fecha_devolucion TEXT,
    estado TEXT DEFAULT 'Prestado',
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado)
);

-- DEVOLUCION
CREATE TABLE Devolucion (
    id_devolucion INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prestamo INTEGER,
    fecha_entrega TEXT DEFAULT CURRENT_DATE,
    observaciones TEXT,
    FOREIGN KEY (id_prestamo) REFERENCES Prestamo(id_prestamo)
);

-- MULTA
CREATE TABLE Multa (
    id_multa INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prestamo INTEGER,
    monto REAL NOT NULL,
    estado TEXT DEFAULT 'Pendiente',
    FOREIGN KEY (id_prestamo) REFERENCES Prestamo(id_prestamo)
);

-- RESERVA
CREATE TABLE Reserva (
    id_reserva INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER,
    id_libro INTEGER,
    fecha_reserva TEXT DEFAULT CURRENT_DATE,
    estado TEXT DEFAULT 'Activa',
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro)
);

-- PROVEEDOR
CREATE TABLE Proveedor (
    id_proveedor INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    direccion TEXT
);

-- COMPRA_LIBRO
CREATE TABLE Compra_Libro (
    id_compra INTEGER PRIMARY KEY AUTOINCREMENT,
    id_libro INTEGER,
    id_proveedor INTEGER,
    cantidad INTEGER NOT NULL,
    fecha TEXT DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor)
);

-- ESTANTERIA
CREATE TABLE Estanteria (
    id_estanteria INTEGER PRIMARY KEY AUTOINCREMENT,
    seccion TEXT NOT NULL,
    pasillo TEXT
);

-- UBICACION_LIBRO
CREATE TABLE Ubicacion_Libro (
    id_ubicacion INTEGER PRIMARY KEY AUTOINCREMENT,
    id_libro INTEGER,
    id_estanteria INTEGER,
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_estanteria) REFERENCES Estanteria(id_estanteria)
);

-- HISTORIAL_PRESTAMO
CREATE TABLE Historial_Prestamo (
    id_historial INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER,
    id_libro INTEGER,
    fecha TEXT DEFAULT CURRENT_DATE,
    accion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro)
);
