<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan with() untuk menghindari masalah N+1 Query
        $query = Order::with(['user', 'shipment'])->latest();

        // --- LOGIC SMART FILTER ---
        if ($request->filled('status')) {
            $status = $request->status;

            switch ($status) {
                case 'pending':
                    // Filter: Pesanan yang butuh konfirmasi pembayaran (Curator: verifyPayment())
                    $query->where('payment_status', 'pending');
                    break;

                case 'delivery':
                    // Filter: Sedang diproses atau dalam pengantaran (Shipment status: processing)
                    $query->whereHas('shipment', function ($q) {
                        $q->where('status', 'processing');
                    });
                    break;

                case 'shipping':
                    // Filter: Sedang dikirim oleh kurir (Shipment status: shipped)
                    $query->whereHas('shipment', function ($q) {
                        $q->where('status', 'shipped');
                    });
                    break;

                case 'completed':
                    // Filter: Selesai (Pembayaran Paid + Barang Delivered)
                    $query->where('payment_status', 'paid')
                        ->whereHas('shipment', function ($q) {
                            $q->where('status', 'delivered');
                        });
                    break;
            }
        }

        // Ambil data dengan pagination agar tidak berat
        $orders = $query->paginate(15);

        // Ambil statistik kecil untuk badge sidebar/header
        $stats = [
            'pending_count' => Order::where('payment_status', 'pending')->count()
        ];

        return view('curator.orders.index', compact('orders', 'stats'));
    }

    /**
     * Menampilkan detail satu pesanan secara mendalam.
     */
    public function show($id)
    {
        /**
         * Mengambil order dengan nested relationship:
         * 1. User: Siapa yang beli?
         * 2. Items.Artwork: Apa saja lukisannya? (Dibutuhkan untuk certificate)
         * 3. Shipment: Bagaimana status kirimnya?
         */
        $order = Order::with(['user', 'items.artwork', 'shipment'])
                    ->findOrFail($id);

        return view('curator.orders.show', compact('order'));
    }

    public function verifyPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['payment_status' => 'paid']);
        
        return back()->with('success', 'Payment for order #' . $order->order_number . ' has been verified.');
    }

    public function updateShipment(Request $request, $id)
    {
        // Validasi input agar data kurir sesuai yang ada di dropdown
        $request->validate([
            'courier_name' => 'required',
            'shipping_address' => 'required',
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);
        
        $order->shipment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'courier_name' => $request->courier_name,
                'tracking_code' => $request->tracking_code,
                'status' => $request->status,
                'shipping_address' => $request->shipping_address,
            ]
        );

        return back()->with('success', 'Shipment information updated successfully!');
    }
}
