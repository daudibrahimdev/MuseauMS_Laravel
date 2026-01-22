@extends('layouts.curator')

@section('title', 'Category Management')
@section('header_title', 'Art Movements')

@push('styles')
<style>
    :root { --primary: #b6895b; --bg-card: #0f0f0f; --border-color: #333; --text-muted: #888; }
    .table-card { background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
    .btn-action { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 10px; transition: 0.3s; cursor: pointer; border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); }
    .btn-edit { color: var(--primary); }
    .btn-edit:hover { background: var(--primary); color: #fff; }
    .btn-delete { color: #d63031; }
    .btn-delete:hover { background: #d63031; color: #fff; }
</style>
@endpush

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-weight: 700; color: #fff; font-size: 2rem;">Art Categories</h2>
        <p style="color: var(--text-muted);">Manage movements and genres for your masterpieces.</p>
    </div>
    <a href="{{ route('curator.categories.create') }}">
        <button style="background: var(--primary); color: #fff; padding: 0.8rem 1.8rem; border-radius: 10px; font-weight: 700; border: none; cursor: pointer;">
            <i data-feather="plus"></i> Add Category
        </button>
    </a>
</div>

<div class="table-card">
    <table width="100%" style="color: #fff;">
        <thead>
            <tr style="color: var(--primary); text-transform: uppercase; font-size: 0.8rem; font-weight: 700;">
                <td style="padding-bottom: 1rem;">Movement Name</td>
                <td style="padding-bottom: 1rem;">Slug</td>
                <td style="padding-bottom: 1rem;">Description</td>
                <td align="center">Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr style="border-top: 1px solid #222;">
                <td style="padding: 1.2rem 0; font-weight: 600;">{{ $cat->name }}</td>
                <td style="color: var(--text-muted);">{{ $cat->slug }}</td>
                <td style="max-width: 300px; color: var(--text-muted); font-size: 0.85rem;">{{ Str::limit($cat->description, 60) }}</td>
                <td>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="{{ route('curator.categories.edit', $cat->id) }}" class="btn-action btn-edit"><i data-feather="edit-3" style="width: 16px;"></i></a>
                        <form action="{{ route('curator.categories.destroy', $cat->id) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-action btn-delete swal-delete-btn"><i data-feather="trash-2" style="width: 16px;"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    feather.replace();
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}", background: '#111', color: '#fff', confirmButtonColor: '#b6895b' });
    @endif
    document.querySelectorAll('.swal-delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Delete Category?', text: "Artworks under this category might be affected!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d63031', cancelButtonColor: '#333',
                confirmButtonText: 'Yes, Delete!', background: '#111', color: '#fff'
            }).then((result) => { if (result.isConfirmed) this.closest('.delete-form').submit(); });
        });
    });
</script>
@endpush