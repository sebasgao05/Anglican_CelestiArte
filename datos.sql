CREATE DATABASE deus_users;
USE deus_users;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Usuario', 'Administrador') DEFAULT 'Usuario'
);

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Geraldine Segura', 'geraldine.segura@email.com', '123', 'Usuario'),
('Pedro Ramírez', 'pedro.ramirez@email.com', '123', 'Usuario'),
('Ana Torres', 'ana.torres@email.com', '123', 'Usuario'),
('Luis Hernández', 'luis.hernandez@email.com', '123', 'Usuario'),
('Sofía Castro', 'sofia.castro@email.com', '123', 'Usuario'),
('Fernando López', 'fernando.lopez@email.com', '123', 'Usuario'),
('Elena Morales', 'elena.morales@email.com', '123', 'Usuario'),
('Roberto Vargas', 'roberto.vargas@email.com', '123', 'Usuario'),
('Gabriela Ríos', 'gabriela.rios@email.com', '123', 'Usuario'),
('José Ramírez', 'jose.ramirez@email.com', '123', 'Usuario'),
('Camila Ortega', 'camila.ortega@email.com', '123', 'Usuario'),
('Miguel Sánchez', 'miguel.sanchez@email.com', '123', 'Usuario'),
('Isabela Mendoza', 'isabela.mendoza@email.com', '123', 'Usuario'),
('Hugo Díaz', 'hugo.diaz@email.com', '123', 'Usuario'),
('Valeria Flores', 'valeria.flores@email.com', '123', 'Usuario'),
('Ricardo Medina', 'ricardo.medina@email.com', '123', 'Usuario'),
('Paola Núñez', 'paola.nunez@email.com', '123', 'Usuario');

--  Para tener estas te recomiendo crear un usuario admin y uno usuario a tu eleccion, un ejemplo es este:
--      la contraseña de estos dos en mysql va a quedar cifrada

--  PRUEBA', 'PRUEBA@PRUEBA.com', 'Administrador'
--  '123', '123@123.com', 'Usuario'