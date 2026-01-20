<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Artwork;
use App\Models\User;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collector = User::where('role', 'collector')->first();
        $artworks = Artwork::all();

        if (!$collector || $artworks->isEmpty()) {
            return;
        }

        // --- SKENARIO 1: Order Baru (Pending) ---
        // Ini untuk ngetes fitur "Needs Confirmation" / verifyPayment()
        $order1 = Order::create([
            'order_number' => 'MS-' . strtoupper(Str::random(8)),
            'user_id' => $collector->id,
            'total_price' => $artworks[0]->price,
            'payment_status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'artwork_id' => $artworks[0]->id,
            'price_at_purchase' => $artworks[0]->price,
        ]);

        Shipment::create([
        'order_id' => $order1->id,
        'courier_name' => 'Pending', // Belum ditentukan kurirnya
        'status' => 'processing',
        'shipping_address' => $collector->address ?? 'Alamat belum diatur di profile', // Otomatis dari user
    ]);

        // --- SKENARIO 2: Order Sedang Dikirim (Paid + Shipped) ---
        // Ini untuk ngetes filter "In Shipping"
        $order2 = Order::create([
            'order_number' => 'MS-' . strtoupper(Str::random(8)),
            'user_id' => $collector->id,
            'total_price' => $artworks[1]->price,
            'payment_status' => 'paid',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'artwork_id' => $artworks[1]->id,
            'price_at_purchase' => $artworks[1]->price,
        ]);

        Shipment::create([
            'order_id' => $order2->id,
            'tracking_code' => 'JNE123456789',
            'courier_name' => 'JNE Express',
            'status' => 'shipped',
            'shipping_address' => 'Jl. Braga No. 10, Bandung, Jawa Barat',
            'estimated_arrival' => now()->addDays(3),
        ]);

        // --- SKENARIO 3: Order Selesai (Paid + Delivered) ---
        // Ini untuk ngetes filter "Completed"
        $order3 = Order::create([
            'order_number' => 'MS-' . strtoupper(Str::random(8)),
            'user_id' => $collector->id,
            'total_price' => $artworks[2]->price,
            'payment_status' => 'paid',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'artwork_id' => $artworks[2]->id,
            'price_at_purchase' => $artworks[2]->price,
        ]);

        Shipment::create([
            'order_id' => $order3->id,
            'tracking_code' => 'POS987654321',
            'courier_name' => 'Pos Indonesia',
            'status' => 'delivered',
            'shipping_address' => 'Jl. Kebon Jeruk No. 5, Jakarta Barat',
            'estimated_arrival' => now()->subDay(),
        ]);
    }
}
