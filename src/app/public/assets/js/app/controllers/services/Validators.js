import {DataTypeField} from "../../pages/admin/components/form/enums/DataTypeField.js";
import {TypeField} from "../../pages/admin/components/form/enums/TypeField.js";
import {PermissionCheckboxes} from "../../pages/admin/sections/role/models/PermissionCheckboxes.js";

export class Validators {
    static fieldToMethod = {
        [DataTypeField.ID]: [Validators.isNotXss],
        [DataTypeField.TEXT]: [Validators.isNotXss],
        [DataTypeField.EMAIL]: [Validators.isEmail, Validators.isNotXss],
        [DataTypeField.PASSWORD]: [Validators.isNotXss],
        [DataTypeField.PHONE]: [Validators.isPhone, Validators.isNotXss],
        [DataTypeField.NUMBER]: [Validators.isNotXss],
        [DataTypeField.IMAGE]: [Validators.isNotXss],
        [DataTypeField.SELECT]: [Validators.isNotXss]
    };

    static validateField(field) {
        const validators = Validators.fieldToMethod[field.dataTypeField];
        // En caso que sean CheckBoxes del formulario de Roles, validar de su forma

        // Si el campo es obligatorio, asegurarse de que no esté vacío
        if (field.typeField === TypeField.REQUIRED) {
            validators.push(Validators.isNotEmpty);
        }
        // Si es opcional y está vacío, no hacer nada
        if (field.typeField === TypeField.OPTIONAL && !field.field.val()) {
            return false;
        }
        let error = false;
        for (const validator of validators) {
            if (!validator(field.field.val())) {
                error = true;
                break;
            }
        }
        return error;
    }

    static isNotEmpty(text) {
        return !!text;
    }

    static isEmail(email) {
        return new RegExp(/^\w[a-zA-Z0-9.-]{1,126}@\w{1,124}\.\w{2,}$/).test(email)
    }

    static isNotXss(xss) {
        return !new RegExp(/<|>|&gt|&lt/).test(xss);
    }

    static isPhone(phone) {
        return new RegExp(/^\+[1-9][0-9]{0,2} [1-9][0-9]{8,15}$/).test(phone);
    }
}