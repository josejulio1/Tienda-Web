/**
 * Clase base que define el comportamiento base de una fila de una tabla.
 * Todas las filas que se quieran añadir a una clase Table para visualizarse
 * en la tabla deben heredar de esta clase y definir el DOM que tendrá la fila
 * @author josejulio1
 * @version 1.0
 */
export class Row {
    /**
     * Constructor de Row.
     * @param data {JSON} Columnas que deben definir cómo crear la fila. Se debe pasar un objeto JSON con
     * clave (siendo la clave el nombre de la columna) y el valor el dato que se debe dibujar. El dato debe de estar
     * envuelto en un elemento DOM
     * @param puedeBorrar {boolean} True si puede borrar y false si no. Si puede borrar, aparecerá una imagen de una
     * X que al pulsarlo borrará la fila
     */
    constructor(data, puedeBorrar) {
        this.elements = []
        const dataFields = Object.values(data);
        for (const dataField of dataFields) {
            // Comprobar si el campo no está vacío
            if (dataField) {
                this.elements.push(dataField);
            }
        }

        if (puedeBorrar) {
            const imgBorrar = document.createElement('img');
            imgBorrar.src = '/assets/img/web/svg/delete.svg';
            imgBorrar.alt = 'Borrar';
            imgBorrar.classList.add('eliminar');
            imgBorrar.setAttribute('value', this.elements[0]);
            this.elements.push(imgBorrar.outerHTML);
        }
    }

    /**
     * Obtiene un array con los DOM de cada columna
     * @returns {[]} Array con DOM de cada columna
     */
    getRow() {
        return this.elements;
    }
}