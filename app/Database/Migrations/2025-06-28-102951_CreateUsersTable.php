<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'username'    => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_name'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'address'     => ['type' => 'TEXT', 'null' => true],
            'role'        => ['type' => 'ENUM', 'constraint' => ['admin', 'customer'], 'default' => 'customer'],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
