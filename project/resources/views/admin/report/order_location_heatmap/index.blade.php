@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .olh-head h4 { margin-bottom: 2px; font-weight: 700; }
        .olh-head p { color: #868e96; margin-bottom: 0; }

        .olh-filters { background:#fff; border:1px solid #edf0f5; border-radius:12px; padding:16px 18px; }
        .olh-filters label { font-size:12px; font-weight:600; color:#495057; text-transform:uppercase; letter-spacing:.03em; }
        .olh-filters .form-control { border-radius:8px; }

        .olh-strip { display:flex; flex-wrap:wrap; gap:10px; }
        .olh-stat { flex:1 1 150px; background:#fff; border:1px solid #edf0f5; border-radius:12px; padding:12px 16px;
                    box-shadow:0 1px 2px rgba(16,24,40,.04); }
        .olh-stat .lbl { font-size:12px; color:#868e96; font-weight:600; text-transform:uppercase; letter-spacing:.03em; }
        .olh-stat .val { font-size:22px; font-weight:700; color:#1f2937; margin-top:4px; line-height:1.1; }
        .olh-stat.s-gps .val { color:#2171b5; } .olh-stat.s-deny .val { color:#f03e3e; }
        .olh-stat.s-none .val { color:#868e96; } .olh-stat.s-out .val { font-size:16px; }

        .olh-panel { background:#fff; border:1px solid #edf0f5; border-radius:14px; padding:18px 20px;
                     box-shadow:0 1px 2px rgba(16,24,40,.04); }
        .olh-panel h6 { font-weight:700; color:#1f2937; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
        .olh-panel h6 .count { margin-left:auto; font-size:12px; color:#868e96; font-weight:600; }

        .olh-table { width:100%; border-collapse:collapse; }
        .olh-table th { font-size:11.5px; text-transform:uppercase; letter-spacing:.03em; color:#868e96;
                        text-align:left; padding:8px 10px; border-bottom:2px solid #f1f3f9; }
        .olh-table th.num, .olh-table td.num { text-align:right; }
        .olh-table td { padding:11px 10px; border-bottom:1px solid #f4f6fa; font-size:14px; color:#343a40; vertical-align:middle; }
        .olh-table tr:last-child td { border-bottom:none; }
        .olh-table .rank { color:#adb5bd; font-weight:700; width:34px; }
        .olh-table .nm { font-weight:600; }
        .olh-table .o { font-weight:700; }
        .olh-share { display:flex; align-items:center; gap:8px; min-width:120px; }
        .olh-track { flex:1; height:8px; background:#f1f3f9; border-radius:6px; overflow:hidden; }
        .olh-fill { height:100%; border-radius:6px; background:linear-gradient(90deg,#6baed6,#08519c); }
        .olh-share .pct { font-size:12px; color:#868e96; width:38px; text-align:right; }
        .olh-empty { color:#adb5bd; font-size:13px; padding:18px 0; text-align:center; }

        #order_heatmap { height:520px; width:100%; border-radius:12px; z-index:1; }
        .olh-maphint { font-size:12px; color:#adb5bd; margin-top:8px; }
        #geo_status { font-size:12px; color:#adb5bd; }
        /* Percentage label centered on each bubble */
        .olh-bubble-lbl { background:transparent !important; border:none !important; box-shadow:none !important;
                          color:#08306b; font-weight:700; font-size:12px; padding:0; }
        .olh-bubble-lbl::before { display:none !important; }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="olh-head mb-3">
            <h4>{{ __('Order Location Analytics') }}</h4>
            <p>{{ __('Where your orders come from — GPS heatmap, division, thana and outlet.') }}</p>
        </div>

        <!-- Filters -->
        <div class="olh-filters mb-3">
            <div class="row align-items-end">
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('From Date') }}</label>
                    <input type="date" id="from_date" class="form-control">
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('To Date') }}</label>
                    <input type="date" id="to_date" class="form-control">
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('Channel') }}</label>
                    <select id="source" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        <option value="Website">{{ __('Website') }}</option>
                        <option value="Mobile Apps">{{ __('Mobile Apps') }}</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('Outlet') }}</label>
                    <select id="branch_id" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('Status') }}</label>
                    <select id="status" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('Division') }} <small class="text-muted">(GPS)</small></label>
                    <select id="f_division" class="form-control"><option value="all">{{ __('All') }}</option></select>
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2">
                    <label>{{ __('Thana') }} <small class="text-muted">(GPS)</small></label>
                    <select id="f_thana" class="form-control"><option value="all">{{ __('All') }}</option></select>
                </div>
                <div class="col-md-3 col-lg-2 form-group mb-2 d-flex align-items-end">
                    <button id="apply_filter" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                </div>
            </div>
            <div id="geo_status">{{ __('Loading map boundaries…') }}</div>
        </div>

        <!-- Stat strip -->
        <div class="olh-strip mb-3">
            <div class="olh-stat"><div class="lbl">{{ __('Orders') }}</div><div class="val" id="stat_total">0</div></div>
            <div class="olh-stat s-gps"><div class="lbl">{{ __('With GPS') }}</div>
                <div class="val"><span id="stat_gps">0</span> <small style="font-size:13px;">(<span id="stat_gps_pct">0</span>%)</small></div></div>
            <div class="olh-stat s-deny"><div class="lbl">{{ __('Denied') }}</div><div class="val" id="stat_denied">0</div></div>
            <div class="olh-stat s-none"><div class="lbl">{{ __('No location') }}</div><div class="val" id="stat_other">0</div></div>
            <div class="olh-stat s-out"><div class="lbl">{{ __('Top Outlet') }}</div><div class="val" id="stat_top_outlet">—</div></div>
        </div>

        <!-- Map -->
        <div class="olh-panel mb-3">
            <h6><i class="fas fa-map-marker-alt" style="color:#2171b5;"></i> {{ __('GPS Order Map') }}
                <span class="count" id="map_count">{{ __('bubble size = orders · label = % share') }}</span></h6>
            <div id="order_heatmap"></div>
            <div class="olh-maphint">{{ __('Each dot = one order where the buyer allowed location. Division/Thana are derived from these GPS points.') }}</div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="olh-panel">
                    <h6><i class="fas fa-map text-primary"></i> {{ __('Orders by Division') }}
                        <span class="count" id="cnt_div"></span></h6>
                    <div style="overflow-x:auto;"><table class="olh-table">
                        <thead><tr><th class="rank">#</th><th>{{ __('Division') }}</th><th class="num">{{ __('Orders') }}</th><th>{{ __('Share') }}</th></tr></thead>
                        <tbody id="tbl_div"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="olh-panel">
                    <h6><i class="fas fa-map-marker-alt text-primary"></i> {{ __('Orders by Thana') }}
                        <span class="count" id="cnt_thana"></span></h6>
                    <div style="overflow-x:auto;"><table class="olh-table">
                        <thead><tr><th class="rank">#</th><th>{{ __('Thana') }}</th><th class="num">{{ __('Orders') }}</th><th>{{ __('Share') }}</th></tr></thead>
                        <tbody id="tbl_thana"></tbody>
                    </table></div>
                </div>
            </div>
            <div class="col-lg-12 mb-3">
                <div class="olh-panel">
                    <h6><i class="fas fa-store text-primary"></i> {{ __('Orders by Outlet') }}
                        <span class="count" id="cnt_outlets"></span></h6>
                    <div style="overflow-x:auto;"><table class="olh-table">
                        <thead><tr><th class="rank">#</th><th>{{ __('Outlet') }}</th><th class="num">{{ __('Orders') }}</th><th class="num">{{ __('Revenue') }}</th><th>{{ __('Share') }}</th></tr></thead>
                        <tbody id="tbl_outlets"></tbody>
                    </table></div>
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
        var BD_BOUNDS = [[20.59, 88.01], [26.64, 92.68]];
        var map = L.map('order_heatmap', { scrollWheelZoom: false });
        map.fitBounds(BD_BOUNDS);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        var heatLayer = null, markerLayer = L.layerGroup().addTo(map);
        var pointsUrl = "{{ route('admin.order.location.heatmap.points') }}";
        var divFeatures = [], thaFeatures = [];
        var locatedPoints = [], serverStats = {}, outletRows = [];

        function fmt(n) { return Number(n || 0).toLocaleString('en-IN'); }

        // --- inline point-in-polygon (ray casting), no external lib ---
        function pointInRing(x, y, ring) {
            var inside = false;
            for (var i = 0, j = ring.length - 1; i < ring.length; j = i++) {
                var xi = ring[i][0], yi = ring[i][1], xj = ring[j][0], yj = ring[j][1];
                if (((yi > y) !== (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi)) inside = !inside;
            }
            return inside;
        }
        function inGeom(x, y, geom) {
            var polys = geom.type === 'Polygon' ? [geom.coordinates] : geom.coordinates;
            for (var p = 0; p < polys.length; p++) {
                var rings = polys[p];
                if (pointInRing(x, y, rings[0])) {
                    var hole = false;
                    for (var h = 1; h < rings.length; h++) { if (pointInRing(x, y, rings[h])) { hole = true; break; } }
                    if (!hole) return true;
                }
            }
            return false;
        }
        function locate(lat, lng, feats) {
            for (var f = 0; f < feats.length; f++) {
                if (inGeom(lng, lat, feats[f].geometry)) return feats[f].properties.shapeName;
            }
            return null;
        }

        function renderTable(tbodyId, cntId, rows, withRevenue) {
            var el = document.getElementById(tbodyId);
            document.getElementById(cntId).textContent = rows.length ? (rows.length + ' {{ __('areas') }}') : '';
            var cols = withRevenue ? 5 : 4;
            if (!rows.length) { el.innerHTML = '<tr><td colspan="' + cols + '" class="olh-empty">{{ __('No data') }}</td></tr>'; return; }
            var max = Math.max.apply(null, rows.map(function (r) { return r.orders; })) || 1;
            var html = '';
            rows.forEach(function (r, i) {
                var pct = Math.round(r.orders / max * 100);
                html += '<tr><td class="rank">' + (i + 1) + '</td><td class="nm">' + (r.name || '—') + '</td>'
                    + '<td class="num o">' + fmt(r.orders) + '</td>'
                    + (withRevenue ? '<td class="num">৳' + fmt(r.revenue) + '</td>' : '')
                    + '<td><div class="olh-share"><div class="olh-track"><div class="olh-fill" style="width:' + pct + '%"></div></div>'
                    + '<span class="pct">' + pct + '%</span></div></td></tr>';
            });
            el.innerHTML = html;
        }

        function groupCount(items, key) {
            var m = {};
            items.forEach(function (it) { var k = it[key] || '{{ __('Unknown') }}'; m[k] = (m[k] || 0) + 1; });
            return Object.keys(m).map(function (k) { return { name: k, orders: m[k] }; })
                .sort(function (a, b) { return b.orders - a.orders; });
        }

        // Re-render map + division/thana tables for the current client filters.
        function render() {
            var selDiv = $('#f_division').val(), selThana = $('#f_thana').val();
            var pts = locatedPoints.filter(function (p) {
                return (selDiv === 'all' || p.division === selDiv) && (selThana === 'all' || p.thana === selThana);
            });

            // Proportional blue circles: one per area (thana, or coarse coord if
            // unknown), radius scaled by order count, label = % of shown orders.
            markerLayer.clearLayers();
            var groups = {};
            pts.forEach(function (p) {
                var key = p.thana || (p.lat.toFixed(2) + ',' + p.lng.toFixed(2));
                if (!groups[key]) { groups[key] = { name: p.thana || '{{ __('Unknown area') }}', lat: 0, lng: 0, n: 0 }; }
                groups[key].lat += p.lat; groups[key].lng += p.lng; groups[key].n++;
            });
            var total = pts.length || 1;
            Object.keys(groups).forEach(function (k) {
                var g = groups[k], clat = g.lat / g.n, clng = g.lng / g.n;
                var pct = Math.round(g.n / total * 100);
                var radius = Math.min(46, 10 + Math.sqrt(g.n) * 8);
                var c = L.circleMarker([clat, clng], {
                    radius: radius, color: '#08519c', weight: 2, fillColor: '#4292c6', fillOpacity: 0.45
                });
                c.bindTooltip(pct + '%', { permanent: true, direction: 'center', className: 'olh-bubble-lbl' });
                c.bindPopup('<b>' + g.name + '</b><br>' + fmt(g.n) + ' {{ __('orders') }} (' + pct + '%)');
                c.addTo(markerLayer);
            });
            document.getElementById('map_count').textContent = fmt(pts.length) + ' {{ __('GPS orders shown') }}';

            renderTable('tbl_div', 'cnt_div', groupCount(pts, 'division'), false);
            renderTable('tbl_thana', 'cnt_thana', groupCount(pts, 'thana'), false);
        }

        function rebuildThanaOptions() {
            var thanas = {};
            locatedPoints.forEach(function (p) { if (p.thana) thanas[p.thana] = 1; });
            var keep = $('#f_thana').val();
            var html = '<option value="all">{{ __('All') }}</option>';
            Object.keys(thanas).sort().forEach(function (t) { html += '<option value="' + t + '">' + t + '</option>'; });
            $('#f_thana').html(html).val(keep);
            if ($('#f_thana').val() === null) $('#f_thana').val('all');
        }

        function loadHeatmap() {
            $('#apply_filter').prop('disabled', true).text('{{ __('Loading...') }}');
            $.get(pointsUrl, {
                from_date: $('#from_date').val(), to_date: $('#to_date').val(),
                source: $('#source').val(), branch_id: $('#branch_id').val(), status: $('#status').val()
            }, function (res) {
                serverStats = res.stats; outletRows = res.breakdowns.outlets;
                $('#stat_total').text(fmt(res.stats.total));
                $('#stat_gps').text(fmt(res.stats.gps));
                $('#stat_gps_pct').text(res.stats.gps_percent);
                $('#stat_denied').text(fmt(res.stats.denied));
                $('#stat_other').text(fmt(res.stats.other));
                $('#stat_top_outlet').text(res.stats.top_outlet || '—');
                renderTable('tbl_outlets', 'cnt_outlets', outletRows, true);

                // Reverse-geocode each GPS point to division + thana.
                locatedPoints = res.points.map(function (p) {
                    return { lat: p[0], lng: p[1],
                        division: locate(p[0], p[1], divFeatures),
                        thana: locate(p[0], p[1], thaFeatures) };
                });
                rebuildThanaOptions();
                render();
            }).fail(function () {
                alert('{{ __('Could not load analytics data.') }}');
            }).always(function () {
                $('#apply_filter').prop('disabled', false).text('{{ __('Apply') }}');
            });
        }

        // Load boundaries first, then data.
        $(document).ready(function () {
            $.when(
                $.getJSON('{{ asset('assets/geo/bd_divisions.geojson') }}'),
                $.getJSON('{{ asset('assets/geo/bd_thanas.geojson') }}')
            ).done(function (d1, d3) {
                divFeatures = d1[0].features || [];
                thaFeatures = d3[0].features || [];
                // Populate division dropdown (sorted names).
                var names = divFeatures.map(function (f) { return f.properties.shapeName; }).sort();
                var html = '<option value="all">{{ __('All') }}</option>';
                names.forEach(function (n) { html += '<option value="' + n + '">' + n + '</option>'; });
                $('#f_division').html(html);
                $('#geo_status').text('{{ __('Boundaries loaded — division & thana from GPS.') }}');
            }).fail(function () {
                $('#geo_status').text('{{ __('Could not load map boundaries; division/thana disabled.') }}');
            }).always(function () {
                loadHeatmap();
            });

            $('#apply_filter').on('click', loadHeatmap);
            $('#f_division, #f_thana').on('change', render);
        });
    </script>
@endsection
