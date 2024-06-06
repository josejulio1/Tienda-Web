<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Util\Chat\Chat;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv -> load();

// Create Chat WebSocket
$webSocketApp = new Ratchet\App($_SERVER['WEBSOCKET_SERVER'], $_SERVER['WEBSOCKET_PORT']);
$webSocketApp -> route('/chat', new Chat, ['*']);
$webSocketApp -> run();