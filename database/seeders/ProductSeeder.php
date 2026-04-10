<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id')->toArray();

        $products = [
            ['name' => 'Nike Air Force 1 \'07', 'price' => 2500000, 'stock' => 50, 'sizes' => ['38', '39', '40', '41', '42']],
            ['name' => 'Adidas Ultraboost Light', 'price' => 4200000, 'stock' => 30, 'sizes' => ['39', '40', '41', '42', '43']],
            ['name' => 'Áo Thun Oversize Cotton', 'price' => 350000, 'stock' => 100, 'sizes' => ['S', 'M', 'L', 'XL']],
            ['name' => 'Quần Jean Slim Fit', 'price' => 680000, 'stock' => 45, 'sizes' => ['29', '30', '31', '32']],
            ['name' => 'Sneaker Retro Vintage', 'price' => 950000, 'stock' => 40, 'sizes' => ['37', '38', '39', '40']],
            ['name' => 'Áo Khoác Gió Waterproof', 'price' => 1200000, 'stock' => 20, 'sizes' => ['M', 'L', 'XL']],
            ['name' => 'Giày Cao Gót Stiletto', 'price' => 1500000, 'stock' => 15, 'sizes' => ['35', '36', '37', '38']],
            ['name' => 'Túi Đeo Chéo Streetwear', 'price' => 450000, 'stock' => 60, 'sizes' => ['Free Size']],
        ];

        // Danh sách ảnh thời trang thực tế để giao diện trông "xịn" hơn
        $fashionImages = [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
            'https://images.unsplash.com/photo-1587563871167-1ee9c731aefb',
            'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
            'https://images.unsplash.com/photo-1541099649105-f69ad21f3246',
            'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77',
            'https://images.unsplash.com/photo-1591047139829-d91aecb6caea',
            'https://images.unsplash.com/photo-1543163521-1bf539c55dd2',
            'https://images.unsplash.com/photo-1548036328-c9fa89d128fa',
        ];

        foreach ($products as $key => $item) {
            Product::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $faker->paragraph(2),
                'price' => $item['price'],
                'stock' => $item['stock'],
                'sizes' => $item['sizes'],
                'images' => $fashionImages[$key] ?? $faker->imageUrl(640, 480, 'fashion'),
                'category_id' => !empty($categoryIds) ? $categoryIds[array_rand($categoryIds)] : null,
            ]);
        }
    }
}