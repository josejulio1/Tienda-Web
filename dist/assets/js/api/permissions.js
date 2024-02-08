export const PERMISSIONS = {
    NO_PERMISSIONS: 0,
    CREATE: 1,
    READ: 2,
    UPDATE: 4,
    DELETE: 8
}

export const PERMISSIONS_TEXT = {
    'crear': PERMISSIONS.CREATE,
    'ver': PERMISSIONS.READ,
    'actualizar': PERMISSIONS.UPDATE,
    'eliminar': PERMISSIONS.DELETE
}