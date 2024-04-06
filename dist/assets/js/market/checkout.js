import {END_POINTS} from "../api/end-points.js";
import {XSS_REGEX} from "../helpers/regex.js";
import {PEDIDO} from "../crud/models.js";
import {HTTP_STATUS_CODES} from "../api/http-status-codes.js";
import {InfoWindow} from "../components/InfoWindow.js";

// Pago
const $numTarjeta = $('#num-tarjeta');
const $fechaCaducidadMes = $('#fecha-caducidad-mes');
const $fechaCaducidadAnio = $('#fecha-caducidad-anio');
const $codigoSeguridad = $('#codigo-seguridad');

// Facturación
const $direccion = $('#direccion');

const $pagar = $('#pagar');

$pagar.on('click', () => {
    let hayErrores = false;

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

    const direccionEnvio = $direccion.val();
    if (!direccionEnvio || XSS_REGEX.test(direccionEnvio)) {
        $direccion.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const formData = new FormData();
    formData.append(PEDIDO.DIRECCION_ENVIO, direccionEnvio);

    fetch(END_POINTS.MARKET.ORDER.ADD, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('El pedido no se pudo realizar. Inténtelo más tarde.');
            return;
        }
        window.location.href = '/';
    })
})