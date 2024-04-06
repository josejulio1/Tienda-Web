import {PHONE_REGEX, XSS_REGEX} from "../helpers/regex.js";
import {CLIENTE} from "../crud/models.js";
import {END_POINTS} from "../api/end-points.js";
import {HTTP_STATUS_CODES} from "../api/http-status-codes.js";
import {InfoWindow} from "../components/InfoWindow.js";

const $imagenPerfilNav = $('#imagen-perfil-nav');
const $nombreClienteNav = $('#nombre-cliente-nav');
const $apellidosClienteNav = $('#apellidos-cliente-nav');

const $imagenPerfilImg = $('#imagen-perfil');
const $sinGuardarImg = $('#no-guardado');
const $imagen = $('#imagen');
const $nombre = $('#nombre');
const $apellidos = $('#apellidos');
const $telefono = $('#telefono');
const $contrasenia = $('#contrasenia');

const $guardarCambios = $('#guardar-cambios');

$imagen.on('change', () => {
    const reader = new FileReader();
    reader.addEventListener('loadend', () => {
        $imagenPerfilImg.attr('src', reader.result);
    })
    reader.readAsDataURL($imagen.prop('files')[0]);
    $sinGuardarImg.removeClass('hide');
})

$guardarCambios.on('click', () => {
    let hayErrores = false;
    let nombre = $nombre.val();
    if (XSS_REGEX.test(nombre)) {
        $nombre.next().removeClass('hide');
        hayErrores = true;
    }

    let apellidos = $apellidos.val();
    if (XSS_REGEX.test(apellidos)) {
        $apellidos.next().removeClass('hide');
        hayErrores = true;
    }

    let telefono = $telefono.val();
    if (telefono && !PHONE_REGEX.test(telefono) || XSS_REGEX.test(telefono)) {
        $telefono.next().removeClass('hide');
        hayErrores = true;
    }

    let contrasenia = $contrasenia.val();
    if (XSS_REGEX.test(contrasenia)) {
        $contrasenia.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }
    $nombre.next().addClass('hide');
    $apellidos.next().addClass('hide');
    $telefono.next().addClass('hide');
    $contrasenia.next().addClass('hide');

    const formData = new FormData();
    if ($imagen.prop('files')) {
        formData.append(CLIENTE.RUTA_IMAGEN_PERFIL, $imagen.prop('files')[0]);
    }
    if (nombre) {
        formData.append(CLIENTE.NOMBRE, nombre);
    }
    if (apellidos) {
        formData.append(CLIENTE.APELLIDOS, apellidos);
    }
    if (telefono) {
        formData.append(CLIENTE.TELEFONO, telefono);
    }
    if (contrasenia) {
        formData.append(CLIENTE.CONTRASENIA, contrasenia);
    }

    fetch(END_POINTS.MARKET.PROFILE, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        $imagenPerfilNav.attr('src', data[CLIENTE.RUTA_IMAGEN_PERFIL]);
        $imagenPerfilImg.attr('src', data[CLIENTE.RUTA_IMAGEN_PERFIL]);
        $sinGuardarImg.addClass('hide');
        if (data.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('No se pudieron cambiar los datos. Inténtelo más tarde.');
            return;
        }
        nombre = $nombre.val();
        if (nombre) {
            $nombreClienteNav.html(nombre);
            $nombre.attr('placeholder', $nombre.val());
            $nombre.val('');
        }

        apellidos = $apellidos.val();
        if (apellidos) {
            $apellidosClienteNav.html(apellidos);
            $apellidos.attr('placeholder', $apellidos.val());
            $apellidos.val('');
        }

        telefono = $telefono.val();
        if (telefono) {
            $telefono.attr('placeholder', $telefono.val());
            $telefono.val('');
        }
        $contrasenia.val('');
        InfoWindow.make('Los cambios se guardaron correctamente', true);
    })
})