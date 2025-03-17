<?php

namespace App\Http\Controllers;

use App\Mail\ResetPass;
use App\Mail\Verify;
use App\Models\User;
use App\Notifications\VerifyNotification;
use GMP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class UserController extends Controller
{
    public function customers()
    {
        $customers = User::where('u_level', 1)->paginate(10);
        return view('admin.customer', compact('customers'));
    }
    public function admin()
    {
        $admins = User::where('u_level', 2)->paginate(10);
        return view('admin.admin', compact('admins'));
    }
    public function adminSearchCus(Request $request) {
        $searchTerm = $request->input('search');
        $customers = User::where('u_level', 1)
        ->where(function ($query) use ($searchTerm) {
            $query->where('username', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        })->paginate(10)->appends(['search' => $searchTerm]);
        return view('admin.customer', compact('customers'));
    }
    public function adminSearchAdm(Request $request) {
        $searchTerm = $request->input('search');
        $admins = User::where('u_level', 2)->where(function ($query) use ($searchTerm) {
            $query->where('username', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        })->paginate(10)->appends(['search' => $searchTerm]);
        return view('admin.admin', compact('admins'));
    }
    public function addUser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:25|min:3',
            'email' => 'required|string|max:25|unique:users,email|email',
            'phone' => 'required|string|max:25|min:8',
            'password' => 'required|string|max:25|min:8',
            'address' => 'nullable|string|min:3',
            'level' => 'int'
        ]);
        

        $user = new User;
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->password = bcrypt($validatedData['password']);
        $user->address = $validatedData['address'];
        $user->u_level = $validatedData['level'];

        $user->save();

        return redirect()->back()->with('success', 'Đăng ký tài khoản thành công.');
    }
    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:25|min:3',
            'phone' => 'required|string|max:25|min:8',
            'address' => 'nullable|string|min:3',
            'level' => 'int'
        ]);
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
        }
        if (Auth::user()->u_level != 2 && empty($request->input('password'))) {
            return redirect()->back()->with('error', 'Mật khẩu là bắt buộc.');
        }
    
        if (Auth::user()->u_level != 2) {
            if (Hash::check($request->input('password'), $user->password)) {
                $user->username = $validatedData['username'];
                $user->phone = $validatedData['phone'];
                $user->address = $validatedData['address'];
                $user->u_level = $validatedData['level'];
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không chính xác');
            }
        } else {
            $user->username = $validatedData['username'];
            $user->phone = $validatedData['phone'];
            $user->address = $validatedData['address'];
            $user->u_level = $validatedData['level'];
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Người dùng đã được cập nhật thành công.');
        
    }
    public function getUserInfo($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
        }
        foreach ($user->orders as $order) {
            $order->delete();
        }
        $user->delete();
        return redirect()->back()->with('success', 'Người dùng đã được xoá thành công.');
    }
    public function showFormLogin()
    {
        return view('logIn');
    }
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();
            if ($user->u_level == 2) {
                return redirect()->route('adminHome');
            }
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng hoặc mật khẩu không chính xác.');
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->forget('cart');
        return redirect()->route('login');
    }
    public function showFormSignup()
    {
        return view('signUp');
    }
    public function signUp(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:25',
            'email' => 'required|string|max:25|unique:users',
            'phone' => 'required|string|max:25',
            'address' => 'nullable|string',
            'password' => 'required|string|max:25',
            'level' => 'integer'
        ]);

        $token = Str::random(6);

        $userData = [
            'username' => $validatedData['username'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'password' => $validatedData['password'],
            'level' => $validatedData['level'],
        ];

        session(['verify_token' => $token]);
        session(['user_data' => $userData]);

        Mail::to($request->input('email'))->send(new Verify($token));

        return redirect()->route('verify')->with('success', 'Đăng ký thành công, vui lòng kiểm tra email để xác thực tài khoản');
    }
    public function showVerifyForm()
    {
        return view('verify');
    }
    public function verify(Request $request)
    {
        $userToken = $request->input('token');
        $verifyToken = session('verify_token');
        $resetToken = session('reset_token');

        if ($userToken ===  $verifyToken) {
            $userData = session('user_data');

            $user = new User;
            $user->username = $userData['username'];
            $user->phone = $userData['phone'];
            $user->email = $userData['email'];
            $user->address = $userData['address'];
            $user->u_level = $userData['level'];
            $user->password = bcrypt($userData['password']);
            $user->save();

            $request->session()->forget('user_data');
            $request->session()->forget('verify_token');
            return redirect()->route('login')->with('success', 'Tài khoản của bạn đã được xác thực thành công!');
        }
        if ($userToken === $resetToken) {
            $userResetdata = session('reset_data');

            $user = User::where('email', $userResetdata['email'])->first();
            if (!$user) {
                return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
            }
            $user->password = bcrypt($userResetdata['password']);
            $user->save();
            if ($user->save()) {
                $request->session()->forget('reset_token');
                $request->session()->forget('reset_data');
                return redirect()->route('login')->with('success', 'Mật khẩu đã được cập nhật thành công.');
            } else {
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật mật khẩu.');
            }
        }
        return back()->with('error', 'Xác thực tài khoản thất bại. Vui lòng thử lại hoặc liên hệ hỗ trợ.');
    }
    public function resendVerification(Request $request)
    {
        $token = Str::random(6);
        $userData = session('user_data');

        Mail::to($userData['email'])->send(new Verify($token));

        session(['verify_token' => $token]);

        return response()->json(['message' => 'Gủi lại mã thành công']);
    }
    public function showResetForm()
    {
        return view('resetPass');
    }
    public function resetPass(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|max:25',
        ]);
        $token = Str::random(6);
        $userEmail = $request->input('email');
        $userData = [
            'email' => $userEmail,
            'password' => $validatedData['password'],
        ];

        session(['reset_token' => $token]);
        session(['reset_data' => $userData]);

        Mail::to($userEmail)->send(new ResetPass($token));

        return redirect()->route('verify')->with('success', 'Reset thành công, vui lòng kiểm tra email để hoàn tất reset');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        // dd($user->email);
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser && $existingUser->provider !== "google" &&$existingUser->provider !== null) {
        return redirect()->route('login')->with('error', 'Địa chỉ email này đã được đăng ký từ một tài khoản khác.');
        }
        
        if ($existingUser) {
            $existingUser->username = $user->name;
            $existingUser->provider = "google";
            $existingUser->provider_id = $user->id;
            $existingUser->save();
            auth()->login($existingUser);
        } else {
            $newUser = new User;
            $newUser->username = $user->name;
            $newUser->email = $user->email;
            $newUser->provider = "google";
            $newUser->u_level = 1;
            $newUser->provider_id = $user->id;

            $newUser->save();
            auth()->login($newUser);
        }

        return redirect()->route('home')->with('success', 'Đăng nhập Google thành công.');
    }
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback() {
        $user = Socialite::driver('facebook')->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser && $existingUser->provider !== "facebook" &&$existingUser->provider !== null) {
            return redirect()->route('login')->with('error', 'Địa chỉ email này đã được đăng ký từ một tài khoản khác.');
        }
        
        if ($existingUser) {
            $existingUser->username = $user->name;
            $existingUser->provider = "facebook";
            $existingUser->provider_id = $user->id;
            $existingUser->save();
            auth()->login($existingUser);
        } else {
            $newUser = new User;
            $newUser->username = $user->name;
            $newUser->email = $user->email;
            $newUser->provider = "facebook";
            $newUser->u_level = 1;
            $newUser->provider_id = $user->id;

            $newUser->save();
            auth()->login($newUser);
        }
        return redirect()->route('home')->with('success', 'Đăng nhập Facebook thành công.');
    }
}