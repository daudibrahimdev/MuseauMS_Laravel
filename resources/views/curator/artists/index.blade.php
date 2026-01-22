@extends('layouts.curator')

@section('title', 'Artist Directory')
@section('header_title', 'Master Painters')

@push('styles')
<style>
    :root {
        --primary: #b6895b;
        --bg-card: #0f0f0f;
        --border-color: #333;
        --text-muted: #888;
    }

    /* --- TABLE & CARD DESIGN --- */
    .table-card {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        animation: fadeIn 0.5s ease-in-out;
    }

    .artist-avatar { 
        width: 55px; 
        height: 55px; 
        border-radius: 12px; 
        object-fit: cover; 
        border: 2px solid var(--border-color);
        transition: 0.3s;
    }

    tr:hover .artist-avatar { border-color: var(--primary); transform: scale(1.1); }

    .btn-action { 
        width: 38px; height: 38px; border-radius: 10px; transition: 0.3s; 
        border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); 
        display: flex; align-items: center; justify-content: center; color: var(--primary); 
    }

    .btn-action:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }

    /* --- FILTER SECTION --- */
    .filter-group {
        background: var(--bg-card);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .input-filter {
        background: #000;
        border: 1px solid var(--border-color);
        color: #fff;
        padding: 12px 15px;
        border-radius: 10px;
        outline: none;
        transition: 0.3s;
    }

    .input-filter:focus { border-color: var(--primary); }

    /* --- PAGINATION --- */
    .pagination-container {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }

    .custom-pagination nav > div:first-child { display: none !important; }
    .custom-pagination .pagination { display: flex; gap: 6px; list-style: none; padding: 0; }
    .custom-pagination .page-link {
        background: #000 !important; border: 1px solid var(--border-color) !important;
        color: #fff !important; padding: 8px 16px; border-radius: 8px !important;
    }
    .custom-pagination .active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')

{{-- Top Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="color: #fff; font-weight: 800; font-size: 2.2rem; letter-spacing: -1px;">Artist Directory</h2>
        <p style="color: var(--text-muted);">Curating the biographies of the world's most influential painters.</p>
    </div>
    <a href="{{ route('curator.artists.create') }}" style="text-decoration: none;">
        <button style="background: var(--primary); color: #fff; padding: 0.9rem 2rem; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(182, 137, 91, 0.2);">
            <i data-feather="plus"></i> Add Artist
        </button>
    </a>
</div>

{{-- Search & Filter Row --}}
<form action="{{ route('curator.artists.index') }}" method="GET" class="filter-group">
    <div style="position: relative; flex: 2;">
        <i data-feather="search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--primary); width: 18px;"></i>
        <input type="text" name="search" placeholder="Search artist name..." value="{{ request('search') }}" class="input-filter" style="width: 100%; padding-left: 45px;">
    </div>

    <select name="nationality" class="input-filter" style="flex: 1;">
        <option value="">All Nationalities</option>
        @foreach($nationalities as $nat)
            <option value="{{ $nat }}" {{ request('nationality') == $nat ? 'selected' : '' }}>{{ $nat }}</option>
        @endforeach
    </select>

    <select name="sort" class="input-filter" style="flex: 1;">
        <option value="">Sort by Age</option>
        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
    </select>

    <button type="submit" style="background: var(--primary); color: #fff; padding: 12px 25px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer;">Apply</button>
    <a href="{{ route('curator.artists.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Reset</a>
</form>

{{-- Artist Table --}}
<div class="table-card">
    <table width="100%" style="color: #fff; border-collapse: collapse;">
        <thead>
            <tr style="color: var(--primary); text-transform: uppercase; font-size: 0.75rem; font-weight: 800; border-bottom: 1px solid var(--border-color);">
                <td style="padding-bottom: 1rem;">Portrait</td>
                <td>Name & Biography</td>
                <td>Nationality</td>
                <td>Birth Date</td>
                <td align="center">Actions</td>
            </tr>
        </thead>
        <tbody>
            @forelse($artists as $artist)
            <tr style="border-bottom: 1px solid #1a1a1a; transition: 0.3s;">
                <td style="padding: 1.2rem 0;">
                    <img src="{{ $artist->photo_url ? asset('storage/'.$artist->photo_url) : 'https://placehold.co/100x100/111/b6895b?text='.$artist->name }}" class="artist-avatar">
                </td>
                <td>
                    <div style="font-weight: 700; font-size: 1.1rem; color: #fff;">{{ $artist->name }}</div>
                    <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 4px;">{{ Str::limit($artist->bio, 70) }}</div>
                </td>
                <td>
                    <span style="background: rgba(182, 137, 91, 0.1); color: var(--primary); padding: 5px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                        {{ $artist->nationality }}
                    </span>
                </td>
                <td style="color: #ccc; font-size: 0.9rem;">
                    {{ $artist->birth_date ? \Carbon\Carbon::parse($artist->birth_date)->format('M d, Y') : 'Unknown' }}
                </td>
                <td>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="{{ route('curator.artists.edit', $artist->id) }}" class="btn-action" title="Edit Profile"><i data-feather="edit-2" style="width: 16px;"></i></a>
                        <form action="{{ route('curator.artists.destroy', $artist->id) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-action swal-delete-btn" style="color: #d63031;" title="Delete Record"><i data-feather="trash-2" style="width: 16px;"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" align="center" style="padding: 5rem 0; color: var(--text-muted);">
                    <i data-feather="users" style="width: 50px; height: 50px; opacity: 0.2; margin-bottom: 1rem;"></i>
                    <p>No artists found in the directory.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Repaired Pagination --}}
    <div class="pagination-container">
        <div style="color: var(--text-muted); font-size: 0.85rem;">
            Showing <span style="color: #fff; font-weight: 700;">{{ $artists->firstItem() ?? 0 }} - {{ $artists->lastItem() ?? 0 }}</span> 
            of <span style="color: #fff; font-weight: 700;">{{ $artists->total() }}</span> legends
        </div>
        <div class="custom-pagination">
            {{ $artists->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    feather.replace();

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Great!', text: "{{ session('success') }}", background: '#111', color: '#fff', confirmButtonColor: '#b6895b' });
    @endif

    document.querySelectorAll('.swal-delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Expunge Artist?',
                text: "Their artworks will remain, but the creator profile will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d63031',
                cancelButtonColor: '#333',
                confirmButtonText: 'Yes, Expunge!',
                background: '#111',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) this.closest('.delete-form').submit();
            });
        });
    });
</script>
@endpush