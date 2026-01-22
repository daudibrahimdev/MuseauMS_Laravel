<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function index()
    {
        // Ambil data dari session, defaultnya array kosong jika belum ada
        $cart = session()->get('cart', []);
        
        // Hitung total harga seluruh item di keranjang
        $totalPrice = 0;
        foreach($cart as $item) {
            $totalPrice += $item['price'];
        }

        return view('collector.cart.index', compact('cart', 'totalPrice'));
    }

    /**
     * Tambahkan artwork ke dalam keranjang.
     */
    public function add($id)
    {
        // Eager load relasi artist agar nama artist tersedia
        $artwork = Artwork::with('artist')->findOrFail($id);

        // Validasi: Karena lukisan bersifat unik, cek status ketersediaan di DB
        if ($artwork->status !== 'available') {
            return redirect()->back()->with('error', 'Maaf, mahakarya ini sudah tidak tersedia atau telah dipesan orang lain.');
        }

        $cart = session()->get('cart', []);

        // Logic unik: Jika sudah ada di keranjang, jangan tambah lagi (karena stok cuma 1)
        if(isset($cart[$id])) {
            return redirect()->route('collector.cart.index')->with('info', 'Artwork ini sudah ada di keranjang Anda.');
        }

        // Masukkan data lukisan ke dalam array session
        $cart[$id] = [
            "title" => $artwork->title,
            "artist" => $artwork->artist->name ?? 'Unknown Artist',
            "price" => (float) $artwork->price,
            "image" => $artwork->image_url,
            "slug" => $artwork->slug,
            "added_at" => now()->toDateTimeString()
        ];

        session()->put('cart', $cart);
        
        return redirect()->route('collector.cart.index')->with('success', 'Artwork berhasil ditambahkan ke koleksi sementara Anda!');
    }

    /**
     * Hapus satu item spesifik dari keranjang.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Artwork telah dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh isi keranjang sekaligus.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('catalog.index')->with('success', 'Keranjang telah dikosongkan.');
    }
}