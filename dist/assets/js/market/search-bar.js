// JavaScript de búsqueda de productos en la página principal
import { select } from "../crud/crud.js";
import { V_PRODUCTO_VALORACION_PROMEDIO } from "../crud/models.js";
import { TYPE_FILTERS } from "../crud/utils.js";
import { SearchItem } from "./models/SearchItem.js";

const $searchBarInput = $('#search-bar--input');
const $searchBarItems = $('#search-bar--items');

$searchBarInput.on('focusin', () => {
    $searchBarItems.removeClass('hide');
})

$searchBarInput.on('focusout', () => {
    setTimeout(() => {
        $searchBarItems.addClass('hide');
    }, 200);
})

$searchBarInput.on('keyup', async e => {
    // Si la letra no es una letra del alfabeto o el retroceso, no continuar
    const { keyCode } = e;
    if ((keyCode < 65 || keyCode > 90) || keyCode === 8) {
        return;
    }
    $searchBarItems.removeClass('hide');
    $searchBarItems.html('');
    if (!$searchBarInput.val()) {
        return;
    }
    const json = await select(V_PRODUCTO_VALORACION_PROMEDIO.TABLE_NAME, [
        V_PRODUCTO_VALORACION_PROMEDIO.ID,
        V_PRODUCTO_VALORACION_PROMEDIO.RUTA_IMAGEN,
        V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE,
        V_PRODUCTO_VALORACION_PROMEDIO.PRECIO,
        V_PRODUCTO_VALORACION_PROMEDIO.VALORACION_PROMEDIO
    ], {
        [TYPE_FILTERS.BEGIN]: {
            [V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE]: $searchBarInput.val()
        }
    })
    for (const item of json) {
        $searchBarItems.append(
            new SearchItem(
                item[V_PRODUCTO_VALORACION_PROMEDIO.ID],
                item[V_PRODUCTO_VALORACION_PROMEDIO.RUTA_IMAGEN],
                item[V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE],
                item[V_PRODUCTO_VALORACION_PROMEDIO.PRECIO],
                item[V_PRODUCTO_VALORACION_PROMEDIO.VALORACION_PROMEDIO]
            ).getItem()
        );
    }
})