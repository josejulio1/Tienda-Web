import {DataTypeField} from "../pages/admin/components/form/enums/DataTypeField.js";
import {TypeField} from "../pages/admin/components/form/enums/TypeField.js";
import {Field} from "../pages/admin/components/form/models/Field.js";

/**
 * Clase que contiene tipos de validaciones para aplicar en los campos de entrada de la aplicación
 * @author josejulio1
 * @version 1.0
 */
export class Validators {
    static fieldToMethod = {
        [DataTypeField.ID]: [Validators.isNotXss],
        [DataTypeField.TEXT]: [Validators.isNotXss],
        [DataTypeField.EMAIL]: [Validators.isEmail, Validators.isNotXss],
        [DataTypeField.PASSWORD]: [Validators.isNotXss],
        [DataTypeField.PHONE]: [Validators.isPhone, Validators.isNotXss],
        [DataTypeField.NUMBER]: [Validators.isNotXss, Validators.isPositiveNumber],
        [DataTypeField.IMAGE]: [Validators.isNotXss],
        [DataTypeField.SELECT]: [Validators.isNotXss],
        [DataTypeField.COLOR]: [Validators.isNotXss]
    };

    /**
     * Valida un tipo de campo aplicando sus respectivos validadores.
     * @param field {Field} Tipo de campo
     * @returns {boolean} True si contiene errores y false si no los tiene
     */
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

    /**
     * Comprueba que el campo no esté vacío
     * @param text {string} Campo
     * @returns {boolean} True si no está vacío y false si lo está
     */
    static isNotEmpty(text) {
        return !!text;
    }

    /**
     * Comprueba que el campo sea un email o correo
     * @param email {string} Campo
     * @returns {boolean} True si es un email y false si no lo es
     */
    static isEmail(email) {
        return new RegExp(/^\w[a-zA-Z0-9.-]{1,126}@\w{1,124}\.\w{2,}$/).test(email);
    }

    /**
     * Comprueba que el campo no tenga XSS
     * @param xss {string} Campo
     * @returns {boolean} True si no contiene XSS y false si lo contiene
     */
    static isNotXss(xss) {
        return !new RegExp(/<|>|&gt|&lt/).test(xss);
    }

    /**
     * Comprueba que el campo sea un teléfono
     * @param phone {string} Campo
     * @returns {boolean} True si es un teléfono y false si no lo es
     */
    static isPhone(phone) {
        return new RegExp(/^\+[1-9][0-9]{0,2} [1-9][0-9]{8,15}$/).test(phone);
    }

    /**
     * Comprueba que el campo sea un número positivo
     * @param number {string} Campo
     * @returns {boolean} True si es un número positivo y false si no lo es
     */
    static isPositiveNumber(number) {
        return number > 0;
    }
}