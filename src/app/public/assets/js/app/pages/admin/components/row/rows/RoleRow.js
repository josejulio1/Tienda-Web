import { Row } from "../Row.js";

export class RoleRow extends Row {
    constructor(rolId, nombreRol, colorRol, puedeBorrar) {
        const colorRolSpan = document.createElement('span');

        colorRolSpan.style.backgroundColor = `#${colorRol}`;

        super(puedeBorrar, 'eliminar-role', rolId, nombreRol, colorRolSpan.outerHTML);
    }
}