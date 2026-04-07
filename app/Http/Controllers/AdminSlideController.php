<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminSlideController extends Controller
{
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
                $uploadPath = public_path('uploads/slides');
                File::ensureDirectoryExists($uploadPath, 0755, true);
                @chmod($uploadPath, 0777); // Cấp quyền ghi cho Render

                foreach ($request->file('images') as $file) {
                    $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
                    $file->move($uploadPath, $fileName);
                    $path = 'uploads/slides/' . $fileName;
                    
                    Slide::create([
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'desc' => $request->desc,
                        'link' => $request->link,
                        'order' => $request->order ?? 0,
                        'is_active' => $request->boolean('is_active', true),
                        'images' => $path,
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
                if ($slide->images && file_exists(public_path($slide->images))) {
                    @unlink(public_path($slide->images));
                }

                $uploadPath = public_path('uploads/slides');
                File::ensureDirectoryExists($uploadPath, 0755, true);
                @chmod($uploadPath, 0777); // Đảm bảo quyền ghi khi update

                foreach ($request->file('images') as $file) {
                    $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
                    $file->move($uploadPath, $fileName);
                    $validated['images'] = 'uploads/slides/' . $fileName;
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
        if ($slide->images && file_exists(public_path($slide->images))) {
            unlink(public_path($slide->images));
        }
        $slide->delete();
        return redirect()->back()->with('success', 'Xóa slide thành công!');
    }
}