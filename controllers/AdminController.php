<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
class AdminController
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            require __DIR__ . '/../views/admin/access_denied.php';
            exit;
        }
    }
    public function dashboard()
    {
        $productModel  = new Product($this->pdo);
        $categoryModel = new Category($this->pdo);
        $userModel     = new User($this->pdo);
        $orderModel    = new Order($this->pdo);
        $message = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        $stats = [
            'products'   => $productModel->count(),
            'categories' => $categoryModel->count(),
            'users'      => $userModel->count(),
            'orders'     => $orderModel->count(),
        ];
        $recentOrders = array_slice($orderModel->getAll(), 0, 10);
        require __DIR__ . '/../views/admin/dashboard.php';
    }
    public function products()
    {
        $productModel  = new Product($this->pdo);
        $categoryModel = new Category($this->pdo);
        $message = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        $products   = $productModel->getAll();
        $categories = $categoryModel->getAll();
        require __DIR__ . '/../views/admin/products/index.php';
    }
    public function productForm()
    {
        $productModel  = new Product($this->pdo);
        $categoryModel = new Category($this->pdo);
        $categories = $categoryModel->getAll();
        $product    = null;
        $error      = '';
        $editId = (int) ($_GET['id'] ?? 0);
        if ($editId > 0) {
            $product = $productModel->findById($editId);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price'       => (float) ($_POST['price'] ?? 0),
                'old_price'   => trim($_POST['old_price'] ?? '') ?: null,
                'stock'       => (int) ($_POST['stock'] ?? 0),
                'category_id' => (int) ($_POST['category_id'] ?? 0),
                'badge'       => $_POST['badge'] ?? '',
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'image'       => trim($_POST['image_url'] ?? ''),
            ];
            if (!empty($_FILES['image_file']['name'])) {
                $uploadResult = $this->uploadImage($_FILES['image_file']);
                if ($uploadResult['success']) {
                    $data['image'] = $uploadResult['path'];
                } else {
                    $error = $uploadResult['error'];
                }
            }
            if (empty($error)) {
                if ($editId > 0) {
                    $productModel->update($editId, $data);
                    $_SESSION['admin_msg'] = 'Produit modifié avec succès.';
                } else {
                    $productModel->create($data);
                    $_SESSION['admin_msg'] = 'Produit ajouté avec succès.';
                }
                header('Location: index.php?page=admin-products');
                exit;
            }
        }
        require __DIR__ . '/../views/admin/products/form.php';
    }
    public function productDelete()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $productModel = new Product($this->pdo);
            $productModel->delete($id);
            $_SESSION['admin_msg'] = 'Produit supprimé.';
        }
        header('Location: index.php?page=admin-products');
        exit;
    }
    public function categories()
    {
        $categoryModel = new Category($this->pdo);
        $message = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        $categories = $categoryModel->getAll();
        require __DIR__ . '/../views/admin/categories/index.php';
    }
    public function categoryForm()
    {
        $categoryModel = new Category($this->pdo);
        $category = null;
        $error    = '';
        $editId = (int) ($_GET['id'] ?? 0);
        if ($editId > 0) {
            $category = $categoryModel->findById($editId);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => trim($_POST['name'] ?? ''),
                'slug'        => trim($_POST['slug'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'image'       => trim($_POST['image_url'] ?? ''),
                'sort_order'  => (int) ($_POST['sort_order'] ?? 0),
            ];
            if (empty($data['slug'])) {
                $data['slug'] = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $data['name']));
            }
            if (!empty($_FILES['image_file']['name'])) {
                $uploadResult = $this->uploadImage($_FILES['image_file']);
                if ($uploadResult['success']) {
                    $data['image'] = $uploadResult['path'];
                } else {
                    $error = $uploadResult['error'];
                }
            }
            if (empty($error)) {
                if ($editId > 0) {
                    $categoryModel->update($editId, $data);
                    $_SESSION['admin_msg'] = 'Catégorie modifiée.';
                } else {
                    $categoryModel->create($data);
                    $_SESSION['admin_msg'] = 'Catégorie ajoutée.';
                }
                header('Location: index.php?page=admin-categories');
                exit;
            }
        }
        require __DIR__ . '/../views/admin/categories/form.php';
    }
    public function categoryDelete()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $categoryModel = new Category($this->pdo);
            $categoryModel->delete($id);
            $_SESSION['admin_msg'] = 'Catégorie supprimée.';
        }
        header('Location: index.php?page=admin-categories');
        exit;
    }
    public function users()
    {
        $userModel = new User($this->pdo);
        $message   = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        $users = $userModel->getAll();
        require __DIR__ . '/../views/admin/users/index.php';
    }
    public function userRole()
    {
        $id   = (int) ($_GET['id'] ?? 0);
        $role = $_GET['role'] ?? 'client';
        if ($id !== $_SESSION['user_id'] && in_array($role, ['client', 'admin'])) {
            $userModel = new User($this->pdo);
            $userModel->updateRole($id, $role);
        }
        header('Location: index.php?page=admin-users');
        exit;
    }
    public function userDelete()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0 && $id !== $_SESSION['user_id']) {
            $userModel = new User($this->pdo);
            $userModel->delete($id);
        }
        header('Location: index.php?page=admin-users');
        exit;
    }
    public function orders()
    {
        $orderModel = new Order($this->pdo);
        $message    = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        $orders = $orderModel->getAll();
        require __DIR__ . '/../views/admin/orders/index.php';
    }
    public function orderStatus()
    {
        $id     = (int) ($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'pending';
        $allowed = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
        if ($id > 0 && in_array($status, $allowed)) {
            $orderModel = new Order($this->pdo);
            $orderModel->updateStatus($id, $status);
        }
        header('Location: index.php?page=admin-orders');
        exit;
    }
    private function uploadImage(array $file): array
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        $maxSize      = 5 * 1024 * 1024;
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Erreur lors de l\'upload.'];
        }
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Type de fichier non autorisé. Utilisez JPG, PNG, WebP.'];
        }
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'Image trop lourde. Maximum 5 Mo.'];
        }
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('product_') . '.' . strtolower($ext);
        $destPath = __DIR__ . '/../uploads/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            return ['success' => true, 'path' => 'uploads/' . $filename];
        }
        return ['success' => false, 'error' => 'Impossible de déplacer le fichier uploadé.'];
    }
}
