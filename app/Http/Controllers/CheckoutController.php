<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('fe.checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'cart_data' => 'required|string', // Chuỗi JSON từ localStorage
        ]);

        $cart = json_decode($request->cart_data, true);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng trống.'], 400);
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'name' => $request->name,
                'shipping_address' => $request->shipping_address,
                'phone_number' => $request->phone_number,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $totalAmount = 0;
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price' => $product->price,
                ]);

                $totalAmount += $product->price * $item['qty'];
                
                // Cập nhật tồn kho
                if ($product->stock >= $item['qty']) {
                    $product->decrement('stock', $item['qty']);
                }
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('fe.checkout.success', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function success(Order $order)
    {
        return view('fe.thankyou', compact('order'));
    }
}