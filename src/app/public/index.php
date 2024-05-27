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
use API\CartController;
use API\AuthController;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv -> load();

$router = new Router();

// Market Pages
$router -> get('/', [MarketController::class, 'index']);
$router -> get('/login', [MarketController::class, 'login']);
$router -> post('/login', [CustomerController::class, 'login']);
$router -> get('/product', [MarketController::class, 'product']);
$router -> get('/profile', [MarketController::class, 'profile']);
$router -> get('/orders', [MarketController::class, 'orders']);
$router -> get('/checkout', [MarketController::class, 'checkout']);

// Admin Pages
$router -> get('/admin', [AdminController::class, 'login']);
$router -> get('/admin/login', [AdminController::class, 'login']);
$router -> get('/admin/user', [AdminController::class, 'index']);
$router -> get('/admin/product', [AdminController::class, 'product']);
$router -> get('/admin/brand', [AdminController::class, 'brand']);
$router -> get('/admin/category', [AdminController::class, 'category']);
$router -> get('/admin/customer', [AdminController::class, 'customer']);
$router -> get('/admin/role', [AdminController::class, 'role']);

// API
$router -> get('/api/close-session', [AuthController::class, 'closeSession']);
$router -> get('/api/has-customer-session', [CustomerController::class, 'hasCustomerSession']);
$router -> post('/api/search-bar', [ProductController::class, 'searchBar']);
$router -> post('/api/customer/login', [CustomerController::class, 'login']);
$router -> post('/api/user/login', [UserController::class, 'login']);

// API - User
$router -> get('/api/users', [UserController::class, 'getAll']);
$router -> post('/api/user', [UserController::class, 'create']);
$router -> put('/api/user', [UserController::class, 'update']);
$router -> delete('/api/user', [UserController::class, 'delete']);

// API - Product
$router -> get('/api/products', [ProductController::class, 'getAll']);
$router -> get('/api/product', [ProductController::class, 'getProductDescription']);
$router -> post('/api/product', [ProductController::class, 'create']);
$router -> put('/api/product', [ProductController::class, 'update']);
$router -> delete('/api/product', [ProductController::class, 'delete']);

// API - Brand
$router -> get('/api/brands', [BrandController::class, 'getAll']);
$router -> post('/api/brand', [BrandController::class, 'create']);
$router -> put('/api/brand', [BrandController::class, 'update']);
$router -> delete('/api/brand', [BrandController::class, 'delete']);

// API - Category
$router -> get('/api/categories', [CategoryController::class, 'getAll']);
$router -> post('/api/category', [CategoryController::class, 'create']);
$router -> put('/api/category', [CategoryController::class, 'update']);
$router -> delete('/api/category', [CategoryController::class, 'delete']);

// API - Customer
$router -> get('/api/customers', [CustomerController::class, 'getAll']);
$router -> post('/api/customer', [CustomerController::class, 'create']);
$router -> put('/api/customer', [CustomerController::class, 'update']);
$router -> delete('/api/customer', [CustomerController::class, 'delete']);
$router -> post('/api/save-profile', [CustomerController::class, 'saveProfile']);

// API - Role
$router -> get('/api/roles', [RoleController::class, 'getAll']);
$router -> post('/api/role', [RoleController::class, 'create']);
$router -> put('/api/role', [RoleController::class, 'update']);
$router -> delete('/api/role', [RoleController::class, 'delete']);

// API - Cart
$router -> get('/api/cart', [CartController::class, 'getAll']);
$router -> post('/api/cart', [CartController::class, 'add']);
$router -> delete('/api/cart', [CartController::class, 'delete']);
$router -> post('/api/set-quantity', [CartController::class, 'setQuantity']);
$router -> delete('/api/quantity', [CartController::class, 'decrementQuantity']);
$router -> post('/api/quantity', [CartController::class, 'incrementQuantity']);

$router -> listenRoute();