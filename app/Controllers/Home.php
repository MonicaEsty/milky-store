<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Home - Milky Dessert Box',
            'products' => $this->productModel->getActiveProducts(),
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('home/index', $data);
    }

    public function about(): string
    {
        $data = [
            'title' => 'About - Milky Dessert Box'
        ];

        return view('home/about', $data);
    }

    public function shop(): string
    {
        $keyword = $this->request->getGet('search');
        $categoryId = $this->request->getGet('category');
        
        if ($keyword) {
            $products = $this->productModel->searchProducts($keyword);
        } elseif ($categoryId) {
            $products = $this->productModel->getProductsByCategory($categoryId);
        } else {
            $products = $this->productModel->getProductsWithCategory();
        }

        $data = [
            'title' => 'Shop - Milky Dessert Box',
            'products' => $products,
            'categories' => $this->categoryModel->getActiveCategories(),
            'keyword' => $keyword,
            'selectedCategory' => $categoryId
        ];

        return view('home/shop', $data);
    }
    public function shopByCategory($slug = null): string
{
    // Mapping slug ke nama kategori sesuai DB
    $slugToCategoryName = [
        'dessert-box' => 'Dessert Box',
        'cake' => 'Cake',
        'pudding' => 'Pudding'
    ];

    // Cek slug valid atau tidak
    if (!isset($slugToCategoryName[$slug])) {
        return redirect()->to('/shop');
    }

    // Ambil kategori berdasarkan nama (via CategoryModel)
    $category = $this->categoryModel
                     ->where('name', $slugToCategoryName[$slug])
                     ->first();

    if (!$category) {
        return redirect()->to('/shop');
    }

    // Ambil produk berdasarkan ID kategori
    $products = $this->productModel->getProductsByCategory($category['id']);

    $data = [
        'title' => $slugToCategoryName[$slug] . ' - Milky Dessert Box',
        'products' => $products,
        'categories' => $this->categoryModel->getActiveCategories(),
        'keyword' => null,
        'selectedCategory' => $category['id']
    ];

    return view('home/shop', $data);
    }

    public function contact(): string
    {
        $data = [
            'title' => 'Contact - Milky Dessert Box'
        ];

        return view('home/contact', $data);
    }

    public function productDetail($id): string
    {
        $product = $this->productModel->select('products.*, categories.name as category_name')
                                     ->join('categories', 'categories.id = products.category_id', 'left')
                                     ->where('products.id', $id)
                                     ->where('products.is_active', 1)
                                     ->first();

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        // Get related products from same category
        $relatedProducts = $this->productModel->where('category_id', $product['category_id'])
                                             ->where('id !=', $id)
                                             ->where('is_active', 1)
                                             ->limit(4)
                                             ->findAll();

        // Get all categories for breadcrumb
        $categories = $this->categoryModel->getActiveCategories();

        $data = [
            'title' => $product['name'] . ' - Milky Dessert Box',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'categories' => $categories
        ];

        return view('home/product_detail', $data);
    }
}
