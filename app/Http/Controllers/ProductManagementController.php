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
    /**
     * Nén và chuyển đổi ảnh sang Base64
     */
    private function compressImageToBase64($file, $maxWidth = 1000, $quality = 75)
    {
        $imageInfo = getimagesize($file->getRealPath());
        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Tạo resource ảnh dựa trên loại file
        switch ($mime) {
            case 'image/jpeg': case 'image/jpg': $image = imagecreatefromjpeg($file->getRealPath()); break;
            case 'image/png':  $image = imagecreatefrompng($file->getRealPath()); break;
            case 'image/webp': $image = imagecreatefromwebp($file->getRealPath()); break;
            default: return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        // Resize nếu ảnh quá rộng
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            $tmp = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $image = $tmp;
        }

        // Sử dụng Output Buffering để lấy dữ liệu ảnh đã nén
        ob_start();
        imagejpeg($image, null, $quality); // Chuyển về định dạng JPEG để nén tốt nhất
        $binaryData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/jpeg;base64,' . base64_encode($binaryData);
    }

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
            'images' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('images')) {
            try {
                $file = $request->file('images');
                $validated['images'] = $this->compressImageToBase64($file);
            } catch (\Exception $e) {
                return back()->withErrors(['images' => 'Lỗi xử lý ảnh Base64: ' . $e->getMessage()])->withInput();
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
            'images' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('images')) {
            try {
                $file = $request->file('images');
                $validated['images'] = $this->compressImageToBase64($file);
            } catch (\Exception $e) {
                return back()->withErrors(['images' => 'Lỗi xử lý ảnh Base64: ' . $e->getMessage()])->withInput();
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}