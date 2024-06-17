/**
 * Clase wrapper que envuelve un CheckBox del DOM para el panel de permisos de Rol
 * @author josejulio1
 * @version 1.0
 */
export class PermissionField {
    /**
     * Constructor de PermissionField.
     * @param fieldId ID del DOM donde se encuentra el input a referenciar
     * @param permission Tipo de permiso que representar el CheckBox. Utilizar constantes de TypePermissionField
     */
    constructor(fieldId, permission) {
        this.field = $(`#${fieldId}`);
        this.permission = permission;
    }
}