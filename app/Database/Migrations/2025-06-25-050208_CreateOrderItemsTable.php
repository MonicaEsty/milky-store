<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
       //
    }
    
    public function down()
    {
        $this->forge->dropTable('order_items');
    }
    
}
