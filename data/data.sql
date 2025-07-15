-- Active: 1752442371044@@127.0.0.1@3306@php_pbo

CREATE DATABASE IF NOT EXISTS php_pbo;
USE  php_pbo;

DROP DATABASE IF NOT EXISTS php_pbo;

DROP TABLE IF EXISTS promociones;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS productos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10 , 2) NOT NULL,
    categoria_id  INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE  ON UPDATE CASCADE
)

CREATE TABLE IF NOT EXISTS promociones(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    descuento DECIMAL(5,2) CHECK (descuento >= 0 AND descuento <= 100),
    producto_id INT,
    Foreign Key (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE  
)


INSERT INTO categorias (nombre) VALUES
('TECNOLOGIA'),
('ROPA'),
('DULCES');

INSERT INTO productos (nombre,precio,categoria_id)VALUES
('computadora',1500.00,'1'),
('torta',9.00,'3'),
('camisa',150.00,'2');

INSERT INTO promociones(descripcion,descuento,producto_id)VALUES
('descuento de eletrodomesticos', 15.00,1),
('camisas al mejor precio', 5.00,3);



SELECT * FROM categorias;