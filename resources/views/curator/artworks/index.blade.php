@extends('layouts.curator')

@section('title', 'Artworks Management')
@section('header_title', 'Artworks Management')

@push('styles')
{{-- SweetAlert2 Custom Style agar sinkron dengan Museau MS --}}
<style>
    .swal2-popup {
        background: #111 !important;
        border: 1px solid #333 !important;
        border-radius: 16px !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .swal2-title { color: #fff !important; }
    .swal2-html-container { color: #888 !important; }
    .swal2-confirm { border-radius: 10px !important; font-weight: 600 !important; }
    .swal2-cancel { border-radius: 10px !important; font-weight: 600 !important; }

    /* --- SEMUA DESIGN ASLI LU PERTAHANKAN DI SINI --- */
    :root {
        --primary: #b6895b;
        --bg-card: #0f0f0f;
        --border-color: #333;
        --text-muted: #888;
    }

    .table-card {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .action-btns {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-action {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        position: relative;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
    }

    .btn-edit { color: var(--primary); }
    .btn-edit:hover {
        background: var(--primary);
        color: #fff;
        transform: rotate(-5deg) scale(1.1);
        box-shadow: 0 5px 15px rgba(182, 137, 91, 0.3);
    }

    .btn-delete { color: #d63031; background: transparent; }
    .btn-delete:hover {
        background: #d63031;
        color: #fff;
        border-color: #d63031;
        transform: rotate(5deg) scale(1.1);
        box-shadow: 0 5px 15px rgba(214, 48, 49, 0.3);
    }

    .artwork-thumb {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid var(--border-color);
        transition: 0.4s;
    }

    tr:hover .artwork-thumb {
        border-color: var(--primary);
        transform: scale(1.08) rotate(2deg);
    }

    .pagination-container {
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-pagination nav > div:first-child {
        display: none !important;
    }

    .custom-pagination .pagination {
        display: flex !important;
        list-style: none !important;
        margin: 0;
        padding: 0;
        gap: 6px;
    }

    .custom-pagination .page-item .page-link {
        background: #000 !important;
        border: 1px solid var(--border-color) !important;
        color: #fff !important;
        padding: 10px 18px;
        border-radius: 10px !important;
        transition: 0.3s;
        font-weight: 500;
    }

    .custom-pagination .page-item.active .page-link {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(182, 137, 91, 0.2);
    }

    .custom-pagination .page-link:hover {
        border-color: var(--primary) !important;
        color: var(--primary) !important;
        transform: translateY(-2px);
    }

    .custom-pagination svg {
        width: 1.2rem;
        height: 1.2rem;
    }
</style>
@endpush

@section('content')

{{-- Top Header Section --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-weight: 700; font-size: 2.2rem; letter-spacing: -1px; color: #fff;">Gallery Inventory</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Management and curation of your digital masterpieces.</p>
    </div>
    <a href="{{ route('curator.artworks.create') }}" style="text-decoration: none;">
        <button style="background: var(--primary); color: #fff; padding: 0.9rem 2rem; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px; cursor: pointer; border: none; transition: 0.3s; box-shadow: 0 4px 15px rgba(182, 137, 91, 0.2);">
            <i data-feather="plus"></i> Add New Artwork
        </button>
    </a>
</div>

{{-- Search & Filter Section --}}
<form action="{{ route('curator.artworks.index') }}" method="GET" class="filter-wrapper" style="background: var(--bg-card); padding: 1.5rem; border-radius: 14px; border: 1px solid var(--border-color); margin-bottom: 2rem; display: flex; gap: 15px; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
    <div class="search-input-group" style="position: relative; flex: 2;">
        <i data-feather="search" style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
        <input type="text" name="search" placeholder="Search masterpiece by title or artist..." value="{{ request('search') }}" style="width: 100%; padding: 14px 14px 14px 50px; background: #000; border: 1px solid var(--border-color); border-radius: 10px; color: #fff; font-size: 0.95rem;">
    </div>

    <select name="category" style="flex: 1; padding: 14px; background: #000; color: #fff; border: 1px solid var(--border-color); border-radius: 10px; cursor: pointer; outline: none;">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>

    <button type="submit" style="background: var(--primary); color: #fff; padding: 14px 30px; border-radius: 10px; cursor: pointer; border: none; font-weight: 700; transition: 0.3s;">Apply Filter</button>
    <a href="{{ route('curator.artworks.index') }}" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none; font-weight: 500; margin-left: 5px;">Reset</a>
</form>

{{-- Artworks Table Section --}}
<div class="table-card">
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td width="120">Masterpiece</td>
                    <td>Artwork Details</td>
                    <td>Category</td>
                    <td>Valuation</td>
                    <td align="center">Actions</td>
                </tr>
            </thead>
            <tbody>
                @forelse($artworks as $artwork)
                <tr style="transition: 0.3s;">
                    <td>
                        <img src="{{ asset('storage/' . $artwork->image_url) }}" class="artwork-thumb" 
                             onerror="this.src='https://placehold.co/400x400/0f0f0f/b6895b?text=Museau+MS'">
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #fff; font-size: 1.15rem; margin-bottom: 6px;">{{ $artwork->title }}</div>
                        <div style="color: var(--text-muted); font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                            <i data-feather="user" style="width: 14px; color: var(--primary);"></i> {{ $artwork->artist->name }}
                        </div>
                    </td>
                    <td>
                        <span style="background: rgba(182, 137, 91, 0.1); color: var(--primary); padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(182, 137, 91, 0.2);">
                            {{ $artwork->category->name }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 800; color: #fff; font-size: 1.1rem;">
                            <span style="color: var(--primary); font-size: 0.85rem; margin-right: 2px;">IDR</span> 
                            {{ number_format($artwork->price, 0, ',', '.') }}
                        </div>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('curator.artworks.edit', $artwork->id) }}" class="btn-action btn-edit" title="Edit Masterpiece">
                                <i data-feather="edit-2" style="width: 18px;"></i>
                            </a>
                            
                            {{-- Form Delete diupdate agar trigger SweetAlert --}}
                            <form action="{{ route('curator.artworks.destroy', $artwork->id) }}" method="POST" class="delete-form">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn-action btn-delete swal-delete-btn" title="Remove Artwork">
                                    <i data-feather="trash-2" style="width: 18px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" align="center" style="padding: 6rem 0; color: var(--text-muted);">
                        <i data-feather="image" style="width: 70px; height: 70px; opacity: 0.15; margin-bottom: 1.5rem;"></i>
                        <p style="font-size: 1.1rem; letter-spacing: 1px;">No masterpieces found in the collection.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Repaired Pagination Area --}}
    <div class="pagination-container">
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
            Displaying <span style="color: var(--primary); font-weight: 700;">{{ $artworks->firstItem() ?? 0 }} - {{ $artworks->lastItem() ?? 0 }}</span> 
            of <span style="color: #fff; font-weight: 700;">{{ $artworks->total() }}</span> masterpieces
        </div>
        <div class="custom-pagination">
            {{ $artworks->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Inisialisasi Feather Icons
    feather.replace();

    // 2. Notifikasi Sukses (Setelah Redirect dari Controller)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#b6895b',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // 3. Logic Konfirmasi Hapus (SweetAlert2)
    document.querySelectorAll('.swal-delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Archive Masterpiece?',
                text: "This artwork will be removed from the gallery display!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d63031',
                cancelButtonColor: '#333',
                confirmButtonText: 'Yes, Archive it!',
                cancelButtonText: 'Keep it',
                background: '#111',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush