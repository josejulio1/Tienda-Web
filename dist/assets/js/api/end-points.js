const PATH = '/api/controllers';

export const END_POINTS = {
    SELECT_ROWS: `${PATH}/select-rows.php`,
    UPDATE_ROW: `${PATH}/update-row.php`,
    DELETE_ROW: `${PATH}/delete-row.php`,
    CLOSE_SESSION: `${PATH}/close-session.php`,
    LOGIN: `${PATH}/login.php`,
    MARKET: {
        HAS_CUSTOMER_SESSION: `${PATH}/market/has-customer-session.php`,
        CART: {
            ADD: `${PATH}/market/cart/add/index.php`,
            DELETE: `${PATH}/market/cart/delete/index.php`
        },
        CHAT: {
            ADD: `${PATH}/market/chat/add/index.php`
        },
        ORDER: {
            ADD: `${PATH}/market/order/add/index.php`
        },
        PROFILE: `${PATH}/market/profile/index.php`
    },
    USER: {
        INSERT: `${PATH}/user/insert/index.php`,
        UPDATE: `${PATH}/user/update/index.php`
    },
    CUSTOMER: {
        INSERT: `${PATH}/customer/insert/index.php`,
        REGISTER: `${PATH}/customer/register/index.php`
    },
    PRODUCT: {
        INSERT: `${PATH}/product/insert/index.php`
    },
    BRAND: {
        INSERT: `${PATH}/brand/insert/index.php`
    },
    ROL: {
        INSERT: `${PATH}/rol/insert/index.php`
    },
    CATEGORY: {
        INSERT: `${PATH}/category/insert/index.php`
    }
}