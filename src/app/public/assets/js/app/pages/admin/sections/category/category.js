import {Field} from "../../components/form/models/Field.js";
import {CATEGORIA} from "../../../../api/models.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {Table} from "../../components/form/Table.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";
import {CategoryRow} from "../../components/row/rows/CategoryRow.js";

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-categoria-crear', CATEGORIA.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED)
    ];
    const modalUpdateFields = [
        new Field('id-categoria-actualizar', CATEGORIA.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-categoria-actualizar', CATEGORIA.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED)
    ];
    const openUpdateBrandCb = (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
    }
    const modalCreate = new ModalCreate(modalCreateFields, (fields, data) => ({
        [CATEGORIA.ID]: data.entidades[CATEGORIA.ID],
        [CATEGORIA.NOMBRE]: fields[0].field.val()
    }));
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields, numRow) => {
        dataTable.cell({row: numRow, column: 1}).data(fields[1].field.val());
    });
    const form = await Table.initialize(
        END_POINTS.CATEGORIA.GET_ALL,
        CATEGORIA,
        CategoryRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateBrandCb
    );
    modalCreate.setTable(form);
    modalUpdate.setTable(form);
})