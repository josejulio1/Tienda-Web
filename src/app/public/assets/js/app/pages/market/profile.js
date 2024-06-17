import {Validators} from "../../services/Validators.js";
import {CLIENTE} from "../../api/models.js";
import {END_POINTS} from "../../api/end-points.js";
import {InfoWindow} from "../../components/InfoWindow.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {ajax} from "../../api/ajax.js";

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

// Fichero que contiene la lógica para poder guardar los datos del perfil del usuario

$imagen.on('change', () => {
    const reader = new FileReader();
    reader.addEventListener('loadend', () => {
        $imagenPerfilImg.attr('src', reader.result);
    })
    reader.readAsDataURL($imagen.prop('files')[0]);
    $sinGuardarImg.removeClass('hide');
})

$guardarCambios.on('click', async () => {
    let hayErrores = false;
    let nombre = $nombre.val();
    if (!Validators.isNotXss(nombre)) {
        $nombre.next().removeClass('hide');
        hayErrores = true;
    }

    let apellidos = $apellidos.val();
    if (!Validators.isNotXss(apellidos)) {
        $apellidos.next().removeClass('hide');
        hayErrores = true;
    }

    let telefono = $telefono.val();
    if (telefono && (!Validators.isPhone(telefono) || !Validators.isNotXss(telefono))) {
        $telefono.next().removeClass('hide');
        hayErrores = true;
    }

    let contrasenia = $contrasenia.val();
    if (!Validators.isNotXss(contrasenia)) {
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

    const profile = new FormData();
    let imagenSubida = false;
    if ($imagen.prop('files').length) {
        profile.append(CLIENTE.RUTA_IMAGEN_PERFIL, $imagen.prop('files')[0]);
        imagenSubida = true;
    }
    if (nombre) {
        profile.append(CLIENTE.NOMBRE, nombre);
    }
    if (apellidos) {
        profile.append(CLIENTE.APELLIDOS, apellidos);
    }
    if (telefono) {
        profile.append(CLIENTE.TELEFONO, telefono);
    }
    if (contrasenia) {
        profile.append(CLIENTE.CONTRASENIA, contrasenia);
    }

    const response = await ajax(END_POINTS.MARKET.SAVE_PROFILE, 'POST', profile);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make('No se pudieron cambiar los datos. Inténtelo más tarde.');
        return;
    }
    // Si se ha subido una imagen, cambiar frontend de la imagen
    if (imagenSubida) {
        const { data: { imagenNueva } } = response;
        $imagenPerfilNav.attr('src', imagenNueva);
        $imagenPerfilImg.attr('src', imagenNueva);
    }
    $sinGuardarImg.addClass('hide');
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