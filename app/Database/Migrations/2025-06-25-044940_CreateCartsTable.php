<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartsTable extends Migration
{
    public function up()
    {
        // kosongkan isi untuk mencegah eksekusi ulang
    }


    public function down()
    {
        $this->forge->dropTable('carts');
    }


}
