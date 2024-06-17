import {Field} from "../../components/form/models/Field.js";
import {MARCA} from "../../../../api/models.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {Table} from "../../components/form/Table.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {BrandRow} from "../../components/row/rows/BrandRow.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-marca-crear', MARCA.MARCA, DataTypeField.TEXT, TypeField.REQUIRED)
    ];
    const modalUpdateFields = [
        new Field('id-marca-actualizar', MARCA.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-marca-actualizar', MARCA.MARCA, DataTypeField.TEXT, TypeField.REQUIRED)
    ];
    const openUpdateBrandCb = (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
    }
    const modalCreate = new ModalCreate(modalCreateFields, (fields, data) => ({
        [MARCA.ID]: data.entidades[MARCA.ID],
        [MARCA.MARCA]: fields[0].field.val()
    }));
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields, numRow) => {
        dataTable.cell({row: numRow, column: 1}).data(fields[1].field.val());
    });
    const form = await Table.initialize(
        END_POINTS.MARCA.GET_ALL,
        MARCA,
        BrandRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateBrandCb
    );
    modalCreate.setTable(form);
    modalUpdate.setTable(form);
})