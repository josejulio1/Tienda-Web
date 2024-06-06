<?php
namespace Util\Image;

class ImageFolder {
    private string $idName;
    private string $typeImage;

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