@extends('layouts.collector')

@section('title', $artwork->title . ' - Details')

@push('styles')
<style>
    .detail-container {
        padding: 8rem 7% 4rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
        min-height: 100vh;
    }

    .artwork-image-wrapper img {
        width: 100%;
        border-radius: 4px;
        border: 1px solid #333;
        box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    }

    .artwork-info h1 {
        font-size: 3.5rem;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }

    .artwork-info .artist-name {
        font-size: 1.5rem;
        color: var(--primary);
        font-style: italic;
        margin-bottom: 2rem;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin: 2rem 0;
        padding: 2rem 0;
        border-top: 1px solid #222;
        border-bottom: 1px solid #222;
    }

    .spec-item label {
        display: block;
        color: #666;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .spec-item span {
        color: #fff;
        font-size: 1.1rem;
    }

    .price-tag {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 2rem 0;
        color: #fff;
    }

    .description-text {
        line-height: 1.8;
        color: #aaa;
        font-size: 1.1rem;
        margin-bottom: 3rem;
    }

    .btn-buy {
        background-color: var(--primary);
        color: #fff;
        padding: 1.2rem 3rem;
        font-size: 1.1rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn-buy:hover {
        background-color: #966e48;
        transform: translateY(-3px);
    }

    @media (max-width: 991px) {
        .detail-container {
            grid-template-columns: 1fr;
            padding-top: 6rem;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    {{-- Sisi Kiri: Visual Lukisan --}}
    <div class="artwork-image-wrapper">
        <img src="{{ asset('storage/' . $artwork->image_url) }}" alt="{{ $artwork->title }}">
    </div>

    {{-- Sisi Kanan: Informasi Detail --}}
    <div class="artwork-info">
        <span style="color: #a0a0a0; text-transform: uppercase; letter-spacing: 3px; font-size: 0.8rem;">
            {{ $artwork->category->name }}
        </span>
        <h1>{{ $artwork->title }}</h1>
        <p class="artist-name">by {{ $artwork->artist->name }}</p>

        <div class="description-text">
            {{ $artwork->description }}
        </div>

        <div class="specs-grid">
            <div class="spec-item">
                <label>Medium</label>
                <span>{{ $artwork->medium }}</span>
            </div>
            <div class="spec-item">
                <label>Dimensions</label>
                <span>{{ $artwork->dimensions }}</span>
            </div>
            <div class="spec-item">
                <label>Created In</label>
                <span>{{ $artwork->year_created }}</span>
            </div>
            <div class="spec-item">
                <label>Availability</label>
                <span style="color: {{ $artwork->status == 'available' ? '#2ecc71' : '#e74c3c' }}">
                    {{ ucfirst($artwork->status) }}
                </span>
            </div>
        </div>

        <div class="price-tag">
            IDR {{ number_format($artwork->price, 0, ',', '.') }}
        </div>

        <div class="action-buttons">
            @auth
                @if($artwork->status == 'available')
                    {{-- Form fungsional: Width 100% dihapus agar kembali ke design awal lu --}}
                    <form action="{{ route('collector.cart.add', $artwork->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-buy" style="border: none; cursor: pointer;">
                            <i data-feather="shopping-cart"></i> Add to Collection
                        </button>
                    </form>
                @else
                    <button class="btn-buy" style="background: #333; cursor: not-allowed;" disabled>
                        Already Acquired
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-buy">
                    <i data-feather="log-in"></i> Login to Purchase
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection