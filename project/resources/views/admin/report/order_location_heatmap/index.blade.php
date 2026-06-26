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

        /* Stat strip */
        .olh-strip { display:flex; flex-wrap:wrap; gap:10px; }
        .olh-stat { flex:1 1 150px; background:#fff; border:1px solid #edf0f5; border-radius:12px; padding:12px 16px;
                    box-shadow:0 1px 2px rgba(16,24,40,.04); }
        .olh-stat .lbl { font-size:12px; color:#868e96; font-weight:600; text-transform:uppercase; letter-spacing:.03em; }
        .olh-stat .val { font-size:22px; font-weight:700; color:#1f2937; margin-top:4px; line-height:1.1; }
        .olh-stat.s-gps .val { color:#37b24d; } .olh-stat.s-deny .val { color:#f03e3e; }
        .olh-stat.s-none .val { color:#868e96; } .olh-stat.s-out .val { font-size:16px; }

        .olh-panel { background:#fff; border:1px solid #edf0f5; border-radius:14px; padding:18px 20px;
                     box-shadow:0 1px 2px rgba(16,24,40,.04); }
        .olh-panel h6 { font-weight:700; color:#1f2937; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
        .olh-panel h6 .count { margin-left:auto; font-size:12px; color:#868e96; font-weight:600; }

        /* Outlet table */
        .olh-table { width:100%; border-collapse:collapse; }
        .olh-table th { font-size:11.5px; text-transform:uppercase; letter-spacing:.03em; color:#868e96;
                        text-align:left; padding:8px 10px; border-bottom:2px solid #f1f3f9; }
        .olh-table th.num, .olh-table td.num { text-align:right; }
        .olh-table td { padding:11px 10px; border-bottom:1px solid #f4f6fa; font-size:14px; color:#343a40; vertical-align:middle; }
        .olh-table tr:last-child td { border-bottom:none; }
        .olh-table .rank { color:#adb5bd; font-weight:700; width:34px; }
        .olh-table .nm { font-weight:600; }
        .olh-table .o { font-weight:700; }
        .olh-share { display:flex; align-items:center; gap:8px; min-width:140px; }
        .olh-track { flex:1; height:8px; background:#f1f3f9; border-radius:6px; overflow:hidden; }
        .olh-fill { height:100%; border-radius:6px; background:linear-gradient(90deg,#fd8d3c,#e31a1c); }
        .olh-share .pct { font-size:12px; color:#868e96; width:38px; text-align:right; }
        .olh-empty { color:#adb5bd; font-size:13px; padding:18px 0; text-align:center; }

        #order_heatmap { height:520px; width:100%; border-radius:12px; z-index:1; }
        .olh-maphint { font-size:12px; color:#adb5bd; margin-top:8px; }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="olh-head mb-3">
            <h4>{{ __('Order Location Analytics') }}</h4>
            <p>{{ __('Where your orders come from — by GPS and outlet.') }}</p>
        </div>

        <!-- Filters -->
        <div class="olh-filters mb-3">
            <div class="row align-items-end">
                <div class="col-md-2 form-group mb-2 mb-md-0">
                    <label>{{ __('From Date') }}</label>
                    <input type="date" id="from_date" class="form-control">
                </div>
                <div class="col-md-2 form-group mb-2 mb-md-0">
                    <label>{{ __('To Date') }}</label>
                    <input type="date" id="to_date" class="form-control">
                </div>
                <div class="col-md-2 form-group mb-2 mb-md-0">
                    <label>{{ __('Channel') }}</label>
                    <select id="source" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        <option value="Website">{{ __('Website') }}</option>
                        <option value="Mobile Apps">{{ __('Mobile Apps') }}</option>
                    </select>
                </div>
                <div class="col-md-2 form-group mb-2 mb-md-0">
                    <label>{{ __('Outlet') }}</label>
                    <select id="branch_id" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-group mb-2 mb-md-0">
                    <label>{{ __('Status') }}</label>
                    <select id="status" class="form-control">
                        <option value="all">{{ __('All') }}</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-group mb-0">
                    <button id="apply_filter" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                </div>
            </div>
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
            <h6><i class="fas fa-fire text-danger"></i> {{ __('GPS Heatmap') }}
                <span class="count">{{ __('precise buyer location at checkout') }}</span></h6>
            <div id="order_heatmap"></div>
            <div class="olh-maphint">{{ __('Each dot = one order where the buyer allowed location. Coverage grows as new orders come in.') }}</div>
        </div>

        <!-- Orders by outlet table -->
        <div class="olh-panel mb-3">
            <h6><i class="fas fa-store text-primary"></i> {{ __('Orders by Outlet') }}
                <span class="count" id="cnt_outlets"></span></h6>
            <div style="overflow-x:auto;">
                <table class="olh-table">
                    <thead>
                        <tr>
                            <th class="rank">#</th>
                            <th>{{ __('Outlet') }}</th>
                            <th class="num">{{ __('Orders') }}</th>
                            <th class="num">{{ __('Revenue') }}</th>
                            <th>{{ __('Share') }}</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_outlets"></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script type="text/javascript">
        // Default view = full Bangladesh (SW + NE corners).
        var BD_BOUNDS = [[20.59, 88.01], [26.64, 92.68]];
        var map = L.map('order_heatmap', { scrollWheelZoom: false });
        map.fitBounds(BD_BOUNDS);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        var heatLayer = null;
        var markerLayer = L.layerGroup().addTo(map);
        var pointsUrl = "{{ route('admin.order.location.heatmap.points') }}";

        function fmt(n) { return Number(n || 0).toLocaleString('en-IN'); }

        function renderOutlets(rows) {
            var el = document.getElementById('tbl_outlets');
            document.getElementById('cnt_outlets').textContent = rows.length ? (rows.length + ' {{ __('outlets') }}') : '';
            if (!rows.length) { el.innerHTML = '<tr><td colspan="5" class="olh-empty">{{ __('No data in this range') }}</td></tr>'; return; }
            var max = Math.max.apply(null, rows.map(function (r) { return r.orders; })) || 1;
            var html = '';
            rows.forEach(function (r, i) {
                var pct = Math.round(r.orders / max * 100);
                html += '<tr>'
                    + '<td class="rank">' + (i + 1) + '</td>'
                    + '<td class="nm">' + (r.name || '—') + '</td>'
                    + '<td class="num o">' + fmt(r.orders) + '</td>'
                    + '<td class="num">৳' + fmt(r.revenue) + '</td>'
                    + '<td><div class="olh-share"><div class="olh-track"><div class="olh-fill" style="width:' + pct + '%"></div></div>'
                    + '<span class="pct">' + pct + '%</span></div></td>'
                    + '</tr>';
            });
            el.innerHTML = html;
        }

        function loadHeatmap() {
            $('#apply_filter').prop('disabled', true).text('{{ __('Loading...') }}');
            $.get(pointsUrl, {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                source: $('#source').val(),
                branch_id: $('#branch_id').val(),
                status: $('#status').val()
            }, function (res) {
                $('#stat_total').text(fmt(res.stats.total));
                $('#stat_gps').text(fmt(res.stats.gps));
                $('#stat_gps_pct').text(res.stats.gps_percent);
                $('#stat_denied').text(fmt(res.stats.denied));
                $('#stat_other').text(fmt(res.stats.other));
                $('#stat_top_outlet').text(res.stats.top_outlet || '—');

                if (heatLayer) { map.removeLayer(heatLayer); }
                heatLayer = L.heatLayer(res.points, {
                    radius: 28, blur: 18, minOpacity: 0.5, maxZoom: 5,
                    // Bluish gradient: light blue (sparse) -> deep blue (hotspot)
                    gradient: { 0.2: '#c6dbef', 0.4: '#9ecae1', 0.6: '#6baed6', 0.75: '#4292c6', 0.9: '#2171b5', 1.0: '#08306b' }
                }).addTo(map);

                // Blue dot per order. Map stays on full Bangladesh (no auto-zoom).
                markerLayer.clearLayers();
                res.points.forEach(function (p) {
                    L.circleMarker([p[0], p[1]], { radius: 6, color: '#08519c', weight: 1, fillColor: '#4292c6', fillOpacity: .8 })
                        .addTo(markerLayer);
                });

                renderOutlets(res.breakdowns.outlets);
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
