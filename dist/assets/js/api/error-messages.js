import { HTTP_STATUS_CODES } from "./http-status-codes.js";

export const ERROR_MESSAGES = {
    [HTTP_STATUS_CODES.UNAUTHORIZED]: 'No puedes borrar el usuario con el que estás logeado',
    [HTTP_STATUS_CODES.NOT_FOUND]: 'Ya existe el registro',
    [HTTP_STATUS_CODES.INCORRECT_DATA]: 'Datos erróneos',
    [HTTP_STATUS_CODES.SERVICE_UNAVAILABLE]: 'No se pudo conectar con la base de datos. Inténtelo más tarde'
}