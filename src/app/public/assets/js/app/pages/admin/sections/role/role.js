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
import {rgbToHex} from "./utils/rgb-to-hex-converter.js";
import {ajax} from "../../../../api/ajax.js";
import {PERMISSIONS} from "../../permissions/permissions.js";

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-rol-crear', ROL.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('color-rol-crear', ROL.COLOR, DataTypeField.SELECT, TypeField.REQUIRED),
        new PermissionCheckboxes(
            ROL.PERMISO_USUARIO,
            new PermissionField('ver-permiso-usuario', PERMISSIONS.READ),
            new PermissionField('crear-permiso-usuario', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-usuario', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-usuario', PERMISSIONS.DELETE),
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_PRODUCTO,
            new PermissionField('ver-permiso-producto', PERMISSIONS.READ),
            new PermissionField('crear-permiso-producto', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-producto', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-producto', PERMISSIONS.DELETE),
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_MARCA,
            new PermissionField('ver-permiso-marca', PERMISSIONS.READ),
            new PermissionField('crear-permiso-marca', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-marca', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-marca', PERMISSIONS.DELETE),
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_CATEGORIA,
            new PermissionField('ver-permiso-categoria', PERMISSIONS.READ),
            new PermissionField('crear-permiso-categoria', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-categoria', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-categoria', PERMISSIONS.DELETE),
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_CLIENTE,
            new PermissionField('ver-permiso-cliente', PERMISSIONS.READ),
            new PermissionField('crear-permiso-cliente', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-cliente', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-cliente', PERMISSIONS.DELETE),
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_ROL,
            new PermissionField('ver-permiso-rol', PERMISSIONS.READ),
            new PermissionField('crear-permiso-rol', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-rol', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-rol', PERMISSIONS.DELETE),
        )
    ];
    const modalUpdateFields = [
        new Field('id-rol-actualizar', ROL.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-rol-actualizar', ROL.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('color-rol-actualizar', ROL.COLOR, DataTypeField.SELECT, TypeField.REQUIRED),
        new PermissionCheckboxes(
            ROL.PERMISO_USUARIO,
            new PermissionField('ver-permiso-usuario-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-usuario-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-usuario-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-usuario-actualizar', PERMISSIONS.DELETE)
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_PRODUCTO,
            new PermissionField('ver-permiso-producto-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-producto-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-producto-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-producto-actualizar', PERMISSIONS.DELETE)
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_MARCA,
            new PermissionField('ver-permiso-marca-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-marca-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-marca-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-marca-actualizar', PERMISSIONS.DELETE)
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_CATEGORIA,
            new PermissionField('ver-permiso-categoria-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-categoria-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-categoria-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-categoria-actualizar', PERMISSIONS.DELETE)
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_CLIENTE,
            new PermissionField('ver-permiso-cliente-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-cliente-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-cliente-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-cliente-actualizar', PERMISSIONS.DELETE)
        ),
        new PermissionCheckboxes(
            ROL.PERMISO_ROL,
            new PermissionField('ver-permiso-rol-actualizar', PERMISSIONS.READ),
            new PermissionField('crear-permiso-rol-actualizar', PERMISSIONS.CREATE),
            new PermissionField('actualizar-permiso-rol-actualizar', PERMISSIONS.UPDATE),
            new PermissionField('eliminar-permiso-rol-actualizar', PERMISSIONS.DELETE)
        )
    ];
    const openUpdateRoleCb = async (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
        fields[2].field.val(`#${rgbToHex(tableColumns[2].children[0].style.backgroundColor)}`);
        const formData = new FormData();
        formData.append(ROL.ID, tableColumns[0].textContent);
        const response = await ajax(END_POINTS.ROL.GET_PERMISSIONS, 'POST', formData, false);
        const { data: { permissions } } = response;
        // Convertir el permiso numérico a los CheckBoxes (check si tienen permisos)
        let i = 0;
        for (const field of fields) {
            if (field instanceof PermissionCheckboxes) {
                field.clearCheckboxes();
                field.permissionNumberToCheckBoxes(permissions[i++]);
            }
        }
    }
    const modalCreate = new ModalCreate(modalCreateFields, (fields, data) => ({
        [ROL.ID]: data.entidades[ROL.ID],
        [ROL.NOMBRE]: fields[0].field.val(),
        [ROL.COLOR]: fields[1].field.val()
    }));
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields) => {
        const id = dataTable.row($('tr[selected]')).index();
        dataTable.cell({row: id, column: 1}).data(fields[1].field.val());
        const spanColor = document.createElement('span');
        spanColor.style.backgroundColor = fields[2].field.val();
        dataTable.cell({row: id, column: 2}).data(spanColor.outerHTML);
        /*$campoNombreRolActualizar.val(children[1].textContent);
        $campoColorActualizar.val(`#${rgbToHex(children[2].children[0].style.backgroundColor)}`);
        const permissions = await select(ROL.TABLE_NAME, [
            ROL.PERMISO_USUARIO,
            ROL.PERMISO_PRODUCTO,
            ROL.PERMISO_MARCA,
            ROL.PERMISO_CATEGORIA,
            ROL.PERMISO_CLIENTE,
            ROL.PERMISO_ROL
        ], {
            [TYPE_FILTERS.EQUALS]: {
                [ROL.ID]: $('tr[selected]').children()[0].textContent
            }
        });
        clearCheckboxes(...allUpdateCheckBoxes);
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_USUARIO],
            $permisoVerActualizarUsuario,
            $permisoCrearActualizarUsuario,
            $permisoActualizarActualizarUsuario,
            $permisoEliminarActualizarUsuario
        );
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_PRODUCTO],
            $permisoVerActualizarProducto,
            $permisoCrearActualizarProducto,
            $permisoActualizarActualizarProducto,
            $permisoEliminarActualizarProducto
        );
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_MARCA],
            $permisoVerActualizarMarca,
            $permisoCrearActualizarMarca,
            $permisoActualizarActualizarMarca,
            $permisoEliminarActualizarMarca
        );
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_CATEGORIA],
            $permisoVerActualizarCategoria,
            $permisoCrearActualizarCategoria,
            $permisoActualizarActualizarCategoria,
            $permisoEliminarActualizarCategoria
        );
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_CLIENTE],
            $permisoVerActualizarCliente,
            $permisoCrearActualizarCliente,
            $permisoActualizarActualizarCliente,
            $permisoEliminarActualizarCliente
        );
        permissionNumberToCheckBox(
            permissions[0][ROL.PERMISO_ROL],
            $permisoVerActualizarRol,
            $permisoCrearActualizarRol,
            $permisoActualizarActualizarRol,
            $permisoEliminarActualizarRol
        );*/
    });
    const form = await Form.initialize(
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