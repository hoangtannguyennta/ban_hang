<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminSlideController extends Controller
{
    /**
     * Nén và chuyển đổi ảnh sang Base64
     */
    private function compressImageToBase64($file, $maxWidth = 1200, $quality = 80)
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
        $slides = Slide::orderBy('order')->paginate(10);
        return view('slides.index', compact('slides'));
    }

    public function create()
    {
        return view('slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'required|array',
            'images.*' => 'image',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('images')) {
            try {
                foreach ($request->file('images') as $file) {
                    $base64Image = $this->compressImageToBase64($file);
                    Slide::create([
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'desc' => $request->desc,
                        'link' => $request->link,
                        'order' => $request->order ?? 0,
                        'is_active' => $request->boolean('is_active', true),
                        'images' => $base64Image,
                    ]);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['images' => 'Lỗi lưu slide: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect()->route('admin.slides.index')->with('success', 'Thêm các slide thành công!');
    }

    public function edit(Slide $slide)
    {
        return view('slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('images')) {
            try {
                foreach ($request->file('images') as $file) {
                    $validated['images'] = $this->compressImageToBase64($file);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['images' => 'Lỗi cập nhật slide: ' . $e->getMessage()])->withInput();
            }
        }

        $slide->update(array_merge($validated, [
            'subtitle' => $request->subtitle,
            'desc' => $request->desc,
            'link' => $request->link,
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('admin.slides.index')->with('success', 'Cập nhật slide thành công!');
    }

    public function destroy(Slide $slide)
    {
        $slide->delete();
        return redirect()->back()->with('success', 'Xóa slide thành công!');
    }
}