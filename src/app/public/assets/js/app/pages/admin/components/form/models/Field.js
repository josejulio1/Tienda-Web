export class Field {
    constructor(fieldId, nameField, dataTypeField, typeField) {
        this.field = $(`#${fieldId}`);
        this.fieldId = fieldId;
        this.nameField = nameField;
        this.dataTypeField = dataTypeField;
        this.typeField = typeField;
    }
}