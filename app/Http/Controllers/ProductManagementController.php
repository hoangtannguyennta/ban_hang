<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                // Làm sạch tên file để tránh lỗi hệ thống Linux
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
                $uploadPath = public_path('uploads/products');
                
                File::ensureDirectoryExists($uploadPath, 0755, true);
                @chmod($uploadPath, 0777); // Cấp quyền ghi tối đa cho Render
                
                $file->move($uploadPath, $fileName);
                $validated['image'] = 'uploads/products/' . $fileName;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Lỗi upload ảnh: ' . $e->getMessage()])->withInput();
            }
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            try {
                if ($product->image && file_exists(public_path($product->image))) {
                    @unlink(public_path($product->image));
                }
                
                $file = $request->file('image');
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
                $uploadPath = public_path('uploads/products');
                
                File::ensureDirectoryExists($uploadPath, 0755, true);
                @chmod($uploadPath, 0777); // Đảm bảo thư mục có thể ghi
                
                $file->move($uploadPath, $fileName);
                $validated['image'] = 'uploads/products/' . $fileName;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Lỗi cập nhật ảnh: ' . $e->getMessage()])->withInput();
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}