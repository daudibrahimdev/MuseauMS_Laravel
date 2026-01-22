@extends('layouts.curator')

@section('title', 'Refine Masterpiece: ' . $artwork->title)
@section('header_title', 'Update Artwork')

@push('styles')
<style>
    /* --- FORM CONTAINER STYLING (MATCHING CREATE) --- */
    .form-container {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        max-width: 950px;
        margin: 0 auto;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        animation: fadeInUp 0.5s ease-out;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .input-custom {
        width: 100%;
        padding: 14px;
        background: #000;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #fff;
        font-family: inherit;
        transition: 0.3s;
    }

    textarea.input-custom {
        min-height: 120px;
        resize: vertical;
    }

    .input-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 15px rgba(182, 137, 91, 0.1);
        outline: none;
    }

    .error-msg {
        color: #d63031;
        font-size: 0.75rem;
        margin-top: 5px;
        display: block;
        font-weight: 500;
        animation: fadeIn 0.3s ease;
    }

    .input-error {
        border-color: #d63031 !important;
    }

    /* --- IMAGE PREVIEW AREA --- */
    .preview-box {
        width: 100%;
        height: 350px;
        background: #000;
        border: 2px dashed var(--border-color);
        border-radius: 12px;
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
        z-index: 5;
    }

    .upload-placeholder {
        text-align: center;
        color: var(--text-muted);
        position: relative;
        z-index: 5;
        display: none; /* Sembunyi karena di edit sudah ada gambar */
    }

    .upload-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        display: block;
    }

    #image-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0; left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 20;
    }

    /* Checkbox & Switch Styling */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 10px 0;
    }

    .checkbox-group input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
    }

    /* --- ANIMATION --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
        <h3 style="color: #fff; font-size: 1.5rem;">Refine Masterpiece Details</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Currently updating: <strong>{{ $artwork->title }}</strong></p>
    </div>

    {{-- Form Edit: Action ke update, Method PUT --}}
    <form action="{{ route('curator.artworks.update', $artwork->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            {{-- Bagian Kiri: Metadata --}}
            <div class="input-col">
                <div class="form-group">
                    <label>Artwork Title</label>
                    <input type="text" name="title" class="input-custom @error('title') input-error @enderror" 
                           value="{{ old('title', $artwork->title) }}">
                    @error('title') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Artist / Painter</label>
                    <select name="artist_id" class="input-custom @error('artist_id') input-error @enderror">
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id', $artwork->artist_id) == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Art Medium</label>
                    <input type="text" name="medium" class="input-custom @error('medium') input-error @enderror" 
                           value="{{ old('medium', $artwork->medium) }}">
                    @error('medium') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Valuation (IDR)</label>
                    <input type="number" name="price" class="input-custom @error('price') input-error @enderror" 
                           value="{{ old('price', $artwork->price) }}">
                </div>

                <div class="form-group">
                    <label>Physical Dimensions</label>
                    <input type="text" name="dimensions" class="input-custom @error('dimensions') input-error @enderror" 
                           value="{{ old('dimensions', $artwork->dimensions) }}">
                </div>

                <div class="form-group">
                    <label>Year Created</label>
                    <input type="number" name="year_created" class="input-custom @error('year_created') input-error @enderror" 
                           value="{{ old('year_created', $artwork->year_created) }}">
                    @error('year_created') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bagian Kanan: Visual & Status --}}
            <div class="upload-col">
                <div class="form-group">
                    <label>Masterpiece Image</label>
                    <div class="preview-box @error('image_url') input-error @enderror">
                        {{-- Munculkan gambar yang sudah ada --}}
                        <img id="image-preview" src="{{ asset('storage/' . $artwork->image_url) }}" alt="Preview Image">
                        
                        <div class="upload-placeholder" id="placeholder-text">
                            <i data-feather="image"></i>
                            <p>Click to select or drag image</p>
                        </div>
                        <input type="file" name="image_url" id="image-input" accept="image/*">
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.7rem; margin-top: 8px; text-align: center;">Leave empty if you don't want to change the visual.</p>
                </div>

                <div class="form-group">
                    <label>Movement / Category</label>
                    <select name="category_id" class="input-custom @error('category_id') input-error @enderror">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $artwork->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Gallery Status</label>
                    <select name="status" class="input-custom @error('status') input-error @enderror">
                        <option value="available" {{ old('status', $artwork->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status', $artwork->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="archived" {{ old('status', $artwork->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $artwork->is_featured) ? 'checked' : '' }}>
                    <label for="is_featured" style="margin-bottom: 0; cursor: pointer; color: #fff;">Set as Featured Artwork</label>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-top: 1rem;">
            <label>Artwork Description</label>
            <textarea name="description" class="input-custom @error('description') input-error @enderror" 
                      placeholder="Describe the masterpiece...">{{ old('description', $artwork->description) }}</textarea>
            @error('description') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 15px; justify-content: flex-end; align-items: center;">
            <a href="{{ route('curator.artworks.index') }}" style="padding: 14px 30px; color: var(--text-muted); font-weight: 600;">Discard Changes</a>
            <button type="submit" style="background: var(--primary); color: #fff; padding: 14px 45px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(182, 137, 91, 0.3);">
                Update Masterpiece
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholderText = document.getElementById('placeholder-text');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            placeholderText.style.display = 'none';
            imagePreview.style.display = 'block';
            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
            });
            reader.readAsDataURL(file);
        }
    });

    feather.replace();
</script>
@endpush