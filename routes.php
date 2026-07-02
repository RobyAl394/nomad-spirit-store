<?php
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/AdminController.php';
$page = $_GET['page'] ?? 'home';
switch ($page) {
    case 'home':
        $controller = new ProductController($pdo);
        $controller->home();
        break;

    case 'products':
        $controller = new ProductController($pdo);
        $controller->products();
        break;

    case 'product':
        $controller = new ProductController($pdo);
        $controller->product();
        break;

    case 'cart':
        $controller = new CartController($pdo);
        $controller->index();
        break;

    case 'cart-add':
        $controller = new CartController($pdo);
        $controller->add();
        break;

    case 'cart-remove':
        $controller = new CartController($pdo);
        $controller->remove();
        break;

    case 'cart-update':
        $controller = new CartController($pdo);
        $controller->update();
        break;

    case 'checkout':
        $controller = new OrderController($pdo);
        $controller->checkout();
        break;

    case 'place-order':
        $controller = new OrderController($pdo);
        $controller->placeOrder();
        break;

    case 'order-confirm':
        $controller = new OrderController($pdo);
        $controller->confirm();
        break;

    case 'my-orders':
        $controller = new OrderController($pdo);
        $controller->myOrders();
        break;

    case 'login':
        $controller = new AuthController($pdo);
        $controller->login();
        break;

    case 'signup':
        $controller = new AuthController($pdo);
        $controller->signup();
        break;

    case 'logout':
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    case 'admin':
        $controller = new AdminController($pdo);
        $controller->dashboard();
        break;

    case 'admin-products':
        $controller = new AdminController($pdo);
        $controller->products();
        break;

    case 'admin-product-form':
        $controller = new AdminController($pdo);
        $controller->productForm();
        break;

    case 'admin-product-delete':
        $controller = new AdminController($pdo);
        $controller->productDelete();
        break;

    case 'admin-categories':
        $controller = new AdminController($pdo);
        $controller->categories();
        break;

    case 'admin-category-form':
        $controller = new AdminController($pdo);
        $controller->categoryForm();
        break;

    case 'admin-category-delete':
        $controller = new AdminController($pdo);
        $controller->categoryDelete();
        break;

    case 'admin-users':
        $controller = new AdminController($pdo);
        $controller->users();
        break;

    case 'admin-user-role':
        $controller = new AdminController($pdo);
        $controller->userRole();
        break;

    case 'admin-user-delete':
        $controller = new AdminController($pdo);
        $controller->userDelete();
        break;

    case 'admin-orders':
        $controller = new AdminController($pdo);
        $controller->orders();
        break;

    case 'admin-order-status':
        $controller = new AdminController($pdo);
        $controller->orderStatus();
        break;

    default:
        header('Location: index.php');
        exit;
}
