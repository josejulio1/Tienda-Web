const PATH = '/api/controllers';

export const END_POINTS = {
    SELECT_ROWS: `${PATH}/select-rows.php`,
    UPDATE_ROW: `${PATH}/update-row.php`,
    DELETE_ROW: `${PATH}/delete-row.php`,
    CLOSE_SESSION: `${PATH}/close-session.php`,
    LOGIN: `${PATH}/login.php`,
    USER: {
        INSERT: `${PATH}/user/insert/index.php`,
        UPDATE: `${PATH}/user/update/index.php`
    },
    PRODUCT: {
        INSERT: `${PATH}/product/insert/index.php`
    },
    ROL: {
        INSERT: `${PATH}/rol/insert/index.php`
    },
    CATEGORY: {
        INSERT: `${PATH}/category/insert/index.php`
    }
}