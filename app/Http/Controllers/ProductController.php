<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Spec;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ProductController extends Controller
{
    public function getAllCate()
    {
        return Category::all();
    }
    public function getAllProducts()
    {
        $products = Product::with('rates')->where('quantity', '>', 0)->get();
        foreach ($products as $product) {
            $product->rates->avg_stars = $product->rates->avg('star');
        }
        $categories = app(ProductController::class)->getAllCate();
        return compact('products', 'categories');
    }
    public function getAllProductsPage()
    {
        return view('product');
    }
    public function getProByCate()
    {
        $categories = app(ProductController::class)->getAllCate();
        $proByCategories = [];
        foreach ($categories as $category) {
            $product = Product::where('cate_id', $category->id)
                ->orderBy('price')
                ->first();
            if ($product !== null) {
                $proByCategories[$category->id] = $product;
            }
        }
        return compact('proByCategories');
    }
    public function getAllProductsHome(Request $request)
    {
        $data = $this->getAllProducts();
        $data2 = $this->getProByCate();
        if ($request->has('vnp_ResponseCode') && $request->input('vnp_ResponseCode') == '00') {
            $user = Auth::user();
            $order = new Order;
            $order->user_id = $user->id;
            $order->status = 1;
            $order->total = $request->input('vnp_Amount') / 100;
            $order->order_code = $request->input('vnp_TxnRef');
            $order->created_at = Carbon::createFromFormat('YmdHis', $request->input('vnp_PayDate'));
            $order->save();
            if(session()->has('buynow')){
                $buynow = session('buynow');
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $buynow['id'];
                $orderDetail->quantity = $buynow['quantity'];
                $orderDetail->total_pro = $buynow['price'] * $buynow['quantity'];
                $orderDetail->save();
                $productQuantity = Product::find($buynow['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $buynow['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
            }
            else{
                $cart = session('cart', []);
                foreach ($cart as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->quantity = $product['quantity'];
                    $orderDetail->total_pro = $product['price'] * $product['quantity'];
                    $orderDetail->save();
    
                    $productQuantity = Product::find($product['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $product['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
                }
            }

            $username = $user->username;
            $phone = $user->phone;
            $address = $user->address;
            $total = $request->input('vnp_Amount') / 100;
            if(session()->has('buynow')){
                $info = session('buynow');
            }else {
                $info = session('cart', []);
            }
            Mail::to(Auth::user()->email)->send(new Checkout($username, $phone, $address, $total, $info));
            
            session()->flash('success', 'Thanh toán VNpay thành công');
            if(session()->has('buynow')){
                session()->forget('buynow');
            }else {
                session()->forget('cart');
            }
        } elseif ($request->has('vnp_ResponseCode') && $request->input('vnp_ResponseCode') != '00') {
            if(session()->has('buynow')){
                session()->forget('buynow');
            }
            session()->flash('error', 'Thanh toán VNpay không thành công');
        }
        if ($request->has('resultCode') && $request->input('resultCode') == '0') {
            $user = Auth::user();
            $order = new Order;
            $order->user_id = $user->id;
            $order->status = 1;
            $order->total = $request->input('amount');
            $order->order_code = $request->input('orderId');
            $order->created_at = Carbon::createFromFormat('YmdHis', $request->input('requestId'));
            $order->save();
            if(session()->has('buynow')){
                $buynow = session('buynow');
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $buynow['id'];
                $orderDetail->quantity = $buynow['quantity'];
                $orderDetail->total_pro = $buynow['price'] * $buynow['quantity'];
                $orderDetail->save();
                $productQuantity = Product::find($buynow['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $buynow['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
            }
            else{
                $cart = session('cart', []);
                foreach ($cart as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->quantity = $product['quantity'];
                    $orderDetail->total_pro = $product['price'] * $product['quantity'];
                    $orderDetail->save();
    
                    $productQuantity = Product::find($product['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $product['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
                }
            }
            
            $username = $user->username;
            $phone = $user->phone;
            $address = $user->address;
            $total = $request->input('amount');
            if(session()->has('buynow')){
                $info = session('buynow');
            }else {
                $info = session('cart', []);
            }
            Mail::to(Auth::user()->email)->send(new Checkout($username, $phone, $address, $total, $info));
            session()->flash('success', 'Thanh toán Momo thành công');
            if(session()->has('buynow')){
                session()->forget('buynow');
            }else {
                session()->forget('cart');
            }
        } elseif ($request->has('resultCode') && $request->input('resultCode') != '0') {
            if(session()->has('buynow')){
                session()->forget('buynow');
            }
            session()->flash('error', 'Thanh toán Momo không thành công');
        }
        if ($request->has('status') && $request->input('status') == '1') {
            $user = Auth::user();
            $order = new Order;
            $order->user_id = $user->id;
            $order->status = 1;
            $order->total = $request->input('amount');
            $transid = $request->input('apptransid');
            $parts = explode("_", $transid);
            $order->order_code = $parts[1];
            $order->created_at = Carbon::now();
            $order->save();
            if(session()->has('buynow')){
                $buynow = session('buynow');
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $buynow['id'];
                $orderDetail->quantity = $buynow['quantity'];
                $orderDetail->total_pro = $buynow['price'] * $buynow['quantity'];
                $orderDetail->save();
                $productQuantity = Product::find($buynow['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $buynow['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
            }else{
                $cart = session('cart', []);
                foreach ($cart as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->quantity = $product['quantity'];
                    $orderDetail->total_pro = $product['price'] * $product['quantity'];
                    $orderDetail->save();
    
                    $productQuantity = Product::find($product['id']);
                    if ($productQuantity ) {
                        $newQuantity = $productQuantity ->quantity - $product['quantity'];
                        $productQuantity ->quantity = $newQuantity;
                        $productQuantity ->save();
                    }
                }
            }
            $username = $user->username;
            $phone = $user->phone;
            $address = $user->address;
            $total = $request->input('amount');
            if(session()->has('buynow')){
                $info = session('buynow');
            }else {
                $info = session('cart', []);
            }
            Mail::to(Auth::user()->email)->send(new Checkout($username, $phone, $address, $total, $info));
            session()->flash('success', 'Thanh toán ZaloPay thành công');
            if(session()->has('buynow')){
                session()->forget('buynow');
            }else {
                session()->forget('cart');
            }
        } elseif ($request->has('status') && $request->input('status') != '1') {
            if(session()->has('buynow')){
                session()->forget('buynow');
            }
            session()->flash('error', 'Thanh toán ZaloPay không thành công');
        }
        return view('home', $data, $data2);
    }
    public function adminPro()
    {
        $products = Product::orderBy('created_at', 'asc')->paginate(5);
        $categories = app(ProductController::class)->getAllCate();
        $discounts = Discount::all();
        return view('admin.productM', compact('products', 'categories', 'discounts'));
    }
    public function adminSearch(Request $request) {
        $searchTerm = $request->input('search');
        $categoryFilter = $request->input('category_filter');
        $query = Product::query();
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        if (!empty($categoryFilter)) {
            $query->where('cate_id', $categoryFilter);
        }
        $products = $query->paginate(5);
        $products->appends(['search' => $searchTerm, 'category_filter' => $categoryFilter]);
        $categories = app(ProductController::class)->getAllCate();
        $discounts = Discount::all();

        return view('admin.productM', compact('products', 'categories', 'discounts'));
    }
    public function addProduct(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3|not_in:0',
            'category' => 'required|integer',
            'discount' => 'nullable|integer',
            'price' => 'required|numeric|not_in:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer',
            'description' => 'nullable|string|min:3|not_in:0',
            'brand' => 'required|string|not_in:0',
            'screen' => 'required|string|not_in:0',
            'storage' => 'required|string|not_in:0',
            'ram' => 'nullable|string|not_in:0',
            'chip' => 'nullable|string|not_in:0',
            'pin' => 'nullable|string|not_in:0',
            'camera' => 'nullable|string|not_in:0',
            'vga' => 'nullable|string|not_in:0',
            'os' => 'nullable|string|not_in:0',
        ]);

        $product = new Product;
        $product->name = $validatedData['name'];
        $product->cate_id = $validatedData['category'];
        $product->dis_id = $validatedData['discount'];
        $product->price = $validatedData['price'];
        $product->des = $validatedData['description'];
        $product->quantity = $validatedData['quantity'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/product-image'), $imageName);
            $product->img = $imageName;
        }

        $product->save();

        $spec = new Spec;
        $spec->brand = $validatedData['brand'];
        $spec->screen = $validatedData['screen'];
        $spec->storage = $validatedData['storage'];
        $spec->ram = $validatedData['ram'];
        $spec->chip = $validatedData['chip'];
        $spec->pin = $validatedData['pin'];
        $spec->camera = $validatedData['camera'];
        $spec->vga = $validatedData['vga'];
        $spec->os = $validatedData['os'];

        $product->spec()->save($spec);

        return redirect()->back()->with('success', 'Sản phẩm đã được tạo thành công.');
    }
    public function getProductInfo($id)
    {
        $product = Product::with('spec')->find($id);
        return response()->json($product);
    }
    public function getProductPage($id)
    {
        $productInfo = Product::with('spec')->find($id);
        $totalQuantitySold = DB::table('order_details')
            ->select(DB::raw('SUM(quantity) as total_sold'))
            ->where('product_id', $id)
            ->first();
        $reviews = Rate::with('user')
            ->where('product_id', $id)
            ->get();
        $products = Product::where('cate_id', $productInfo->cate_id)
            ->where('quantity', '>', 0)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        foreach ($products as $product) {
            $product->rates->avg_stars = $product->rates->avg('star');
        }
        return view('pro-info', compact('productInfo', 'totalQuantitySold', 'reviews', 'products'));
    }
    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3|not_in:0',
            'category' => 'required|integer',
            'discount' => 'nullable|integer',
            'price' => 'required|numeric|not_in:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer',
            'description' => 'nullable|string|min:3|not_in:0',
            'brand' => 'required|string|not_in:0',
            'screen' => 'required|string|not_in:0',
            'storage' => 'required|string|not_in:0',
            'ram' => 'nullable|string|not_in:0',
            'chip' => 'nullable|string|not_in:0',
            'pin' => 'nullable|string|not_in:0',
            'camera' => 'nullable|string|not_in:0',
            'vga' => 'nullable|string|not_in:0',
            'os' => 'nullable|string|not_in:0',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm.');
        }
        $product->name = $validatedData['name'];
        $product->cate_id = $validatedData['category'];
        $product->dis_id = $validatedData['discount'];
        $product->price = $validatedData['price'];
        $product->des = $validatedData['description'];
        $product->quantity = $validatedData['quantity'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/product-image'), $imageName);
            $product->img = $imageName;
        }

        $product->save();

        $spec = $product->spec;
        if (!$spec) {
            $spec = new Spec;
        }
        $spec->brand = $validatedData['brand'];
        $spec->screen = $validatedData['screen'];
        $spec->storage = $validatedData['storage'];
        $spec->ram = $validatedData['ram'];
        $spec->chip = $validatedData['chip'];
        $spec->pin = $validatedData['pin'];
        $spec->camera = $validatedData['camera'];
        $spec->vga = $validatedData['vga'];
        $spec->os = $validatedData['os'];

        $product->spec()->save($spec);

        if ($product->save()) {
            return redirect()->back()->with('success', 'Sản phẩm đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm.');
        }
    }
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm.');
        }
        $imagePath = public_path('image/product-image/' . $product->img);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $spec = $product->spec;
        if ($spec) {
            $spec->delete();
        }

        $product->delete();
        return redirect()->back()->with('success', 'Sản phẩm đã được xoá thành công.');
    }
    public function liveSearch(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $results = Product::where('name', 'like', '%' . $searchTerm . '%')->get();
        return response()->json(['results' => $results]);
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $products = Product::with('rates')->where('name', 'like', '%' . $searchTerm . '%')->paginate(16)->appends(['search' => $searchTerm]);
        $categories = $this->getAllCate();
        foreach ($products as $product) {
            $product->rates->avg_stars = $product->rates->avg('star');
        }
        $brands = Spec::distinct()->pluck('brand')->filter()->toArray();
        $storages = Spec::distinct()->pluck('storage')->filter()->toArray();
        $rams = Spec::distinct()->pluck('ram')->filter()->toArray();
        $pins = Spec::distinct()->pluck('pin')->filter()->toArray();
        return view('product', compact('products', 'categories', 'brands', 'storages', 'rams', 'pins'));
    }
    public function rate(Request $request)
    {
        // nếu mua mới được đánh giá
        $orderDetail = OrderDetail::where('product_id', $request->input('product-id'))
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();

        if (!$orderDetail) {
            return redirect()->back()->with('error', 'Bạn cần mua sản phẩm này trước khi đánh giá.');
        }

        //Kiểm tra xem người dùng đã đánh giá sản phẩm này
        $existingRating = Rate::where('product_id', $request->input('product-id'))
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này.');
        }

        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
        ]);
        $rate = new Rate();
        $rate->user_id = Auth::user()->id;
        $rate->product_id = $request->input('product-id');
        $rate->star = $validatedData['rating'];
        $rate->comment = $validatedData['comment'];
        $rate->save();

        return redirect()->back()->with('success', 'Đánh giá thành công.');
    }
}