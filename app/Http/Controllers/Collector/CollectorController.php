<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Artwork;

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

    public function collection()
    {
        $artworks = Artwork::latest()->paginate(12);

        return view('collector.collection.index', compact('artworks'));
    }

    public function show($slug)
    {
        // Cari artwork berdasarkan slug, ambil juga data artist dan category-nya
        $artwork = Artwork::with(['artist', 'category'])
                    ->where('slug', $slug)
                    ->firstOrFail(); // Munculkan 404 jika slug tidak ada di database

        return view('collector.collection.product_detail', compact('artwork'));
    }
}