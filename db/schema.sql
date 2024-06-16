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
    precio_producto FLOAT(7,2) NOT NULL
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
    num_estrellas INT(1) NOT NULL,
    fecha_hora_comentario DATETIME NOT NULL
);

CREATE TABLE Chat (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    mensaje VARCHAR(300) NOT NULL,
    fecha DATETIME NOT NULL,
    es_cliente BOOLEAN NOT NULL
);

CREATE TABLE Producto (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion VARCHAR(5000) NOT NULL,
    precio FLOAT(7,2) NOT NULL,
    stock INT NOT NULL,
    ruta_imagen VARCHAR(100) NOT NULL,
    marca_id INT NOT NULL,
    categoria_id INT NOT NULL
);

CREATE TABLE Marca (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    marca VARCHAR(100) UNIQUE NOT NULL
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
    permiso_marca TINYINT NOT NULL,
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
ADD CONSTRAINT fk_comentario_productoId FOREIGN KEY (producto_id) REFERENCES Producto(id) ON DELETE CASCADE
;

ALTER TABLE Chat
ADD CONSTRAINT fk_chat_clienteId FOREIGN KEY (cliente_id) REFERENCES Cliente(id) ON DELETE CASCADE
;

ALTER TABLE Producto
ADD CONSTRAINT fk_producto_marcaId FOREIGN KEY (marca_id) REFERENCES Marca(id) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT fk_producto_categoriaId FOREIGN KEY (categoria_id) REFERENCES Categoria(id) ON DELETE CASCADE
;

ALTER TABLE Usuario
ADD CONSTRAINT fk_usuario_rolId FOREIGN KEY (rol_id) REFERENCES Rol(id) ON DELETE CASCADE ON UPDATE CASCADE
;

-- Vistas
CREATE VIEW V_Usuario_Rol AS
SELECT u.id AS "usuario_id", u.usuario, u.correo, u.contrasenia, r.id AS "rol_id", r.nombre AS "nombre_rol", r.color AS "color_rol", u.ruta_imagen_perfil, r.permiso_categoria, r.permiso_producto, r.permiso_marca, r.permiso_cliente, r.permiso_usuario, r.permiso_rol
FROM Usuario u JOIN Rol r ON u.rol_id = r.id
;

CREATE VIEW V_Producto_Categoria AS
SELECT p.id AS "producto_id", p.nombre, p.descripcion, p.precio, m.marca, p.stock, p.ruta_imagen, c.nombre AS "nombre_categoria"
FROM Producto p JOIN Categoria c ON p.categoria_id = c.id JOIN Marca m ON p.marca_id = m.id
;

CREATE VIEW V_Pedido AS
SELECT p.id, c.id AS "cliente_id", c.nombre AS "nombre_cliente", c.apellidos AS "apellidos_cliente", pr.nombre AS "nombre_producto", m.nombre AS "metodo_pago", e.nombre AS "estado_pago", p.direccion_envio
FROM Pedido_Producto_Item pp JOIN Pedido p ON pp.pedido_id = p.id JOIN Cliente c ON p.cliente_id = c.id JOIN Producto pr ON pp.producto_id = pr.id JOIN Metodo_Pago m ON p.metodo_pago_id = m.id JOIN Estado_Pago e ON p.estado_pago_id = e.id
;

CREATE VIEW V_Pedido_Producto_Item_Detallado AS
SELECT ppi.pedido_id, pe.cliente_id, pr.id AS "producto_id", pr.nombre AS "nombre_producto", ppi.cantidad_producto, ppi.precio_producto, pr.ruta_imagen
FROM Pedido_Producto_Item ppi JOIN Pedido pe ON ppi.pedido_id = pe.id JOIN Producto pr ON ppi.producto_id = pr.id
;

CREATE VIEW V_Carrito_Cliente AS
SELECT c.cliente_id AS "cliente_id", p.id AS "producto_id", p.nombre AS "nombre_producto", p.precio AS "precio_producto", p.stock AS "stock_producto", c.cantidad, p.ruta_imagen AS "ruta_imagen_producto"
FROM Carrito_Item c JOIN Producto p ON c.producto_id = p.id
;

CREATE VIEW V_Producto_Valoracion_Promedio AS
SELECT p.id, p.nombre, p.descripcion, p.ruta_imagen, p.precio, m.id AS "marca_id", m.marca, ca.id AS "categoria_id", ca.nombre AS "nombre_categoria", ROUND(AVG(c.num_estrellas)) AS "valoracion_promedio"
FROM Producto p JOIN Marca m ON p.marca_id = m.id JOIN Categoria ca ON p.categoria_id = ca.id LEFT JOIN Comentario c ON p.id = c.producto_id GROUP BY p.id
;

CREATE VIEW V_Comentario_Cliente_Producto AS
SELECT c.producto_id, cl.id AS "cliente_id", cl.nombre AS "nombre_cliente", cl.apellidos AS "apellidos_cliente", cl.ruta_imagen_perfil, c.comentario, c.num_estrellas, c.fecha_hora_comentario
FROM Comentario c JOIN Cliente cl ON c.cliente_id = cl.id JOIN Producto p ON c.producto_id = p.id
;

CREATE VIEW V_Chat_Cliente_Info AS
SELECT ch.id, ch.cliente_id, cl.correo, cl.ruta_imagen_perfil, ch.mensaje, ch.fecha, ch.es_cliente
FROM Chat ch JOIN Cliente cl ON ch.cliente_id = cl.id
;