<?php
require_once __DIR__ . '/../models/Product.php';
class CartController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        $productModel = new Product($this->pdo);
        $cartItems    = $_SESSION['cart'];
        $subtotal     = 0;
        foreach ($cartItems as $id => &$item) {
            $product = $productModel->findById($id);
            if ($product) {
                $item['price'] = $product['price'];
                $item['name']  = $product['name'];
                $item['image'] = $product['image'];
                $subtotal     += $product['price'] * $item['qty'];
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        unset($item);

        $shippingCost = $subtotal >= 150 ? 0 : 30;
        $total        = $subtotal + $shippingCost;

        require __DIR__ . '/../views/cart/index.php';
    }
    public function add()
    {
        $productModel = new Product($this->pdo);
        $productId    = (int) ($_POST['product_id'] ?? 0);
        $qty          = max(1, (int) ($_POST['qty'] ?? 1));

        if ($productId > 0) {
            $product = $productModel->findById($productId);
            if ($product) {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['qty'] += $qty;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'product_id' => $productId,
                        'name'       => $product['name'],
                        'price'      => $product['price'],
                        'image'      => $product['image'],
                        'qty'        => $qty,
                    ];
                }
                $_SESSION['flash'] = 'Article ajouté au panier.';
            }
        }

        $redirect = $_POST['redirect'] ?? 'index.php?page=cart';
        header('Location: ' . $redirect);
        exit;
    }
    public function remove()
    {
        $productId = (int) ($_GET['id'] ?? 0);

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            $_SESSION['flash'] = 'Article supprimé.';
        }
        header('Location: index.php?page=cart');
        exit;
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantities = $_POST['qty'] ?? [];

            foreach ($quantities as $productId => $qty) {
                $productId = (int) $productId;
                $qty       = (int) $qty;

                if ($qty <= 0) {
                    unset($_SESSION['cart'][$productId]);
                } elseif (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['qty'] = $qty;
                }
            }
            $_SESSION['flash'] = 'Panier mis à jour.';
        }
        header('Location: index.php?page=cart');
        exit;
    }
}
