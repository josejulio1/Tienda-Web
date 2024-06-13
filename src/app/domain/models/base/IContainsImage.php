<?php
namespace Model\Base;

/**
 * Interfaz que debe implementarse en aquellos modelos que guarden imágenes, ya que los modelos deberán de implementar
 * cuál es la propiedad de la clase que guarda la imagen de la base de datos, para que cuando se elimine una fila,
 * se borre también la imagen.
 * @author josejulio1
 * @version 1.0
 */
interface IContainsImage {
    /**
     * Devuelve la ruta de la imagen donde se encuentra alojada en el servidor
     * @return string Ruta de la imagen en el servidor
     */
    function getImagePath(): string;
}