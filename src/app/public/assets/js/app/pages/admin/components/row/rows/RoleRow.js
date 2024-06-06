import { Row } from "../Row.js";
import {ROL} from "../../../../../api/models.js";

export class RoleRow extends Row {
    constructor(data, puedeBorrar) {
        const colorRolSpan = document.createElement('span');

        const color = data[ROL.COLOR];
        colorRolSpan.style.backgroundColor = color.includes('#') ? color : `#${color}`;

        data[ROL.COLOR] = colorRolSpan.outerHTML;
        super(puedeBorrar, data);
    }
}