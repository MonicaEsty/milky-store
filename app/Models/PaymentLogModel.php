<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentLogModel extends Model
{
    protected $table = 'payment_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'order_id', 'transaction_id', 'payment_type', 'transaction_status',
        'fraud_status', 'gross_amount', 'signature_key', 'notification_body'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
