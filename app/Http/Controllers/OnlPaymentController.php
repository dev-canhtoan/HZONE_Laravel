<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


class OnlPaymentController extends OrderController
{
    public function vnpay_payment(Request $request){
        $cart = session('cart', []);
        $buynow = session('buynow');
        $totalPrice =0;
        if(session()->has('buynow')){
            $totalPrice = $buynow['price'];
        }else {
            foreach($cart as $product){
                $totalPrice += $product['price'] * $product['quantity'];
            }
        }
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/home";
        $vnp_TmnCode = "4U36LR6R";
        $vnp_HashSecret = "DGIOOHNYTKWTFORAGYONWZBZUXZHBPEL";

        $vnp_TxnRef = 'HZ-' . now()->format('Ymd') . '-' . Str::random(6);
        $vnp_OrderInfo = "Thanh toán hoá đơn";
        $vnp_OrderType =  'billpayment';
        $vnp_Amount = $totalPrice * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = "";
        $vnp_IpAddr = request()->ip();
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function momo_payment(Request $request){
        $cart = session('cart', []);
        $buynow = session('buynow');
        $totalPrice =0;
        if(session()->has('buynow')){
            $totalPrice = $buynow['price'];
        }else {
            foreach($cart as $product){
                $totalPrice += $product['price'] * $product['quantity'];
            } 
        }
        
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $totalPrice;
        $orderId = 'HZ-' . now()->format('Ymd') . '-' . Str::random(6);
        $redirectUrl = "http://localhost:8000/home";
        $ipnUrl = "http://localhost:8000/home";
        $extraData = "";
        $requestId = now()->format('YmdHis') . "";
        $requestType = "payWithMethod";
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            if (isset($jsonResult['payUrl'])) {
                // Nếu tồn tại, chuyển hướng đến URL thanh toán
                return redirect()->to($jsonResult['payUrl']);
            } else {
                // Nếu không tồn tại, xử lý lỗi hoặc thông báo cho người dùng
                return redirect()->back()->with('error', 'Chỉ có thể thanh toán Momo với đơn hàng dưới 50 triệu VND');
            }
    }
    public function zalo_payment(Request $request){
        $cart = session('cart', []);
        $buynow = session('buynow');
        $totalPrice =0;
        if(session()->has('buynow')){
            $totalPrice = $buynow['price'];
        }else {
            foreach($cart as $product){
                $totalPrice += $product['price'] * $product['quantity'];
            }
        }
        
        $config = [
            "app_id" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
        ];
        
        $embeddata = '{"redirecturl": "http://localhost:8000/home"}'; 
        $items = '[]';
        $transID = 'HZ-' . now()->format('Ymd') . '-' . Str::random(6);
        $order = [
            "app_id" => $config["app_id"],
            "app_time" => round(microtime(true) * 1000),
            "app_trans_id" => date("ymd") . "_" . $transID,
            "app_user" => "user123",
            "item" => $items,
            "embed_data" => $embeddata,
            "amount" => $totalPrice,
            "description" => "Thanh toán đơn hàng " . $transID,
            "bank_code" => ""
        ];
        
        $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
            . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
        $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);
        
        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);
        
        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);
        
        return redirect()->to($result["order_url"]);
    }
}