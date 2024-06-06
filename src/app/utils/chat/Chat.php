<?php
namespace Util\Chat;

use Exception;
use Model\Cliente;
use Model\Usuario;
use Ratchet\RFC6455\Messaging\MessageInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use Util\Auth\RoleAccess;

class Chat implements MessageComponentInterface {
    private SplObjectStorage $clients;

    public function __construct() {
        $this -> clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this -> clients -> attach($conn);
    }

    public function onClose(ConnectionInterface $conn) {
        $this -> clients -> detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e) {
        $conn -> close();
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg) {
        foreach ($this -> clients as $client) {
            if ($conn !== $client) {
                parse_str($conn -> httpRequest -> getUri() -> getQuery(), $query);
                $json = json_decode($msg -> getPayload());
                $data = [];
                if ($json -> sessionType === RoleAccess::USER) {
                    $data['ruta-imagen-perfil'] = Usuario::findOne($json -> sessionId, [Usuario::RUTA_IMAGEN_PERFIL]) -> ruta_imagen_perfil;
                } else {
                    $cliente = Cliente::findOne($json -> sessionId, [
                        Cliente::ID,
                        Cliente::CORREO,
                        Cliente::RUTA_IMAGEN_PERFIL
                    ]);
                    $data['id'] = $cliente -> id;
                    $data['correo'] = $cliente -> correo;
                    $data['ruta-imagen-perfil'] = $cliente -> ruta_imagen_perfil;
                }
                $data['message'] = $json -> message;
                $client -> send(json_encode($data));
            }
        }
    }
}