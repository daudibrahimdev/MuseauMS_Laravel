<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('curator.dashboard') }}" class="sidebar-logo">Museau <span>MS</span></a>
        <div class="close" id="close-btn">
            <i data-feather="x"></i>
        </div>
    </div>

    <div class="sidebar-content">
        {{-- SECTION: CORE --}}
        <div class="menu-section">
            <span class="section-title">Core Management</span>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('curator.dashboard') }}" class="{{ request()->routeIs('curator.dashboard') ? 'active' : '' }}">
                        <div class="icon-box"><i data-feather="grid"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('curator.orders.index') }}" class="{{ request()->routeIs('curator.orders.*') ? 'active' : '' }}">
                        <div class="icon-box"><i data-feather="shopping-cart"></i></div>
                        <span>Order entries</span>
                        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
                            <span class="badge-premium">{{ $stats['pending_orders'] }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- SECTION: INVENTORY --}}
        <div class="menu-section">
            <span class="section-title">Gallery Collection</span>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('curator.artworks.index') }}" class="{{ request()->routeIs('curator.artworks.*') ? 'active' : '' }}">
                        <div class="icon-box"><i data-feather="image"></i></div>
                        <span>Masterpieces</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('curator.categories.index') }}" class="{{ request()->routeIs('curator.categories.*') ? 'active' : '' }}">
                        <div class="icon-box"><i data-feather="layers"></i></div>
                        <span>Art Movements</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('curator.artists.index') }}" class="{{ request()->routeIs('curator.artists.*') ? 'active' : '' }}">
                        <div class="icon-box"><i data-feather="users"></i></div>
                        <span>Master Artists</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- SECTION: SYSTEM --}}
        <div class="menu-section system-section">
            <ul class="sidebar-menu">
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                            <div class="icon-box"><i data-feather="log-out"></i></div>
                            <span>Exit System</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>