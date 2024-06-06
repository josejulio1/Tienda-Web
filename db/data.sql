USE tienda;

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
(1, 'VISA'),
(2, 'MasterCard'),
(3, 'PayPal');

-- Estado_Pago
INSERT INTO Estado_Pago (id, nombre) VALUES
(1, 'Aceptado'),
(2, 'Denegado'),
(3, 'Pendiente');

-- Pedido
INSERT INTO Pedido (id, cliente_id, metodo_pago_id, estado_pago_id, direccion_envio) VALUES
(1, 2, 2, 1, 'Apt 207'),
(2, 3, 3, 2, 'Suite 72'),
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
INSERT INTO Comentario (id, cliente_id, producto_id, comentario, num_estrellas) VALUES
(1, 1, 2, 'Buen producto', 5),
(2, 2, 2, 'Horrible producto', 1),
(3, 3, 2, 'Producto mediocre', 2),
(4, 6, 5, 'Me llegó defectuoso', 1);