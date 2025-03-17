<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function getAllDis() {
        $discounts = Discount::paginate(10);
        return view('admin.discount', compact('discounts'));
    }
    public function adminSearch(Request $request){
        $searchTerm = $request->input('search');
        $discounts = Discount::where('name', 'like', '%' . $searchTerm . '%')->paginate(10)->appends(['search' => $searchTerm]);
        return view('admin.discount', compact('discounts'));
    } 
    public function getDisInfo($id) {
        $discounts = Discount::find($id);
        return response()->json($discounts);
    }
    public function addDisCount(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:discount,name|min:3',
            'percent' => 'required|integer|not_in:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);
        $discount = new Discount;
        $discount->name = $validatedData['name'];
        $discount->percent = $validatedData['percent'];
        $discount->start_at = $validatedData['start_at'];
        $discount->end_at = $validatedData['end_at'];
        $discount->save();
        return redirect()->back()->with('success', 'Giảm giá đã được tạo thành công.');
    }
    public function updateDis(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'percent' => 'required|integer|not_in:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);
        $discount = Discount::find($id);
        if (!$discount) {
            return redirect()->back()->with('error', 'Không tìm thấy chương trình giảm giá.');
        }
        if ($discount->name !== $validatedData['name']) {
            $existingDiscount = Discount::where('name', $validatedData['name'])->where('id', '!=', $id)->first();
    
            if ($existingDiscount) {
                return redirect()->back()->with('error', 'Tên chương trình giảm giá đã tồn tại.');
            }
        }
        $discount->name = $validatedData['name'];
        $discount->percent = $validatedData['percent'];
        $discount->start_at = $validatedData['start_at'];
        $discount->end_at = $validatedData['end_at'];
        $discount->save();
        if ($discount->save()) {
            return redirect()->back()->with('success', 'Chương trình giảm giá đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật chương trình giảm giá.');
        }
    }
    public function deleteDis($id) {
        $discount = Discount::find($id);
    
        if (!$discount) {
            return redirect()->back()->with('error', 'Không tìm thấy chương trình giảm giá.');
        }
    
        try {
            $discount->delete();
            return redirect()->back()->with('success', 'Chương trình giảm giá đã được xoá thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xoá chương trình giảm giá: ' . $e->getMessage());
        }
    }
    
}