@extends('layouts.collector')

@section('title', $artwork->title)

@section('content')
    <section class="about" id="product-detail" style="padding-top: 10rem;">
        <h2><span>Product</span> Details</h2>

        <div class="row">
            <div class="about-img">
                {{-- Mengambil gambar dinamis dari database --}}
                <img src="{{ asset('img/artworks/' . $artwork->image_url) }}" alt="{{ $artwork->title }}" />
            </div>

            <div class="content">
                {{-- Judul dan Deskripsi Dinamis --}}
                <h3>{{ $artwork->title }}</h3>
                <p>{{ $artwork->description }}</p>
                
                <div class="product-info-table">
                    <div class="info-item">
                        <strong>Artist</strong>
                        {{-- Mengambil nama dari relasi Artist --}}
                        <span>{{ $artwork->artist->name }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Year Created</strong>
                        <span>{{ $artwork->year_created }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Price</strong>
                        {{-- Format mata uang otomatis --}}
                        <span class="price-highlight">IDR {{ number_format($artwork->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Medium</strong>
                        <span>{{ $artwork->medium }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Dimensions</strong>
                        <span>{{ $artwork->dimensions }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Category</strong>
                        {{-- Mengambil nama dari relasi Category --}}
                        <span>{{ $artwork->category->name }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Status</strong>
                        <span style="text-transform: capitalize;">{{ $artwork->status }}</span>
                    </div>
                </div>

                <div class="action-buttons" style="margin-top: 2rem;">
                    @if($artwork->status === 'available')
                        <a href="#" class="cta">
                            <i data-feather="shopping-cart"></i> Add to Cart
                        </a>
                    @else
                        <button class="cta" style="background-color: #666; cursor: not-allowed;" disabled>
                            <i data-feather="x-circle"></i> Already Sold
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endsection

@push('scripts')
<script>
    // Memastikan icon feather me-render ulang setelah konten dynamic masuk
    feather.replace();
</script>
@endpush