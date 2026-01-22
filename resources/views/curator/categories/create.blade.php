@extends('layouts.curator')

@section('title', 'Add Category')
@section('header_title', 'New Art Movement')

@section('content')
<div style="max-width: 600px; margin: 0 auto; background: #0f0f0f; border: 1px solid #333; padding: 2.5rem; border-radius: 16px;">
    <h3 style="color: #fff; margin-bottom: 2rem;">Define New Movement</h3>
    <form action="{{ route('curator.categories.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="color: #b6895b; display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 700;">CATEGORY NAME</label>
            <input type="text" name="name" style="width: 100%; padding: 12px; background: #000; border: 1px solid #333; border-radius: 8px; color: #fff;" placeholder="e.g. Surrealism" required>
        </div>
        <div style="margin-bottom: 2rem;">
            <label style="color: #b6895b; display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 700;">DESCRIPTION</label>
            <textarea name="description" rows="5" style="width: 100%; padding: 12px; background: #000; border: 1px solid #333; border-radius: 8px; color: #fff;" placeholder="Brief explanation about this movement..."></textarea>
        </div>
        <div style="display: flex; gap: 15px; justify-content: flex-end;">
            <a href="{{ route('curator.categories.index') }}" style="color: #888; text-decoration: none; padding-top: 10px;">Cancel</a>
            <button type="submit" style="background: #b6895b; color: #fff; padding: 12px 30px; border-radius: 8px; border: none; font-weight: 700; cursor: pointer;">Save Category</button>
        </div>
    </form>
</div>
@endsection