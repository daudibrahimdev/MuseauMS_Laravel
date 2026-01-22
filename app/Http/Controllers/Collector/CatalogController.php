<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Artist;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data Artist dan Category untuk filter di Sidebar Katalog
        $categories = Category::all();
        $artists = Artist::all();

        // 2. Query Utama: Hanya tampilkan yang 'available'
        $artworks = Artwork::with(['artist', 'category'])
            ->where('status', 'available')
            ->when($request->category, function($query) use ($request) {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->when($request->artist, function($query) use ($request) {
                $query->where('artist_id', $request->artist);
            })
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('collector.catalog.index', compact('artworks', 'categories', 'artists'));
    }

    public function show($slug)
    {
        // Mencari artwork berdasarkan slug
        $artwork = Artwork::with(['artist', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('collector.catalog.show', compact('artwork'));
    }
}
