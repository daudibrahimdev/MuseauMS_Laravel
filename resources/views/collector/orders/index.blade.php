@extends('layouts.collector')

@section('title', 'My Acquisitions | MuseauMS')

@section('content')
<div style="padding: 10rem 7% 5rem; min-height: 100vh; background-color: var(--bg); color: #fff; font-family: 'Poppins', sans-serif;">
    
    <header style="margin-bottom: 4rem;">
        <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -2px; text-transform: uppercase;">
            Acquisition <span>Portfolio.</span>
        </h1>
        <p style="color: #666; font-size: 1.1rem; margin-top: 0.5rem;">Monitor the status and logistics of your private collection.</p>
    </header>

    @if($orders->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @foreach($orders as $order)
                <div style="background: #0a0a0a; border: 1px solid #1a1a1a; padding: 2.5rem; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#1a1a1a'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; border-bottom: 1px solid #222; padding-bottom: 1.5rem;">
                        <div>
                            <span style="color: #444; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;">Order Reference</span>
                            <h3 style="font-size: 1.2rem; margin-top: 0.3rem;">{{ $order->order_number }}</h3>
                        </div>
                        <div style="text-align: right;">
                            {{-- Warna status dinamis sesuai payment_status --}}
                            <span style="display: inline-block; padding: 0.5rem 1.5rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; 
                                {{ $order->payment_status == 'paid' ? 'background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid #2ecc71;' : 'background: rgba(241, 196, 15, 0.1); color: #f1c40f; border: 1px solid #f1c40f;' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 4rem;">
                        {{-- Daftar Lukisan --}}
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($order->items as $item)
                                <div style="display: flex; gap: 1.5rem; align-items: center;">
                                    <img src="{{ asset('storage/' . $item->artwork->image_url) }}" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #333;">
                                    <div>
                                        <h4 style="font-size: 1rem; color: #fff;">{{ $item->artwork->title }}</h4>
                                        <p style="color: #555; font-size: 0.8rem;">Acquired for IDR {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Info Logistik --}}
                        <div style="background: #000; padding: 1.5rem; border: 1px solid #111;">
                            <h4 style="font-size: 0.8rem; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Logistic Status</h4>
                            <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 0.5rem;">{{ strtoupper($order->shipment->status ?? 'Processing') }}</p>
                            @if($order->shipment && $order->shipment->tracking_code)
                                <p style="color: #666; font-size: 0.8rem;">Tracking: <span style="color: #fff;">{{ $order->shipment->tracking_code }}</span></p>
                            @else
                                <p style="color: #444; font-size: 0.75rem; font-style: italic;">Awaiting curator verification & courier dispatch.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 8rem 0; border: 1px dashed #222;">
            <p style="color: #555; font-size: 1.2rem; font-weight: 300;">You have no active acquisition records.</p>
            <a href="{{ route('catalog.index') }}" class="cta" style="margin-top: 2rem; display: inline-block; text-decoration: none;">Explore Gallery</a>
        </div>
    @endif
</div>
@endsection