-- Active: 1752520654667@@127.0.0.1@3306@php_pbo

CREATE DATABASE IF NOT EXISTS taller_api;
USE  taller_api;

DROP DATABASE IF NOT EXISTS taller_api;

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
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
)

CREATE TABLE IF NOT EXISTS promociones(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    descuento DECIMAL(5,2) CHECK (descuento >= 0 AND descuento <= 100),
    producto_id INT,
    Foreign Key (producto_id) REFERENCES productos(id)
)
