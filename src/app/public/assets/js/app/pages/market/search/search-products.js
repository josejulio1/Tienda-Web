import {ProductItem} from "../components/ProductItem.js";
import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {V_PRODUCTO_VALORACION_PROMEDIO} from "../../../api/models.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {Validators} from "../../../services/Validators.js";

// Búsqueda
const $precioMin = $('#precio-min');
const $precioMax = $('#precio-max');
const $buscarProducto = $('#buscar-producto');
const $checkBoxesCategoria = $('.busqueda__categoria input');
const $checkBoxesMarca = $('.busqueda__marca input');

// Productos
const $productosItems = $('#producto__items');

// Filtro
let filtros = new Map();
$precioMin.on('focusout', setPrecio);
$precioMax.on('focusout', setPrecio);

$checkBoxesCategoria.on('click', async function() {
    const $checkBox = $(this);
    if ($checkBox.is(':checked')) {
        filtros.set(V_PRODUCTO_VALORACION_PROMEDIO.CATEGORIA_ID, $checkBox.val());
        ajaxProductos(true);
    } else {
        filtros.delete(V_PRODUCTO_VALORACION_PROMEDIO.CATEGORIA_ID);
        ajaxProductos(filtros.size > 0);
    }
})

$checkBoxesMarca.on('click', async function() {
    const $checkBox = $(this);
    if ($checkBox.is(':checked')) {
        filtros.set(V_PRODUCTO_VALORACION_PROMEDIO.MARCA_ID, $checkBox.val());
        ajaxProductos(true);
    } else {
        filtros.delete(V_PRODUCTO_VALORACION_PROMEDIO.MARCA_ID);
        ajaxProductos(filtros.size > 0);
    }
})

$buscarProducto.on('keyup', async () => {
    // No buscar si el campo está vacío
    if (!$buscarProducto.val() && !filtros.size) {
        ajaxProductos(false);
        return;
    }
    filtros.set('nombre', $buscarProducto.val());
    ajaxProductos(true);
})

/**
 * Valida que los campos de precio mínimo y precio máximo sean correctos y manda una petición al backend para filtrar por precio
 * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
 */
async function setPrecio() {
    const precioMin = $precioMin.val();
    const precioMax = $precioMax.val();
    if (!precioMin || !Validators.isPositiveNumber(precioMin) || !Validators.isNotXss(precioMax) || (precioMax && parseFloat(precioMin) > parseFloat(precioMax))) {
        return;
    }
    if (precioMax) {
        filtros.set('precio_min', precioMin);
        filtros.set('precio_max', precioMax);
    } else {
        filtros.delete('precio_min');
        filtros.delete('precio_max');
    }
    ajaxProductos(filtros.size > 0);
}

/**
 * Realiza un AJAX o petición asíncrona al backend, obteniendo todos los productos a través de un filtro que se aplique
 * @param existenFiltros True si se quiere buscar con filtros y false si no
 * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
 */
async function ajaxProductos(existenFiltros) {
    const response = await ajax(`${END_POINTS.SEARCH_PRODUCTS}${existenFiltros ? crearFiltroAQueryString() : ''}`, 'GET');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    const { data: { productos } } = response;
    mostrarProductos(productos);
}

/**
 * Muestra todos los productos recogidos de la base de datos en la vista
 * @param productos {Array} Productos de la base de datos
 */
function mostrarProductos(productos) {
    $productosItems.html('');
    const documentFragment = document.createDocumentFragment();
    for (const producto of productos) {
        documentFragment.appendChild(
            new ProductItem(producto).getProductItem()
        );
    }
    $productosItems.append(documentFragment);
}

/**
 * Crea un query string con los filtros utilizados, para poder consultar al backend con los filtros solicitados.
 * @returns {string} Devuelve un query string con los filtros aplicados
 */
function crearFiltroAQueryString() {
    const filtrosIterator = filtros.entries();
    let iteratorYield = filtrosIterator.next().value;
    let queryParameters = `?${iteratorYield[0]}=${iteratorYield[1]}`;
    const { size: numFiltros } = filtros;
    for (let i = 1; i < numFiltros; i++) {
        iteratorYield = filtrosIterator.next().value;
        queryParameters += `&${iteratorYield[0]}=${iteratorYield[1]}`;
    }
    return queryParameters;
}