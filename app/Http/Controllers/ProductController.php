<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Xử lý tìm kiếm nếu có
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp
        switch ($request->sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $slides = Slide::where('is_active', true)->orderBy('order')->get();
        $categories = Category::latest()->take(5)->get();

        return view('fe.index', compact('products', 'slides', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // Lấy sản phẩm liên quan (cùng danh mục hoặc ngẫu nhiên)
        $relatedProducts = Product::where('id', '!=', $product->id)->limit(4)->get();
        $categories = Category::latest()->take(5)->get();
        return view('fe.product', compact('product', 'relatedProducts', 'categories'));
    }

    public function category(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $query = Product::where('category_id', $id)->with('category');

        // Tìm kiếm theo tên trong danh mục
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp sản phẩm
        switch ($request->sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::latest()->take(5)->get();

        return view('fe.productList', compact('products', 'category', 'categories'));
    }

    public function allProducts(Request $request)
    {
        
        $query = Product::with('category');

        // Xử lý tìm kiếm nếu có
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(5)->withQueryString();
        $categories = Category::latest()->take(5)->get();

        return view('fe.productAll', compact('products', 'categories'));
    }
}