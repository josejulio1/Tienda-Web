import {Field} from "../../components/form/models/Field.js";
import {ROL} from "../../../../api/models.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {Form} from "../../components/form/Form.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {RoleRow} from "../../components/row/rows/RoleRow.js";
import {PermissionField} from "./models/PermissionField.js";
import {PermissionCheckboxes} from "./models/PermissionCheckboxes.js";

window.addEventListener('load', () => {
    const modalCreateFields = [
        new Field('nombre-rol-crear', ROL.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('color-rol-crear', ROL.COLOR, DataTypeField.OTHER, TypeField.REQUIRED),
        new PermissionCheckboxes(
            new PermissionField('marcar-todo-usuario'),
            new PermissionField('ver-permiso-usuario'),
            new PermissionField('crear-permiso-usuario'),
            new PermissionField('actualizar-permiso-usuario'),
            new PermissionField('eliminar-permiso-usuario'),
        )
    ];
    const modalUpdateFields = [
        new Field('nombre-rol-actualizar', ROL.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('color-rol-actualizar', ROL.COLOR, DataTypeField.OTHER, TypeField.REQUIRED)
    ];
    const openUpdateRoleCb = (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
    }
    const modalCreate = new ModalCreate(modalCreateFields, (dataTable, fields) => {

    });
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields) => {

    });
    const form = Form.initialize(
        END_POINTS.ROL.GET_ALL,
        ROL,
        RoleRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateRoleCb
    )
    modalCreate.setForm(form);
    modalUpdate.setForm(form);
})