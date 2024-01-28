import { Row } from "./Row.js";

export class UserRow extends Row {
    constructor(usuarioId, usuario, correo, rol, colorRol, imagenPerfil, puedeBorrar) {
        const colorRolSpan = document.createElement('span');
        const perfilUsuarioImg = document.createElement('img');

        colorRolSpan.style.backgroundColor = `#${colorRol}`;
        perfilUsuarioImg.src = imagenPerfil;
        perfilUsuarioImg.alt = 'Imagen de Perfil';

        super(puedeBorrar, 'eliminar-usuario', usuarioId, usuario, correo, rol, colorRolSpan.outerHTML, perfilUsuarioImg.outerHTML);
    }
}