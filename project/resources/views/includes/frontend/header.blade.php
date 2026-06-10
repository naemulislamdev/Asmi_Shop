 <header class="header ">
        <div class="container-fluid">
            <!-- Desktop Logo, Menubar, Search Start -->
            <div class="d-flex align-items-center justify-content-between px-1 px-lg-3 container-fluid">
                <div class="d-flex align-items-center gap-3 logo_Bar">
                    <div id="menu-btn" class="menu-icon active">
                        <i id="barIcon" class="fa-solid fa-bars-staggered"></i>
                    </div>
                    <a href="{{ route('front.index') }}">
                        <img src="{{ asset('assets/images/' . $gs->logo) }}" class="logo" alt="Asmishop" />
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
                

                <div class="search-box d-none d-lg-block  position-relative">
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
                <a title="Dashboard" class="ms-5 ms-lg-0" href="{{ route('user-dashboard') }}">
                    <i class="fas fa-user-circle " style="font-size: 1.5rem;"></i> 
                </a>
            @else
                <a title="Login" href="{{ route('user.login') }}" class="ms-5 ms-lg-0">
                <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i> 
                </a>
            @endif
                <div class="ms-0 ms-lg-3 conditonalNotification">
                  <div class="dropdown position-static ms-0 ml-md-3 position-relative">
                      @php
                          $offers = session('offers', []);
                      @endphp
                      <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button"
                          data-bs-toggle="dropdown">
                          <img style="height: 30px; width: auto;"
                              src="{{ asset('assets/front/images/notification.gif') }}" alt="Notification Bell">

                          <span style="top: 0; left: 35px"
                              class="position-absolute translate-middle badge rounded-pill bg-primary">
                              {{ count($offers) }}
                          </span>
                      </button>

                      <ul class="dropdown-menu dropdown-menu-end shadow pt-0" style="margin-left: -98px !important;">
                           @if (count($offers) > 0)
                              <div class="offer-header rounded-top">
                                  <span>🎁 Special Offer Unlocked</span>
                              </div>
                          @endif
                          @forelse($offers as $offer)
                              <li class="mb-3 d-inline-block">
                                  <a class="dropdown-item"
                                      href="{{ route('front.conditional-product', $offer['sku']) }}">
                                      <img style="width: 40px;" src="{{ $offer['image'] }}" alt="{{$offer['name']}}">
                                      <span>{{ $offer['name'] }}</span>
                                  </a>
                              </li>
                          @empty
                              <li class="text-center p-2">No Offers found in your cart!</li>
                          @endforelse

                      </ul>
                  </div>
              </div>
            </div>
            <!-- Desktop Logo, Menubar, Search  End-->

            <div class="search-box d-blcok d-lg-none   position-relative">
              <form action="{{ route('front.search') }}" method="GET">

                  <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                      placeholder="Search for Products (e.g. " />

                  <!-- Typing Animation -->
                  <div class="typing-placeholder">
                      <span class="typingText"></span>
                      )
                  </div>

              </form>

              <div style="min-height: 0; max-height: 300px;
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