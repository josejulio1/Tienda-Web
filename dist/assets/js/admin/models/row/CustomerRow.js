import { Row } from "./Row.js";

export class CustomerRow extends Row {
    constructor(clienteId, nombre, apellidos, telefono, direccion, correo, imagenPerfil, puedeBorrar) {
        const perfilUsuarioImg = document.createElement('img');

        perfilUsuarioImg.src = imagenPerfil;
        perfilUsuarioImg.alt = 'Imagen de Perfil';
        perfilUsuarioImg.loading = 'lazy';

        super(puedeBorrar, 'eliminar-cliente', clienteId, nombre, apellidos, telefono, direccion, correo, perfilUsuarioImg.outerHTML);
    }
}