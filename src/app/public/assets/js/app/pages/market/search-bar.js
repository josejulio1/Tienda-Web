// JavaScript de búsqueda de productos en la página principal
import {ajax} from "../../api/ajax.js";
import {END_POINTS} from "../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {InfoWindow} from "../../components/InfoWindow.js";
import {SearchItem} from "./components/SearchItem.js";
import {V_PRODUCTO_VALORACION_PROMEDIO} from "../../api/models.js";

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
    const nombreProducto = $searchBarInput.val();
    if (!nombreProducto) {
        return;
    }
    const Producto = {
        [V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE]: nombreProducto
    }
    const response = await ajax(END_POINTS.SEARCH_BAR, 'POST', Producto);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    const { data: { searchBarItems } } = response;
    // En caso de no encontrar ninguna coincidencia, informar de que no se encontraron resultados
    if (!searchBarItems.length) {
        const noResultadosContenedor = document.createElement('div');
        const noResultadosH2 = document.createElement('h2');
        noResultadosContenedor.classList.add('search-bar--item', 'search-bar--item__description');
        noResultadosH2.textContent = 'No se encontraron resultados';
        noResultadosContenedor.appendChild(noResultadosH2);
        $searchBarItems.append(noResultadosContenedor);
        $searchBarItems.removeClass('hide');
        return;
    }
    // Si se encontraron resultados, mostrarlos
    for (const searchBarItem of searchBarItems) {
        $searchBarItems.append(
            new SearchItem(
                searchBarItem
            ).getItem()
        );
    }
})