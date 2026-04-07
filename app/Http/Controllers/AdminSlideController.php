<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            foreach ($request->file('images') as $file) {
                $path = $file->store('slides', 'public');
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
            Storage::disk('public')->delete($slide->images);      
            foreach ($request->file('images') as $file) {
                $path = $file->store('slides', 'public');
                $validated['images'] = $path;
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
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();
        return redirect()->back()->with('success', 'Xóa slide thành công!');
    }
}