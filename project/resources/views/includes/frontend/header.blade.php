  <header class="header shadow">
      <div class="container-fluid">
          <!-- Desktop Logo, Menubar, Search Start -->
          <div class="d-flex align-items-center justify-content-between px-1 px-lg-3 container-fluid">
              <div class="d-flex align-items-center gap-3 logo_Bar">
                  <div id="menu-btn" class="menu-icon active">
                      <i id="barIcon" class="fa-solid fa-bars-staggered"></i>
                  </div>
                  <a href="{{ route('front.index') }}">
                      <img src="{{ asset('assets/images/' . $gs->logo) }}" class="logo" />
                  </a>
                  <div class="whatsapp_div ">
                      <div class="d-flex align-items-center gap-2"><img style="width: 40px; height: auto;"
                              src="{{ asset('assets/front/images/whatsapp.png') }}" alt="whatsapp">
                          <div>
                              <a href="https://wa.me/8801805020340?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop."
                                  class="text-success fw-bold d-none d-lg-block">
                                  01805020340
                              </a>
                              <a class="text-success fw-bold d-none d-lg-block"
                                  href="https://wa.me/8801805020346?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop.">01805020346</a>
                          </div>
                      </div>
                  </div>
              </div>
              {{-- <div class="search-box d-none d-lg-block">
                  <form action="{{ route('front.search') }}" method="GET">

                      <input autocomplete="off" type="text" name="search" class="searchInput"
                          placeholder="Search for products (e.g. milk, rice, meat, fish)" />
                  </form>

                  <div style=" min-height: 0; max-height: 300px;
                        overflow-y: auto;
                        overflow-x: hidden;
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        position: absolute;
                        width: 100%;
                        z-index: 9999;"
                      class="searchResults"></div>
              </div> --}}
              {{--
              <div class="search-box  container position-relative">
                  <form action="{{ route('front.search') }}" method="GET">

                      <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                          placeholder="Search for products (e.g" />

                      <!-- Animated text -->
                      <div class="placeholder-animation">
                          <span id="slideText">Fish</span>
                          )
                      </div>

                  </form>

                  <div style=" min-height: 0; max-height: 300px;
                        overflow-y: auto;
                        overflow-x: hidden;
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        position: absolute;
                        width: 100%;
                        z-index: 9999;"
                      class="searchResults"></div>
              </div> --}}

              <div class="search-box d-none d-lg-block  container position-relative">
                  <form action="{{ route('front.search') }}" method="GET">

                      <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                          placeholder="Search for Products (e.g. " />

                      <!-- Typing Animation -->
                      <div class="typing-placeholder">
                          <span class="typingText"></span>
                          )
                      </div>

                  </form>

                  <div style=" min-height: 0; max-height: 300px;
                        overflow-y: auto;
                        overflow-x: hidden;
                        background: #fff;
                        border-radius: 4px;
                        position: absolute;
                        width: 100%;
                        z-index: 9999;"
                      class="searchResults"></div>
              </div>


              @if (Auth::guard('web')->check())
                  <a class="btn login-btn" href="{{ route('user-dashboard') }}"><i class="fa fa-user-circle"
                          aria-hidden="true"></i> @lang('Dashboard')</a>
              @else
                  <a href="{{ route('user.login') }}" class="btn login-btn"> <i class="fa fa-sign-in"
                          aria-hidden="true"></i> @lang('Login')</a>
              @endif
          </div>
          <!-- Desktop Logo, Menubar, Search  End-->

          <!-- mobile search will appear below automatically -->
          {{-- <div class="search-box d-lg-none container">
              <form action="{{ route('front.search') }}" method="GET">

                  <input autocomplete="off" type="text" name="search" class="searchInput"
                      placeholder="Search for products " />
              </form>
              <div style="max-height: 300px;
                        overflow-y: auto;
                        overflow-x: hidden;
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        position: absolute;
                        width: 89%;
                        z-index: 9999;"
                  class="searchResults"></div>
          </div> --}}
          <div class="search-box d-blcok d-lg-none  container position-relative">
              <form action="{{ route('front.search') }}" method="GET">

                  <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                      placeholder="Search for Products (e.g. " />

                  <!-- Typing Animation -->
                  <div class="typing-placeholder">
                      <span class="typingText"></span>
                      )
                  </div>

              </form>

              <div style="max-height: 300px;
                        overflow-y: auto;
                        overflow-x: hidden;
                        background: #fff;

                        border-radius: 4px;
                        position: absolute;
                        width: 89%;
                        z-index: 9999;"
                  class="searchResults"></div>
          </div>
      </div>

  </header>
