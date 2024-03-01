export const USUARIO = {
    TABLE_NAME: 'Usuario',
    ID: 'id',
    USUARIO: 'usuario',
    CORREO: 'correo',
    CONTRASENIA: 'contrasenia',
    ROL_ID: 'rol_id',
    RUTA_IMAGEN_PERFIL: 'ruta_imagen_perfil'
}

export const V_USUARIO_ROL = {
    TABLE_NAME: 'v_usuario_rol',
    USUARIO_ID: 'usuario_id',
    USUARIO: 'usuario',
    CORREO: 'correo',
    CONTRASENIA: 'contrasenia',
    NOMBRE_ROL: 'nombre_rol',
    COLOR_ROL: 'color_rol',
    RUTA_IMAGEN_PERFIL: 'ruta_imagen_perfil'
}

export const CATEGORIA = {
    TABLE_NAME: 'Categoria',
    ID: 'id',
    NOMBRE: 'nombre'
}

export const PRODUCTO = {
    TABLE_NAME: 'Producto',
    ID: 'id',
    NOMBRE: 'nombre',
    DESCRIPCION: 'descripcion',
    PRECIO: 'precio',
    MARCA: 'marca',
    STOCK: 'stock',
    RUTA_IMAGEN: 'ruta_imagen',
    CATEGORIA_ID: 'categoria_id'
}

export const V_PRODUCTO_CATEGORIA = {
    TABLE_NAME: 'v_producto_categoria',
    PRODUCTO_ID: 'producto_id',
    NOMBRE: 'nombre',
    DESCRIPCION: 'descripcion',
    PRECIO: 'precio',
    MARCA: 'marca',
    STOCK: 'stock',
    RUTA_IMAGEN: 'ruta_imagen',
    NOMBRE_CATEGORIA: 'nombre_categoria'
}

export const ROL = {
    TABLE_NAME: 'Rol',
    ID: 'id',
    NOMBRE: 'nombre',
    COLOR: 'color',
    PERMISO_CATEGORIA: 'permiso_categoria',
    PERMISO_PRODUCTO: 'permiso_producto',
    PERMISO_CLIENTE: 'permiso_cliente',
    PERMISO_USUARIO: 'permiso_usuario',
    PERMISO_ROL: 'permiso_rol'
}

export const CLIENTE = {
    TABLE_NAME: 'Cliente',
    ID: 'id',
    NOMBRE: 'nombre',
    APELLIDOS: 'apellidos',
    TELEFONO: 'telefono',
    DIRECCION: 'direccion',
    CORREO: 'correo',
    CONTRASENIA: 'contrasenia',
    RUTA_IMAGEN_PERFIL: 'ruta_imagen_perfil'
}

export const CARRITO_ITEM = {
    TABLE_NAME: 'Carrito_Item',
    PRODUCTO_ID: 'producto_id',
    CLIENTE_ID: 'cliente_id',
    CANTIDAD: 'cantidad'
}

export const V_PEDIDO = {
    TABLE_NAME: 'v_pedido',
    ID: 'id',
    CLIENTE_ID: 'cliente_id',
    NOMBRE_CLIENTE: 'nombre_cliente',
    APELLIDOS_CLIENTE: 'apellidos_cliente',
    NOMBRE_PRODUCTO: 'nombre_producto',
    METODO_PAGO: 'metodo_pago',
    ESTADO_PAGO: 'estado_pago',
    DIRECCION_ENVIO: 'direccion_envio'
}

export const V_CARRITO_CLIENTE = {
    TABLE_NAME: 'v_carrito_cliente',
    CLIENTE_ID: 'cliente_id',
    NOMBRE_PRODUCTO: 'nombre_producto',
    PRECIO_PRODUCTO: 'precio_producto',
    RUTA_IMAGEN_PRODUCTO: 'ruta_imagen_producto'
}

export const V_PRODUCTO_VALORACION_PROMEDIO = {
    TABLE_NAME: 'v_producto_valoracion_promedio',
    ID: 'id',
    NOMBRE: 'nombre',
    RUTA_IMAGEN: 'ruta_imagen',
    PRECIO: 'precio',
    VALORACION_PROMEDIO: 'valoracion_promedio'
}

export const V_COMENTARIO_CLIENTE_PRODUCTO = {
    TABLE_NAME: 'v_comentario_cliente_producto',
    PRODUCTO_ID: 'producto_id',
    NOMBRE_CLIENTE: 'nombre_cliente',
    APELLIDOS_CLIENTE: 'apellidos_cliente',
    RUTA_IMAGEN_PERFIL: 'ruta_imagen_perfil',
    COMENTARIO: 'comentario',
    NUM_ESTRELLAS: 'num_estrellas'
}