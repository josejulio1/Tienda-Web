<?php
session_start();
if (!$_SESSION) {
    header('Location: /admin/auth.php');
}

require_once __DIR__ . '/../../db/crud.php';
require_once __DIR__ . '/../../db/utils/utils.php';
require_once __DIR__ . '/../../db/models/v_usuario_rol.php';
require_once __DIR__ . '/../../api/utils/permissions.php';

$userInfo = select(v_usuario_rol::class, [
  v_usuario_rol::USUARIO,
  v_usuario_rol::NOMBRE_ROL,
  v_usuario_rol::RUTA_IMAGEN_PERFIL,
  v_usuario_rol::PERMISO_CATEGORIA,
  v_usuario_rol::PERMISO_PRODUCTO,
  v_usuario_rol::PERMISO_CLIENTE,
  v_usuario_rol::PERMISO_USUARIO,
  v_usuario_rol::PERMISO_ROL
], [
  TypesFilters::EQUALS => [
      v_usuario_rol::CORREO => $_SESSION[v_usuario_rol::CORREO]
  ]
])[0];
?>