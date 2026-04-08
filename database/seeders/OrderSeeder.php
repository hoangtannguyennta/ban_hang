<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        foreach ($users as $user) {
            // Mỗi user tạo 1-2 đơn hàng
            for ($i = 0; $i < rand(1, 2); $i++) {
                $order = Order::create([
                    'name' => $user->name,
                    'total_amount' => 0, // Sẽ tính toán lại sau khi thêm item
                    'status' => $statuses[array_rand($statuses)],
                    'shipping_address' => 'Số ' . rand(1, 100) . ' Đường ABC, Quận XYZ, TP.HCM',
                    'phone_number' => '090' . rand(1000000, 9999999),
                ]);

                $total = 0;
                // Mỗi đơn hàng có 1-3 sản phẩm ngẫu nhiên
                $randomProducts = $products->random(rand(1, 3));
                foreach ($randomProducts as $product) {
                    $qty = rand(1, 2);
                    $price = $product->price;
                    // Lấy ngẫu nhiên 1 size từ danh sách size của sản phẩm
                    $size = !empty($product->sizes) ? $product->sizes[array_rand($product->sizes)] : null;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'size' => $size,
                        'price' => $price,
                    ]);
                    $total += $price * $qty;
                }
                $order->update(['total_amount' => $total]);
            }
        }
    }
}