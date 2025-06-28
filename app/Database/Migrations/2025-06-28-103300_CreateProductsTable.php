<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'category_id'=> ['type' => 'INT', 'null' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'description'=> ['type' => 'TEXT', 'null' => true],
            'price'      => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'stock'      => ['type' => 'INT', 'default' => 0],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET', 'NULL');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
