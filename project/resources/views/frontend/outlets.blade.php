@extends('layouts.front')

@section('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --teal: #1598a7;
            --teal-dark: #0d8a98;
            --teal-light: #e4f8fb;
            --teal-mid: #b2ecf3;
            --ink: #111b26;
            --slate: #475569;
            --fog: #f0f6f8;
            --line: #dde8ec;
            --white: #ffffff;
        }

        /* ── Breadcrumb ── */
        .outlet-top {
            background: var(--white);
            border-bottom: 1px solid var(--line);
            padding: 13px 0;
        }

        .custom-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .custom-breadcrumb a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 500;
        }

        .custom-breadcrumb a:hover {
            text-decoration: underline;
        }

        .custom-breadcrumb .separator {
            color: var(--slate);
            font-size: 10px;
        }

        .custom-breadcrumb .active {
            color: var(--slate);
        }

        /* ── Hero ── */
        .outlet-hero {
            background: var(--ink);
            padding: 31px 0 31px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .outlet-hero::before {
            content: '';
            position: absolute;
            top: -110px;
            right: -110px;
            width: 400px;
            height: 400px;
            border: 72px solid rgba(27, 185, 203, 0.07);
            border-radius: 50%;
        }

        .outlet-hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 280px;
            height: 280px;
            border: 58px solid rgba(27, 185, 203, 0.05);
            border-radius: 50%;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
        }

        .hero-eyebrow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 14px;
        }

        .hero-eyebrow::before,
        .hero-eyebrow::after {
            content: '';
            width: 26px;
            height: 1px;
            background: var(--teal);
            opacity: .5;
        }

        .outlet-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 700;
            color: var(--white);
            margin: 0 0 12px;
            line-height: 1.1;
        }

        .outlet-hero .hero-sub {
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.50);
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.65;
        }

        /* ── Stats bar ── */
        .stats-bar {
            background: var(--teal);
            padding: 18px 0;
        }

        .stats-bar .s-item {
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, 0.22);
            padding: 0 28px;
        }

        .stats-bar .s-item:last-child {
            border-right: none;
        }

        .stats-bar .s-num {

            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .stats-bar .s-lbl {
            font-family: 'Outfit', sans-serif;
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.72);
            margin-top: 3px;
        }

        /* ── Main section ── */
        .outlet-section {
            background: var(--fog);
            padding: 52px 0 76px;
            min-height: 60vh;
        }

        /* ── Search row ── */
        .search-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 34px;
            flex-wrap: wrap;
        }

        .total-label {
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            color: var(--slate);
        }

        .total-label strong {
            color: var(--ink);
        }

        .s-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }

        .s-box .s-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate);
            font-size: 14px;
            pointer-events: none;
        }

        .s-box input {
            width: 100%;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: 8px;
            padding: 10px 14px 10px 36px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .s-box input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(27, 185, 203, 0.11);
        }

        /* ── Cards ── */
        .outlet-card {
            background: var(--white);
            border-radius: 18px;
            border: 1.5px solid var(--line);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform .27s ease, box-shadow .27s ease, border-color .27s;
            animation: riseUp .45s ease both;
        }

        .outlet-col:nth-child(2) .outlet-card {
            animation-delay: .08s;
        }

        .outlet-col:nth-child(3) .outlet-card {
            animation-delay: .16s;
        }

        .outlet-col:nth-child(4) .outlet-card {
            animation-delay: .24s;
        }

        .outlet-col:nth-child(5) .outlet-card {
            animation-delay: .32s;
        }

        .outlet-col:nth-child(6) .outlet-card {
            animation-delay: .40s;
        }

        @keyframes riseUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .outlet-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 44px rgba(17, 27, 38, 0.10);
            border-color: var(--teal);
        }

        /* top gradient line */
        .card-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--teal-dark) 0%, var(--teal) 60%, var(--teal-mid) 100%);
        }

        .card-body-inner {
            padding: 22px 24px 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* outlet number badge */
        .outlet-num {
            display: inline-block;
            font-family: 'Outfit', sans-serif;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--teal-dark);
            background: var(--teal-light);
            border-radius: 4px;
            padding: 3px 10px;
            margin-bottom: 12px;
        }

        .outlet-name-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 18px;
            line-height: 1.25;
        }

        /* info rows */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-icon {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
            background: var(--teal-light);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon i {
            font-size: 12px;
            color: var(--teal-dark);
        }

        .info-text {
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            color: var(--slate);
            line-height: 1.55;
            padding-top: 4px;
        }

        /* days chips */
        .days-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            padding-top: 4px;
        }

        .day-chip {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--teal-dark);
            background: var(--teal-light);
            border: 1px solid var(--teal-mid);
            border-radius: 4px;
            padding: 2px 8px;
            letter-spacing: .3px;
        }

        /* card footer */
        .card-foot {
            padding: 14px 24px;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .open-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #1a7a52;
        }

        .open-dot {
            width: 7px;
            height: 7px;
            background: #2ecc71;
            border-radius: 50%;
            animation: blink 1.8s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(1.4);
            }
        }

        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--teal-dark);
            background: var(--teal-light);
            border: 1.5px solid var(--teal-mid);
            border-radius: 7px;
            padding: 7px 14px;
            text-decoration: none;
            transition: background .2s, color .2s, border-color .2s;
        }

        .map-btn:hover {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
            text-decoration: none;
        }

        .map-btn i {
            font-size: 13px;
        }

        /* ── Empty / No-results ── */
        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 86px;
            height: 86px;
            background: var(--teal-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
        }

        .empty-icon i {
            font-size: 34px;
            color: var(--teal);
        }

        .empty-state h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: var(--slate);
        }

        #no-results {
            display: none;
            text-align: center;
            padding: 40px 20px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: var(--slate);
        }

        /* ── Search Dropdown ── */
        .s-box {
            position: relative;
        }

        .s-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: 10px;
            overflow: hidden;
            z-index: 999;
            display: none;
            box-shadow: 0 8px 24px rgba(17, 27, 38, 0.10);
            max-height: 340px;
            overflow-y: auto;
        }

        .s-dropdown .s-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            cursor: pointer;
            border-bottom: 1px solid var(--line);
            transition: background .15s;
            text-align: left;
        }

        .s-dropdown .s-item:last-child {
            border-bottom: none;
        }

        .s-dropdown .s-item:hover {
            background: var(--teal-light);
        }

        .s-dropdown .s-item-icon {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background: var(--teal-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .s-dropdown .s-item-icon i {
            font-size: 15px;
            color: var(--teal-dark);
        }

        .s-dropdown .s-item-name {
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.3;
        }

        .s-dropdown .s-item-addr {
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            color: var(--slate);
            margin-top: 3px;
            line-height: 1.4;
        }

        .s-dropdown .s-footer {
            padding: 8px 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            color: var(--slate);
            background: var(--fog);
            border-top: 1px solid var(--line);
        }

        .s-dropdown .s-empty {
            padding: 22px 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            color: var(--slate);
            text-align: center;
        }

        mark.s-highlight {
            background: rgba(27, 185, 203, 0.18);
            color: var(--teal-dark);
            border-radius: 3px;
            padding: 0 2px;
            font-weight: 600;
        }

        .s-spinner {
            width: 15px;
            height: 15px;
            border: 2px solid var(--line);
            border-top-color: var(--teal);
            border-radius: 50%;
            animation: spin .7s linear infinite;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        @keyframes spin {
            to {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .outlet-hero {
                padding: 10px 0 10px !important;
            }

            .stats-bar {
                padding: 5px 0;
            }

            .outlet-top {
                padding: 5px 0;
            }

            .outlet-section {
                padding: 30px 0 76px;
            }

            .stats-bar .s-num {
                font-size: 1.4rem;
            }
        }
    </style>
@endsection

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="outlet-top">
        <div class="container">
            <nav class="custom-breadcrumb mb-2 mb-lg-0">
                <a href="{{ url('/') }}">Home</a>
                <span class="separator"><i class="fa fa-chevron-right"></i></span>
                <span class="active">Outlets</span>
            </nav>
        </div>
    </div>

    {{-- ── Hero ── --}}
    <section class="outlet-hero">
        <div class="container">
            <div class="hero-inner">

                <h1>Our Outlet Locations</h1>
                <p class="hero-sub">Fresh products and great service, right around the corner from you.</p>
            </div>
        </div>
    </section>

    {{-- ── Stats bar (only if outlets exist) ── --}}
    @if ($outlets->count() > 0)
        <div class="stats-bar">
            <div class="container">
                <div class="row justify-content-center g-3 g-lg-0">
                    <div class="col-auto s-item">
                        <div class="s-num">{{ $outlets->count() }}</div>
                        <div class="s-lbl">Outlets</div>
                    </div>
                    <div class="col-auto s-item">
                        <div class="s-num">7</div>
                        <div class="s-lbl">Days Open</div>
                    </div>
                    <div class="col-auto s-item">
                        <div class="s-num">10K+</div>
                        <div class="s-lbl"> Regular Customers</div>
                    </div>
                    <div class="col-auto s-item">
                        <div class="s-num">24/7</div>
                        <div class="s-lbl">Support</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Outlets Grid ── --}}
    <section class="outlet-section">
        <div class="container">

            @if ($outlets->count() > 0)
                {{-- Search row --}}
                <div class="search-row">
                    <p class="total-label">
                        Showing <strong>{{ $outlets->count() }}</strong> outlet{{ $outlets->count() > 1 ? 's' : '' }}
                    </p>
                    <div class="s-box">
                        <i class="fa fa-search s-icon"></i>
                        <input type="text" id="outletSearch" placeholder="Search by name or address..."
                            autocomplete="off" oninput="filterOutlets(this.value)">
                        <div class="s-spinner" id="sSpinner" style="display:none;"></div>
                        <div class="s-dropdown" id="sDropdown"></div>
                    </div>
                </div>

                {{-- Cards --}}
                <div class="row g-4" id="outletGrid">
                    @foreach ($outlets as $i => $outlet)
                        <div class="col-lg-4 col-md-6 col-12 outlet-col"
                            data-search="{{ strtolower($outlet->name . ' ' . $outlet->address) }}">
                            <div class="outlet-card">

                                {{-- Top colour stripe --}}
                                <div class="card-stripe"></div>

                                <div class="card-body-inner">

                                    {{-- Number badge --}}
                                    <span class="outlet-num">Outlet &bull;
                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>

                                    {{-- Name from DB --}}
                                    <h4 class="outlet-name-title">{{ $outlet->name }}</h4>

                                    <div class="info-list">

                                        {{-- Address from DB --}}
                                        <div class="info-row">
                                            <div class="info-icon"><i class="fa fa-store"></i></div>
                                            <span class="info-text">{!! $outlet->address !!}</span>
                                        </div>

                                        {{-- Open days — hardcoded 7 days --}}
                                        <div class="info-row">
                                            <div class="info-icon"><i class="fa fa-calendar"></i></div>
                                            <div class="days-chips">
                                                <span class="day-chip">Sat</span>
                                                <span class="day-chip">Sun</span>
                                                <span class="day-chip">Mon</span>
                                                <span class="day-chip">Tue</span>
                                                <span class="day-chip">Wed</span>
                                                <span class="day-chip">Thu</span>
                                                <span class="day-chip">Fri</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div class="card-foot">
                                    <span class="open-badge">
                                        <span class="open-dot"></span> Open 7 Days
                                    </span>
                                    @if (!empty($outlet->map_url))
                                        <a href="{{ $outlet->map_url }}" target="_blank" class="map-btn">
                                            <i class="fa fa-map"></i> Google Map
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <p id="no-results">No outlets match your search.</p>
            @else
                {{-- Empty state --}}
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa fa-store"></i></div>
                    <h4>No Outlets Available</h4>
                    <p>We're expanding soon — check back later!</p>
                </div>
            @endif

        </div>
    </section>

    @push('scripts')
        <script>
            const allOutlets = @json(
                $outlets->map(fn($o) => [
                        'name' => $o->name,
                        'address' => $o->address,
                    ]));

            function filterOutlets(val) {
                const q = val.trim().toLowerCase();
                const dropdown = document.getElementById('sDropdown');

                // input খালি → সব card দেখাও, dropdown বন্ধ
                if (q.length < 1) {
                    showCards('');
                    dropdown.style.display = 'none';
                    return;
                }

                // card filter
                showCards(q);

                // dropdown build
                const matches = allOutlets.filter(o =>
                    o.name.toLowerCase().includes(q) ||
                    o.address.toLowerCase().includes(q)
                );

                if (matches.length === 0) {
                    dropdown.innerHTML = `<div class="s-empty">কোনো আউটলেট পাওয়া যায়নি</div>`;
                } else {
                    dropdown.innerHTML = matches.map(o => `
            <div class="s-item" onclick="selectOutlet('${o.name.replace(/'/g, "\\'")}')">
                <div class="s-item-icon"><i class="fa fa-store"></i></div>
                <div>
                    <div class="s-item-name">${highlight(o.name, q)}</div>
                    <div class="s-item-addr">${highlight(o.address, q)}</div>
                </div>
            </div>
        `).join('') +
                        `<div class="s-footer"><i class="fa fa-store"></i> ${matches.length} টি আউটলেট পাওয়া গেছে</div>`;
                }

                dropdown.style.display = 'block';
            }

            function showCards(q) {
                const cols = document.querySelectorAll('#outletGrid .outlet-col');
                let visible = 0;
                cols.forEach(col => {
                    const match = q === '' || col.dataset.search.includes(q);
                    col.style.display = match ? '' : 'none';
                    if (match) visible++;
                });
                document.getElementById('no-results').style.display = visible === 0 ? 'block' : 'none';
            }

            function selectOutlet(name) {
                const input = document.getElementById('outletSearch');
                input.value = name;
                document.getElementById('sDropdown').style.display = 'none';
                showCards(name.toLowerCase()); // শুধু সেই outlet card দেখাবে
            }

            function highlight(text, q) {
                const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                return text.replace(re, '<mark class="s-highlight">$1</mark>');
            }

            // click outside → dropdown বন্ধ
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.s-box')) {
                    document.getElementById('sDropdown').style.display = 'none';
                }
            });
        </script>
    @endpush

@endsection
