<?php
namespace Util\API;

class JsonHelper {
    public static function getPostInJson(): array {
        return json_decode(file_get_contents('php://input'), true);
    }
}