<header>
    <div class="menu-toggle" id="menu-toggle">
        <i data-feather="menu"></i>
    </div>
    <div class="header-title">
        <h1>@yield('header_title', 'Dashboard Overview')</h1>
    </div>
    <div class="admin-profile">
        <span>Admin, <b>{{ Auth::user()->name }}</b></span>
        <i data-feather="user"></i>
    </div>
</header>