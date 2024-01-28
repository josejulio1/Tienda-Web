export class Row {
    constructor(puedeBorrar, ...fields) {
        this.elements = []
        for (const field of fields) {
            this.elements.push(field);
        }

        if (puedeBorrar) {
            const imgBorrar = document.createElement('img');
            imgBorrar.src = '/assets/img/web/svg/delete.svg';
            imgBorrar.alt = 'Borrar';
            imgBorrar.classList.add('eliminar', 'eliminar-usuario');
            imgBorrar.setAttribute('value', fields[0]);
            this.elements.push(imgBorrar.outerHTML);
        }
    }

    getRow() {
        return this.elements;
    }
}