import {Validators} from "../../controllers/services/Validators.js";
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
    if (!telefono || !Validators.isPhone(telefono) || !Validators.isNotXss(telefono)) {
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

    const Profile = {}
    if ($imagen.prop('files')) {
        Profile[CLIENTE.RUTA_IMAGEN_PERFIL] = $imagen.prop('files')[0];
    }
    if (nombre) {
        Profile[CLIENTE.NOMBRE] = nombre;
    }
    if (apellidos) {
        Profile[CLIENTE.APELLIDOS] = apellidos;
    }
    if (telefono) {
        Profile[CLIENTE.TELEFONO] = telefono;
    }

    const response = await ajax(END_POINTS.MARKET.SAVE_PROFILE, 'POST', Profile);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make('No se pudieron cambiar los datos. Inténtelo más tarde.');
        return;
    }
    $imagenPerfilNav.attr('src', response.data[CLIENTE.RUTA_IMAGEN_PERFIL]);
    $imagenPerfilImg.attr('src', response.data[CLIENTE.RUTA_IMAGEN_PERFIL]);
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