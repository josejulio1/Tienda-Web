<?php
namespace Util\API;

class HttpErrorMessages {
    public const INCORRECT_DATA = 'Datos incorrectos';
    public const NO_DELETE_LOGGED_USER = 'No puedes eliminar el usuario con el que tienes iniciada sesión';
    public const EXISTS = 'Ya existe el registro';
    public const UNKNOWN_ID = 'ID desconocido';
    public const INCORRECT_USER_OR_PASSWORD = 'Usuario o contraseña incorrectos';
    public const NO_ROWS = 'No se encontraron registros';
    public const SERVICE_UNAVAILABLE = 'No se pudo conectar con la base de datos. Inténtelo más tarde';
    public const NO_CUSTOMER_SESSION = 'Debes tener una cuenta para poder añadir un producto al carrito';
    public const NO_ADD_CART = 'No se pudo añadir el producto al carrito';
}