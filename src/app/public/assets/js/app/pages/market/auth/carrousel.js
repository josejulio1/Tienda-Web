import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";

let carrouselIndex = 0;
const $imagenCarrusel = $('.imagen-carrusel');
let srcImages;

window.addEventListener('load', async () => {
    const response = await ajax(END_POINTS.PRODUCTO.GET_CARROUSEL, 'GET');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    srcImages = response.data.imagenes;
    // Si existen imágenes de productos, colocar la de los productos. En caso contrario, dejar la por defecto
    if (srcImages) {
        $imagenCarrusel.attr('src', srcImages[0]);
        carrouselIndex++;
    }
    $imagenCarrusel.on('animationiteration', () => {
        $imagenCarrusel.attr('src', srcImages[carrouselIndex++]);
        if (carrouselIndex >= srcImages.length) {
            carrouselIndex = 0;
        }
    })
})