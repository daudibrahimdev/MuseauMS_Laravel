@extends('layouts.collector')

@section('title', 'Collections')

@push('styles')
<style>
    /* Hero Design Lu - TETAP UTUH */
    .hero {
        background-image: url("{{ asset('img/dark.jpg') }}");
    }

    .hero .mask-container {
  position: absolute;
  inset: 0;
  -webkit-mask-image: url('../img/dark.svg');
  -webkit-mask-repeat: no-repeat;
  -webkit-mask-size: cover;
  -webkit-mask-position: center;
}

    /* Bar Pencarian & Filter yang Efisien */
    .search-filter-wrapper {
        max-width: 1000px;
        margin: -40px auto 3rem auto; /* Overlap ke hero sedikit biar elegan */
        background: #111;
        border: 1px solid #333;
        border-radius: 12px;
        padding: 15px 25px;
        display: flex;
        gap: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.6);
        position: relative;
        z-index: 100;
    }

    .search-filter-wrapper input, .search-filter-wrapper select {
        background: #000;
        border: 1px solid #222;
        color: #ccc;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .search-filter-wrapper input { flex: 3; } /* Kolom Search lebih lebar */
    .search-filter-wrapper select { flex: 1; cursor: pointer; } /* Dropdown Kategori */

    .btn-filter {
        background: #b6895b;
        color: #fff;
        border: none;
        padding: 0 25px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-filter:hover { background: #8e6a45; }

    
</style>
@endpush

@section('content')
{{-- HERO SECTION - TIDAK DIRUBAH --}}
<section class="hero" id="home">
    <div class="mask-container">
        <main class="content">
            <h1>Colle<span>ction.</span></h1>
            <p>Eksplorasi mahakarya dari seluruh penjuru dunia, dikurasi khusus untuk Anda.</p>
        </main>
    </div>
</section>

{{-- MENU SECTION --}}
<section id="menu" class="menu" style="padding-top: 0;">
    
    {{-- Search & Dropdown Kategori (Pengganti Chips Sampah) --}}
    <form action="{{ route('catalog.index') }}" method="GET" class="search-filter-wrapper">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul lukisan...">
        
        <select name="category">
            <option value="">All Art Movements</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-filter">Filter</button>
    </form>

    <div class="row">
        @forelse ($artworks as $artwork)
            <div class="menu-card">
                <img src="{{ asset('storage/' . $artwork->image_url) }}" 
                     alt="{{ $artwork->title }}" 
                     class="menu-card-img"
                     onerror="this.src='{{ asset('img/menu/1.jpg') }}'">
                
                <h3 class="menu-card-title">{{ $artwork->title }}</h3>
                <p class="menu-card-price">IDR {{ number_format($artwork->price, 0, ',', '.') }}</p>

                <div class="menu-card-buttons">
                    <a href="{{ route('catalog.show', $artwork->slug) }}" class="btn-info">
                        <i data-feather="eye"></i> Detail
                    </a>
                    <a href="#" class="btn-cart">
                        <i data-feather="shopping-cart"></i> Add to Cart
                    </a>
                </div>
            </div>
        @empty
            <div style="width: 100%; text-align: center; color: #555; padding: 5rem 0;">
                <p>Tidak ada karya yang ditemukan untuk kriteria tersebut.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-container">
        {{ $artworks->appends(request()->query())->links() }}
    </div>
</section>
@endsection