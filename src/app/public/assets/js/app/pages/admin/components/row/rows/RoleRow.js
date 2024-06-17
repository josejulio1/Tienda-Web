import { Row } from "../Row.js";
import {ROL} from "../../../../../api/models.js";

/**
 * Crea una fila para mostrar los datos de un Rol
 * @author josejulio1
 * @version 1.0
 */
export class RoleRow extends Row {
    constructor(data, puedeBorrar) {
        const colorRolSpan = document.createElement('span');

        const color = data[ROL.COLOR];
        colorRolSpan.style.backgroundColor = color.includes('#') ? color : `#${color}`;

        data[ROL.COLOR] = colorRolSpan.outerHTML;
        super(data, puedeBorrar);
    }
}