import {ROL} from "../../../../../api/models.js";
import {InfoWindow} from "../../../../../components/InfoWindow.js";
import {PermissionField} from "./PermissionField.js";

/**
 * Clase que agrupa un conjunto de CheckBox para poder darle funcionalidad en el panel rol de administración
 * @author josejulio1
 * @version 1.0
 */
export class PermissionCheckboxes {
    /**
     * Constructor de PermissionCheckboxes.
     * @param nameField {string} Nombre de la columna equivalente al permiso en la base de datos
     * @param verPermiso {PermissionField} Permiso para ver
     * @param crearPermiso {PermissionField} Permiso para crear
     * @param actualizarPermiso {PermissionField} Permiso para actualizar
     * @param eliminarPermiso {PermissionField} Permiso para eliminar
     */
    constructor(nameField, verPermiso, crearPermiso, actualizarPermiso, eliminarPermiso) {
        this.nameField = nameField;
        this.checkBoxes = [verPermiso, crearPermiso, actualizarPermiso, eliminarPermiso];
        this.mapPermissionToError = {
            [ROL.PERMISO_USUARIO]: 'Usuario',
            [ROL.PERMISO_PRODUCTO]: 'Producto',
            [ROL.PERMISO_MARCA]: 'Marca',
            [ROL.PERMISO_CATEGORIA]: 'Categoría',
            [ROL.PERMISO_CLIENTE]: 'Cliente',
            [ROL.PERMISO_ROL]: 'Rol'
        };
    }

    /**
     * Obtiene el número de permiso en total de todos los CheckBox
     * @returns {number} Devuelve el número de permiso total
     */
    getPermissions() {
        let permissionNumber = 0;
        const { checkBoxes } = this;
        for (const checkBox of checkBoxes) {
            if (checkBox.field.prop('checked')) {
                permissionNumber += checkBox.permission;
            }
        }
        return permissionNumber;
    }

    /**
     * Establece todos los CheckBox en desactivados
     */
    clearCheckboxes() {
        const { checkBoxes } = this;
        for (const checkBox of checkBoxes) {
            checkBox.field.prop('checked', false);
        }
    }

    /**
     * Valida que los permisos sean correctos. Los permisos serán correctos en caso de que
     * se tenga marcado el campo "ver" siempre que haya alguna otra opción seleccionada como "crear",
     * ya que no será posible tener desmarcado el campo "ver" y marcado el campo "crear"
     * @returns {boolean} Devuelve true si los permisos son correctos y false si no lo son
     */
    validatePermissions() {
        const { checkBoxes } = this;
        // Validar que todos los CheckBoxes estén vacíos
        let empty = true;
        for (const checkBox of checkBoxes) {
            if (checkBox.field.prop('checked')) {
                empty = false;
            }
        }
        if (empty) {
            return true;
        }
        if (checkBoxes[0].field.prop('checked')) {
            return true;
        }
        return !!((checkBoxes[1].field.prop('checked') || checkBoxes[2].field.prop('checked') || checkBoxes[3].field.prop('checked')) && checkBoxes[0].field.prop('checked'));
    }

    /**
     * Muestra el error de un permiso en el componente InfoWindow
     * @param nameField
     */
    showError(nameField) {
        InfoWindow.make(`Debe tener el permiso Ver en ${this.mapPermissionToError[nameField]} marcado`)
    }

    /**
     * Convierte el permiso numérico a los CheckBoxes, marcando estos según si tengan el permiso o no
     * @param permissionsNumber {number} Número de permiso a convertir a CheckBox
     */
    permissionNumberToCheckBoxes(permissionsNumber) {
        const { checkBoxes, checkBoxes: { length: numCheckBoxes } } = this;
        for (let i = 0; i < numCheckBoxes; i++) {
            if (permissionsNumber & checkBoxes[i].permission) {
                checkBoxes[i].field.prop('checked', true);
            }
        }
    }
}