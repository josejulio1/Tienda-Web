-- Cliente
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (1, 'Kristoffer', 'D''Antoni', '+62 7648871598', 'Suite 8', 'kdantoni0@drupal.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (2, 'Janos', 'Layhe', '+46 2695049111', 'Room 646', 'jlayhe1@mashable.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (3, 'Violante', 'Clawsley', '+34 4941590695', '20th Floor', 'vclawsley2@wunderground.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (4, 'Greta', 'Piscotti', '+81 4341205334', 'Suite 80', 'gpiscotti3@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (5, 'Ilario', 'De Biaggi', '+595 9632584809', 'Suite 99', 'idebiaggi4@slashdot.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (6, 'Umeko', 'Kinsella', '+60 8028058834', 'Apt 820', 'ukinsella5@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (7, 'Yolane', 'Snasdell', '+51 3144202389', 'Room 94', 'ysnasdell6@globo.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (8, 'Wilie', 'Megany', '+1 4732908271', 'Suite 55', 'wmegany7@pcworld.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (9, 'Briny', 'Guyton', '+502 5947441669', 'Room 225', 'bguyton8@oaic.gov.au', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');
insert into Cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (10, 'Konrad', 'Schuck', '+375 5421625244', 'Room 1066', 'kschuck9@bing.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/internal/default/default-avatar.jpg');

-- Categoría
insert into Categoria (id, nombre) values (1, 'Tarjetas Gráficas');
insert into Categoria (id, nombre) values (2, 'Procesadores');
insert into Categoria (id, nombre) values (3, 'Almacenamiento');
insert into Categoria (id, nombre) values (4, 'Monitores');
insert into Categoria (id, nombre) values (5, 'Placas Bases');

-- Producto
insert into Producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (1, 'ASUS GTX 1060 6GB', 'Tarjeta gráfica de gama media', 339, 'ASUS', 8, '/assets/img/internal/products/ASUS GTX 1060 6GB/asus.jpg', 1);
insert into Producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (2, 'Intel Core i9-9900K', 'Procesador de gama media-alta. La calidad a tus pies', 789.89, 'Intel', 84, '/assets/img/internal/products/Intel Core i9-9900K/intel.jpg', 2);
insert into Producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (3, 'WD 1TB 7.2K RPM Blue', 'Disco duro de 7.200 revoluciones/minuto. Estándar blue', 30.5, 'Western Digital', 12, '/assets/img/internal/products/WD 1TB 7.2K RPM Blue/disco-duro.jpg', 3);
insert into Producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (4, 'MSI B450M Artic Tomahawk', 'Placa base para gamers. Chipset B450. Socket AM4', 160.3, 'MSI', 12, '/assets/img/internal/products/MSI B450M Artic Tomahawk/msi.jpg', 5);
insert into Producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (5, 'Lenovo D24-45', 'Monitor para uso personal', 120, 'Lenovo', 12, '/assets/img/internal/products/Lenovo D24-45/d24-45.jpg', 4);

-- Carrito_Item
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (4, 9, 1);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (3, 1, 50);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (2, 9, 48);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (4, 4, 59);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (5, 9, 81);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (5, 7, 77);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (1, 6, 37);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (2, 1, 51);
insert into Carrito_Item (producto_id, cliente_id, cantidad) values (3, 2, 50);

-- Metodo_Pago
insert into Metodo_Pago (id, nombre) values (1, 'VISA');
insert into Metodo_Pago (id, nombre) values (2, 'MasterCard');
insert into Metodo_Pago (id, nombre) values (3, 'PayPal');

-- Estado_Pago
insert into Estado_Pago (id, nombre) values (1, 'Aceptado');
insert into Estado_Pago (id, nombre) values (2, 'Denegado');
insert into Estado_Pago (id, nombre) values (3, 'Pendiente');

-- Pedido
insert into Pedido (id, cliente_id, metodo_pago_id, estado_pago_id, direccion_envio) values (1, 2, 2, 1, 'Apt 207');
insert into Pedido (id, cliente_id, metodo_pago_id, estado_pago_id, direccion_envio) values (2, 3, 3, 2, 'Suite 72');
insert into Pedido (id, cliente_id, metodo_pago_id, estado_pago_id, direccion_envio) values (3, 9, 2, 2, '3rd Floor');

-- Pedido_Producto_Item
INSERT INTO Pedido_Producto_Item (id, pedido_id, producto_id, cantidad_producto, precio_producto) VALUES (1, 1, 2, 8, 789.89);
INSERT INTO Pedido_Producto_Item (id, pedido_id, producto_id, cantidad_producto, precio_producto) VALUES (2, 2, 5, 8, 120);
INSERT INTO Pedido_Producto_Item (id, pedido_id, producto_id, cantidad_producto, precio_producto) VALUES (3, 2, 3, 8, 30.5);

-- Rol
INSERT INTO Rol (nombre, color, permiso_categoria, permiso_producto, permiso_cliente, permiso_usuario, permiso_rol) VALUES ('Administrador', '000000', 15, 15, 15, 15, 15);
INSERT INTO Rol (nombre, color, permiso_categoria, permiso_producto, permiso_cliente, permiso_usuario, permiso_rol) VALUES ('Moderador', '777777', 0, 3, 0, 2, 6);

-- Usuario
INSERT INTO Usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('jose', 'jose@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/internal/default/default-avatar.jpg');
INSERT INTO Usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('pepe', 'pepe@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/internal/default/default-avatar.jpg');
INSERT INTO Usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('antonio', 'antonio@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 2, '/assets/img/internal/default/default-avatar.jpg');

-- Comentario
INSERT INTO Comentario (id, cliente_id, producto_id, comentario, num_estrellas)
VALUES (1, 1, 2, 'Buen producto', 5);
INSERT INTO Comentario (id, cliente_id, producto_id, comentario, num_estrellas)
VALUES (2, 2, 2, 'Horrible producto', 1);
INSERT INTO Comentario (id, cliente_id, producto_id, comentario, num_estrellas)
VALUES (3, 3, 2, 'Producto mediocre', 2);