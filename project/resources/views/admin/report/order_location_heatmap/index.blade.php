@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .olh-wrap { --olh-accent: #4c6ef5; }
        .olh-head h4 { margin-bottom: 2px; font-weight: 700; }
        .olh-head p { color: #868e96; margin-bottom: 0; }

        /* Filter bar */
        .olh-filters { background:#fff; border:1px solid #edf0f5; border-radius:12px; padding:16px 18px; }
        .olh-filters label { font-size:12px; font-weight:600; color:#495057; text-transform:uppercase; letter-spacing:.03em; }
        .olh-filters .form-control { border-radius:8px; }

        /* Stat cards */
        .olh-cards { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
        @media (max-width: 991px){ .olh-cards{ grid-template-columns:repeat(2,1fr);} }
        .olh-card { background:#fff; border:1px solid #edf0f5; border-radius:14px; padding:18px 20px;
                    box-shadow:0 1px 2px rgba(16,24,40,.04); position:relative; overflow:hidden; }
        .olh-card .lbl { font-size:12px; color:#868e96; font-weight:600; text-transform:uppercase; letter-spacing:.03em; }
        .olh-card .val { font-size:26px; font-weight:700; color:#1f2937; margin-top:6px; line-height:1.1; }
        .olh-card .sub { font-size:12px; color:#adb5bd; margin-top:4px; }
        .olh-card .ic { position:absolute; right:14px; top:14px; width:38px; height:38px; border-radius:10px;
                        display:flex; align-items:center; justify-content:center; font-size:18px; color:#fff; }
        .olh-card.c1 .ic{ background:#4c6ef5;} .olh-card.c2 .ic{ background:#37b24d;}
        .olh-card.c3 .ic{ background:#f59f00;} .olh-card.c4 .ic{ background:#e8590c;}

        /* Panels */
        .olh-panel { background:#fff; border:1px solid #edf0f5; border-radius:14px; padding:18px 20px;
                     box-shadow:0 1px 2px rgba(16,24,40,.04); height:100%; }
        .olh-panel h6 { font-weight:700; color:#1f2937; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
        .olh-panel h6 .count { margin-left:auto; font-size:12px; color:#868e96; font-weight:600; }

        /* Bar table */
        .olh-bartable { width:100%; }
        .olh-row { display:flex; align-items:center; gap:10px; padding:9px 0; border-bottom:1px solid #f4f6fa; }
        .olh-row:last-child{ border-bottom:none; }
        .olh-rank { width:20px; font-size:12px; color:#adb5bd; font-weight:700; flex:none; text-align:center; }
        .olh-name { flex:1 1 auto; min-width:0; }
        .olh-name .nm { font-weight:600; color:#343a40; font-size:13.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .olh-track { height:7px; background:#f1f3f9; border-radius:6px; margin-top:5px; overflow:hidden; }
        .olh-fill { height:100%; border-radius:6px; background:linear-gradient(90deg,#748ffc,#4c6ef5); }
        .olh-vals { flex:none; text-align:right; min-width:104px; }
        .olh-vals .o { font-weight:700; color:#1f2937; font-size:14px; }
        .olh-vals .r { font-size:11.5px; color:#868e96; }
        .olh-empty { color:#adb5bd; font-size:13px; padding:18px 0; text-align:center; }

        #order_heatmap { height:520px; width:100%; border-radius:12px; z-index:1; }
        .olh-maphint { font-size:12px; color:#adb5bd; margin-top:8px; }
    </style>
@endsection

@section('content')
    <div class="olh-wrap container-fluid py-2">
        <div class="olh-head d-flex flex-wrap align-items-center mb-3">
            <div>
                <h4>{{ __('Order Location Analytics') }}</h4>
                <p>{{ __('Where your orders come from — by GPS, outlet, city and division.') }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="olh-filters mb-3">
            <div class="row align-items-end">
                <div class="col-md-3 form-group mb-md-0">
                    <label>{{ __('From Date') }}</label>
                    <input type="date" id="from_date" class="form-control">
                </div>
                <div class="col-md-3 form-group mb-md-0">
                    <label>{{ __('To Date') }}</label>
                    <input type="date" id="to_date" class="form-control">
                </div>
                <div class="col-md-3 form-group mb-md-0">
                    <label>{{ __('Channel') }}</label>
                    <select id="source" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        <option value="Website">{{ __('Website') }}</option>
                        <option value="Mobile Apps">{{ __('Mobile Apps') }}</option>
                    </select>
                </div>
                <div class="col-md-3 form-group mb-0">
                    <button id="apply_filter" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                </div>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="olh-cards mb-3">
            <div class="olh-card c1"><div class="ic"><i class="fas fa-shopping-bag"></i></div>
                <div class="lbl">{{ __('Total Orders') }}</div>
                <div class="val" id="stat_total">0</div>
                <div class="sub">{{ __('in selected range') }}</div></div>
            <div class="olh-card c2"><div class="ic"><i class="fas fa-map-marker-alt"></i></div>
                <div class="lbl">{{ __('With GPS') }}</div>
                <div class="val" id="stat_gps">0</div>
                <div class="sub"><span id="stat_gps_pct">0</span>% {{ __('of orders · denied') }} <span id="stat_denied">0</span></div></div>
            <div class="olh-card c3"><div class="ic"><i class="fas fa-store"></i></div>
                <div class="lbl">{{ __('Top Outlet') }}</div>
                <div class="val" id="stat_top_outlet" style="font-size:18px;">—</div>
                <div class="sub">{{ __('most orders') }}</div></div>
            <div class="olh-card c4"><div class="ic"><i class="fas fa-receipt"></i></div>
                <div class="lbl">{{ __('Orders via Outlet') }}</div>
                <div class="val" id="stat_outlet_orders">0</div>
                <div class="sub">{{ __('tagged to an outlet') }}</div></div>
        </div>

        <!-- Map -->
        <div class="olh-panel mb-3">
            <h6><i class="fas fa-fire text-danger"></i> {{ __('GPS Heatmap') }}
                <span class="count">{{ __('precise buyer location at checkout') }}</span></h6>
            <div id="order_heatmap"></div>
            <div class="olh-maphint">{{ __('Each dot = one order where the buyer allowed location. Red clusters = hotspots. Coverage grows as new orders come in.') }}</div>
        </div>

        <!-- Breakdown: orders by outlet (the reliable location signal) -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="olh-panel">
                    <h6><i class="fas fa-store text-primary"></i> {{ __('Orders by Outlet') }}
                        <span class="count" id="cnt_outlets"></span></h6>
                    <div class="olh-bartable" id="tbl_outlets"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script type="text/javascript">
        var map = L.map('order_heatmap', { scrollWheelZoom: false }).setView([23.6850, 90.3563], 7);
        // Clean light basemap so the heat/markers pop.
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        var heatLayer = null;
        var markerLayer = L.layerGroup().addTo(map);
        var pointsUrl = "{{ route('admin.order.location.heatmap.points') }}";

        function fmt(n) { return Number(n || 0).toLocaleString('en-IN'); }

        function renderTable(elId, cntId, rows) {
            var el = document.getElementById(elId);
            document.getElementById(cntId).textContent = rows.length ? (rows.length + ' {{ __('areas') }}') : '';
            if (!rows.length) { el.innerHTML = '<div class="olh-empty">{{ __('No data in this range') }}</div>'; return; }
            var max = Math.max.apply(null, rows.map(function (r) { return r.orders; })) || 1;
            var html = '';
            rows.forEach(function (r, i) {
                var pct = Math.round(r.orders / max * 100);
                html += '<div class="olh-row">'
                    + '<div class="olh-rank">' + (i + 1) + '</div>'
                    + '<div class="olh-name"><div class="nm">' + (r.name || '—') + '</div>'
                    + '<div class="olh-track"><div class="olh-fill" style="width:' + pct + '%"></div></div></div>'
                    + '<div class="olh-vals"><div class="o">' + fmt(r.orders) + '</div>'
                    + '<div class="r">৳' + fmt(r.revenue) + '</div></div>'
                    + '</div>';
            });
            el.innerHTML = html;
        }

        function loadHeatmap() {
            $('#apply_filter').prop('disabled', true).text('{{ __('Loading...') }}');
            $.get(pointsUrl, {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                source: $('#source').val()
            }, function (res) {
                // Stat cards
                $('#stat_total').text(fmt(res.stats.total));
                $('#stat_gps').text(fmt(res.stats.gps));
                $('#stat_gps_pct').text(res.stats.gps_percent);
                $('#stat_denied').text(fmt(res.stats.denied));
                $('#stat_top_outlet').text(res.stats.top_outlet || '—');
                $('#stat_outlet_orders').text(fmt(res.stats.outlet_orders));

                // Heat layer
                if (heatLayer) { map.removeLayer(heatLayer); }
                heatLayer = L.heatLayer(res.points, {
                    radius: 28, blur: 18, minOpacity: 0.45, maxZoom: 5,
                    gradient: { 0.2: '#4263eb', 0.4: '#22b8cf', 0.6: '#94d82d', 0.8: '#ff922b', 1.0: '#f03e3e' }
                }).addTo(map);

                // Visible dot per order + auto-zoom
                markerLayer.clearLayers();
                var latlngs = [];
                res.points.forEach(function (p) {
                    var ll = [p[0], p[1]];
                    latlngs.push(ll);
                    L.circleMarker(ll, { radius: 6, color: '#c92a2a', weight: 1, fillColor: '#f03e3e', fillOpacity: .75 })
                        .addTo(markerLayer);
                });
                if (latlngs.length === 1) { map.setView(latlngs[0], 13); }
                else if (latlngs.length > 1) { map.fitBounds(latlngs, { padding: [40, 40], maxZoom: 14 }); }

                // Breakdown table
                renderTable('tbl_outlets', 'cnt_outlets', res.breakdowns.outlets);
            }).fail(function () {
                alert('{{ __('Could not load analytics data.') }}');
            }).always(function () {
                $('#apply_filter').prop('disabled', false).text('{{ __('Apply') }}');
            });
        }

        $('#apply_filter').on('click', loadHeatmap);
        $(document).ready(loadHeatmap);
    </script>
@endsection
