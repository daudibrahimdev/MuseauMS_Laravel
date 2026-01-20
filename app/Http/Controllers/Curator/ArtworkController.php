<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Artwork;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil data untuk dropdown filter
        $artists = Artist::all();
        $categories = Category::all();

        // Query dinamis dengan filter
        $artworks = Artwork::with(['artist', 'category'])
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->category, function($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->artist, function($query) use ($request) {
                $query->where('artist_id', $request->artist);
            })
            ->latest()
            ->paginate(10);

        return view('curator.artworks.index', compact('artworks', 'artists', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $artists = Artist::all();
        $categories = Category::all();
        return view('curator.artworks.create', compact('artists', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Jalankan Validasi dengan Pesan Custom Bahasa Inggris yang Pro
        $request->validate([
            'title' => 'required|max:255',
            'artist_id' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'year_created' => 'required|integer|min:1000|max:'.date('Y'),
            'medium' => 'required',
            'dimensions' => 'required|max:100',
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'medium.required' => 'Please provide the medium',
            'dimensions.required' => 'Please provide the physical dimensions (e.g., 100 x 80 cm).',
            'image_url.required' => 'The masterpiece image is mandatory.',
            'description.required' => 'A historical description is required for the gallery.',
            'price.numeric' => 'Valuation must be a valid number.',
        ]);

        // 2. Logic simpan data (seperti sebelumnya)
        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . time();

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('artworks', 'public');
        }

        \App\Models\Artwork::create($data);
        
        return redirect()->route('curator.artworks.index')->with('success', 'New masterpiece successfully uploaded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $artwork = Artwork::findOrFail($id);
        $artists = Artist::all();
        $categories = Category::all();
        return view('curator.artworks.edit', compact('artwork', 'artists', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $artwork = Artwork::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image_url')) {
            // Hapus gambar lama jika ada
            if ($artwork->image_url) {
                Storage::disk('public')->delete($artwork->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('artworks', 'public');
        }

        $artwork->update($data);
        return redirect()->route('curator.artworks.index')->with('success', 'Artwork updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Cari data artwork berdasarkan ID
        $artwork = Artwork::findOrFail($id);

        // 2. Hapus file gambar dari folder storage agar tidak menjadi sampah server
        if ($artwork->image_url) {
            // Hapus file yang ada di storage/app/public/artworks/...
            \Illuminate\Support\Facades\Storage::disk('public')->delete($artwork->image_url);
        }

        // 3. Hapus data dari database
        $artwork->delete();

        // 4. KRUSIAL: Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('curator.artworks.index')
                        ->with('success', 'Masterpiece has been archived successfully.');
    }
}
