<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        // Sementara dikosongkan supaya tidak error
    }
    

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
