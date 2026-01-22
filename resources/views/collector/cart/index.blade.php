@extends('layouts.collector')

@section('title', 'Your Cart')

@section('content')
<div style="padding: 8rem 7% 4rem; min-height: 100vh; color: #fff;">
    <h1 style="font-size: 2.5rem; margin-bottom: 3rem;">Shopping <span>Cart.</span></h1>

    @if(session('cart'))
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 4rem; align-items: start;">
            
            {{-- List Items --}}
            <div>
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] @endphp
                    <div style="display: flex; gap: 2rem; background: #0a0a0a; padding: 1.5rem; border-bottom: 1px solid #222; margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $details['image']) }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 4px;">
                        <div style="flex: 1;">
                            <h3 style="color: var(--primary);">{{ $details['title'] }}</h3>
                            <p style="color: #888;">by {{ $details['artist'] }}</p>
                            <h4 style="margin-top: 1rem;">IDR {{ number_format($details['price'], 0, ',', '.') }}</h4>
                        </div>
                        <form action="{{ route('collector.cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; color: #e74c3c; cursor: pointer;">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div style="background: #111; padding: 2rem; border-radius: 8px; border: 1px solid #333;">
                <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid #222; padding-bottom: 1rem;">Summary</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem;">
                    <span>Total Est.</span>
                    <strong style="font-size: 1.2rem; color: var(--primary);">IDR {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
                <a href="#" class="cta" style="width: 100%; text-align: center; display: block;">Proceed to Checkout</a>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 5rem;">
            <i data-feather="shopping-bag" style="width: 64px; height: 64px; color: #333; margin-bottom: 2rem;"></i>
            <p style="color: #666;">Keranjang lu masih kosong, bro.</p>
            <a href="{{ route('catalog.index') }}" style="color: var(--primary); margin-top: 1rem; display: inline-block;">Lihat Koleksi Lukisan</a>
        </div>
    @endif
</div>
@endsection