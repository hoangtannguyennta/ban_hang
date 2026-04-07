<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        return view('reviews.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra nếu người dùng đã đánh giá sản phẩm này rồi
        if (Review::where('user_id', $validated['user_id'])->where('product_id', $validated['product_id'])->exists()) {
            return redirect()->back()->withErrors(['message' => 'Người dùng này đã đánh giá sản phẩm này rồi.'])->withInput();
        }

        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'product']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        return view('reviews.edit', compact('review', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra unique constraint, nhưng cho phép cập nhật đánh giá hiện tại
        if (Review::where('user_id', $validated['user_id'])->where('product_id', $validated['product_id'])->where('id', '!=', $review->id)->exists()) {
            return redirect()->back()->withErrors(['message' => 'Người dùng này đã đánh giá sản phẩm này rồi.'])->withInput();
        }

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được xóa thành công!');
    }
}