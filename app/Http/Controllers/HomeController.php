<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirect()
    {
        // تحقق من نوع المستخدم بعد تسجيل الدخول
        if (Auth::user()->user_type === 'admin') {
            return redirect()->route('Admindashboard');  // توجيه إلى لوحة التحكم Admin
        } else {
            return redirect()->route('dashboard');  // توجيه إلى صفحة المستخدم العادي
        }
    }
}
