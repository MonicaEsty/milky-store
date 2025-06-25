<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_id' => 1,
                'name' => "Chocolate Lover's",
                'description' => 'Moist cake with Belgian milk chocolate and chocochip.',
                'price' => 25000,
                'weight' => 300,
                'stock' => 50,
                'image' => '1750740316_18e887cfe0d8b19ec07f.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-23 18:01:20',
                'updated_at' => '2025-06-24 04:45:16',
            ],
            [
                'category_id' => 1,
                'name' => 'Tiramisu',
                'description' => 'Cake with coffee, mascarpone cream cheese, and Belgian chocolate.',
                'price' => 25000,
                'weight' => 300,
                'stock' => 30,
                'image' => 'tiramisu.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-23 18:01:20',
                'updated_at' => '2025-06-24 04:57:04',
            ],
            [
                'category_id' => 3,
                'name' => 'Borneo',
                'description' => 'Dessert box dengan oreo dan burnt cream',
                'price' => 25000,
                'weight' => null,
                'stock' => 40,
                'image' => 'oreo.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-23 18:01:20',
                'updated_at' => '2025-06-23 18:01:20',
            ],
            [
                'category_id' => 1,
                'name' => 'Matcha Cheese',
                'description' => 'Matcha cake with cream cheese and matcha chocolate.',
                'price' => 25000,
                'weight' => 300,
                'stock' => 12,
                'image' => '1750740403_03c022b3601c679047d1.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-23 11:50:35',
                'updated_at' => '2025-06-24 04:46:43',
            ],
            [
                'category_id' => 1,
                'name' => 'Red Velvet',
                'description' => 'Red Velvet cake with cream cheese and crumble red velvet.',
                'price' => 25000,
                'weight' => 300,
                'stock' => 20,
                'image' => '1750740596_04e48aeb4486d42b8e2e.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-24 04:49:56',
                'updated_at' => '2025-06-24 12:01:26',
            ],
            [
                'category_id' => 1,
                'name' => 'Milk Bath',
                'description' => 'Soft vanilla cake with whipping cream and cheese topping.',
                'price' => 27000,
                'weight' => 300,
                'stock' => 10,
                'image' => '1750740684_f0d47fba9cea53c441b2.jpg',
                'is_active' => 1,
                'created_at' => '2025-06-24 04:51:24',
                'updated_at' => '2025-06-24 12:01:50',
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
