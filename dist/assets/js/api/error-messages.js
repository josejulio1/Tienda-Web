import { HTTP_STATUS_CODES } from "./http-status-codes.js";

export const ERROR_MESSAGES = {
    [HTTP_STATUS_CODES.UNAUTHORIZED]: 'No puedes borrar un registro necesario para seguir estando logueado',
    [HTTP_STATUS_CODES.NOT_FOUND]: 'Ya existe el registro',
    [HTTP_STATUS_CODES.INCORRECT_DATA]: 'Datos erróneos',
    [HTTP_STATUS_CODES.SERVICE_UNAVAILABLE]: 'No se pudo conectar con la base de datos. Inténtelo más tarde'
}