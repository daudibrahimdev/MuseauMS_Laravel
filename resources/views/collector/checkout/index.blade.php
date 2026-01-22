@extends('layouts.collector')

@section('title', 'Finalize Acquisition | MuseauMS')

@section('content')
<div style="padding: 10rem 7% 5rem; min-height: 100vh; background-color: var(--bg); color: #fff; font-family: 'Poppins', sans-serif;">
    
    {{-- Page Header --}}
    <header style="margin-bottom: 4rem; text-align: center;">
        <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -2px; text-transform: uppercase; margin-bottom: 1rem;">
            Acquisition <span>Finalization.</span>
        </h1>
        <p style="color: #666; font-size: 1.1rem;">Please provide your shipping particulars to complete the acquisition of your selected masterpieces.</p>
    </header>

    <form action="{{ route('collector.checkout.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 450px; gap: 6rem; align-items: start;">
            
            {{-- Left Side: Shipping & Masterpiece Review --}}
            <div style="display: flex; flex-direction: column; gap: 4rem;">
                
                {{-- Shipping Section --}}
                <section>
                    <h2 style="font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary); margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                        <i data-feather="map-pin"></i> Shipping Particulars
                    </h2>
                    <div style="background: #0a0a0a; padding: 2.5rem; border: 1px solid #1a1a1a;">
                        <label for="shipping_address" style="display: block; color: #888; margin-bottom: 1rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Full Delivery Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="4" required 
                            placeholder="Enter your international shipping address here..."
                            style="width: 100%; background: #000; border: 1px solid #333; color: #fff; padding: 1.5rem; border-radius: 4px; font-size: 1rem; line-height: 1.6; transition: 0.3s;"
                            onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#333'"></textarea>
                        @error('shipping_address')
                            <p style="color: #e74c3c; font-size: 0.85rem; mt-2;">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                {{-- Selected Works Review --}}
                <section>
                    <h2 style="font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary); margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                        <i data-feather="layers"></i> Portfolio Review
                    </h2>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($cart as $id => $details)
                        <div style="display: flex; gap: 2rem; background: #0a0a0a; padding: 1.5rem; border: 1px solid #1a1a1a; align-items: center;">
                            <img src="{{ asset('storage/' . $details['image']) }}" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #333;">
                            <div style="flex: 1;">
                                <h4 style="font-size: 1.2rem; color: #fff; margin-bottom: 0.3rem;">{{ $details['title'] }}</h4>
                                <p style="color: #666; font-size: 0.9rem; font-style: italic;">by {{ $details['artist'] }}</p>
                            </div>
                            <div style="font-weight: 700; color: var(--primary);">
                                IDR {{ number_format($details['price'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- Right Side: Investment Summary & Action --}}
            <aside style="background: #0d0d0d; padding: 3.5rem; border: 1px solid #222; position: sticky; top: 120px;">
                <h2 style="font-size: 1.4rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2.5rem; border-bottom: 1px solid #222; padding-bottom: 1rem;">
                    Investment Detail
                </h2>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 3rem;">
                    <div style="display: flex; justify-content: space-between; color: #888;">
                        <span>Subtotal ({{ count($cart) }} Artworks)</span>
                        <span>IDR {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: #888;">
                        <span>Insurance & Handling</span>
                        <span style="font-style: italic;">Complimentary</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #222; align-items: baseline;">
                        <span style="font-size: 1rem; color: #fff; font-weight: 600;">Total Amount</span>
                        <strong style="font-size: 1.8rem; color: var(--primary); font-weight: 700;">
                            IDR {{ number_format($totalPrice, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>

                <button type="submit" class="cta" style="width: 100%; border: none; padding: 1.5rem; font-size: 1.1rem; letter-spacing: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 1rem;">
                    FINALIZE ACQUISITION <i data-feather="check-circle"></i>
                </button>

                <div style="margin-top: 2rem; padding: 1.5rem; background: #000; border: 1px solid #1a1a1a; font-size: 0.8rem; color: #555; line-height: 1.6;">
                    <i data-feather="shield" style="width: 12px; height: 12px; margin-right: 5px;"></i>
                    Your transaction is secured by MuseauMS private encryption. By clicking the button above, you agree to our Private Acquisition Terms and conditions.
                </div>
            </aside>
        </div>
    </form>
</div>
@endsection