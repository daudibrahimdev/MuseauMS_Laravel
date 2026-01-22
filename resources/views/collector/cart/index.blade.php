@extends('layouts.collector')

@section('title', 'Curated Selection | MuseauMS')

@section('content')
<div style="padding: 10rem 7% 5rem; min-height: 100vh; background-color: var(--bg); color: #fff; font-family: 'Poppins', sans-serif;">
    <header style="margin-bottom: 4rem;">
        <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; text-transform: uppercase;">
            Your <span>Selection.</span>
        </h1>
        <p style="color: #888; font-size: 1.1rem; max-width: 600px;">Review your curated masterpieces before finalizing the acquisition process.</p>
    </header>

    @if(session('cart') && count(session('cart')) > 0)
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 5rem; align-items: start;">
            
            {{-- Acquisition List --}}
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] @endphp
                    <div style="display: flex; gap: 2.5rem; background: #0a0a0a; padding: 2.5rem; border: 1px solid #1a1a1a; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#1a1a1a'">
                        
                        {{-- Artwork Visual --}}
                        <div style="width: 220px; height: 160px; overflow: hidden; border: 1px solid #333;">
                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        {{-- Artwork Details --}}
                        <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                            <span style="color: var(--primary); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 0.5rem;">
                                {{ $details['artist'] }}
                            </span>
                            <h3 style="font-size: 2rem; font-weight: 600; margin-bottom: 1rem; color: #fff;">{{ $details['title'] }}</h3>
                            <div style="font-size: 1.4rem; font-weight: 700; color: #fff;">
                                IDR {{ number_format($details['price'], 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div style="display: flex; align-items: center;">
                            <form action="{{ route('collector.cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; color: #444; cursor: pointer; transition: 0.3s;" onmouseover="this.style.color='#e74c3c'">
                                    <i data-feather="trash-2" style="width: 24px; height: 24px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Investment Summary --}}
            <aside style="background: #0d0d0d; padding: 3rem; border: 1px solid #222; position: sticky; top: 120px;">
                <h2 style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2.5rem; border-bottom: 1px solid #222; padding-bottom: 1rem;">
                    Acquisition Summary
                </h2>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; color: #888; font-size: 1.1rem;">
                    <span>Total Masterpieces</span>
                    <span>{{ count(session('cart')) }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 4rem; margin-bottom: 3rem; align-items: baseline;">
                    <span style="font-size: 1rem; color: #666; text-transform: uppercase; letter-spacing: 1px;">Total Investment</span>
                    <strong style="font-size: 2rem; color: var(--primary); font-weight: 700;">
                        IDR {{ number_format($total, 0, ',', '.') }}
                    </strong>
                </div>

                {{-- FIXED PREMIUM BUTTON DESIGN --}}
                <a href="{{ route('collector.checkout.index') }}" 
                   style="width: 100%; text-align: center; display: inline-flex; justify-content: center; align-items: center; gap: 1rem; 
                          padding: 1.5rem; font-size: 1.1rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; 
                          background-color: var(--primary); color: #fff; text-decoration: none; border-radius: 4px; transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.3);"
                   onmouseover="this.style.backgroundColor='#966e48'; this.style.transform='translateY(-3px)';" 
                   onmouseout="this.style.backgroundColor='var(--primary)'; this.style.transform='translateY(0)';" >
                    PROCEED TO CHECKOUT <i data-feather="arrow-right" style="width: 1.2rem; height: 1.2rem;"></i>
                </a>

                <p style="color: #444; font-size: 0.8rem; margin-top: 2rem; text-align: center; line-height: 1.5;">
                    By proceeding, you acknowledge that these masterpieces are subject to availability and private gallery terms.
                </p>
            </aside>
        </div>
    @else
        {{-- Elegant Empty State --}}
        <div style="text-align: center; padding: 10rem 0; border: 1px dashed #222; border-radius: 4px;">
            <i data-feather="shopping-bag" style="width: 64px; height: 64px; color: #222; margin-bottom: 2rem;"></i>
            <h2 style="font-size: 2rem; color: #666; font-weight: 300; margin-bottom: 2rem;">Your collection is currently empty.</h2>
            <a href="{{ route('catalog.index') }}" 
               style="padding: 1rem 3rem; background-color: var(--primary); color: #fff; text-decoration: none; font-weight: 700; display: inline-block; letter-spacing: 2px;"
               onmouseover="this.style.backgroundColor='#966e48'" 
               onmouseout="this.style.backgroundColor='var(--primary)'">
                EXPLORE COLLECTIONS
            </a>
        </div>
    @endif
</div>
@endsection