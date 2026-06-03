PRAGMA foreign_keys = ON;

-- CATEGORIA
CREATE TABLE Categoria (
    id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL UNIQUE
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
    nombre TEXT NOT NULL UNIQUE,
    telefono TEXT,
    direccion TEXT
);

-- LIBRO
CREATE TABLE Libro (
    id_libro INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    isbn TEXT UNIQUE,
    anio_publicacion INTEGER CHECK (anio_publicacion > 0),
    paginas INTEGER CHECK (paginas > 0),
    stock INTEGER NOT NULL DEFAULT 0 CHECK (stock >= 0),
    id_categoria INTEGER NOT NULL,
    id_editorial INTEGER,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria),
    FOREIGN KEY (id_editorial) REFERENCES Editorial(id_editorial)
);

-- LIBRO_AUTOR
CREATE TABLE Libro_Autor (
    id_libro INTEGER NOT NULL,
    id_autor INTEGER NOT NULL,
    PRIMARY KEY (id_libro, id_autor),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_autor) REFERENCES Autor(id_autor)
);

-- USUARIO
CREATE TABLE Usuario (
    id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    telefono TEXT,
    correo TEXT UNIQUE,
    direccion TEXT,
    estado TEXT NOT NULL DEFAULT 'Activo'
        CHECK (estado IN ('Activo', 'Inactivo'))
);

-- EMPLEADO
CREATE TABLE Empleado (
    id_empleado INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    puesto TEXT NOT NULL,
    telefono TEXT,
    estado TEXT NOT NULL DEFAULT 'Activo'
        CHECK (estado IN ('Activo', 'Inactivo'))
);

-- PRESTAMO
CREATE TABLE Prestamo (
    id_prestamo INTEGER PRIMARY KEY AUTOINCREMENT,
    id_libro INTEGER NOT NULL,
    id_usuario INTEGER NOT NULL,
    id_empleado INTEGER NOT NULL,
    fecha_prestamo TEXT NOT NULL DEFAULT CURRENT_DATE,
    fecha_limite TEXT NOT NULL,
    fecha_devolucion TEXT,
    estado TEXT NOT NULL DEFAULT 'Prestado'
        CHECK (estado IN ('Prestado', 'Devuelto', 'Atrasado')),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado)
);

-- DEVOLUCION
CREATE TABLE Devolucion (
    id_devolucion INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prestamo INTEGER NOT NULL UNIQUE,
    fecha_entrega TEXT NOT NULL DEFAULT CURRENT_DATE,
    observaciones TEXT,
    FOREIGN KEY (id_prestamo) REFERENCES Prestamo(id_prestamo)
);

-- MULTA
CREATE TABLE Multa (
    id_multa INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prestamo INTEGER NOT NULL,
    monto REAL NOT NULL CHECK (monto >= 0),
    motivo TEXT,
    estado TEXT NOT NULL DEFAULT 'Pendiente'
        CHECK (estado IN ('Pendiente', 'Pagada', 'Cancelada')),
    FOREIGN KEY (id_prestamo) REFERENCES Prestamo(id_prestamo)
);

-- RESERVA
CREATE TABLE Reserva (
    id_reserva INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER NOT NULL,
    id_libro INTEGER NOT NULL,
    fecha_reserva TEXT NOT NULL DEFAULT CURRENT_DATE,
    estado TEXT NOT NULL DEFAULT 'Activa'
        CHECK (estado IN ('Activa', 'Cancelada', 'Atendida')),
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
    id_libro INTEGER NOT NULL,
    id_proveedor INTEGER NOT NULL,
    cantidad INTEGER NOT NULL CHECK (cantidad > 0),
    costo_unitario REAL NOT NULL CHECK (costo_unitario >= 0),
    fecha TEXT NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor)
);

-- ESTANTERIA
CREATE TABLE Estanteria (
    id_estanteria INTEGER PRIMARY KEY AUTOINCREMENT,
    seccion TEXT NOT NULL,
    pasillo TEXT NOT NULL
);

-- UBICACION_LIBRO
CREATE TABLE Ubicacion_Libro (
    id_ubicacion INTEGER PRIMARY KEY AUTOINCREMENT,
    id_libro INTEGER NOT NULL UNIQUE,
    id_estanteria INTEGER NOT NULL,
    nivel TEXT,
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro),
    FOREIGN KEY (id_estanteria) REFERENCES Estanteria(id_estanteria)
);

-- HISTORIAL_PRESTAMO
CREATE TABLE Historial_Prestamo (
    id_historial INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER NOT NULL,
    id_libro INTEGER NOT NULL,
    fecha TEXT NOT NULL DEFAULT CURRENT_DATE,
    accion TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro)
);