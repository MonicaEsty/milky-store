<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username'  => 'admin',
                'email'     => 'admin@milkystore.com',
                'password'  => '$2a$12$MXFhSiEz6ySI4Ro/bwCwauo/3ldBS1ZpoqYjwOdMRj...', // hash bcrypt
                'full_name' => 'Administrator',
                'phone'     => null,
                'address'   => null,
                'role'      => 'admin',
                'is_active' => 1,
            ],
            [
                'username'  => 'customer1',
                'email'     => 'customer@example.com',
                'password'  => '$2y$10$92lXUNpkj0r0OQ5byMi.Ye4oKoEa3Ro9llC/.og/at2...', // hash bcrypt
                'full_name' => 'John Doe',
                'phone'     => null,
                'address'   => null,
                'role'      => 'customer',
                'is_active' => 1,
            ],
            [
                'username'  => 'Jeje',
                'email'     => 'jeje@gmail.com',
                'password'  => '$2y$10$SLNMl1aCLmbWnKCtLB7B6.1ck8Z3bua3zdSFybaSCzK...', // hash bcrypt
                'full_name' => 'AjengPembayun',
                'phone'     => '082137758554',
                'address'   => 'jl.Madukoro V,18',
                'role'      => 'customer',
                'is_active' => 1,
            ],
        ];

        $userTable = $this->db->table('users');

        foreach ($users as $user) {
            $exists = $userTable
                ->where('username', $user['username'])
                ->countAllResults();

            if ($exists == 0) {
                $userTable->insert($user);
            }
        }
    }
}
