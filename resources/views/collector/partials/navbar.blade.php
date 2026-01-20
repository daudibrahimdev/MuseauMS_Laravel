<!-- navbar start -->
    <nav class="navbar">
      <a href="home" class="navbar-logo">Museau <span>MS</span></a>
      <div class="navbar-nav">
        <a href="index.html">Home</a>
        <a href="about.html">About Us</a>
        <a href="products.html">Collections</a>
        <a href="reference.html">Reference</a>
        <a href="attribution.html">Attribution</a>
      </div>

      

      <div class="navbar-extra">
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i></a>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>

        {{-- Logic Auth Start --}}
    @auth
        <a href="{{ route('profile.show') }}" title="Profile">
            <i data-feather="user"></i>
        </a>

        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
            <i data-feather="log-out"></i>
        </a>
    @endauth
    {{-- Logic Auth End --}}

    <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
</div>
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