import {PEDIDO, V_PEDIDO} from "../../../../api/models.js";
import {ajax} from "../../../../api/ajax.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";
import {InfoWindow} from "../../../../components/InfoWindow.js";
import {PaymentStatus} from "./components/PaymentStatus.js";

const $modalVerPedidos = $('#modal-cliente-pedidos');
const $tablaPedidos = $('#tabla-pedidos').DataTable();

const $idClienteActualizar = $('#id-cliente-actualizar');
const $buttonVerPedidos = $('#mostrar-pedidos-cliente');

$buttonVerPedidos.on('click', async e => {
    e.preventDefault();
    const formData = new FormData();
    formData.append(V_PEDIDO.CLIENTE_ID, $idClienteActualizar.val());
    const response = await ajax(END_POINTS.PEDIDO.GET_ALL, 'POST', formData);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    const { data: { pedidos } } = response;
    $tablaPedidos.clear();
    for (const pedido of pedidos) {
        $tablaPedidos.row.add([
            pedido[V_PEDIDO.ID],
            pedido[V_PEDIDO.NOMBRE_PRODUCTO],
            pedido[V_PEDIDO.METODO_PAGO],
            await PaymentStatus.initialize(pedido[V_PEDIDO.ESTADO_PAGO]),
            pedido[V_PEDIDO.DIRECCION_ENVIO]
        ])
    }
    $tablaPedidos.draw();
    $modalVerPedidos.modal('show');
    // Asignar evento a los select de los estado de pago para cambiar el estado del pago de un pedido
    $('.estado-pago-select').on('change', async function() {
        const $column = $(this);
        const id = $column.closest('tr').children()[0].textContent;
        const estadoPagoSeleccionado = $column.val();
        const formData = new FormData();
        formData.append(PEDIDO.ID, id);
        formData.append(PEDIDO.ESTADO_PAGO_ID, estadoPagoSeleccionado);
        const response = await ajax(END_POINTS.PEDIDO.UPDATE, 'POST', formData);
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        // Modificar estado del pago de todos los pedidos con el mismo ID
        $('#tabla-pedidos tbody td:first-child').each(function() {
            if ($(this).html() === id) {
                $(this).closest('tr').find('select').val(estadoPagoSeleccionado);
            }
        })
        InfoWindow.make('Estado del pago actualizado correctamente', true);
    })
})