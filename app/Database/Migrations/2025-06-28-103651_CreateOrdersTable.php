<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'auto_increment' => true],
            'user_id'             => ['type' => 'INT'],
            'order_number'        => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'total_amount'        => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'status'              => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'], 'default' => 'pending'],
            'payment_method'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'payment_status'      => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'failed', 'expired'], 'default' => 'pending'],
            'midtrans_transaction_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'midtrans_order_id'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'shipping_address'    => ['type' => 'TEXT', 'null' => true],
            'notes'               => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
