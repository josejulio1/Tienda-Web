export class Row {
    constructor(puedeBorrar, data) {
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

    getRow() {
        return this.elements;
    }
}