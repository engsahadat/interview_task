<?php

namespace App\Http\Controllers;

use App\Libs\Constants;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == Constants::ADMIN_ROLE) {
            return view('dashboard.admin-dashboard');
        } else {
            return view('dashboard.user-dashboard');
        }
    }

    public function admin()
    {
        return view('dashboard.admin');
    }
}
