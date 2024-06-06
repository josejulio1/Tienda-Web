import {ROL} from "../../../../../api/models.js";
import {InfoWindow} from "../../../../../components/InfoWindow.js";

export class PermissionCheckboxes {
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
     * @param $checkBoxCrear
     * @param $checkBoxActualizar
     * @param $checkBoxEliminar
     * @returns {boolean}
     */
    validatePermissions() {
        /*let strActualizar;
        const checkBoxCrearId = $checkBoxCrear.attr('id');
        if (checkBoxCrearId.includes('-actualizar')) {
            strActualizar = '-actualizar';
        }
        let $checkBoxVer;
        if (strActualizar) {
            $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}${strActualizar}`);
        } else {
            $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}`);
        }*/
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

    showError(nameField) {
        InfoWindow.make(`Debe tener el permiso Ver en ${this.mapPermissionToError[nameField]} marcado`)
    }

    /**
     * Convierte el permiso numérico a los CheckBoxes, marcando estos según si tengan el permiso o no
     * @param {number} permissionNumberVer Número de permiso
     * @param {HTMLInputElement} $checkBoxVer CheckBox Ver
     * @param {HTMLInputElement} $checkBoxCrear CheckBox Crear
     * @param {HTMLInputElement} $checkBoxActualizar CheckBox Actualizar
     * @param {HTMLInputElement} $checkBoxEliminar CheckBox Eliminar
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