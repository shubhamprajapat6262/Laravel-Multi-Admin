<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class ManagerLoginContoller extends Controller
{
    public function index() {
        return view("manager.login");
    }

    public function authenticate(Request $request) {

        $validator = validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()) {
            if(Auth::guard('manager')->attempt(['email'=> $request->email,'password'=>$request->password], $request->get('remember'))) {
                $manager = Auth::guard('manager')->user();

                if($manager->role == 3) {
                    return redirect()->route('manager.dashboard')->with('success','Success Login...');
                } else {
                    Auth::guard('manager')->logout();
                    return redirect()->route('manager.login')->with('error','You are not authorized to access Admin panel');
                    // return back()->with('error','You are not authorized to access Admin panel');
                }
                
            } else {
                return redirect()->route('manager.login')->with('error','Email/Password is incorrect');
                // return back()->with('error','Email/Password is incorrect');
            }
        } else {
            return redirect()->route('manager.login')->withErrors($validator)->withInput($request->only('email'));
            // return back()->with('error', 'Validation Error...!');
        }
    }

    public function logout() {
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }
}
