<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';

class OrderController
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?page=cart');
            exit;
        }

        $error     = '';
        $cartItems = $_SESSION['cart'];
        $subtotal  = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $shippingCost = $subtotal >= 150 ? 0 : 30;
        $total        = $subtotal + $shippingCost;

        $prefill = [];
        if (isset($_SESSION['user_id'])) {
            $userModel = new User($this->pdo);
            $user = $userModel->findById($_SESSION['user_id']);
            if ($user) {
                $prefill = [
                    'name'    => $user['name'],
                    'email'   => $user['email'],
                    'phone'   => $user['phone'],
                    'address' => $user['address'] ?? '',
                ];
            }
        }

        require __DIR__ . '/../views/orders/checkout.php';
    }

    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=checkout');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: index.php?page=cart');
            exit;
        }

        $orderModel   = new Order($this->pdo);
        $productModel = new Product($this->pdo);

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $error   = '';

        if (empty($name) || empty($email) || empty($address)) {
            $error     = 'Ce champ est obligatoire.';
            $cartItems = $_SESSION['cart'];
            $subtotal  = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['qty'];
            }
            $shippingCost = $subtotal >= 150 ? 0 : 30;
            $total        = $subtotal + $shippingCost;
            $prefill      = compact('name', 'email', 'phone', 'address');
            require __DIR__ . '/../views/orders/checkout.php';
            exit;
        }
        $cartItems = $_SESSION['cart'];
        $total     = 0;
        foreach ($cartItems as &$item) {
            $product = $productModel->findById($item['product_id']);
            if ($product) {
                $item['price'] = $product['price'];
                $total        += $product['price'] * $item['qty'];
            }
        }
        unset($item);
        $total += ($total >= 150) ? 0 : 30;

        $orderId = $orderModel->create([
            'user_id'          => $_SESSION['user_id'] ?? null,
            'guest_name'       => !isset($_SESSION['user_id']) ? $name : null,
            'guest_email'      => !isset($_SESSION['user_id']) ? $email : null,
            'guest_phone'      => !isset($_SESSION['user_id']) ? $phone : null,
            'shipping_address' => $address,
            'total'            => $total,
        ]);

        foreach ($cartItems as $item) {
            $orderModel->addItem($orderId, [
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'quantity'     => $item['qty'],
                'price'        => $item['price'],
            ]);
        }

        $_SESSION['cart']          = [];
        $_SESSION['last_order_id'] = $orderId;

        header('Location: index.php?page=order-confirm');
        exit;
    }

    public function confirm()
    {
        $orderId = $_SESSION['last_order_id'] ?? 0;

        if (!$orderId) {
            header('Location: index.php?page=home');
            exit;
        }

        $orderModel = new Order($this->pdo);
        $order      = $orderModel->findById($orderId);
        $orderItems = $orderModel->getItems($orderId);

        require __DIR__ . '/../views/orders/confirm.php';
    }

    public function myOrders()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $orderModel = new Order($this->pdo);
        $orders     = $orderModel->getByUser($_SESSION['user_id']);

        require __DIR__ . '/../views/orders/my_orders.php';
    }
}
