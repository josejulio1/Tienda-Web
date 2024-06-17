/**
 * Clase que envuelve toda la información generada durante una llamada al backend
 * @author josejulio1
 * @version 1.0
 */
export class Response {
    /**
     * Constructor de Response. La respuesta siempre debe estar en formato JSON.
     * @param json {JSON} JSON con los datos de la respuesta
     */
    constructor(json) {
        // Código de estado HTTP
        this.status = json['status'];
        // Mensaje recibido por el backend. Opcional
        this.message = json['message'] ?? null;
        // Datos recibidos por el backend. Opcional
        this.data = json['data'] ?? null;
    }
}