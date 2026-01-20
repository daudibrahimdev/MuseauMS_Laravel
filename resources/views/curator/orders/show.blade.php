@extends('layouts.curator')

@section('title', 'Order Detail #' . $order->order_number)
@section('header_title', 'Order Detail')

@push('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .order-card {
        background: #111;
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid #222;
        margin-bottom: 2rem;
    }

    /* Notifikasi Style */
    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        border: 1px solid #28a745;
        color: #28a745;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .section-title {
        color: #b6895b;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
    }

    .info-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .info-item label {
        display: block;
        color: #888;
        font-size: 0.8rem;
        margin-bottom: 5px;
    }

    .info-item p {
        font-weight: 500;
        color: #fff;
    }

    .artwork-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem 0;
        border-bottom: 1px solid #222;
    }

    .artwork-img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #b6895b;
    }

    .btn-verify {
        background: #b6895b;
        color: #fff;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-weight: 600;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-verify:hover {
        background: #a0764d;
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
    }

    .status-badge.pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
    .status-badge.paid { background: rgba(40, 167, 69, 0.2); color: #28a745; }

    .input-custom {
        background: #1a1a1a;
        border: 1px solid #333;
        color: #fff;
        padding: 12px;
        border-radius: 5px;
        width: 100%;
        margin-top: 10px;
        font-family: inherit;
    }

    textarea.input-custom {
        resize: vertical;
        min-height: 80px;
    }

    @media (max-width: 992px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- Menampilkan Notifikasi Sukses --}}
@if(session('success'))
    <div class="alert-success">
        <i data-feather="check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="detail-grid">
    <div class="left-col">
        <div class="order-card">
            <div class="section-title">
                <i data-feather="shopping-bag"></i> Transaction Details
            </div>
            <div class="info-group">
                <div class="info-item">
                    <label>Order Number</label>
                    <p>#{{ $order->order_number }}</p>
                </div>
                <div class="info-item">
                    <label>Order Date</label>
                    <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="info-item">
                    <label>Payment Status</label>
                    <span class="status-badge {{ $order->payment_status }}">
                        {{ $order->payment_status }}
                    </span>
                </div>
                <div class="info-item">
                    <label>Total Amount</label>
                    <p style="color: #b6895b; font-size: 1.2rem;">IDR {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="order-card">
            <div class="section-title">
                <i data-feather="image"></i> Purchased Artworks
            </div>
            @foreach($order->items as $item)
            <div class="artwork-item">
                <img src="{{ asset('img/artworks/' . $item->artwork->image_url) }}" class="artwork-img">
                <div class="artwork-info">
                    <h4 style="color: #fff;">{{ $item->artwork->title }}</h4>
                    <p style="color: #888; font-size: 0.85rem;">Artist: {{ $item->artwork->artist->name }}</p>
                    <p style="color: #b6895b; font-weight: 600;">IDR {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="right-col">
        <div class="order-card">
            <div class="section-title">
                <i data-feather="user"></i> Customer Info
            </div>
            <div class="info-item" style="margin-bottom: 1rem;">
                <label>Name</label>
                <p>{{ $order->user->name }}</p>
            </div>
            <div class="info-item">
                <label>Current Shipping Address</label>
                <p style="font-size: 0.9rem; line-height: 1.5; color: #ccc;">{{ $order->shipment->shipping_address ?? 'Address not set' }}</p>
            </div>
        </div>

        @if($order->payment_status === 'pending')
        <div class="order-card" style="border: 1px solid #b6895b;">
            <div class="section-title">
                <i data-feather="check-circle"></i> Curator Action
            </div>
            <p style="font-size: 0.85rem; color: #ccc; margin-bottom: 1.5rem;">Verify the payment to proceed with shipment and certificate generation.</p>
            <form action="{{ route('curator.orders.verify', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-verify">VERIFY PAYMENT</button>
            </form>
        </div>
        @endif

        <div class="order-card">
            <div class="section-title">
                <i data-feather="truck"></i> Shipment Tracking
            </div>
            <form action="{{ route('curator.orders.updateShipment', $order->id) }}" method="POST">
                @csrf
                
                {{-- Dropdown Nama Kurir --}}
                <label style="color: #888; font-size: 0.8rem;">Courier Name</label>
                <select name="courier_name" class="input-custom" required>
                    <option value="" disabled {{ !isset($order->shipment->courier_name) ? 'selected' : '' }}>Select Courier</option>
                    <option value="JNE Express" {{ ($order->shipment->courier_name ?? '') == 'JNE Express' ? 'selected' : '' }}>JNE Express</option>
                    <option value="J&T Express" {{ ($order->shipment->courier_name ?? '') == 'J&T Express' ? 'selected' : '' }}>J&T Express</option>
                    <option value="Sicepat" {{ ($order->shipment->courier_name ?? '') == 'Sicepat' ? 'selected' : '' }}>Sicepat</option>
                    <option value="Pos Indonesia" {{ ($order->shipment->courier_name ?? '') == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                    <option value="FedEx" {{ ($order->shipment->courier_name ?? '') == 'FedEx' ? 'selected' : '' }}>FedEx</option>
                </select>

                {{-- Input Alamat Pengiriman (Wajib ada untuk mencegah SQL Error) --}}
                <label style="color: #888; font-size: 0.8rem; margin-top: 15px; display: block;">Shipping Address</label>
                <textarea name="shipping_address" class="input-custom" required placeholder="Update shipping address if necessary">{{ $order->shipment->shipping_address ?? '' }}</textarea>
                
                <label style="color: #888; font-size: 0.8rem; margin-top: 15px; display: block;">Tracking Code (Resi)</label>
                <input type="text" name="tracking_code" class="input-custom" value="{{ $order->shipment->tracking_code ?? '' }}" placeholder="Enter AWB Number">
                
                <label style="color: #888; font-size: 0.8rem; margin-top: 15px; display: block;">Delivery Status</label>
                <select name="status" class="input-custom">
                    <option value="processing" {{ ($order->shipment->status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ ($order->shipment->status ?? '') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ ($order->shipment->status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>

                <button type="submit" class="btn-verify" style="margin-top: 20px; background: transparent; border: 1px solid #b6895b; color: #b6895b;">
                    UPDATE SHIPMENT
                </button>
            </form>
        </div>
    </div>
</div>
@endsection