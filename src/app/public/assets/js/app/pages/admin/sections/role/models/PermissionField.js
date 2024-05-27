export class PermissionField {
    constructor(fieldId, permission) {
        this.field = $(`#${fieldId}`);
        this.permission = permission;
    }
}