export class PermissionCheckboxes {
    constructor(checkBoxes) {
        this.checkBoxes = checkBoxes;
        const mapPermissionToCheckbox = {};
        for (const checkBox of checkBoxes) {
            mapPermissionToCheckbox[checkBox.permission] = checkBox.field;
        }
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
     * Valida que los permisos sean correctos.
     * @param $checkBoxCrear
     * @param $checkBoxActualizar
     * @param $checkBoxEliminar
     * @returns {boolean}
     */
    validatePermissions($checkBoxCrear, $checkBoxActualizar, $checkBoxEliminar) {
        let strActualizar;
        const checkBoxCrearId = $checkBoxCrear.attr('id');
        if (checkBoxCrearId.includes('-actualizar')) {
            strActualizar = '-actualizar';
        }
        let $checkBoxVer;
        if (strActualizar) {
            $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}${strActualizar}`);
        } else {
            $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}`);
        }
        if ($checkBoxVer.prop('checked')) {
            return true;
        }

        if (($checkBoxCrear.prop('checked') || $checkBoxActualizar.prop('checked') || $checkBoxEliminar.prop('checked')) && $checkBoxVer.prop('checked')) {
            return true;
        }
        return false;
    }

    /**
     * Convierte el permiso numérico a los CheckBoxes, marcando estos según si tengan el permiso o no
     * @param {number} permissionNumber Número de permiso
     * @param {HTMLInputElement} $checkBoxVer CheckBox Ver
     * @param {HTMLInputElement} $checkBoxCrear CheckBox Crear
     * @param {HTMLInputElement} $checkBoxActualizar CheckBox Actualizar
     * @param {HTMLInputElement} $checkBoxEliminar CheckBoxx Eliminar
     */
    permissionNumberToCheckBox(permissionNumber) {
        const { checkBoxes } = this;
        for (const checkBox of checkBoxes) {
            if (permissionNumber & checkBox.permission) {
                checkBox.field.prop('checked', true);
            }
        }
    }

    /**
     * Marca el CheckBox "Ver Permiso" en caso de que se marque "Crear, Actualizar o Eliminar"
     * @param {Event} e CheckBox que accionó el evento
     * @returns En caso de que se haya desmarcado el CheckBox, no hará nada
     */
    checkVer(e) {
        const { target, target: { id } } = e;
        // Si se desmarca, no hacer nada
        if (!target.checked) {
            return;
        }
        // Si es del modal de actualizar, cambiar el ID para coger la referencia del modal de actualizar
        $(`#ver-permiso-${id.split('-')[2]}${id.includes('-actualizar') ? '-actualizar' : ''}`).prop('checked', true);
    }
}