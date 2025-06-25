<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Shop extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $this->request->getGet('category');
        $search = $this->request->getGet('search');

        $query = $productModel->where('is_active', 1); // hanya produk aktif

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($search) {
            $query->like('name', $search);
        }

        $products = $query->findAll();
        $categories = $categoryModel->findAll();

        return view('shop', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
            'keyword' => $search
        ]);
    }
}
