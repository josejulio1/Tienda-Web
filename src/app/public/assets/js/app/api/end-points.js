const PATH = '/api';

export const END_POINTS = {
    SELECT_ROWS: `${PATH}/select-rows.php`,
    UPDATE_ROW: `${PATH}/update-row.php`,
    DELETE_ROW: `${PATH}/delete-row.php`,
    CLOSE_SESSION: `${PATH}/close-session`,
    LOGIN: `${PATH}/login.php`,
    SEARCH_BAR: `${PATH}/search-bar`,
    HAS_CUSTOMER_SESSION: `${PATH}/has-customer-session`,
    CARRITO: {
        GET_ALL: `${PATH}/cart`,
        ADD: `${PATH}/cart`,
        DELETE: `${PATH}/cart`,
        SET_QUANTITY: `${PATH}/set-quantity`,
        DECREMENT_QUANTITY: `${PATH}/quantity`,
        INCREMENT_QUANTITY: `${PATH}/quantity`
    },
    MARKET: {
        SAVE_PROFILE: `${PATH}/save-profile`,
        HAS_CUSTOMER_SESSION: `${PATH}/market/has-customer-session.php`,

        CHAT: {
            ADD: `${PATH}/market/chat/add/index.php`
        },
        ORDER: {
            ADD: `${PATH}/market/order/add/index.php`
        }
    },
    USUARIO: {
        GET_ALL: `${PATH}/users`,
        LOGIN: `${PATH}/user/login`,
        CREATE: `${PATH}/user`,
        UPDATE: `${PATH}/user`,
        DELETE: `${PATH}/user`,
    },
    CLIENTE: {
        LOGIN: `${PATH}/customer/login`,
        REGISTER: `${PATH}/customer/register/index.php`,
        GET_ALL: `${PATH}/customers`,
        GET: `${PATH}/customer`,
        CREATE: `${PATH}/customer`,
        UPDATE: `${PATH}/customer`,
        DELETE: `${PATH}/customer`,
    },
    PRODUCTO: {
        GET_ALL: `${PATH}/products`,
        GET: `${PATH}/product`,
        CREATE: `${PATH}/product`,
        UPDATE: `${PATH}/product`,
        DELETE: `${PATH}/product`,
    },
    MARCA: {
        GET_ALL: `${PATH}/brands`,
        CREATE: `${PATH}/brand`,
        UPDATE: `${PATH}/brand`,
        DELETE: `${PATH}/brand`
    },
    ROL: {
        GET_ALL: `${PATH}/roles`,
        CREATE: `${PATH}/role`,
        UPDATE: `${PATH}/role`,
        DELETE: `${PATH}/role`,
    },
    CATEGORIA: {
        GET_ALL: `${PATH}/categories`,
        GET: `${PATH}/category`,
        CREATE: `${PATH}/category`,
        UPDATE: `${PATH}/category`,
        DELETE: `${PATH}/category`,
    }
}