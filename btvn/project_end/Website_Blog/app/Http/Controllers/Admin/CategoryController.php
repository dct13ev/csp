<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();

        Log::channel('blog')->info('Danh mục mới được tạo.', [
            'category_id' => $category->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();

        Log::channel('blog')->info('Danh mục đã được cập nhật.', [
            'category_id' => $category->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postCount = Post::where('category_id', $id)->count();

        if ($postCount > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xóa! Đang có '.$postCount.' bài viết thuộc danh mục này.');
        }

        $category = Category::findOrFail($id);
        $category->delete();

        Log::channel('blog')->info('Danh mục đã bị xóa.', [
            'category_id' => $category->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa!');
    }
}
