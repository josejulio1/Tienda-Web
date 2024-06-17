import {Field} from "../../components/form/models/Field.js";
import {PRODUCTO} from "../../../../api/models.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {Table} from "../../components/form/Table.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";
import {ajax} from "../../../../api/ajax.js";
import {ProductRow} from "../../components/row/rows/ProductRow.js";

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-producto-crear', PRODUCTO.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('precio-producto-crear', PRODUCTO.PRECIO, DataTypeField.NUMBER, TypeField.REQUIRED),
        new Field('marca-producto-crear', PRODUCTO.MARCA_ID, DataTypeField.SELECT, TypeField.REQUIRED),
        new Field('stock-producto-crear', PRODUCTO.STOCK, DataTypeField.NUMBER, TypeField.REQUIRED),
        new Field('descripcion-producto-crear', PRODUCTO.DESCRIPCION, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('categoria-producto-crear', PRODUCTO.CATEGORIA_ID, DataTypeField.SELECT, TypeField.REQUIRED),
        new Field('imagen-producto-crear', PRODUCTO.RUTA_IMAGEN, DataTypeField.IMAGE, TypeField.REQUIRED)
    ];
    const modalUpdateFields = [
        new Field('id-producto-actualizar', PRODUCTO.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-producto-actualizar', PRODUCTO.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('precio-producto-actualizar', PRODUCTO.PRECIO, DataTypeField.NUMBER, TypeField.REQUIRED),
        new Field('descripcion-producto-actualizar', PRODUCTO.DESCRIPCION, DataTypeField.TEXT, TypeField.REQUIRED)
    ];
    const openUpdateProductCb = async (fields, tableColumns) => {
        const id = tableColumns[0].textContent;
        fields[0].field.val(id);
        fields[1].field.val(tableColumns[1].textContent);
        fields[2].field.val(parseFloat(tableColumns[2].textContent));
        const response = await ajax(`${END_POINTS.PRODUCTO.GET}?id=${id}`, 'GET');
        const { entidades: entidad } = response.data;
        fields[3].field.val(entidad[PRODUCTO.DESCRIPCION]);
    }
    const modalCreate = new ModalCreate(modalCreateFields, (fields, data) => {
        const { entidades: entidad } = data;
        const brandSelectedOption = $(`#marca-producto-crear option[value=${fields[2].field.val()}]`);
        const categorySelectedOption = $(`#categoria-producto-crear option[value=${fields[5].field.val()}]`);
        return {
            [PRODUCTO.ID]: entidad[PRODUCTO.ID],
            [PRODUCTO.NOMBRE]: fields[0].field.val(),
            [PRODUCTO.PRECIO]: fields[1].field.val(),
            [PRODUCTO.MARCA_ID]: brandSelectedOption.text(),
            [PRODUCTO.STOCK]: fields[3].field.val(),
            [PRODUCTO.RUTA_IMAGEN]: entidad[PRODUCTO.RUTA_IMAGEN],
            [PRODUCTO.CATEGORIA_ID]: categorySelectedOption.text()
        }
    });
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields, numRow) => {
        dataTable.cell({row: numRow, column: 1}).data(fields[1].field.val());
        dataTable.cell({row: numRow, column: 2}).data(fields[2].field.val());
    });
    const form = await Table.initialize(
        END_POINTS.PRODUCTO.GET_ALL,
        PRODUCTO,
        ProductRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateProductCb
    );
    modalCreate.setTable(form);
    modalUpdate.setTable(form);
})