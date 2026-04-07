<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Mỗi người dùng sẽ đánh giá ngẫu nhiên từ 1 đến 3 sản phẩm
            $randomProducts = $products->random(rand(1, 3));

            foreach ($randomProducts as $product) {
                Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Thường tạo đánh giá tích cực từ 3-5 sao
                    'comment' => "Sản phẩm " . $product->name . " dùng rất tốt, chất lượng tuyệt vời!",
                ]);
            }
        }
    }
}