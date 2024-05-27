import { Row } from "../Row.js";
import {V_USUARIO_ROL} from "../../../../../api/models.js";

export class UserRow extends Row {
    constructor(data, puedeBorrar) {
        const colorRolSpan = document.createElement('span');
        const perfilUsuarioImg = document.createElement('img');

        colorRolSpan.style.backgroundColor = `#${data[V_USUARIO_ROL.COLOR_ROL]}`;
        perfilUsuarioImg.src = data[V_USUARIO_ROL.RUTA_IMAGEN_PERFIL];
        perfilUsuarioImg.alt = 'Imagen de Perfil';
        perfilUsuarioImg.classList.add('img-perfil');
        perfilUsuarioImg.loading = 'lazy';

        // Eliminar campos innecesarios porque se crean en esta clase
        data[V_USUARIO_ROL.COLOR_ROL] = colorRolSpan.outerHTML;
        data[V_USUARIO_ROL.RUTA_IMAGEN_PERFIL] = perfilUsuarioImg.outerHTML;
        super(puedeBorrar, data);
    }


    /*constructor(usuarioId, usuario, correo, role, colorRol, imagenPerfil, puedeBorrar) {
        const colorRolSpan = document.createElement('span');
        const perfilUsuarioImg = document.createElement('img');

        colorRolSpan.style.backgroundColor = `#${colorRol}`;
        perfilUsuarioImg.src = imagenPerfil;
        perfilUsuarioImg.alt = 'Imagen de Perfil';
        perfilUsuarioImg.loading = 'lazy';

        super(puedeBorrar, 'eliminar-usuario', usuarioId, usuario, correo, role, colorRolSpan.outerHTML, perfilUsuarioImg.outerHTML);
    }*/
}