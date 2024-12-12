<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class logincontroller extends Controller
{
    public function login(){
        return view('/login');
    }
    public function loginproses(Request $request)
    {
        // dd($request->all());
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password ], true))
        {
            if(Auth::User()->role == 'pendaftar')
            {
                // echo('pendaftar');die();
                return redirect()->intended('user/dashboard');
            }
            else if(Auth::User()->role == 'assessor')
            {
                // echo('assessor');die();
                return redirect()->intended('assessor/dashboard');
            }
            else if(Auth::User()->role == 'admin')
            {
                // echo('admin');die();
                return redirect()->intended('admin/dashboard');
            }
            else if(Auth::User()->role == 'super')
            {
                // echo('admin');die();
                return redirect()->intended('super_admin/dashboard');
            }
            else
            {
                return redirect('login')->with('error','No Avaiable email..');
            }
        }
        else
        {
            return redirect()->back();
        }


        // $credentials = $request->only('email','password','role');
 
        // if(Auth::attempt($credentials)){
        //     $user = Auth::user();
        //     switch ($user->role) {
        //         case 'admin':
        //             return redirect('/Admin/welcome');
        //         case 'assessor':
        //             return redirect('/Assessor/welcome');
        //         case 'pendaftar':
        //             return redirect('/User/welcome');
        //         default:
        //             return redirect('/login');
        //     }
        // }
    }

    public function register(){
        return view('register');
    }

    public function registeruser(Request $request){
        user::create([
            'email' => $request->email,
            'username' =>$request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'remember_token' => Str::random(60),
        ]);
        return redirect('/login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
