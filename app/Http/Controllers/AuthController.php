<?php

namespace App\Http\Controllers;

use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        if (Auth::guard('web')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'NIK / Password Salah']);
        }
    }

    public function prosesLoginAdmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/panel-admin');
        } else {
            return redirect('/')->with(['warning' => 'Username / Password Salah']);
        }
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            $userId = Auth::guard('web')->id();

            UserSession::where('user_id', $userId)
                ->where('session_id', Session::getId())
                ->delete();

            Auth::guard('web')->logout();
            Session::invalidate();

            return redirect('/');
        }

        return redirect('/');
    }

    public function logoutAdmin()
    {
        if (Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }else {
            return redirect('/');
        }
    }
}
