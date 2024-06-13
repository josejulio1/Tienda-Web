<?php
namespace Util\Image;

/**
 * Clase que define con constantes los distintos nombres de carpeta que se pueden guardar o eliminar imágenes
 * en el servidor. Se utiliza con la clase wrapper {@see ImageFolder}
 * @author josejulio1
 * @version 1.0
 */
class TypeImage {
    public const PROFILE_USER = 'users';
    public const PROFILE_CUSTOMER = 'customers';
    public const PRODUCT = 'products';
}