<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Artwork;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('collector.cart.index');
        }

        $totalPrice = array_sum(array_column($cart, 'price'));

        return view('collector.checkout.index', compact('cart', 'totalPrice'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'shipping_address' => 'required|string|min:10',
        ]);

        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'price'));

        // 2. Eksekusi Database Transaction
        return DB::transaction(function () use ($request, $cart, $totalPrice) {
            
            // Buat data Order baru
            $order = Order::create([
                'order_number' => 'INV-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'payment_status' => 'pending', // Status awal
            ]);

            foreach ($cart as $id => $details) {
                // Masukkan item ke OrderItems
                OrderItem::create([
                    'order_id' => $order->id,
                    'artwork_id' => $id,
                    'price_at_purchase' => $details['price'],
                ]);

                // Update status lukisan menjadi 'sold'
                Artwork::where('id', $id)->update(['status' => 'sold']);
            }

            // Inisialisasi Shipment (Courier NULL dulu)
            Shipment::create([
                'order_id' => $order->id,
                'status' => 'processing',
                'shipping_address' => $request->shipping_address,
            ]);

            // 3. Bersihkan Keranjang Sementara
            session()->forget('cart');

            // 4. REDIRECT KE HALAMAN SUCCESS (Ini yang bikin tombol lu pindah halaman)
            return redirect()->route('collector.checkout.success', $order->id);
        });
    }

    public function success($id)
    {
        // Ambil data order beserta item dan karya seninya dari database
        // Kita gunakan Eager Loading (with) agar data artist juga terbawa
        $order = \App\Models\Order::with(['items.artwork.artist', 'shipment'])->findOrFail($id);

        // Pastikan hanya kolektor pemilik pesanan yang bisa melihat halaman ini
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this acquisition record.');
        }

        return view('collector.checkout.success', compact('order'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = \App\Models\Order::where('user_id', auth()->id())->findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            // Simpan file bukti ke folder private payment_proofs
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            // Simpan path gambar ke kolom payment_proof di database
            $order->update([
                'payment_proof' => $path
            ]);
        }

        return redirect()->route('collector.orders.index', $order->id)
                        ->with('success', 'Your payment proof has been submitted for gallery verification.');
    }

    public function myOrders()
    {
        // Ambil data order beserta item dan pengirimannya
        $orders = \App\Models\Order::with(['items.artwork', 'shipment'])
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('collector.orders.index', compact('orders'));
    }
}
