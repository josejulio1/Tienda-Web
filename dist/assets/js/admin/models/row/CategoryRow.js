import { Row } from "./Row.js";

export class CategoryRow extends Row {
    constructor(categoriaId, nombreCategoria, permisoBorrar) {
        super(permisoBorrar, categoriaId, nombreCategoria);
    }
}