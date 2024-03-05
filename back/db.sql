CREATE TABLE tipos_usuarios(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL
);

-- CREATE TABLE tipo_cargo(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     nombre VARCHAR(25) NOT NULL
-- );

-- CREATE TABLE idiomas(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     descripcion VARCHAR(25) NOT NULL
-- );

-- CREATE TABLE nivel_idiomas(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     descripcion VARCHAR(25) NOT NULL,
--     id_idioma INT NOT NULL,
--     FOREIGN KEY (id_idioma) REFERENCES idiomas(id)
-- );

CREATE TABLE tipos_practicas(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25) NOT NULL
);

CREATE TABLE ciclos(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25) NOT NULL
);

CREATE TABLE empresas(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nif VARCHAR(9),
    pais VARCHAR(15),
    razonSocial VARCHAR(255),
    titularidad VARCHAR(50),
    tipo_entidad VARCHAR(50),
    territorio VARCHAR(50),
    municipio VARCHAR(25),
    direccion VARCHAR(75),
    codigo_postal VARCHAR(15),
    telefono VARCHAR(15),
    fax VARCHAR(15),
    cnae VARCHAR(15),
    numero_trabajadores INT 
);

CREATE TABLE centros_trabajo(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    denominacion VARCHAR(255),
    pais VARCHAR(15),
    territorio VARCHAR(50),
    municipio VARCHAR(25),
    codigo_postal VARCHAR(15),
    direccion VARCHAR(75),
    telefono VARCHAR(15),
    telefono2 VARCHAR(15),
    fax VARCHAR(15),
    email VARCHAR(100),
    actividad VARCHAR(255),
    numero_trabajadores INT,
    FOREIGN KEY (id_empresa) REFERENCES empresas(id)
);

CREATE TABLE alumnos(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(9) NOT NULL UNIQUE,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    poblacion VARCHAR(25),
    email VARCHAR(100),
    otra_titulacion VARCHAR(100),
    vehiculo TINYINT(1) NOT NULL DEFAULT 0,
    ingles VARCHAR(25),
    euskera VARCHAR(25),
    otros_idiomas VARCHAR(100),
    id_ciclo INT NOT NULL,
    FOREIGN KEY (id_ciclo) REFERENCES ciclos(id)
);

CREATE TABLE usuarios(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(25) NOT NULL UNIQUE,
    nombre VARCHAR(30) NOT NULL,
    apellidos VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(64) NOT NULL,
    telefono VARCHAR(15),
    id_tipo_usuario INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipos_usuarios(id)
);

CREATE TABLE profesores(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(255) NOT NULL UNIQUE,
    nombre VARCHAR(30) NOT NULL,
    apellidos VARCHAR(30) NOT NULL
);

CREATE TABLE contactos(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nif VARCHAR(255) NOT NULL UNIQUE,
    nombre VARCHAR(30) NOT NULL,
    apellidos VARCHAR(30) NOT NULL,
    telefono VARCHAR(15),
    movil VARCHAR(15),
    fax VARCHAR(15),
    email VARCHAR(100),
    departamento VARCHAR(50),
    responsable TINYINT(1) NOT NULL DEFAULT 0,
    id_centro INT NOT NULL,
    FOREIGN KEY (id_centro) REFERENCES centros_trabajo(id)
);

-- CREATE TABLE cargo_empresa(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     id_contacto INT NOT NULL,
--     id_tipoCargo INT NOT NULL,
--     FOREIGN KEY (id_contacto) REFERENCES contactos(id),
--     FOREIGN KEY (id_tipoCargo) REFERENCES tipo_cargo(id)
-- );

-- CREATE TABLE idioma_alumno(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     id_alumno INT NOT NULL,
--     id_nivel_idioma INT NOT NULL,
--     FOREIGN KEY (id_alumno) REFERENCES alumnos(id),
--     FOREIGN KEY (id_nivel_idioma) REFERENCES nivel_idiomas(id)
-- );

CREATE TABLE practicas(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_centro_trabajo INT NOT NULL,
    id_responsable INT NOT NULL,
    id_tutor INT NOT NULL,
    id_tipo_practica INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id),
    FOREIGN KEY (id_centro_trabajo) REFERENCES centros_trabajo(id),
    FOREIGN KEY (id_responsable) REFERENCES contactos(id),
    FOREIGN KEY (id_tutor) REFERENCES profesores(id),
    FOREIGN KEY (id_tipo_practica) REFERENCES tipos_practicas(id)
);



INSERT INTO `tipos_usuarios` (`id`, `nombre`) VALUES (NULL, 'admin');
INSERT INTO `tipos_usuarios` (`id`, `nombre`) VALUES (NULL, 'profesor');

INSERT INTO tipos_practicas (nombre) VALUES ('FCT');
INSERT INTO tipos_practicas (nombre) VALUES ('DUAL');
INSERT INTO tipos_practicas (nombre) VALUES ('Bachillerato');

-- Manually hash the password
SET @hashedPassword = SHA2('admin', 256);
-- Insert the user with hashed password into the usuarios table
INSERT INTO usuarios (username, nombre, apellidos, email, contrasena, telefono, id_tipo_usuario)
VALUES ('admin', 'admin', 'admin', 'admin@admin', @hashedPassword, '123456789', 1);

INSERT INTO ciclos (nombre) VALUES ('DAW');
INSERT INTO ciclos (nombre) VALUES ('DAM');
INSERT INTO ciclos (nombre) VALUES ('ASIR');
INSERT INTO ciclos (nombre) VALUES ('AD');
INSERT INTO ciclos (nombre) VALUES ('ADE');
INSERT INTO ciclos (nombre) VALUES ('ASI');


INSERT INTO alumnos (dni, nombre, apellidos, poblacion, email, otra_titulacion, vehiculo, ingles, euskera, otros_idiomas, id_ciclo) VALUES 
('12345678A', 'Juan', 'García Pérez', 'Donostia-San Sebastián', 'juan.garcia@example.com', 'Bachillerato', 1, 'B2', 'A1', 'Francés, Alemán', 5),
('98765432B', 'María', 'Martínez López', 'Hernani', 'maria.martinez@example.com', NULL, 0, 'C1', 'A2', 'Árabe', 6),
('56789012C', 'Carlos', 'Fernández Rodríguez', 'Rentería', 'carlos.fernandez@example.com', 'Ciclo Formativo de Grado Medio', 1, 'First Certificate', 'B1', 'Italiano, Chino', 4),
('34567890D', 'Ana', 'Sánchez Gómez', 'Tolosa', 'ana.sanchez@example.com', 'Ciclo Formativo de Grado Superior', 0, 'Advanced Certificate', 'C1', 'Portugués, Japonés', 4),
('90123456E', 'Laura', 'González Martín', 'Azpeitia', 'laura.gonzalez@example.com', NULL, 1, 'A2', 'B2', 'Ruso, Coreano', 3),
('78901234F', 'David', 'López Hernández', 'Irún', 'david.lopez@example.com', NULL, 0, 'B1', 'A1', 'Holandés, Sueco', 5),
('23456789G', 'Sara', 'Pérez García', 'Zarauz', 'sara.perez@example.com', 'Formación Profesional Básica', 1, 'C1', 'A2', 'Chino, Turco', 2),
('45678901H', 'Pedro', 'Rodríguez Martínez', 'Eibar', 'pedro.rodriguez@example.com', NULL, 0, 'A1', 'B1', 'Griego', 1),
('67890123I', 'Carmen', 'Martín Sánchez', 'Orio', 'carmen.martin@example.com', NULL, 1, 'B2', 'C1', 'Sueco, Polaco', 1);

INSERT INTO empresas (nif, pais, razonSocial, titularidad, tipo_entidad, territorio, municipio, direccion, codigo_postal, telefono, fax, cnae, numero_trabajadores)
VALUES ('123456789', 'Spain', 'Empresa1', 'Privada', 'SL', 'Guipúzcoa', 'San Sebastián', 'Dirección 1', '20001', '123456789', '987654321', 'CNAE1', 50),
       ('987654321', 'Spain', 'Empresa2', 'Pública', 'SA', 'Vizcaya', 'Bilbao', 'Dirección 2', '48001', '987654321', '123456789', 'CNAE2', 100);

INSERT INTO centros_trabajo (id_empresa, denominacion, pais, territorio, municipio, codigo_postal, direccion, telefono, telefono2, fax, email, actividad, numero_trabajadores)
VALUES (1, 'Centro1', 'Spain', 'Guipúzcoa', 'San Sebastián', '20001', 'Dirección 1', '123456789', '987654321', '987654321', 'centro1@example.com', 'Actividad1', 20),
       (2, 'Centro2', 'Spain', 'Vizcaya', 'Bilbao', '48001', 'Dirección 2', '987654321', '123456789', '123456789', 'centro2@example.com', 'Actividad2', 30);

INSERT INTO contactos (nif, nombre, apellidos, telefono, movil, fax, email, departamento, responsable, id_centro)
VALUES ('123456789', 'Contacto1', 'Apellido1', '123456789', '987654321', '987654321', 'contacto1@example.com', 'Departamento1', 1, 1),
       ('987654321', 'Contacto2', 'Apellido2', '987654321', '123456789', '123456789', 'contacto2@example.com', 'Departamento2', 0, 2);

INSERT INTO profesores (dni, nombre, apellidos) VALUES 
('11111111A', 'Profesor1', 'Apellido1'),
('22222222B', 'Profesor2', 'Apellido2');

INSERT INTO practicas (id_alumno, id_centro_trabajo, id_responsable, id_tutor, id_tipo_practica, fecha_inicio, fecha_fin)
VALUES (1, 1, 1, 1, 1, '2023-01-01', '2023-06-30'),
       (2, 2, 2, 2, 2, '2023-02-01', '2023-07-30');