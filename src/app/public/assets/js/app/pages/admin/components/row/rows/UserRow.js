import { Row } from "../Row.js";
import {V_USUARIO_ROL} from "../../../../../api/models.js";

/**
 * Crea una fila para mostrar los datos de una Usuario
 * @author josejulio1
 * @version 1.0
 */
export class UserRow extends Row {
    constructor(data, puedeBorrar) {
        const colorRolSpan = document.createElement('span');
        const perfilUsuarioImg = document.createElement('img');

        colorRolSpan.style.backgroundColor = `#${data[V_USUARIO_ROL.COLOR_ROL]}`;
        perfilUsuarioImg.src = data[V_USUARIO_ROL.RUTA_IMAGEN_PERFIL];
        perfilUsuarioImg.alt = 'Imagen de Perfil';
        perfilUsuarioImg.classList.add('img-perfil');
        perfilUsuarioImg.loading = 'lazy';

        data[V_USUARIO_ROL.COLOR_ROL] = colorRolSpan.outerHTML;
        data[V_USUARIO_ROL.RUTA_IMAGEN_PERFIL] = perfilUsuarioImg.outerHTML;
        super(data, puedeBorrar);
    }
}