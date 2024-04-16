import { Row } from "./Row.js";

export class BrandRow extends Row {
    constructor(marcaId, nombreMarca, permisoBorrar) {
        super(permisoBorrar, 'eliminar-marca', marcaId, nombreMarca);
    }
}