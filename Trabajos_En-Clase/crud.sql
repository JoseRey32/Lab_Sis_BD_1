-- Tabla Profesores
CREATE TABLE profesores (
    id_profesor INT PRIMARY KEY,
    nombre VARCHAR(255),
    apellido_paterno VARCHAR(255),
    apellido_materno VARCHAR(255)
);

-- Tabla Estudiantes
CREATE TABLE estudiantes (
    id_estudiante INT PRIMARY KEY,
    nombre VARCHAR(255),
    apellido_paterno VARCHAR(255),
    apellido_materno VARCHAR(255),
    grado INT,
    grupo VARCHAR(255)
);

-- Tabla Cursos
CREATE TABLE cursos (
    id_curso INT PRIMARY KEY,
    nombre VARCHAR(255),
    profesor_id INT,
    FOREIGN KEY (profesor_id) REFERENCES profesores(id_profesor)
);

-- Tabla Tutores
CREATE TABLE tutores (
    id_tutor INT PRIMARY KEY,
    nombre VARCHAR(255),
    apellido_paterno VARCHAR(255),
    apellido_materno VARCHAR(255),
    telefono VARCHAR(255),
    email VARCHAR(255),
    parentesco VARCHAR(255),
    estudiante_id INT,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id_estudiante)
);

-- Tabla Calificaciones
CREATE TABLE calificaciones (
    id_calificacion INT PRIMARY KEY,
    estudiante_id INT,
    curso_id INT,
    calificacion DECIMAL(10,2),
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (curso_id) REFERENCES cursos(id_curso)
);

-- INSERTS PROFESORES
INSERT INTO profesores (id_profesor, nombre, apellido_paterno, apellido_materno) VALUES
(1, 'Ricardo', 'Mendoza', 'Navarro'),
(2, 'Patricia', 'Delgado', 'Reyes'),
(3, 'Hugo', 'Cervantes', 'Pineda'),
(4, 'Daniela', 'Campos', 'Ortega'),
(5, 'Fernando', 'León', 'Castillo'),
(6, 'Gabriela', 'Serrano', 'Fuentes');

-- INSERTS ESTUDIANTES
INSERT INTO estudiantes (id_estudiante, nombre, apellido_paterno, apellido_materno, grado, grupo) VALUES
(1, 'Kevin', 'Moreno', 'Ibarra', 1, 'B'),
(2, 'Natalia', 'Esquivel', 'Ruiz', 1, 'B'),
(3, 'Andrés', 'Peña', 'Carrillo', 2, 'A'),
(4, 'Lucía', 'Acosta', 'Valdez', 2, 'A'),
(5, 'Emiliano', 'Guerrero', 'Núñez', 3, 'D'),
(6, 'Fernanda', 'Cabrera', 'Mejía', 3, 'D');

-- INSERTS CURSOS
INSERT INTO cursos (id_curso, nombre, profesor_id) VALUES
(1, 'Álgebra', 1),
(2, 'Geografía', 2),
(3, 'Programación', 3),
(4, 'Química Orgánica', 4),
(5, 'Redacción', 5),
(6, 'Ecología', 6);

-- INSERTS TUTORES
INSERT INTO tutores (id_tutor, nombre, apellido_paterno, apellido_materno, telefono, email, parentesco, estudiante_id) VALUES
(1, 'Mauricio', 'Moreno', 'Salazar', '555-1201', 'mauricio@email.com', 'Padre', 1),
(2, 'Claudia', 'Ruiz', 'López', '555-1202', 'claudia@email.com', 'Madre', 2),
(3, 'Esteban', 'Peña', 'Ramos', '555-1203', 'esteban@email.com', 'Padre', 3),
(4, 'Patricia', 'Valdez', 'Santos', '555-1204', 'patricia@email.com', 'Madre', 4),
(5, 'Raúl', 'Guerrero', 'Torres', '555-1205', 'raul@email.com', 'Padre', 5),
(6, 'Mónica', 'Mejía', 'Flores', '555-1206', 'monica@email.com', 'Madre', 6);

-- INSERTS CALIFICACIONES
INSERT INTO calificaciones (id_calificacion, estudiante_id, curso_id, calificacion) VALUES
(1, 1, 1, 8.90),
(2, 2, 2, 9.40),
(3, 3, 3, 7.95),
(4, 4, 4, 9.85),
(5, 5, 5, 8.20),
(6, 6, 6, 9.10);

