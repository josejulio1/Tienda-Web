import {Field} from "../../components/form/models/Field.js";
import {CLIENTE} from "../../../../api/models.js";
import {DataTypeField} from "../../components/form/enums/DataTypeField.js";
import {TypeField} from "../../components/form/enums/TypeField.js";
import {Form} from "../../components/form/Form.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {ModalUpdate} from "../../components/form/ModalUpdate.js";
import {ModalCreate} from "../../components/form/ModalCreate.js";
import {CustomerRow} from "../../components/row/rows/CustomerRow.js";

/*const $buttonVerPedidos = $('#mostrar-pedidos-cliente');
$buttonVerPedidos.on('click', async e => {
    e.preventDefault();
    const json = await select(V_PEDIDO.TABLE_NAME, [
        V_PEDIDO.ID,
        V_PEDIDO.NOMBRE_CLIENTE,
        V_PEDIDO.APELLIDOS_CLIENTE,
        V_PEDIDO.NOMBRE_PRODUCTO,
        V_PEDIDO.METODO_PAGO,
        V_PEDIDO.ESTADO_PAGO,
        V_PEDIDO.DIRECCION_ENVIO
    ], {
        [TYPE_FILTERS.EQUALS]: {
            [V_PEDIDO.CLIENTE_ID]: $('tr[selected]').children()[0].textContent
        }
    })
    $tablaPedidosDataTable.clear();
    for (const row of json) {
        $tablaPedidosDataTable.row.add([
            row[V_PEDIDO.ID],
            row[V_PEDIDO.NOMBRE_CLIENTE],
            row[V_PEDIDO.APELLIDOS_CLIENTE],
            row[V_PEDIDO.NOMBRE_PRODUCTO],
            row[V_PEDIDO.METODO_PAGO],
            row[V_PEDIDO.ESTADO_PAGO],
            row[V_PEDIDO.DIRECCION_ENVIO]
        ])
    }
    $tablaPedidosDataTable.draw();
    $modalVerPedidos.modal('show');
})*/

window.addEventListener('load', async () => {
    const modalCreateFields = [
        new Field('nombre-cliente-crear', CLIENTE.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('apellidos-cliente-crear', CLIENTE.APELLIDOS, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('telefono-cliente-crear', CLIENTE.TELEFONO, DataTypeField.PHONE, TypeField.REQUIRED),
        new Field('direccion-cliente-crear', CLIENTE.DIRECCION, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('correo-cliente-crear', CLIENTE.CORREO, DataTypeField.EMAIL, TypeField.REQUIRED),
        new Field('contrasenia-cliente-crear', CLIENTE.CONTRASENIA, DataTypeField.PASSWORD, TypeField.REQUIRED),
        new Field('imagen-cliente-crear', CLIENTE.RUTA_IMAGEN_PERFIL, DataTypeField.IMAGE, TypeField.OPTIONAL)
    ];
    const modalUpdateFields = [
        new Field('id-cliente-actualizar', CLIENTE.ID, DataTypeField.ID, TypeField.REQUIRED),
        new Field('nombre-cliente-actualizar', CLIENTE.NOMBRE, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('apellidos-cliente-actualizar', CLIENTE.APELLIDOS, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('telefono-cliente-actualizar', CLIENTE.TELEFONO, DataTypeField.PHONE, TypeField.REQUIRED),
        new Field('direccion-cliente-actualizar', CLIENTE.DIRECCION, DataTypeField.TEXT, TypeField.REQUIRED),
        new Field('contrasenia-cliente-actualizar', CLIENTE.CONTRASENIA, DataTypeField.PASSWORD, TypeField.OPTIONAL)
    ];
    const openUpdateProductCb = (fields, tableColumns) => {
        fields[0].field.val(tableColumns[0].textContent);
        fields[1].field.val(tableColumns[1].textContent);
        fields[2].field.val(tableColumns[2].textContent);
        fields[3].field.val(tableColumns[3].textContent);
        fields[4].field.val(tableColumns[4].textContent);
    }
    const modalCreate = new ModalCreate(modalCreateFields, (fields, data) => {
        const { entidades: entidad } = data;
        return {
            [CLIENTE.ID]: entidad[CLIENTE.ID],
            [CLIENTE.NOMBRE]: fields[0].field.val(),
            [CLIENTE.APELLIDOS]: fields[1].field.val(),
            [CLIENTE.TELEFONO]: fields[2].field.val(),
            [CLIENTE.DIRECCION]: fields[3].field.val(),
            [CLIENTE.CORREO]: fields[4].field.val(),
            [CLIENTE.RUTA_IMAGEN_PERFIL]: entidad[CLIENTE.RUTA_IMAGEN_PERFIL],
        }
    });
    const modalUpdate = new ModalUpdate(modalUpdateFields, (dataTable, fields) => {
        const id = dataTable.row($('tr[selected]')).index();
        dataTable.cell({row: id, column: 1}).data(fields[1].field.val()).draw();
        dataTable.cell({row: id, column: 2}).data(fields[2].field.val()).draw();
        dataTable.cell({row: id, column: 3}).data(fields[3].field.val()).draw();
        dataTable.cell({row: id, column: 4}).data(fields[4].field.val()).draw();
    });
    const form = await Form.initialize(
        END_POINTS.CLIENTE.GET_ALL,
        CLIENTE,
        CustomerRow.prototype,
        modalCreate,
        modalUpdate,
        openUpdateProductCb
    );
    modalCreate.setForm(form);
    modalUpdate.setForm(form);
})