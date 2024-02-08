-- Cliente
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (1, 'Kristoffer', 'D''Antoni', '+62 764 887 1598', 'Suite 8', 'kdantoni0@drupal.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (2, 'Janos', 'Layhe', '+46 269 504 9111', 'Room 646', 'jlayhe1@mashable.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (3, 'Violante', 'Clawsley', '+34 494 159 0695', '20th Floor', 'vclawsley2@wunderground.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (4, 'Greta', 'Piscotti', '+81 434 120 5334', 'Suite 80', 'gpiscotti3@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (5, 'Ilario', 'De Biaggi', '+595 963 258 4809', 'Suite 99', 'idebiaggi4@slashdot.org', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (6, 'Umeko', 'Kinsella', '+60 802 805 8834', 'Apt 820', 'ukinsella5@moonfruit.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (7, 'Yolane', 'Snasdell', '+51 314 420 2389', 'Room 94', 'ysnasdell6@globo.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (8, 'Wilie', 'Megany', '+1 473 290 8271', 'Suite 55', 'wmegany7@pcworld.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (9, 'Briny', 'Guyton', '+502 594 744 1669', 'Room 225', 'bguyton8@oaic.gov.au', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');
insert into cliente (id, nombre, apellidos, telefono, direccion, correo, contrasenia, ruta_imagen_perfil) values (10, 'Konrad', 'Schuck', '+375 542 162 5244', 'Room 1066', 'kschuck9@bing.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', '/assets/img/users/default/default-avatar.jpg');

-- Categoría
insert into categoria (id, nombre) values (1, 'Roofing (Asphalt)');
insert into categoria (id, nombre) values (2, 'Prefabricated Aluminum Metal Canopies');
insert into categoria (id, nombre) values (3, 'Drilled Shafts');
insert into categoria (id, nombre) values (4, 'Ornamental Railings');
insert into categoria (id, nombre) values (5, 'Rebar & Wire Mesh Install');
insert into categoria (id, nombre) values (6, 'Painting & Vinyl Wall Covering');
insert into categoria (id, nombre) values (7, 'Sitework & Site Utilities');
insert into categoria (id, nombre) values (8, 'Masonry');

-- Producto
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (1, 'Maureen', 'Other synovitis and tenosynovitis, left forearm', 28.86, 'Clarithromycin', 8, '/assets/img/users/default/default-avatar.jpg', 2);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (2, 'Cherice', 'String or thread causing external constriction', 587.94, 'sunmark anti', 87, '/assets/img/users/default/default-avatar.jpg', 8);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (3, 'Jacinda', 'Nondisplaced comminuted fracture of shaft of unspecified femur, subsequent encounter for open fracture type IIIA, IIIB, or IIIC with nonunion', 413.35, 'Privigen', 12, '/assets/img/users/default/default-avatar.jpg', 8);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (4, 'Brennan', 'Toxic effect of chlorine gas, intentional self-harm, initial encounter', 718.24, 'Fruit Punch Scented Hand Sanitizer', 91, '/assets/img/users/default/default-avatar.jpg', 3);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (5, 'Alvira', 'Unspecified physeal fracture of lower end of radius, unspecified arm, subsequent encounter for fracture with routine healing', 610.46, 'No7 Dual Action Tinted Moisturiser Fair', 11, '/assets/img/users/default/default-avatar.jpg', 1);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (6, 'Missy', 'Osteonecrosis in diseases classified elsewhere, right shoulder', 573.15, 'LBEL HYDRATESS', 88, '/assets/img/users/default/default-avatar.jpg', 3);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (7, 'Abraham', 'Exposure of graft of urinary organ, initial encounter', 711.84, 'HYDROCORTISONE', 4, '/assets/img/users/default/default-avatar.jpg', 5);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (8, 'Raina', 'Open bite of right great toe without damage to nail', 532.64, 'Ciprofloxacin', 32, '/assets/img/users/default/default-avatar.jpg', 4);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (9, 'Elliot', 'Crushing injury of unspecified hand', 789.89, 'Leader Extra Strength Medicated Pain Relief Patch', 84, '/assets/img/users/default/default-avatar.jpg', 3);
insert into producto (id, nombre, descripcion, precio, marca, stock, ruta_imagen, categoria_id) values (10, 'Nertie', 'Other sprain of left foot, initial encounter', 95.29, 'Periodontium Quartz', 12, '/assets/img/users/default/default-avatar.jpg', 4);

-- Carrito
insert into carrito (id, cliente_id, producto_id) values (1, 9, 6);
insert into carrito (id, cliente_id, producto_id) values (2, 5, 6);
insert into carrito (id, cliente_id, producto_id) values (3, 2, 3);
insert into carrito (id, cliente_id, producto_id) values (4, 7, 5);
insert into carrito (id, cliente_id, producto_id) values (5, 3, 1);
insert into carrito (id, cliente_id, producto_id) values (6, 5, 8);
insert into carrito (id, cliente_id, producto_id) values (7, 8, 10);
insert into carrito (id, cliente_id, producto_id) values (8, 8, 1);
insert into carrito (id, cliente_id, producto_id) values (9, 5, 10);
insert into carrito (id, cliente_id, producto_id) values (10, 3, 9);

-- CarritoItem
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (1, 4, 9, 1);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (2, 3, 1, 50);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (3, 7, 9, 48);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (4, 4, 4, 59);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (5, 6, 9, 81);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (6, 5, 7, 77);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (7, 9, 6, 37);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (8, 6, 1, 51);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (9, 3, 1, 66);
insert into carritoitem (id, carrito_id, producto_id, cantidad) values (10, 7, 2, 50);

-- Metodo_Pago
insert into metodo_pago (id, nombre) values (1, 'Eveleen');
insert into metodo_pago (id, nombre) values (2, 'Ivonne');
insert into metodo_pago (id, nombre) values (3, 'Rhys');
insert into metodo_pago (id, nombre) values (4, 'Heda');
insert into metodo_pago (id, nombre) values (5, 'Khalil');
insert into metodo_pago (id, nombre) values (6, 'Carolina');
insert into metodo_pago (id, nombre) values (7, 'Grethel');
insert into metodo_pago (id, nombre) values (8, 'Vicki');
insert into metodo_pago (id, nombre) values (9, 'Jared');
insert into metodo_pago (id, nombre) values (10, 'Imogen');

-- Estado_Pago
insert into estado_pago (id, nombre) values (1, 'Warde');
insert into estado_pago (id, nombre) values (2, 'Stanwood');
insert into estado_pago (id, nombre) values (3, 'Wandie');
insert into estado_pago (id, nombre) values (4, 'Cynthia');
insert into estado_pago (id, nombre) values (5, 'Felicio');
insert into estado_pago (id, nombre) values (6, 'Katerine');
insert into estado_pago (id, nombre) values (7, 'Ashlin');
insert into estado_pago (id, nombre) values (8, 'Cathrine');
insert into estado_pago (id, nombre) values (9, 'Dyna');
insert into estado_pago (id, nombre) values (10, 'Tab');

-- Pedido
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (1, 2, 7, 6, 9, 'Apt 207');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (2, 3, 8, 5, 9, 'Suite 72');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (3, 9, 5, 10, 1, '3rd Floor');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (4, 4, 10, 3, 1, 'Suite 68');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (5, 6, 8, 1, 4, '11th Floor');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (6, 6, 7, 7, 9, '9th Floor');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (7, 5, 6, 10, 6, 'PO Box 54704');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (8, 10, 7, 10, 9, 'Suite 56');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (9, 9, 9, 8, 7, 'Suite 7');
insert into pedido (id, cliente_id, carrito_id, metodo_pago_id, estado_pago_id, direccion_envio) values (10, 10, 7, 1, 9, 'Apt 219');

-- Rol
INSERT INTO rol (nombre, color, permiso_categoria, permiso_producto, permiso_cliente, permiso_usuario, permiso_rol) VALUES ('Administrador', '000000', 15, 15, 15, 15, 15);
INSERT INTO rol (nombre, color, permiso_categoria, permiso_producto, permiso_cliente, permiso_usuario, permiso_rol) VALUES ('Moderador', '777777', 0, 3, 0, 2, 4);
INSERT INTO usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('jose', 'jose@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/users/default/default-avatar.jpg');
INSERT INTO usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('pepe', 'pepe@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 1, '/assets/img/users/default/default-avatar.jpg');
INSERT INTO usuario (usuario, correo, contrasenia, rol_id, ruta_imagen_perfil) VALUES ('antonio', 'antonio@gmail.com', '$2y$10$G3lxPK6tte2Jvh7qneHUHOxf3PCmHPxq8Njj5.x1l88Cre1gpdfGO', 2, '/assets/img/users/default/default-avatar.jpg');