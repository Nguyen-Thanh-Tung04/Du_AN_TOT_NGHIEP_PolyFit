<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }
    public function create(){
        return view('admin.banner.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|max:2048',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;

        // Upload và lưu hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        $banner->link = $request->link;
        $banner->is_active = $request->is_active ? 1 : 0;
        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner đã được tạo thành công');
    }
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'is_active' => 'required|boolean',
        ]);

        $banner = Banner::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banner.index')->with('success', 'Đã cập nhật  thành công.');
    }
    public function delete($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('banner.index')->with('success', 'Đã xóa thành công.');
    }

}
