<?php
namespace Util\Image;

/**
 * Clase wrapper que guarda información acerca de un directorio o carpeta que guarda imágenes
 * @author josejulio1
 * @version 1.0
 */
class ImageFolder {
    private string $idName;
    private string $typeImage;

    /**
     * Constructor de ImageFolder.
     * @param string $idName Nombre de la carpeta
     * @param string $typeImage Tipo de imagen que guarda la carpeta. Usar constantes de {@see TypeImage}
     */
    public function __construct(string $idName, string $typeImage) {
        $this -> idName = $idName;
        $this -> typeImage = $typeImage;
    }

    public function getIdName(): string {
        return $this -> idName;
    }

    public function getTypeImage(): string {
        return $this -> typeImage;
    }
}