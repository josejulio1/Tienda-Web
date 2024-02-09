export const USUARIO = {
    TABLE_NAME: 'usuario',
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
    TABLE_NAME: 'categoria',
    ID: 'id',
    NOMBRE: 'nombre'
}

export const PRODUCTO = {
    TABLE_NAME: 'producto',
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
    TABLE_NAME: 'rol',
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
    TABLE_NAME: 'cliente',
    ID: 'id',
    NOMBRE: 'nombre',
    APELLIDOS: 'apellidos',
    TELEFONO: 'telefono',
    DIRECCION: 'direccion',
    CORREO: 'correo',
    CONTRASENIA: 'contrasenia',
    RUTA_IMAGEN_PERFIL: 'ruta_imagen_perfil'
}