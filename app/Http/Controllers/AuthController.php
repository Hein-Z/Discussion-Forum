<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credential = $request->only('email', 'password');
        if (Auth::attempt($credential)) {
            return redirect('/')->with('success', 'Welcome', Auth::user()->name);
        }

        return redirect()->back()->with('error', 'Incorrect Credential!');

    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:6',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        $image = $request->file('image');
        $image_name = uniqid() . str_replace(' ', '', $image->getClientOriginalName());
        $image_path = '/images/profile/';
        $image->move(public_path('images/profile'), $image_name);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image_path . $image_name,
        ]);
        $credential = $request->only('email', 'password');
        if (Auth::attempt($credential)) {
            return Redirect::route('home');
        }
    }


    public function logout()
    {
        Auth::logout();
        return Redirect::route('login');
    }
}
