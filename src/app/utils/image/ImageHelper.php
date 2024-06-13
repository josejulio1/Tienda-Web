<?php
namespace Util\Image;

/**
 * Clase Helper que permite crear, guardar o eliminar imágenes del servidor
 * @author josejulio1
 * @version 1.0
 */
class ImageHelper {
    /**
     * Guarda una imagen nueva en el servidor.
     * @param array $file Superglobal $_FILES del formulario
     * @param ImageFolder $image Información acerca de la carpeta de la imagen
     * @return string Devuelve la ruta raíz donde se encuentra la imagen guardada en la aplicación
     */
    public static function createImage(array $file, ImageFolder $image): string {
        $imagePathWithoutRoot = '/assets/img/internal/' . $image -> getTypeImage();
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . $imagePathWithoutRoot;
        $folderPath = $rootPath . '/' . $image -> getIdName();
        if (!file_exists($folderPath)) {
            mkdir($folderPath);
        }
        $imageName = uniqid() . '.' . explode('/', $file['type'])[1];
        $imagePath = $folderPath . '/' . $imageName;
        move_uploaded_file($file['tmp_name'], $imagePath);
        return $imagePathWithoutRoot . '/' . $image -> getIdName() . '/' . $imageName;
    }

    /**
     * Reemplaza una imagen existente por una nueva en el servidor.
     * @param array $file Superglobal $_FILES del formulario
     * @param string $imagePath Ruta raíz donde se encuentra alojada la imagen a reemplazar en el servidor
     * @return string Devuelve la ruta raíz donde se encuentra la imagen guardada en la aplicación o null si no la pudo guardar
     */
    public static function saveImage(array $file, string $imagePath): ?string {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
        if (!is_dir($rootPath)) {
            return null;
        }
        $files = scandir($rootPath);
        // Si la carpeta customers está vacía
        if (count($files) === 2) {
            return null;
        }
        // Eliminar la imagen que exista en la carpeta
        if (!self::deleteImage($imagePath . '/' . $files[2])) {
            return null;
        }
        mkdir($rootPath);
        $imageName = uniqid() . '.' . explode('/', $file['type'])[1];
        move_uploaded_file($file['tmp_name'], $rootPath . '/' . $imageName);
        return $imagePath . '/' . $imageName;
    }

    /**
     * Elimina una imagen alojada en el servidor y su carpeta que la contiene
     * @param string $imagePath Ruta raíz de la imagen a eliminar
     * @return bool True si la eliminó correctamente y false si no
     */
    public static function deleteImage(string $imagePath): bool {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
        if (!file_exists($rootPath) || $imagePath === DefaultPath::DEFAULT_IMAGE_PROFILE) {
            return false;
        }
        $folderPath = pathinfo($rootPath, PATHINFO_DIRNAME);
        $files = scandir($folderPath);
        unset($files[0]); // .
        unset($files[1]); // ..
        // Eliminar carpeta de forma recursiva
        foreach ($files as $file) {
            unlink($folderPath . '/' . $file);
        }
        return rmdir($folderPath);
    }
}