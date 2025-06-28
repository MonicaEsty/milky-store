<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'order_number', 'total_amount', 'shipping_cost', 'grand_total',
        'customer_name', 'customer_email', 'customer_phone',
        'status', 'payment_method', 'payment_status', 
        'midtrans_transaction_id', 'midtrans_order_id', 
        'shipping_address', 'notes'
    ];
    

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getOrdersWithUser()
    {
        return $this->select('orders.*, users.full_name, users.email')
                    ->join('users', 'users.id = orders.user_id')
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }

    public function getUserOrders($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function generateOrderNumber()
    {
        return 'MDB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
