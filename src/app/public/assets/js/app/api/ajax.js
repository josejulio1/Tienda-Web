import {Response} from "./Response.js";

/**
 * Realiza una llamada al backend de manera asíncrona. Se debe indicar la ruta o end-point donde realizar
 * la llamada, el tipo de método HTTP a realizar y enviar datos si así se requiere.
 * @param endPoint {string} Ruta o end-point al que realizar la llamada. Usar objeto END_POINTS del fichero end-points.js
 * @param typeMethod {string} Método HTTP a realizar. GET, POST o DELETE (en el caso de DELETE, adjuntar datos en la URL)
 * @param data {FormData} Formulario de datos PHP a enviar al backend. Opcional
 * @returns {Promise<Response>} Devuelve una promesa, que es la información de la respuesta envuelta en la clase Response
 */
export async function ajax(endPoint, typeMethod, data = null) {
    const properties = {
        method: typeMethod,
        headers: {
            'Accept': 'application/json'
        }
    }
    if (data) {
        properties.body = data
    }
    return new Response(await fetch(endPoint, properties).then(response => response.json()));
}