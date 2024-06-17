<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Core\Router;
use Controller\MarketController;
use Controller\AdminController;
use API\ProductController;
use API\CategoryController;
use API\BrandController;
use API\CustomerController;
use API\UserController;
use API\RoleController;
use API\OrderController;
use API\PaymentStatusController;
use API\CartController;
use API\AuthController;
use API\ChatController;
use Util\API\HttpStatusCode;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv -> load();

$router = new Router();

// Market Pages
$router -> get('/', [MarketController::class, 'index'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin/user');
    }
});
$router -> get('/login', [MarketController::class, 'login'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/product', [MarketController::class, 'product'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin/user');
    }
});
$router -> get('/search-products', [MarketController::class, 'searchProducts'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin/user');
    }
});
$router -> get('/profile', [MarketController::class, 'profile'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/orders', [MarketController::class, 'orders'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/checkout', [MarketController::class, 'checkout'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/done-checkout', [MarketController::class, 'doneCheckout'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});

// Admin Pages
$router -> get('/admin', [AdminController::class, 'login'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin/user');
    }
    if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/admin/login', [AdminController::class, 'login'], function() {
    if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin/user');
    }
    if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        header('Location: /');
    }
});
$router -> get('/admin/user', [AdminController::class, 'index'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});
$router -> get('/admin/product', [AdminController::class, 'product'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});
$router -> get('/admin/brand', [AdminController::class, 'brand'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});
$router -> get('/admin/category', [AdminController::class, 'category'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});
$router -> get('/admin/customer', [AdminController::class, 'customer'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});
$router -> get('/admin/role', [AdminController::class, 'role'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        header('Location: /admin');
    }
});

// API
// API - Session
$router -> get('/api/close-session', [AuthController::class, 'closeSession']);
$router -> get('/api/has-customer-session', [CustomerController::class, 'hasCustomerSession']);

// API - Market
$router -> get('/api/product/get-carrousel', [ProductController::class, 'getCarrousel']);
$router -> get('/api/search-products', [ProductController::class, 'searchProducts']);
$router -> post('/api/search-bar', [ProductController::class, 'searchBar']);
$router -> post('/api/comment', [CustomerController::class, 'comment']);

// API - Login
$router -> post('/api/customer/login', [CustomerController::class, 'login'], function (): int {
    if (AuthHelper::isAuthenticated()) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/user/login', [UserController::class, 'login'], function(): int {
    if (AuthHelper::isAuthenticated()) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Register
$router -> post('/api/customer/register', [CustomerController::class, 'register']);

// API - User
$router -> get('/api/users', [UserController::class, 'getAll'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/user', [UserController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/user/update', [UserController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/user', [UserController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Product
$router -> get('/api/products', [ProductController::class, 'getAll'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> get('/api/product', [ProductController::class, 'getProductDescription'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/product', [ProductController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/product/update', [ProductController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/product', [ProductController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Brand
$router -> get('/api/brands', [BrandController::class, 'getAll'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/brand', [BrandController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/brand/update', [BrandController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/brand', [BrandController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Category
$router -> get('/api/categories', [CategoryController::class, 'getAll'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/category', [CategoryController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/category/update', [CategoryController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/category', [CategoryController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Customer
$router -> get('/api/customers', [CustomerController::class, 'getAll'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/customer', [CustomerController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/customer/update', [CustomerController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/customer', [CustomerController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/save-profile', [CustomerController::class, 'saveProfile'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
}, true);

// API - Role
$router -> get('/api/roles', [RoleController::class, 'getAll'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/role/get-permissions', [RoleController::class, 'getAllPermissions'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/role', [RoleController::class, 'create'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/role/update', [RoleController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/role', [RoleController::class, 'delete'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Order
$router -> post('/api/orders', [OrderController::class, 'getAll'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/order', [OrderController::class, 'create'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/order/update', [OrderController::class, 'update'], function() {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Payment Status
$router -> get('/api/payments-status', [PaymentStatusController::class, 'getAll']);

// API - Cart
$router -> get('/api/cart', [CartController::class, 'getAll'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/cart', [CartController::class, 'add'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> delete('/api/cart', [CartController::class, 'delete'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/set-quantity', [CartController::class, 'setQuantity'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/quantity/decrement', [CartController::class, 'decrementQuantity'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/quantity/increment', [CartController::class, 'incrementQuantity'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

// API - Chat
$router -> get('/api/chat/get-customers', [ChatController::class, 'getCustomers'], function(): int {
    if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> get('/api/chat/get-customer-messages', [ChatController::class, 'openCustomerChat'], function(): int {
    if (!AuthHelper::isAuthenticated()) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});
$router -> post('/api/chat/send-message', [ChatController::class, 'sendMessage'], function(): int {
    if (!AuthHelper::isAuthenticated()) {
        return HttpStatusCode::UNAUTHORIZED;
    }
    return HttpStatusCode::OK;
});

$router -> listenRoute();