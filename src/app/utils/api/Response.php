<?php
namespace Util\API;

/**
 * Clase que envía al frontend una respuesta HTTP. Contiene un método estático que es el que
 * se utiliza para realizar la acción dicha previamente
 * @author josejulio1
 * @version 1.0
 */
class Response {
    /**
     * Envía una respuesta al frontend.
     * @param int $status Código de estado HTTP. Usar clase {@see HttpStatusCode}
     * @param string|null $message Mensaje que se desea enviar al frontend. Use las constantes de {@see HttpSuccessMessages} o {@see HttpErrorMessages} según la necesidad
     * @param array|null $data Datos que se desean enviar al frontend, el cuál se otorgarán en forma de <b>JSON</b>. Si se deja vacío, no se enviará información al frontend
     * @return void
     */
    public static function sendResponse(int $status, ?string $message = null, ?array $data = null) {
        $response = [
            'status' => $status,
            'data' => $data
        ];
        if ($message) {
            $response['message'] = $message;
        }
        echo json_encode($response);
    }
}