@extends('layouts.collector')

@section('title', 'Collections')

@push('styles')
<style>
    /* Menggunakan background spesifik untuk halaman Collection */
    .hero {
        background-image: url("{{ asset('img/dark.jpg') }}");
    }

    .hero .mask-container {
        -webkit-mask-image: url("{{ asset('img/dark.svg') }}");
    }
    
    /* Styling tambahan untuk pagination agar sesuai tema Museau MS */
    .pagination-container {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<section class="hero" id="home">
    <div class="mask-container">
        <main class="content">
            <h1>Colle<span>ction.</span></h1>
            <p>Eksplorasi mahakarya dari seluruh penjuru dunia, dikurasi khusus untuk Anda.</p>
        </main>
    </div>
</section>

<section id="menu" class="menu">
    <h2><span>Presence </span>here follows restraint.</h2>
    <p>Setiap goresan kuas menyimpan cerita. Temukan makna di balik setiap karya besar.</p>

    <div class="row">
        @forelse ($artworks as $artwork)
            <div class="menu-card">
                {{-- Pastikan folder public/img/artworks/ sudah ada isinya --}}
                <img src="{{ asset('img/artworks/' . $artwork->image_url) }}" 
                     alt="{{ $artwork->title }}" 
                     class="menu-card-img"
                     onerror="this.src='{{ asset('img/menu/1.jpg') }}'"> {{-- Fallback jika gambar tidak ada --}}
                
                <h3 class="menu-card-title">{{ $artwork->title }}</h3>
                <p class="menu-card-price">IDR {{ number_format($artwork->price, 0, ',', '.') }}</p>

                <div class="menu-card-buttons">
                    <a href="{{ route('collector.collections.show', $artwork->slug) }}" class="btn-info">
                        <i data-feather="eye"></i> Detail
                    </a>
                    <a href="#" class="btn-cart">
                        <i data-feather="shopping-cart"></i> Add to Cart
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Belum ada koleksi yang dipamerkan saat ini.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-container">
        {{ $artworks->links() }}
    </div>
</section>
@endsection