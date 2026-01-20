@extends('layouts.curator')

@section('title', 'Edit Masterpiece: ' . $artwork->title)
@section('header_title', 'Refine Artwork')

@push('styles')
<style>
    /* --- FORM CONTAINER STYLING --- */
    .form-container {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        max-width: 950px;
        margin: 0 auto;
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-group label {
        display: block;
        color: var(--primary);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
    }

    .input-custom {
        width: 100%;
        padding: 14px 16px;
        background: #000;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: #fff;
        font-size: 0.95rem;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 20px rgba(182, 137, 91, 0.15);
        outline: none;
    }

    /* --- ENHANCED IMAGE PREVIEW --- */
    .preview-box {
        width: 100%;
        height: 350px;
        background: #050505;
        border: 2px dashed var(--border-color);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: 0.3s;
    }

    .preview-box:hover {
        border-color: var(--primary);
    }

    #image-preview {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: 0.5s;
    }

    .upload-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        padding: 15px;
        text-align: center;
        color: var(--primary);
        font-size: 0.8rem;
        font-weight: 600;
        transform: translateY(100%);
        transition: 0.3s;
    }

    .preview-box:hover .upload-overlay {
        transform: translateY(0);
    }

    @media (max-width: 992px) {
        .form-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <div style="margin-bottom: 2.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
        <h3 style="color: #fff; font-size: 1.8rem; letter-spacing: -0.5px;">Update Masterpiece</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">You are currently modifying <strong>{{ $artwork->title }}</strong></p>
    </div>

    {{-- Form Edit Wajib ada @method('PUT') --}}
    <form action="{{ route('curator.artworks.update', $artwork->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            {{-- Kiri: Fields Data --}}
            <div class="fields-col">
                <div class="form-group">
                    <label>Artwork Title</label>
                    <input type="text" name="title" class="input-custom" value="{{ old('title', $artwork->title) }}" required>
                </div>

                <div class="form-group">
                    <label>Assigned Artist</label>
                    <select name="artist_id" class="input-custom" required>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ $artwork->artist_id == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Genre / Category</label>
                    <select name="category_id" class="input-custom" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $artwork->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Current Valuation (IDR)</label>
                    <input type="number" name="price" class="input-custom" value="{{ old('price', $artwork->price) }}" required>
                </div>
            </div>

            {{-- Kanan: Image Management --}}
            <div class="visual-col">
                <div class="form-group">
                    <label>Masterpiece Visual</label>
                    <div class="preview-box">
                        {{-- Menampilkan gambar lama sebagai default --}}
                        <img id="image-preview" src="{{ asset('storage/' . $artwork->image_url) }}" alt="Current Image">
                        
                        <div class="upload-overlay">
                            <i data-feather="refresh-cw" style="width: 14px; margin-right: 5px;"></i> Click to Change Image
                        </div>

                        <input type="file" name="image_url" id="image-input" accept="image/*" 
                               style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 10px; text-align: center;">
                        Leave empty if you don't want to change the image.
                    </p>
                </div>
            </div>
        </div>

        <div style="margin-top: 3rem; display: flex; gap: 20px; justify-content: flex-end; align-items: center;">
            <a href="{{ route('curator.artworks.index') }}" style="color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Discard Changes</a>
            <button type="submit" style="background: var(--primary); color: #fff; padding: 16px 45px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 20px rgba(182, 137, 91, 0.3);">
                Update Masterpiece
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // --- PREVIEW LOGIC FOR EDIT PAGE ---
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
                // Tambahkan sedikit efek transisi saat gambar diganti
                imagePreview.style.opacity = '0';
                setTimeout(() => {
                    imagePreview.style.opacity = '1';
                }, 100);
            });

            reader.readAsDataURL(file);
        }
    });

    feather.replace();
</script>
@endpush