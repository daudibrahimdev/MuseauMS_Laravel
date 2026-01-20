<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('curator.dashboard') }}" class="sidebar-logo">Museau <span>MS</span></a>
        <div class="close" id="close-btn">
            <i data-feather="x"></i>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('curator.dashboard') }}" class="{{ request()->routeIs('curator.dashboard') ? 'active' : '' }}">
                <i data-feather="home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('curator.orders.index') }}" class="{{ request()->routeIs('curator.orders.index') ? 'active' : '' }}">
                <i data-feather="shopping-bag"></i>
                <span>Orders</span>
                <span class="badge-count">{{ $stats['pending_orders'] ?? 0 }}</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('curator.artworks.*') ? 'active' : '' }}">
            <a href="{{ route('curator.artworks.index') }}">
                <i data-feather="package"></i>
                <span>Products</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i data-feather="layers"></i>
                <span>Categories</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i data-feather="pen-tool"></i>
                <span>Artists</span>
            </a>
        </li>
        <li>
            <hr style="border: 0.5px solid #333; margin: 10px 0;">
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="logout-btn">
                    <i data-feather="log-out"></i>
                    <span>Logout</span>
                </a>
            </form>
        </li>
    </ul>
</aside>