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

-- Cliente
INSERT INTO Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) VALUES
(1, 'Kristoffer', 'D''Antoni', '+62 7648871598', 'Suite 8', 'kdantoni0@drupal.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(2, 'Janos', 'Layhe', '+46 2695049111', 'Room 646', 'jlayhe1@mashable.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(3, 'Violante', 'Clawsley', '+34 4941590695', '20th Floor', 'vclawsley2@wunderground.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(4, 'Greta', 'Piscotti', '+81 4341205334', 'Suite 80', 'gpiscotti3@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(5, 'Ilario', 'De Biaggi', '+595 9632584809', 'Suite 99', 'idebiaggi4@slashdot.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(6, 'Umeko', 'Kinsella', '+60 8028058834', 'Apt 820', 'ukinsella5@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(7, 'Yolane', 'Snasdell', '+51 3144202389', 'Room 94', 'ysnasdell6@globo.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(8, 'Wilie', 'Megany', '+1 4732908271', 'Suite 55', 'wmegany7@pcworld.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(9, 'Briny', 'Guyton', '+502 5947441669', 'Room 225', 'bguyton8@oaic.gov.au', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg'),
(10, 'Konrad', 'Schuck', '+375 5421625244', 'Room 1066', 'kschuck9@bing.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');

-- Categoría
INSERT INTO Categoria (id, nombre) VALUES
(1, 'Tarjetas Gráficas'),
(2, 'Procesadores'),
(3, 'Almacenamiento'),
(4, 'Monitores'),
(5, 'Placas Bases');

-- Marca
INSERT INTO Marca (id, marca) VALUES
(1, 'ASUS'),
(2, 'Intel'),
(3, 'Western Digital'),
(4, 'MSI'),
(5, 'Lenovo');

-- Producto
INSERT INTO Producto (id, nombre, descripcion, precio, stock, ruta_imagen, marca_id, categoria_id) VALUES
(1, 'ASUS GTX 1060 6GB', 'Tarjeta gráfica de gama media', 339, 8, '/assets/img/internal/products/ASUS GTX 1060 6GB/asus.jpg', 1, 1),
(2, 'Intel Core i9-9900K', 'Procesador de gama media-alta. La calidad a tus pies', 789.89, 84, '/assets/img/internal/products/Intel Core i9-9900K/intel.jpg', 2, 2),
(3, 'WD 1TB 7.2K RPM Blue', 'Disco duro de 7.200 revoluciones/minuto. Estándar blue', 30.5, 12, '/assets/img/internal/products/WD 1TB 7.2K RPM Blue/disco-duro.jpg', 3, 3),
(4, 'MSI B450M Artic Tomahawk', 'Placa base para gamers. Chipset B450. Socket AM4', 160.3, 12, '/assets/img/internal/products/MSI B450M Artic Tomahawk/msi.jpg', 4, 5),
(5, 'Lenovo D24-45', 'Monitor para uso personal', 120, 12, '/assets/img/internal/products/Lenovo D24-45/d24-45.jpg', 5, 4);

-- Carrito_Item
INSERT INTO Carrito_Item (producto_id, cliente_id, cantidad) VALUES
(4, 9, 1),
(3, 1, 10),
(2, 9, 48),
(4, 4, 59),
(5, 9, 81),
(5, 7, 77),
(1, 6, 37),
(2, 1, 51),
(3, 2, 50);

-- Metodo_Pago
INSERT INTO Metodo_Pago (id, nombre) VALUES
(1, 'Tarjeta'),
(2, 'PayPal');

-- Estado_Pago
INSERT INTO Estado_Pago (id, nombre) VALUES
(1, 'Aceptado'),
(2, 'Denegado'),
(3, 'Pendiente');

-- Pedido
INSERT INTO Pedido (id, cliente_id, metodo_pago_id, estado_pago_id, direccion_envio) VALUES
(1, 2, 2, 1, 'Apt 207'),
(2, 3, 1, 2, 'Suite 72'),
(3, 9, 2, 2, '3rd Floor');

-- Pedido_Producto_Item
INSERT INTO Pedido_Producto_Item (id, pedido_id, producto_id, cantidad_producto, precio_producto) VALUES
(1, 1, 2, 8, 789.89),
(2, 2, 5, 8, 120),
(3, 2, 3, 8, 30.5);

-- Rol
INSERT INTO Rol (nombre, color, permiso_categoria, permiso_producto, permiso_marca, permiso_cliente, permiso_usuario, permiso_rol) VALUES
('Administrador', '000000', 15, 15, 15, 15, 15, 15),
('Moderador', '777777', 0, 3, 15, 0, 2, 6);

-- Usuario
INSERT INTO Usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES
('jose', 'jose@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/internal/default/default-avatar.jpg'),
('pepe', 'pepe@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/internal/default/default-avatar.jpg'),
('antonio', 'antonio@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 2, '/assets/img/internal/default/default-avatar.jpg');

-- Comentario
INSERT INTO Comentario (id, cliente_id, producto_id, comentario, num_estrellas, fecha_hora_comentario) VALUES
(1, 1, 2, 'Buen producto', 5, '2022-02-23 12:42:36'),
(2, 2, 2, 'Horrible producto', 1, '2023-07-28 23:12:39'),
(3, 3, 2, 'Producto mediocre', 2, '2020-01-05 17:23:21'),
(4, 6, 5, 'Me llegó defectuoso', 1, '2024-04-08 19:12:15');