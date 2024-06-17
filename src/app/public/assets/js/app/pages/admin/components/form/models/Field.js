/**
 * Clase wrapper encargada de guardar un tipo de campo en un input de la aplicación
 * @author josejulio1
 * @version 1.0
 */
export class Field {
    /**
     * Constructor de Field.
     * @param fieldId ID en el DOM del input al que se quiere referenciar
     * @param nameField Nombre de la columna equivalente en la base de datos. Usar el fichero models.js en api
     * @param dataTypeField Tipo de dato del campo, necesario para realizar su tipo respectivo de validación. Usar constantes de DataTypeField
     * @param typeField Tipo de escritura de campo, si es obligatorio o no. Usar constantes de TypeField
     */
    constructor(fieldId, nameField, dataTypeField, typeField) {
        this.field = $(`#${fieldId}`);
        this.fieldId = fieldId;
        this.nameField = nameField;
        this.dataTypeField = dataTypeField;
        this.typeField = typeField;
    }
}