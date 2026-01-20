<!-- navbar start -->
    <nav class="navbar">
      <a href="home" class="navbar-logo">Museau <span>MS</span></a>
      <div class="navbar-nav">
        <a href="{{ route('collector.home') }}">Home</a>
        <a href="about.html">About Us</a>
        <a href="{{ route('collection.index') }}">Collections</a>
        <a href="reference.html">Reference</a>
        <a href="attribution.html">Attribution</a>
      </div>

      

      <div class="navbar-extra">
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i></a>

        @auth
          <div class="user-profile-dropdown">
                <a href="#" id="user-button"><i data-feather="user"></i></a>
                
                <div class="dropdown-menu">
                    <a href="{{ route('profile.show') }}"><i data-feather="settings"></i> Profile Settings</a>
                    
                    @if(Auth::user()->role === 'curator')
                        <a href="{{ route('admin.dashboard') }}"><i data-feather="layout"></i> Curator Panel</a>
                    @endif
                    
                    <hr>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                            <i data-feather="log-out"></i> Logout
                        </a>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" title="Login"><i data-feather="log-in"></i></a>
        @endauth

        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>

      <!-- search form start -->
       <div class="search-form">
        <input type="search" id="search-box" placeholder="search here...">
        <label for="search-box"><i data-feather="search"></i></label>
       </div>


       <!-- search form end -->

       <!-- shopping cart start -->
        <div class="shopping-cart">
          <div class="cart-item">
            <img src="img/menu/1.jpg" alt="">
            <div class="item-detail">
              <h3>Product</h3>
              <div class="item-price">IDR 2000k</div>
              <i data-feather="trash-2" class="remove-item"></i>
            </div>
          </div>
          <div class="cart-item">
            <img src="img/menu/1.jpg" alt="">
            <div class="item-detail">
              <h3>Product</h3>
              <div class="item-price">IDR 2000k</div>
              <i data-feather="trash-2" class="remove-item"></i>
            </div>
          </div>
        </div>

        
        
        
       <!-- shopping cart ends -->
    </nav>
    <!-- navbar ends -->