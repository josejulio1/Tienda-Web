const PATH = '/api';

export const END_POINTS = {
    CLOSE_SESSION: `${PATH}/close-session`,
    SEARCH_BAR: `${PATH}/search-bar`,
    HAS_CUSTOMER_SESSION: `${PATH}/has-customer-session`,
    COMENTARIO: `${PATH}/comment`,
    GET_SESSION_ID: `${PATH}/get-session-id`,
    CHAT: `${PATH}/chat`,
    ESTADO_PAGO: {
        GET_ALL: `${PATH}/payments-status`
    },
    PEDIDO: {
        GET_ALL: `${PATH}/orders`,
        UPDATE: `${PATH}/order`
    },
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
        UPDATE: `${PATH}/user/update`,
        DELETE: `${PATH}/user`,
    },
    CLIENTE: {
        LOGIN: `${PATH}/customer/login`,
        REGISTER: `${PATH}/customer/register/index.php`,
        GET_ALL: `${PATH}/customers`,
        GET: `${PATH}/customer`,
        CREATE: `${PATH}/customer`,
        UPDATE: `${PATH}/customer/update`,
        DELETE: `${PATH}/customer`,
    },
    PRODUCTO: {
        GET_ALL: `${PATH}/products`,
        GET: `${PATH}/product`,
        CREATE: `${PATH}/product`,
        UPDATE: `${PATH}/product/update`,
        DELETE: `${PATH}/product`,
    },
    MARCA: {
        GET_ALL: `${PATH}/brands`,
        CREATE: `${PATH}/brand`,
        UPDATE: `${PATH}/brand/update`,
        DELETE: `${PATH}/brand`
    },
    ROL: {
        GET_ALL: `${PATH}/roles`,
        GET_PERMISSIONS: `${PATH}/role/get-permissions`,
        CREATE: `${PATH}/role`,
        UPDATE: `${PATH}/role/update`,
        DELETE: `${PATH}/role`,
    },
    CATEGORIA: {
        GET_ALL: `${PATH}/categories`,
        GET: `${PATH}/category`,
        CREATE: `${PATH}/category`,
        UPDATE: `${PATH}/category/update`,
        DELETE: `${PATH}/category`,
    }
}