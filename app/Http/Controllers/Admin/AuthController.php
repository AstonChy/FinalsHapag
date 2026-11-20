<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() { return view('admin.login'); }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);
        if (hash_equals((string) config('restaurant.admin_password'), (string) $request->password)) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);
            return redirect()->route('admin.reservations.index');
        }
        return back()->withErrors(['password' => 'Wrong password.']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }
}
