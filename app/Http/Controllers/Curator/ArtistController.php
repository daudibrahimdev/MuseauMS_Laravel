<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil semua kebangsaan unik untuk dropdown filter
        $nationalities = Artist::select('nationality')->distinct()->pluck('nationality');

        $artists = Artist::query()
            ->when($request->search, function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->nationality, function($query) use ($request) {
                $query->where('nationality', $request->nationality);
            })
            ->when($request->sort, function($query) use ($request) {
                if ($request->sort == 'oldest') $query->orderBy('birth_date', 'asc');
                if ($request->sort == 'newest') $query->orderBy('birth_date', 'desc');
            }, function($query) {
                $query->latest();
            })
            ->paginate(10);

        return view('curator.artists.index', compact('artists', 'nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('curator.artists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'bio' => 'required',
            'nationality' => 'required|max:255',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo_url')) {
            $data['photo_url'] = $request->file('photo_url')->store('artists', 'public');
        }

        Artist::create($data);
        return redirect()->route('curator.artists.index')->with('success', 'Legendary artist added to the records!');
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
    public function edit(Artist $artist)
    {
        return view('curator.artists.edit', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'required|max:255',
            'bio' => 'required',
            'nationality' => 'required|max:255',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo_url')) {
            if ($artist->photo_url) {
                Storage::disk('public')->delete($artist->photo_url);
            }
            $data['photo_url'] = $request->file('photo_url')->store('artists', 'public');
        }

        $artist->update($data);
        return redirect()->route('curator.artists.index')->with('success', 'Artist profile updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        if ($artist->photo_url) {
            Storage::disk('public')->delete($artist->photo_url);
        }
        $artist->delete();
        return redirect()->route('curator.artists.index')->with('success', 'Artist removed from directory.');
    }
}
