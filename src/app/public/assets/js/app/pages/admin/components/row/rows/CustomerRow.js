import { Row } from "../Row.js";
import {CLIENTE} from "../../../../../api/models.js";

/**
 * Crea una fila para mostrar los datos de un Cliente
 * @author josejulio1
 * @version 1.0
 */
export class CustomerRow extends Row {
    constructor(data, puedeBorrar) {
        const perfilUsuarioImg = document.createElement('img');

        perfilUsuarioImg.src = data[CLIENTE.RUTA_IMAGEN_PERFIL];
        perfilUsuarioImg.alt = 'Imagen de Perfil';
        perfilUsuarioImg.classList.add('img-perfil');
        perfilUsuarioImg.loading = 'lazy';

        data[CLIENTE.RUTA_IMAGEN_PERFIL] = perfilUsuarioImg.outerHTML;
        super(data, puedeBorrar);
    }
}