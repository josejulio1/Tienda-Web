import { Row } from "./Row.js";

export class RolRow extends Row {
    constructor(rolId, nombreRol, colorRol, puedeBorrar) {
        const colorRolSpan = document.createElement('span');

        colorRolSpan.style.backgroundColor = `#${colorRol}`;

        super(puedeBorrar, 'eliminar-rol', rolId, nombreRol, colorRolSpan.outerHTML);
    }
}