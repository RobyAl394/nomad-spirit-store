<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
class ProductController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function home()
    {
        $productModel  = new Product($this->pdo);
        $categoryModel = new Category($this->pdo);

        $featuredProducts = $productModel->getFeatured(8);
        $categories       = $categoryModel->getAll();

        $testimonials = [
            ['stars' => 5, 'text' => 'Je me sens connectée à mes racines. La melhfa s\'adapte à toutes les morphologies et est si élégante.', 'author' => 'Fatima', 'city' => 'Laayoune'],
            ['stars' => 5, 'text' => 'La daraa est l\'essence du patrimoine sahraoui. Le tissu respire parfaitement sous le soleil du désert.', 'author' => 'Omar', 'city' => 'Dakhla'],
            ['stars' => 5, 'text' => 'Artisanat magnifique ! Les accessoires en argent portent la profonde histoire des tribus nomades.', 'author' => 'Amina', 'city' => 'Smara'],
        ];

        require __DIR__ . '/../views/home.php';
    }

    public function products()
    {
        $productModel  = new Product($this->pdo);
        $categoryModel = new Category($this->pdo);

        $categoryHierarchy = $categoryModel->getHierarchy();
        $slug              = $_GET['slug'] ?? '';
        $currentCategory   = null;

        if ($slug) {
            $currentCategory = $categoryModel->findBySlug($slug);
            if ($currentCategory) {
                $children = $categoryModel->getChildren($currentCategory['id']);
                if (!empty($children)) {
                    $products = $productModel->getByParentCategory($currentCategory['id']);
                } else {
                    $products = $productModel->getByCategory($currentCategory['id']);
                }
            } else {
                $products = [];
            }
        } else {
            $products = $productModel->getAll();
        }

        $keyword = trim($_GET['q'] ?? '');
        if ($keyword) {
            $products = $productModel->search($keyword);
        }

        require __DIR__ . '/../views/products/index.php';
    }
    public function product()
    {
        $productModel = new Product($this->pdo);
        $id           = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?page=products');
            exit;
        }

        $product = $productModel->findById($id);

        if (!$product) {
            header('Location: index.php?page=products');
            exit;
        }
        $relatedProducts = $productModel->getByCategory($product['category_id'] ?? 0);
        $relatedProducts = array_filter($relatedProducts, fn($p) => $p['id'] != $id);
        $relatedProducts = array_slice(array_values($relatedProducts), 0, 4);

        require __DIR__ . '/../views/products/show.php';
    }
}
