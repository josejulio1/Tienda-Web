import {ajax} from "../../../../api/ajax.js";
import {PERMISSIONS} from "../../permissions/permissions.js";
import {waitResolveModalChoice} from "../modals/modal-choice.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {$modalInfo, correctModal, incorrectModal} from "../modals/modal-info.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";

/**
 * Crea y gestiona una tabla del panel de administración. Importante que para que la tabla funcione
 * correctamente, debe de tener la etiqueta table un ID llamado "tabla"
 * @author josejulio1
 * @version 1.0
 */
export class Table {
    /**
     * Constructor de Table. Utilizar el método estático initialize para crear la tabla de forma asíncrona (await)
     * @param enumClass Objeto modelo de donde recogerá el nombre de la la tabla de la base de datos. Usar objetos de el fichero models.js en api
     * @param rowPrototype {Row} Prototype de una clase componente para crear el DOM de una fila de la tabla
     * @param hasUpdatePermissions {boolean} Si el usuario que tiene iniciado sesión tiene permisos para actualizar las filas de la tabla
     * @param hasDeletePermissions {boolean} Si el usuario que tiene iniciado sesión tiene permisos para eliminar las filas de la tabla
     * @param modalCreate {ModalCreate} Se debe adjuntar una dependencia de la clase ModalCreate. Permite comunicarse con el modal de crear una fila
     * @param modalUpdate {ModalUpdate} Se debe adjuntar una dependencia de la clase ModalUpdate. Permite comunicarse con el modal de eliminar una fila
     * @param openUpdateCallback {function} Callback que recibe dos parámetros, las filas introducidas en un modal, y las columnas de la tabla.
     * Se utiliza para definir cómo deben visualizarse en el modal de actualizar (ModalUpdate) los datos de la fila pulsada
     */
    constructor(enumClass, rowPrototype, hasUpdatePermissions, hasDeletePermissions, modalCreate, modalUpdate, openUpdateCallback) {
        this.dataTable = $('#tabla').DataTable();
        this.enumClass = enumClass;
        this.rowPrototype = rowPrototype;
        this.modalUpdate = modalUpdate;
        this.openUpdateCallback = openUpdateCallback;
        this.hasUpdatePermissions = hasUpdatePermissions;
        this.hasDeletePermissions = hasDeletePermissions;
        // Si tiene permisos de actualizar, añadir un evento
        if (hasUpdatePermissions) {
            this.dataTable.on('click', 'tbody tr', e => this.modalUpdate.openUpdateModal(e, openUpdateCallback));
        }
        this.dataTable.on('click', '.eliminar', e => this.deleteRow(e))
    }

    /**
     * Inicializa la tabla con los datos del backend, añadiendo las filas y eventos necesarios para que esta funcione.
     * @param getAllEndPoint {string} Ruta o end-point del backend donde recoger los datos para la tabla
     * @param enumClass Objeto modelo de donde recogerá el nombre de la la tabla de la base de datos. Usar objetos de el fichero models.js en api
     * @param rowPrototype {Row} Prototype de una clase componente para crear el DOM de una fila de la tabla
     * @param modalCreate {ModalCreate} Se debe adjuntar una dependencia de la clase ModalCreate. Permite comunicarse con el modal de crear una fila
     * @param modalUpdate {ModalUpdate} Se debe adjuntar una dependencia de la clase ModalUpdate. Permite comunicarse con el modal de eliminar una fila
     * @param openUpdateCallback {function} Callback que recibe dos parámetros, las filas introducidas en un modal, y las columnas de la tabla.
     * Se utiliza para definir cómo deben visualizarse en el modal de actualizar (ModalUpdate) los datos de la fila pulsada
     * @returns {Promise<Table>} Devuelve una promesa con la clase que se debe hacer un await para esperar a que termine de recoger todos
     * los datos del backend. Después, se debe añadir como dependencia en las instancias de las clases ModalCreate y ModalUpdate usando
     * el método setForm
     */
    static async initialize(getAllEndPoint, enumClass, rowPrototype, modalCreate, modalUpdate, openUpdateCallback) {
        const response = await ajax(getAllEndPoint, 'GET');
        let { data: { entidades, hasUpdatePermissions, hasDeletePermissions } } = response;
        hasUpdatePermissions = hasUpdatePermissions !== PERMISSIONS.NO_PERMISSIONS;
        hasDeletePermissions = hasDeletePermissions !== PERMISSIONS.NO_PERMISSIONS;
        const form = new Table(enumClass, rowPrototype, hasUpdatePermissions, hasDeletePermissions, modalCreate, modalUpdate, openUpdateCallback);
        for (const entidad of entidades) {
            form.dataTable.row.add(
                new rowPrototype.constructor(entidad, hasDeletePermissions).getRow()
            );
        }
        form.dataTable.draw();
        return form;
    }

    /**
     * Elimina una fila pulsada de la tabla.
     * @param e {MouseEvent} Click que accionó el evento
     * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
     */
    async deleteRow(e) {
        e.stopPropagation();
        const selectedId = e.target.getAttribute('value');
        const modalChoiceResultOk = await waitResolveModalChoice();
        if (!modalChoiceResultOk) {
            return;
        }
        const response = await ajax(`${END_POINTS[this.enumClass.TABLE_NAME.toUpperCase()].DELETE}?id=${selectedId}`, 'DELETE');
        $modalInfo.modal('show');
        const $modalShow = $('.modal.show');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            $modalShow.modal('hide');
            incorrectModal(response.message);
            return;
        }
        $modalShow.modal('hide');
        this.dataTable.row(e.target.closest('tr')).remove().draw();
        correctModal(response.message);
    }
}