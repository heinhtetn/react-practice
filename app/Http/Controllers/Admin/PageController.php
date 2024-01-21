<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
;

class PageController extends Controller
{
    //
    public function showDashboard()
    {
        return view('admin.dashboard');
    }

    public function showLogin()
    {
        return view('admin.layout.login');
    }

    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $cre = request()->only('email', 'password');

        if(auth()->guard('admin')->attempt($cre))
        {
            return redirect('/admin')->with('success', 'Welcome Admin');
        }

        return redirect()->back()->with('error', 'Credentials are not valid!');
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect('/');
    }
}
