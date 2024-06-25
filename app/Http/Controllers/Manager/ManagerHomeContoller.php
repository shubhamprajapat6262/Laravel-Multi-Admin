<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ManagerHomeContoller extends Controller
{
    public function index() {
        $manager = User::all()->where('role', 3);
        return view('manager.dashboard',compact('manager'));
        // $admin = Auth::guard('admin')->user();
        // echo 'Welcome '.$admin->name.' <a href="'.route('admin.logout').'">LogOut</a>';
    }

    public function logout() {
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }
}
