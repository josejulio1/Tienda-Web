import { PERMISSIONS } from "../../../api/permissions.js";

$('.marcar-todo').on('click', e => {
    const { target: { id } } = e;
    const nombrePagina = id.split('-')[2];
    $(`#ver-permiso-${nombrePagina}`).prop('checked', true);
    $(`#crear-permiso-${nombrePagina}`).prop('checked', true);
    $(`#actualizar-permiso-${nombrePagina}`).prop('checked', true);
    $(`#eliminar-permiso-${nombrePagina}`).prop('checked', true);
})

// Cambiar de página
$('.btn-permiso').on('click', e => {
    e.preventDefault();
    const { target } = e;
    $('.btn-permiso.selected-button').removeClass('selected-button');
    target.classList.add('selected-button');
    // Ocultar página que esté mostrándose
    $('.contenedor-permiso:not(.hide)').addClass('hide');
    $(`.contenedor-${target.id}`).removeClass('hide');
})

// Al pulsar el CheckBox de marcar todo, marcar todos los CheckBox
$('.marcar-todo').on('change', e => {
    const { target: { id, checked } } = e;
    const splittedId = id.split('-')[2];
    let strActualizar;
    if (id.includes('actualizar')) {
        strActualizar = '-actualizar';
    }
    $(`#ver-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#crear-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#actualizar-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#eliminar-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
})

$('.permiso-crear').on('change', checkVer);
$('.permiso-actualizar').on('change', checkVer);
$('.permiso-eliminar').on('change', checkVer);

/**
 * Calcula el número equivalente de permiso según los checkboxes que hayan activados.
 * @param {HTMLInputElement} $checkBoxVer CheckBox Ver
 * @param {HTMLInputElement} $checkBoxCrear CheckBox Crear
 * @param {HTMLInputElement} $checkBoxActualizar CheckBox Actualizar
 * @param {HTMLInputElement} $checkBoxEliminar CheckBox Eliminar
 * @returns Devuelve el número de permiso calculado
 */
export function getPermissions($checkBoxVer, $checkBoxCrear, $checkBoxActualizar, $checkBoxEliminar) {
    let permissionNumber = 0;
    if ($checkBoxVer.prop('checked')) {
        permissionNumber += PERMISSIONS.READ;
    }
    if ($checkBoxCrear.prop('checked')) {
        permissionNumber += PERMISSIONS.CREATE;
    }
    if ($checkBoxActualizar.prop('checked')) {
        permissionNumber += PERMISSIONS.UPDATE;
    }
    if ($checkBoxEliminar.prop('checked')) {
        permissionNumber += PERMISSIONS.DELETE;
    }
    return permissionNumber;
}

export function clearCheckboxes(...$checkBoxes) {
    for (const $checkBox of $checkBoxes) {
        $checkBox.prop('checked', false);
    }
}

export function validatePermissions($checkBoxCrear, $checkBoxActualizar, $checkBoxEliminar) {
    let strActualizar;
    const checkBoxCrearId = $checkBoxCrear.attr('id');
    if (checkBoxCrearId.includes('-actualizar')) {
        strActualizar = '-actualizar';
    }
    let $checkBoxVer;
    if (strActualizar) {
        $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}${strActualizar}`);
    } else {
        $checkBoxVer = $(`#ver-permiso-${checkBoxCrearId.split('-')[2]}`);
    }
    if ($checkBoxVer.prop('checked')) {
        return true;
    }

    if (($checkBoxCrear.prop('checked') || $checkBoxActualizar.prop('checked') || $checkBoxEliminar.prop('checked')) && $checkBoxVer.prop('checked')) {
        return true;
    }
    return false;
}

/**
 * Convierte el permiso numérico a los CheckBoxes, marcando estos según si tengan el permiso o no
 * @param {number} permissionNumber Número de permiso
 * @param {HTMLInputElement} $checkBoxVer CheckBox Ver
 * @param {HTMLInputElement} $checkBoxCrear CheckBox Crear
 * @param {HTMLInputElement} $checkBoxActualizar CheckBox Actualizar
 * @param {HTMLInputElement} $checkBoxEliminar CheckBoxx Eliminar
 */
export function permissionNumberToCheckBox(permissionNumber, $checkBoxVer, $checkBoxCrear, $checkBoxActualizar, $checkBoxEliminar) {
    debugger
    if (permissionNumber & PERMISSIONS.READ) {
        $checkBoxVer.prop('checked', true);
    }
    if (permissionNumber & PERMISSIONS.CREATE) {
        $checkBoxCrear.prop('checked', true);
    }
    if (permissionNumber & PERMISSIONS.UPDATE) {
        $checkBoxActualizar.prop('checked', true);
    }
    if (permissionNumber & PERMISSIONS.DELETE) {
        $checkBoxEliminar.prop('checked', true);
    }
}

/**
 * Marca el CheckBox "Ver Permiso" en caso de que se marque "Crear, Actualizar o Eliminar"
 * @param {Event} e CheckBox que accionó el evento
 * @returns En caso de que se haya desmarcado el CheckBox, no hará nada
 */
function checkVer(e) {
    const { target, target: { id } } = e;
    // Si se desmarca, no hacer nada
    if (!target.checked) {
        return;
    }
    if (id.includes('-actualizar')) {
        $(`#ver-permiso-${id.split('-')[2]}-actualizar`).prop('checked', true);
    } else {
        $(`#ver-permiso-${id.split('-')[2]}`).prop('checked', true);
    }
}