<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'product_id', 'quantity'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCartItems($userId)
    {
        return $this->select('carts.*, products.name, products.price, products.image, products.stock')
                    ->join('products', 'products.id = carts.product_id')
                    ->where('carts.user_id', $userId)
                    ->where('products.is_active', 1)
                    ->findAll();
    }

    public function getCartTotal($userId)
    {
        $items = $this->getCartItems($userId);
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCartCount($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function clearCart($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}
