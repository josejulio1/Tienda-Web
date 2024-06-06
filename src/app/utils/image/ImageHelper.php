<?php
namespace Util\Image;

class ImageHelper {
    public static function createImage(array $file, ImageFolder $image): ?string {
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
        $imageName = uniqid() . '.' . explode('/', $file['type'])[1];
        move_uploaded_file($file['tmp_name'], $rootPath . '/' . $imageName);
        return $imagePath . '/' . $imageName;
    }

    public static function deleteImage(string $imagePath): bool {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
        if (!file_exists($rootPath) || $imagePath === DefaultPath::DEFAULT_IMAGE_PROFILE) {
            return false;
        }
        unlink($rootPath);
        return rmdir(pathinfo($rootPath, PATHINFO_DIRNAME));
    }
}