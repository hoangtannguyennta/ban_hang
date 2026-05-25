<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QrCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class CheckoutController extends Controller
{
    public function index()
    {
        $activeQr = QrCode::where('is_active', true)->first();
        $categories = Category::latest()->take(5)->get();
        return view('fe.checkout', compact('activeQr', 'categories'));
    }

    public function store(Request $request)
    {
        // Giải mã dữ liệu giỏ hàng gửi từ frontend (localStorage)
        $cartData = json_decode($request->cart_data, true);
        
        if (empty($cartData)) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng trống']);
        }

        DB::beginTransaction();
        try {
            // Gộp các trường địa chỉ thành một chuỗi duy nhất
            $fullAddress = "{$request->shipping_address}, {$request->ward}, {$request->district}, {$request->province}";

            // 1. Tạo đơn hàng chính
            $order = Order::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'shipping_address' => $fullAddress,
                'payment_method' => $request->payment_method, // 'cod' hoặc 'transfer'
                'total_amount' => 0, 
                'status' => 'pending'
            ]);

            $total = 0;
            // 2. Tạo chi tiết đơn hàng
            foreach ($cartData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'size' => $item['size'] ?? null,
                ]);
                $total += $item['price'] * $item['qty'];
            }

            // Cập nhật lại tổng tiền thực tế
            $order->update(['total_amount' => $total]);

            DB::commit();

            // Gửi email xác nhận nếu người dùng có cung cấp địa chỉ email
            Mail::to('nguyenht.nta@gmail.com')->send(new OrderPlaced($order));
            
            return response()->json([
                'success' => true,
                'redirect_url' => route('fe.checkout.success', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function success(Order $order)
    {
        $categories = Category::latest()->take(5)->get();
        return view('fe.thankyou', compact('order', 'categories'));
    }
}