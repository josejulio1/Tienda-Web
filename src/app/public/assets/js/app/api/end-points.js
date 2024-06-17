const PATH = '/api';

/**
 * En este objeto se almacenan todos los endpoints de la API REST desde el frontend
 * @type {{MARKET: {SAVE_PROFILE: string}, CLOSE_SESSION: string, CHAT: {SEND_MESSAGE: string, GET_CUSTOMERS: string, GET_CUSTOMER_MESSAGES: string}, MARCA: {DELETE: string, CREATE: string, UPDATE: string, GET_ALL: string}, CLIENTE: {REGISTER: string, DELETE: string, CREATE: string, GET: string, LOGIN: string, UPDATE: string, GET_ALL: string}, USUARIO: {DELETE: string, CREATE: string, LOGIN: string, UPDATE: string, GET_ALL: string}, ROL: {DELETE: string, CREATE: string, GET_PERMISSIONS: string, UPDATE: string, GET_ALL: string}, CARRITO: {ADD: string, SET_QUANTITY: string, DELETE: string, INCREMENT_QUANTITY: string, GET_ALL: string, DECREMENT_QUANTITY: string}, PRODUCTO: {DELETE: string, CREATE: string, GET: string, UPDATE: string, GET_CARROUSEL: string, GET_ALL: string}, HAS_CUSTOMER_SESSION: string, SEARCH_PRODUCTS: string, PEDIDO: {CREATE: string, UPDATE: string, GET_ALL: string}, COMENTARIO: string, SEARCH_BAR: string, ESTADO_PAGO: {GET_ALL: string}, CATEGORIA: {DELETE: string, CREATE: string, GET: string, UPDATE: string, GET_ALL: string}}}
 */
export const END_POINTS = {
    CLOSE_SESSION: `${PATH}/close-session`,
    SEARCH_BAR: `${PATH}/search-bar`,
    SEARCH_PRODUCTS: `${PATH}/search-products`,
    HAS_CUSTOMER_SESSION: `${PATH}/has-customer-session`,
    COMENTARIO: `${PATH}/comment`,
    CHAT: {
        SEND_MESSAGE: `${PATH}/chat/send-message`,
        GET_CUSTOMERS: `${PATH}/chat/get-customers`,
        GET_CUSTOMER_MESSAGES: `${PATH}/chat/get-customer-messages`
    },
    ESTADO_PAGO: {
        GET_ALL: `${PATH}/payments-status`
    },
    PEDIDO: {
        GET_ALL: `${PATH}/orders`,
        CREATE: `${PATH}/order`,
        UPDATE: `${PATH}/order/update`
    },
    CARRITO: {
        GET_ALL: `${PATH}/cart`,
        ADD: `${PATH}/cart`,
        DELETE: `${PATH}/cart`,
        SET_QUANTITY: `${PATH}/set-quantity`,
        DECREMENT_QUANTITY: `${PATH}/quantity/decrement`,
        INCREMENT_QUANTITY: `${PATH}/quantity/increment`
    },
    MARKET: {
        SAVE_PROFILE: `${PATH}/save-profile`,
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
        REGISTER: `${PATH}/customer/register`,
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
        GET_CARROUSEL: `${PATH}/product/get-carrousel`
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