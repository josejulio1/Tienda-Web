DROP DATABASE IF EXISTS tienda;

CREATE DATABASE tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE tienda;

CREATE TABLE Carrito (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL
);

CREATE TABLE CarritoItem (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    carrito_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL
);

CREATE TABLE Metodo_Pago (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL
);

CREATE TABLE Estado_Pago (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL
);

CREATE TABLE Pedido (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    carrito_id INT NOT NULL,
    metodo_pago_id INT NOT NULL,
    estado_pago_id INT NOT NULL,
    direccion_envio VARCHAR(100) NOT NULL
);

CREATE TABLE Cliente (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    contrasenia CHAR(60) NOT NULL,
    ruta_imagen_perfil VARCHAR(100) NOT NULL
);

CREATE TABLE Comentario (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    comentario VARCHAR(1000) NOT NULL,
    num_estrellas INT NOT NULL
);

CREATE TABLE Producto (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(5000) NOT NULL,
    precio FLOAT(5,2) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    stock INT NOT NULL,
    categoria_id INT NOT NULL
);

CREATE TABLE Imagen_Producto (
    id INT NOT NULL,
    ruta_imagen VARCHAR(200) NOT NULL,
    producto_id INT NOT NULL
);

CREATE TABLE Categoria (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE Usuario (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    contrasenia CHAR(60) NOT NULL,
    rol_id INT NOT NULL,
    ruta_imagen_perfil VARCHAR(100) NOT NULL
);

CREATE TABLE Rol (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    color CHAR(6) NOT NULL,
    permiso_categoria TINYINT NOT NULL,
    permiso_producto TINYINT NOT NULL,
    permiso_cliente TINYINT NOT NULL,
    permiso_usuario TINYINT NOT NULL,
    permiso_rol TINYINT NOT NULL
);

-- ALTER
ALTER TABLE Carrito
ADD CONSTRAINT fk_carrito_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
ADD CONSTRAINT fk_carrito_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id)
;

ALTER TABLE CarritoItem
ADD CONSTRAINT fk_carritoItem_carritoId FOREIGN KEY (carrito_id) REFERENCES Carrito(id),
ADD CONSTRAINT fk_carritoItem_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id)
;

ALTER TABLE Pedido
ADD CONSTRAINT fk_pedido_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
ADD CONSTRAINT fk_pedido_carritoId FOREIGN KEY (carrito_id) REFERENCES Carrito(id),
ADD CONSTRAINT fk_pedido_metodoPagoId FOREIGN KEY (metodo_pago_id) REFERENCES Metodo_Pago(id),
ADD CONSTRAINT fk_pedido_estadoPagoId FOREIGN KEY (estado_pago_id) REFERENCES Estado_Pago(id)
;

ALTER TABLE Comentario
ADD CONSTRAINT fk_comentario_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
ADD CONSTRAINT fk_comentario_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id)
;

ALTER TABLE Producto
ADD CONSTRAINT fk_producto_clienteId FOREIGN KEY (categoria_id) REFERENCES Categoria(id)
;

ALTER TABLE Imagen_Producto
ADD CONSTRAINT pk_imagenProducto PRIMARY KEY(id, producto_id),
ADD CONSTRAINT fk_imagenProducto_clienteId FOREIGN KEY (producto_id) REFERENCES Producto(id),
MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT
;

ALTER TABLE Usuario
ADD CONSTRAINT fk_usuario_rolId FOREIGN KEY (rol_id) REFERENCES Rol(id)
;

-- Vistas
CREATE VIEW V_Usuario_Rol AS
SELECT u.id AS "usuario_id", u.usuario, u.correo, u.contrasenia, r.nombre AS "nombre_rol", r.color AS "color_rol", u.ruta_imagen_perfil, r.permiso_categoria, r.permiso_producto, r.permiso_cliente, r.permiso_usuario, r.permiso_rol FROM usuario u JOIN rol r ON u.rol_id = r.id
;