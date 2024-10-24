<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index');
    }
    public function create(){
        return view('admin.banner.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image',
            'link' => 'nullable|url',
        ]);

        // Upload hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        // Tạo banner mới
        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link' => $request->link,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('banners.index');
    }

}
