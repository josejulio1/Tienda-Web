import {PEDIDO} from "../../api/models.js";
import {ajax} from "../../api/ajax.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {InfoWindow} from "../../components/InfoWindow.js";
import {END_POINTS} from "../../api/end-points.js";
import {Validators} from "../../services/Validators.js";

// Fichero que tiene la lógica para realizar el pago

const TIPO_PAGO = {
    TARJETA: '1',
    PAYPAL: '2'
}

const $pagosButton = $('.pago__button');
// Pago Tarjeta
const $numTarjeta = $('#num-tarjeta');
const $fechaCaducidadMes = $('#fecha-caducidad-mes');
const $fechaCaducidadAnio = $('#fecha-caducidad-anio');
const $codigoSeguridad = $('#codigo-seguridad');

// Pago PayPal
const $correo = $('#correo');

// Facturación
const $direccion = $('#direccion');

const $pagar = $('#pagar');

$pagosButton.on('click', function() {
    if ($(this).hasClass('pago__seleccionado')) {
        return;
    }
    $('.pago__seleccionado').removeClass('pago__seleccionado');
    $(this).addClass('pago__seleccionado');
    $('.tipo__pago:not(.hide)').addClass('hide');
    $(`.tipo__pago.${$(this).attr('id')}`).removeClass('hide');
})

$pagar.on('click', async () => {
    let hayErrores = false, response;
    const formData = new FormData();
    const $pagoSeleccionado = $('.pago__seleccionado').attr('pago-id');
    if ($pagoSeleccionado === TIPO_PAGO.TARJETA) {
        const numTarjeta = $numTarjeta.val();
        if (!numTarjeta || numTarjeta.length !== 16) {
            $numTarjeta.next().removeClass('hide');
            hayErrores = true;
        }

        const fechaCaducidadMes = $fechaCaducidadMes.val();
        if (!fechaCaducidadMes || (fechaCaducidadMes < 1 || fechaCaducidadMes > 12)) {
            $fechaCaducidadMes.next().removeClass('hide');
            hayErrores = true;
        }

        const fechaCaducidadAnio = $fechaCaducidadAnio.val();
        if (!fechaCaducidadAnio || (fechaCaducidadAnio < (new Date().getFullYear() % 100))) {
            $fechaCaducidadAnio.next().removeClass('hide');
            hayErrores = true;
        }

        const codigoSeguridad = $codigoSeguridad.val();
        if (!codigoSeguridad) {
            $codigoSeguridad.next().removeClass('hide');
            hayErrores = true;
        }
    } else {
        const correo = $correo.val();
        if (!correo || !Validators.isEmail(correo)) {
            $correo.next().removeClass('hide');
            hayErrores = true;
        }
    }

    const direccionEnvio = $direccion.val();
    if (!direccionEnvio || !Validators.isNotXss(direccionEnvio)) {
        $direccion.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    formData.append(PEDIDO.METODO_PAGO_ID, $pagoSeleccionado);
    formData.append(PEDIDO.DIRECCION_ENVIO, direccionEnvio);
    response = await ajax(END_POINTS.PEDIDO.CREATE, 'POST', formData);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    window.location.href = '/done-checkout';
})