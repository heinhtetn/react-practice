<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function postRegister(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,webp',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);

        $findUser = User::where('email', request()->email)->first();
        if($findUser)
        {
            return redirect()->back()->with('error', 'Email already exists');
        }

        $file = $request->file('image');
        $file_name = uniqid() . $file->getClientOriginalName();
        $file->move(public_path('/images'), $file_name);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $file_name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        auth()->login($user);

        return redirect('/')->with('success', 'Welcome ' . $user->name);
    }

    public function postLogin(Request $request)
    {

        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            return redirect()->back()->with('error', 'Email not found');
        }

        if(!Hash::check($request->password, $user->password))
        {
            return redirect()->back()->with('error', 'Password is Incorrect');
        }

        auth()->login($user);

        return redirect('/')->with('success', 'Welcome ' . $user->name);

        // if(auth()->attempt($request->only('email', 'password')))
        // {
        //     return redirect('/')->with('success', 'Login Success');
        // }
        // else
        // {
        //     return redirect('/login')->with('error', 'Your credentials are incorrect');
        // }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
