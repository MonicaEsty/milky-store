<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'category_id', 'name', 'description', 'price', 
        'stock', 'image', 'weight', 'is_active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'price' => 'required|decimal',
        'stock' => 'required|integer'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('products.is_active', 1)
                    ->findAll();
    }

    public function getActiveProducts()
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('products.category_id', $categoryId)
                    ->where('products.is_active', 1)
                    ->findAll();
    }

    public function searchProducts($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->groupStart()
                        ->like('products.name', $keyword)
                        ->orLike('products.description', $keyword)
                        ->orLike('categories.name', $keyword)
                    ->groupEnd()
                    ->where('products.is_active', 1)
                    ->findAll();
    }

    public function getFeaturedProducts($limit = 6)
    {
        return $this->where('is_active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getPopularProducts($limit = 6)
    {
        // This would typically join with order_items to get most ordered products
        // For now, we'll just return recent products
        return $this->where('is_active', 1)
                    ->where('stock >', 0)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
