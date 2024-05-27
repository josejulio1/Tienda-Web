<?php
namespace Util\API;

class Response {
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