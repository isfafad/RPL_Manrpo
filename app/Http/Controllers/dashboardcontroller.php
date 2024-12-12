<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class dashboardcontroller extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->role == 'pendaftar')
        { 
            return view('User.dashboard');
        }
        else if(Auth::user()->role == 'assessor')
        {
            $data['getRecord'] = User::find(Auth::user()->id);
            return view('Assessor.dashboard',$data);
        }
        else if(Auth::user()->role == 'admin')
        {
            $data['getRecord'] = User::find(Auth::user()->id);
            return view('Admin.dashboard',$data);
        }
        else if(Auth::user()->role == 'super')
        {
            $data['getRecord'] = User::find(Auth::user()->id);
            return view('Super_admin.dashboard',$data);
        }
    }
}
