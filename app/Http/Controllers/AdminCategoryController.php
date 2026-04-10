<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    private function compressImageToBase64($file, $maxWidth = 500, $quality = 80)
    {
        if (!extension_loaded('gd')) {
            return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $imageInfo = @getimagesize($file->getRealPath());
        if (!$imageInfo) {
            return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        try {
            switch ($mime) {
                case 'image/jpeg': case 'image/jpg': $image = @imagecreatefromjpeg($file->getRealPath()); break;
                case 'image/png':  $image = @imagecreatefrompng($file->getRealPath()); break;
                case 'image/webp': $image = @imagecreatefromwebp($file->getRealPath()); break;
                default: $image = false;
            }

            if (!$image) {
                return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            }

            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($maxWidth / $width));
                $tmp = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $image = $tmp;
            }

            ob_start();
            imagejpeg($image, null, $quality);
            $binaryData = ob_get_clean();
            imagedestroy($image);

            return 'data:image/jpeg;base64,' . base64_encode($binaryData);
        } catch (\Throwable $e) {
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }
    }


    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->compressImageToBase64($request->file('icon'));
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->compressImageToBase64($request->file('icon'));
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}