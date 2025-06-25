<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     ...
        // ]);
        // $this->forge->createTable('users');
    }


    public function down()
    {
        $this->forge->dropTable('users');
    }
}
