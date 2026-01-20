<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectorController extends Controller
{
    public function index()
    {
        // Cek login user
        $isLoggedIn = Auth::check();
        
        // Ambil data user
        $user = Auth::user();
        
        return view('collector.dashboard.index'/*, compact('isLoggedIn', 'user')*/);
    }
}