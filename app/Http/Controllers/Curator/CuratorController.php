<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Artwork;
use App\Models\Artist;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

class CuratorController extends Controller
{
    public function index()
    {
        // Statistik untuk Dashboard Curator
        $stats = [
            'total_artworks' => Artwork::count(),
            'total_artists'  => Artist::count(),
            'total_categories' => Category::count(),
            'total_collectors' => User::where('role', 'collector')->count(),
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('payment_status', 'pending')->count(),
        ];

        // Mengambil 5 lukisan terbaru yang baru ditambahkan
        $recent_artworks = Artwork::with('artist')->latest()->take(5)->get();

        return view('curator.dashboard.index', compact('stats', 'recent_artworks'));
    }
}
