DROP DATABASE IF EXISTS tienda;

CREATE DATABASE tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE tienda;

CREATE TABLE Carrito_Item (
    producto_id INT NOT NULL,
    cliente_id INT NOT NULL,
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
    metodo_pago_id INT NOT NULL,
    estado_pago_id INT NOT NULL,
    direccion_envio VARCHAR(100) NOT NULL
);

CREATE TABLE Pedido_Producto_Item (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad_producto INT NOT NULL,
    precio_producto FLOAT(5,2) NOT NULL
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
    num_estrellas INT(1) NOT NULL
);

CREATE TABLE Producto (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion VARCHAR(5000) NOT NULL,
    precio FLOAT(5,2) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    stock INT NOT NULL,
    ruta_imagen VARCHAR(100) NOT NULL,
    categoria_id INT NOT NULL
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
ALTER TABLE Carrito_Item
ADD CONSTRAINT pk_carritoItem PRIMARY KEY (producto_id, cliente_id),
ADD CONSTRAINT fk_carritoItem_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id) ON DELETE CASCADE,
ADD CONSTRAINT fk_carritoItem_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id) ON DELETE CASCADE
;

ALTER TABLE Pedido
ADD CONSTRAINT fk_pedido_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
ADD CONSTRAINT fk_pedido_metodoPagoId FOREIGN KEY (metodo_pago_id) REFERENCES Metodo_Pago(id),
ADD CONSTRAINT fk_pedido_estadoPagoId FOREIGN KEY (estado_pago_id) REFERENCES Estado_Pago(id)
;

ALTER TABLE Pedido_Producto_Item
ADD CONSTRAINT fk_pedidoProductoItem_pedidoId FOREIGN KEY (pedido_id) REFERENCES Pedido(id)
;

ALTER TABLE Comentario
ADD CONSTRAINT fk_comentario_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
ADD CONSTRAINT fk_comentario_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id)
;

ALTER TABLE Producto
ADD CONSTRAINT fk_producto_clienteId FOREIGN KEY (categoria_id) REFERENCES Categoria(id) ON DELETE CASCADE
;

ALTER TABLE Usuario
ADD CONSTRAINT fk_usuario_rolId FOREIGN KEY (rol_id) REFERENCES Rol(id) ON DELETE CASCADE ON UPDATE CASCADE
;

-- Vistas
CREATE VIEW v_usuario_rol AS
SELECT u.id AS "usuario_id", u.usuario, u.correo, u.contrasenia, r.id AS "id_rol", r.nombre AS "nombre_rol", r.color AS "color_rol", u.ruta_imagen_perfil, r.permiso_categoria, r.permiso_producto, r.permiso_cliente, r.permiso_usuario, r.permiso_rol FROM Usuario u JOIN Rol r ON u.rol_id = r.id
;

CREATE VIEW v_producto_categoria AS
SELECT p.id AS "producto_id", p.nombre, p.descripcion, p.precio, p.marca, p.stock, p.ruta_imagen, c.nombre AS "nombre_categoria"
FROM Producto p JOIN Categoria c ON p.categoria_id = c.id
;

CREATE VIEW v_pedido AS
SELECT p.id, c.id AS "cliente_id", c.nombre AS "nombre_cliente", c.apellidos AS "apellidos_cliente", pr.nombre AS "nombre_producto", m.nombre AS "metodo_pago", e.nombre AS "estado_pago", p.direccion_envio
FROM Pedido_Producto_Item pp JOIN Pedido p ON pp.pedido_id = p.id JOIN Cliente c ON p.cliente_id = c.id JOIN Producto pr ON pp.producto_id = pr.id JOIN Metodo_Pago m ON p.metodo_pago_id = m.id JOIN Estado_Pago e ON p.estado_pago_id = e.id
;

CREATE VIEW v_carrito_cliente AS
SELECT c.cliente_id AS "cliente_id", p.id AS "producto_id", p.nombre AS "nombre_producto", p.precio AS "precio_producto", c.cantidad, p.ruta_imagen AS "ruta_imagen_producto" 
FROM Carrito_Item c JOIN Producto p ON c.producto_id = p.id
;

CREATE VIEW v_producto_valoracion_promedio AS
SELECT vp.id, vp.nombre, vp.descripcion, vp.ruta_imagen, vp.precio, vp.marca, vp.valoracion_promedio
FROM (SELECT p.id, p.nombre, p.descripcion, p.ruta_imagen, p.precio, p.marca, ROUND(AVG(c.num_estrellas), 0) AS "valoracion_promedio" FROM Producto p JOIN Comentario c ON p.id = c.producto_id UNION SELECT id, nombre, descripcion, ruta_imagen, precio, marca, NULL FROM Producto) vp GROUP BY vp.nombre
;

CREATE VIEW v_comentario_cliente_producto AS 
SELECT c.producto_id, cl.nombre AS "nombre_cliente", cl.apellidos AS "apellidos_cliente", cl.ruta_imagen_perfil, c.comentario, c.num_estrellas FROM Comentario c JOIN Cliente cl ON c.cliente_id = cl.id JOIN Producto p ON c.producto_id = p.id
;