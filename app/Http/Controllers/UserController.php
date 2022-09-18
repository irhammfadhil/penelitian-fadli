<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Models\User;

class UserController extends Controller
{
    public function getLogin() {
        return view('auth.login');
    }

    public function doLogin(Request $request) {
        $email = $request->email;
        $password = $request->password;
        
        //auto-login
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_deleted' => 0]) || Auth::attempt(['username' => $request->email, 'password' => $request->password, 'is_deleted' => 0])) {
            $user = Auth::user();
            if(Auth::user()->is_admin == 0) {
                return redirect('/dashboard/user');
            }
            else {
                return redirect('/dashboard/admin');
            }
        }
        else {
            return redirect()->back()->with(['danger' => 'Username/Email atau Password salah!']);
        }
    }
    public function getRegister() {
        return view('auth.register');
    }
    public function submitRegister(Request $request) {
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if (strlen($password) < 8) {
            return redirect()->back()->with(['danger' => 'Panjang minimal password adalah 8 karakter!']);
        }
        if ($password != $confirm_password) {
            return redirect()->back()->with(['danger' => 'Password/Konfirmasi Password harus sama!']);
        }
        $user = User::where('email', '=', $email)->first();
        if($user) {
            return redirect()->back()->with(['registered' => 'Username sudah terdaftar']);
        }
        $user_name = User::where('username', '=', $username)->first();
        if($user_name) {
            return redirect()->back()->with(['registered' => 'Username sudah terdaftar']);
        }
        $user = new User;
        $user->name = $name;
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        //auto-login
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) || Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            if(Auth::user()->is_admin == 0) {
                return redirect('/dashboard/user');
            }
            else {
                return redirect('/dashboard/admin');
            }
        }
    }
    public function doLogout() {
        Auth::logout();
        return redirect('/login');
    }
    public function getChangePassword() {
        return view('auth.change-password');
    }
    public function submitChangePassword(Request $request) {
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $confirm_new_password = $request->confirm_new_password;

        $password = Auth::user()->password;

        if(!Hash::check($current_password, $password)) {
            return redirect()->back()->with(['danger' => 'Password yang Anda masukkan salah. Silakan coba lagi.']);
        }
        else if (strcmp($new_password, $confirm_new_password)!=0) {
            return redirect()->back()->with(['danger' => 'Password dan konfirmasi password harus sama. Silakan coba kembali.']);
        }
        else {
            if(strlen($password) < 8) {
                return redirect()->back()->with(['danger' => 'Panjang minimal password adalah 8 karakter!']);
            }
            else {
                $user = User::where('id', '=', Auth::user()->id)->first();
                $user->password = Hash::make($password);
                $user->save();
                
                return redirect()->back()->with(['success' => 'Password berhasil diubah']);
            }
        }
    }
}
