@extends('layouts.curator')

@section('title', 'Refine Artist: ' . $artist->name)
@section('header_title', 'Update Legend Profile')

@push('styles')
<style>
    /* --- FORM CONTAINER STYLING (PERFECT SYNC WITH CREATE) --- */
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
    }

    .input-error {
        border-color: #d63031 !important;
    }

    /* --- IMAGE PREVIEW AREA --- */
    .preview-box {
        width: 100%;
        height: 100%;
        min-height: 350px;
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
        object-fit: cover;
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

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
        <h3 style="color: #fff; font-size: 1.5rem;">Update Artist Records</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Refining the biography of <strong>{{ $artist->name }}</strong>.</p>
    </div>

    {{-- Form Action ke Update Method dengan Spoofing PUT --}}
    <form action="{{ route('curator.artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            {{-- Bagian Kiri: Metadata Artist --}}
            <div class="input-col">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="input-custom @error('name') input-error @enderror" 
                           value="{{ old('name', $artist->name) }}" required>
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Nationality</label>
                    <input type="text" name="nationality" class="input-custom @error('nationality') input-error @enderror" 
                           value="{{ old('nationality', $artist->nationality) }}" required>
                    @error('nationality') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Birth Date</label>
                    <input type="date" name="birth_date" class="input-custom @error('birth_date') input-error @enderror" 
                           value="{{ old('birth_date', $artist->birth_date) }}">
                    @error('birth_date') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Artist Biography</label>
                    <textarea name="bio" class="input-custom @error('bio') input-error @enderror" 
                              required>{{ old('bio', $artist->bio) }}</textarea>
                    @error('bio') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bagian Kanan: Portrait Upload --}}
            <div class="upload-col">
                <div class="form-group" style="height: 100%;">
                    <label>Profile Portrait</label>
                    <div class="preview-box @error('photo_url') input-error @enderror">
                        {{-- Munculkan gambar lama dari database --}}
                        <img id="image-preview" src="{{ $artist->photo_url ? asset('storage/'.$artist->photo_url) : 'https://placehold.co/400x600/111/b6895b?text=Artist+Portrait' }}" alt="Artist Portrait">
                        
                        <div class="upload-placeholder" id="placeholder-text">
                            <i data-feather="user"></i>
                            <p>Select Artist Photo</p>
                        </div>
                        <input type="file" name="photo_url" id="image-input" accept="image/*">
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.7rem; margin-top: 10px; text-align: center;">Leave empty if you don't want to change the profile photo.</p>
                    @error('photo_url') <span class="error-msg" style="text-align: center;">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; display: flex; gap: 15px; justify-content: flex-end; align-items: center;">
            <a href="{{ route('curator.artists.index') }}" style="padding: 14px 30px; color: var(--text-muted); font-weight: 600; text-decoration: none;">Discard Changes</a>
            <button type="submit" style="background: var(--primary); color: #fff; padding: 14px 45px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(182, 137, 91, 0.3);">
                Update Artist Profile
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // --- PORTRAIT PREVIEW LOGIC ---
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