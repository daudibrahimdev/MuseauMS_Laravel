@extends('layouts.curator')

@section('title', 'Edit Category: ' . $category->name)
@section('header_title', 'Refine Art Movement')

@push('styles')
<style>
    
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: #0f0f0f;
        border: 1px solid #333;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        animation: fadeInUp 0.5s ease-out;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-group label {
        display: block;
        color: #b6895b; 
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
    }

    .input-custom {
        width: 100%;
        padding: 14px 16px;
        background: #000;
        border: 1px solid #333;
        border-radius: 10px;
        color: #fff;
        font-size: 0.95rem;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        border-color: #b6895b;
        box-shadow: 0 0 15px rgba(182, 137, 91, 0.15);
        outline: none;
    }

    textarea.input-custom {
        min-height: 150px;
        resize: vertical;
    }

    .error-msg {
        color: #d63031;
        font-size: 0.75rem;
        margin-top: 8px;
        display: block;
        font-weight: 500;
    }

    .input-error {
        border-color: #d63031 !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <div style="margin-bottom: 2.5rem; border-bottom: 1px solid #333; padding-bottom: 1.5rem;">
        <h3 style="color: #fff; font-size: 1.6rem; letter-spacing: -0.5px;">Update Category Details</h3>
        <p style="color: #888; font-size: 0.9rem;">Refining the definition of <strong>{{ $category->name }}</strong>.</p>
    </div>

    {{-- Form Action ke Update Method dengan Spoofing PUT --}}
    <form action="{{ route('curator.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="name" 
                   class="input-custom @error('name') input-error @enderror" 
                   value="{{ old('name', $category->name) }}" 
                   placeholder="e.g. Surrealism" required>
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Slug (Automatic)</label>
            <input type="text" class="input-custom" value="{{ $category->slug }}" disabled 
                   style="opacity: 0.5; cursor: not-allowed; background: #0a0a0a;">
            <small style="color: #555; font-size: 0.75rem; margin-top: 5px; display: block;">Slug will be updated based on the new name.</small>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" 
                      class="input-custom @error('description') input-error @enderror" 
                      placeholder="Explain the characteristics of this art movement...">{{ old('description', $category->description) }}</textarea>
            @error('description') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 3rem; display: flex; gap: 20px; justify-content: flex-end; align-items: center;">
            <a href="{{ route('curator.categories.index') }}" 
               style="color: #888; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: 0.3s;"
               onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">
               Discard Changes
            </a>
            <button type="submit" 
                    style="background: #b6895b; color: #fff; padding: 14px 40px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 20px rgba(182, 137, 91, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                Update Category
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    feather.replace();
</script>
@endpush