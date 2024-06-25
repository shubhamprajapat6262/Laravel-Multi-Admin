<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class HomeContoller extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
        // $admin = Auth::guard('admin')->user();
        // echo 'Welcome '.$admin->name.' <a href="'.route('admin.logout').'">LogOut</a>';
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
