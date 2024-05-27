import {USUARIO, V_USUARIO_ROL} from "../../../../api/models.js";
import {UserRow} from "../../components/row/rows/UserRow.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {Form} from "../../components/form/Form.js";
import {Field} from "../../components/form/models/Field.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-usuario-crear', USUARIO.USUARIO, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('correo-usuario-crear', USUARIO.CORREO, DataTypeField.EMAIL, TypeField.REQUIRED),
        new Field('contrasenia-usuario-crear', USUARIO.CONTRASENIA, DataTypeField.PASSWORD, TypeField.REQUIRED),
        new Field('role-usuario-crear', USUARIO.ROL_ID, DataTypeField.OTHER, TypeField.REQUIRED),
        new Field('imagen-usuario-crear', USUARIO.RUTA_IMAGEN_PERFIL, DataTypeField.IMAGE, TypeField.OPTIONAL)
    ];
    const modalUpdateFields = [
        new Field('id-usuario-actualizar', USUARIO.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-usuario-actualizar', USUARIO.USUARIO, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('correo-usuario-actualizar', USUARIO.CORREO, DataTypeField.EMAIL, TypeField.REQUIRED),
        new Field('role-usuario-actualizar', USUARIO.ROL_ID, DataTypeField.OTHER, TypeField.REQUIRED)
    ];
    const openUpdateUserCb = (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
        fields[2].field.val(tableColumns[2].textContent);
        const $campoRol = tableColumns[3].textContent;
        $('#role-usuario-actualizar option').each(function() {
            if ($(this).text() === $campoRol) {
                $(this).attr('selected', '');
                return false;
            }
        })
    }
    const modalCreate = new ModalCreate(
        modalCreateFields,
        (dataTable, fields, data) => {
        const roleSelectedOption = $(`#rol-usuario-crear option[value=${fields[3].field.val()}]`);

        const { entidades: entidad } = data;
        return {
            [V_USUARIO_ROL.USUARIO_ID]: entidad[V_USUARIO_ROL.USUARIO_ID],
            [V_USUARIO_ROL.USUARIO]: fields[0].field.val(),
            [V_USUARIO_ROL.CORREO]: fields[1].field.val(),
            [V_USUARIO_ROL.NOMBRE_ROL]: roleSelectedOption.text(),
            [V_USUARIO_ROL.COLOR_ROL]: roleSelectedOption.attr('color'),
            [V_USUARIO_ROL.RUTA_IMAGEN_PERFIL]: entidad[V_USUARIO_ROL.RUTA_IMAGEN_PERFIL]
        }
    });
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields) => {
        const id = dataTable.row($('tr[selected]')).index();
        dataTable.cell({row: id, column: 1}).data(fields[1].field.val()).draw();
        const $selectedOption = $('#role-usuario-actualizar option:selected');
        dataTable.cell({row: id, column: 3}).data($selectedOption.text());
        const spanColor = document.createElement('span');
        spanColor.style.backgroundColor = `#${$selectedOption.attr('color')}`;
        dataTable.cell({row: id, column: 4}).data(spanColor.outerHTML).draw();
    }, openUpdateUserCb);
    const form = await Form.initialize(
        END_POINTS.USUARIO.GET_ALL,
        USUARIO,
        UserRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateUserCb
    );
    modalCreate.setForm(form);
    modalUpdate.setForm(form);
})