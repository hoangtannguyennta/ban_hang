<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm, bạn có thể thêm paginate nếu muốn
        $products = Product::latest()->get();
        $slides = Slide::where('is_active', true)->orderBy('order')->get();
        return view('fe.index', compact('products', 'slides'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // Lấy sản phẩm liên quan (cùng danh mục hoặc ngẫu nhiên)
        $relatedProducts = Product::where('id', '!=', $product->id)->limit(4)->get();
        return view('fe.product', compact('product', 'relatedProducts'));
    }
}