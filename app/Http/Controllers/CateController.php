<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CateController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }
    public function adminsearch(Request $request)
    {
        $searchTerm = $request->input('search');
        $categories = Category::where('name', 'like', '%' . $searchTerm . '%')->get();
        return view('admin.category', compact('categories'));
    }
    public function addCate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|min:3|unique:category,name|not_in:0',
        ]);
        $category = new Category;
        $category->name = $validatedData['name'];
        $category->save();
        return redirect()->back()->with('success', 'Danh mục đã được tạo thành công.');
    }
    public function getCateId($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
    public function updateCate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|min:3|unique:category,name|not_in:0',
        ]);
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục.');
        }
        $category->name = $validatedData['name'];
        $category->save();
        if ($category->save()) {
            return redirect()->back()->with('success', 'Danh mục đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật danh mục.');
        }
    }
    public function deleteCate($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục.');
        }
        $category->delete();
        return redirect()->back()->with('success', 'Danh mục đã được xoá thành công.');
    }
}