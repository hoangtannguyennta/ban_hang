<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Áo'],
            ['name' => 'Quần'],
            ['name' => 'Giày dép'],
            ['name' => 'Phong thủy'],
            ['name' => 'Xe ô tô'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
