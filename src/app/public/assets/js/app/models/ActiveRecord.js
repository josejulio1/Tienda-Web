import {ajax} from "../api/ajax.js";
import {END_POINTS} from "../api/end-points.js";

export class ActiveRecord {
    static tableName = '';

    static create() {
        ajax(END_POINTS.CLIENTE.CREATE);
    }
}