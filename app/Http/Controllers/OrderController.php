<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class OrderController extends Controller
{
    public function createOrder($total)
    {
        $user = Auth::user();

        $order = new Order;
        $order->user_id = $user->id;
        $order->status = 1;
        $order->total = $total;
        $order->order_code = 'HZ-' . now()->format('Ymd') . '-' . Str::random(6);
        $order->save();

        if (session()->has('buynow')) {
            $buynow = session('buynow');
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $buynow['id'];
            $orderDetail->quantity = $buynow['quantity'];
            $orderDetail->total_pro = $buynow['price'] * $buynow['quantity'];
            $orderDetail->save();
            $productQuantity = Product::find($buynow['id']);
            if ($productQuantity) {
                $newQuantity = $productQuantity->quantity - $buynow['quantity'];
                $productQuantity->quantity = $newQuantity;
                $productQuantity->save();
            }
        } else {
            $cart = session('cart', []);
            foreach ($cart as $product) {
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product['id'];
                $orderDetail->quantity = $product['quantity'];
                $orderDetail->total_pro = $product['price'] * $product['quantity'];
                $orderDetail->save();

                $productQuantity = Product::find($product['id']);
                if ($productQuantity) {
                    $newQuantity = $productQuantity->quantity - $product['quantity'];
                    $productQuantity->quantity = $newQuantity;
                    $productQuantity->save();
                }
            }
        }

        return $order;
    }

    public function confirmOrder(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra xem người dùng có địa chỉ hay không
        if (empty($user->address)) {
            return redirect()->back()->with('error', 'Vui lòng cập nhật địa chỉ của bạn.');
        }

        $total = $request->input('total');
        $order = $this->createOrder($total);

        $username = $user->username;
        $phone = $user->phone;
        $address = $user->address;

        if (session()->has('buynow')) {
            $info = session('buynow');
        } else {
            $info = session('cart', []);
        }

        Mail::to($user->email)->send(new Checkout($username, $phone, $address, $total, $info));

        if (session()->has('buynow')) {
            $request->session()->forget('buynow');
        } else {
            $request->session()->forget('cart');
        }

        return redirect()->route('home')->with('success', 'Thanh toán thành công, tiếp tục mua sắm.');
    }

    public function getAllOrder()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('admin.order', compact('orders'));
    }

    public function adminSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where('orders.order_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.username', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(10)
            ->appends(['search' => $searchTerm]);

        return view('admin.order', compact('orders'));
    }

    public function getOrderDetail($orderId)
    {
        $orderDetails = OrderDetail::where('order_id', $orderId)->with('product')->get();

        // Kiểm tra xem có đơn hàng nào không
        if ($orderDetails->isEmpty()) {
            return response()->json(['error' => 'Không tìm thấy chi tiết đơn hàng.'], 404);
        }

        return response()->json($orderDetails);
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        $order->delete();
        return redirect()->back()->with('success', 'Đơn hàng đã được xoá thành công.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer',
        ]);

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại.'], 404);
        }

        $order->status = $request->input('status');
        $order->save();
        return response()->json(['message' => 'Cập nhật trạng thái thành công']);
    }

    public function getDashboardDetail()
    {
        $totalCustomers = User::where('u_level', 1)->count();
        $totalProducts = Product::count();
        
        // thống kê trong 1 tháng
        $startDateTotal = Carbon::now()->startOfMonth();
        $endDateTotal = Carbon::now()->endOfMonth();
        $totalSalesInMonth = Order::whereBetween('created_at', [$startDateTotal, $endDateTotal])->sum('total');
        $totalSoldInMonth = Order::whereBetween('created_at', [$startDateTotal, $endDateTotal])
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum('order_details.quantity');

        // thống kê sản phẩm bán và doanh thu trong 7 ngày gần nhất
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(6);

        $dateRange = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        $dailySoldData = [];
        $dailySalesData = [];

        foreach ($dateRange as $date) {
            $totalSold = Order::whereDate('created_at', $date)
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->sum('order_details.quantity');
            $totalSales = Order::whereDate('created_at', $date)->sum('total');
            $dailySoldData[$date] = $totalSold;
            $dailySalesData[$date] = $totalSales;
        }

        // Thống kê 5 sản phẩm được mua nhiều nhất
        $topProducts = OrderDetail::select('product_id', 'products.name', 'products.img', 'products.price')
            ->selectRaw('SUM(order_details.quantity) as total_quantity')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->groupBy('product_id', 'products.name', 'products.img', 'products.price')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return response()->json([
            'totalSalesInMonth' => $totalSalesInMonth,
            'totalSoldInMonth' => $totalSoldInMonth,
            'totalCustomers' => $totalCustomers,
            'totalProducts' => $totalProducts,
            'dailySoldData' => $dailySoldData,
            'dailySalesData' => $dailySalesData,
            'topProducts' => $topProducts,
        ]);
    }

    public function showPersonalOrder()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        return view('profile', compact('orders'));
    }

    public function exportPDF($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại');
        }

        $orderDetails = OrderDetail::where('order_id', $order->id)->get();

        $view = view('pdf.invoice', compact('order', 'orderDetails'));
        $pdf = new Mpdf();
        $pdf->WriteHTML($view);

        $pdf->Output("order_{$order->id}.pdf", 'D');
    }
}
