@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #order_heatmap {
            height: 600px;
            width: 100%;
            border-radius: 8px;
            z-index: 1;
        }
        .heat-stat {
            display: inline-block;
            margin-right: 18px;
            font-size: 14px;
        }
        .heat-stat strong {
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Order Location Heatmap') }}</h4>
                    <p class="text-muted mb-0">
                        {{ __("Buyer's real device location captured at checkout. Darker/red zones = more orders.") }}
                    </p>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row align-items-end mb-3">
                        <div class="col-md-3 form-group">
                            <label>{{ __('From Date') }}</label>
                            <input type="date" id="from_date" class="form-control">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>{{ __('To Date') }}</label>
                            <input type="date" id="to_date" class="form-control">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>{{ __('Channel') }}</label>
                            <select id="source" class="form-control">
                                <option value="all">{{ __('All') }}</option>
                                <option value="Website">{{ __('Website') }}</option>
                                <option value="Mobile Apps">{{ __('Mobile Apps') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <button id="apply_filter" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                        </div>
                    </div>

                    <!-- Data-quality summary -->
                    <div class="mb-3" id="heat_stats">
                        <span class="heat-stat">{{ __('Orders') }}: <strong id="stat_total">0</strong></span>
                        <span class="heat-stat text-success">{{ __('With GPS') }}: <strong id="stat_gps">0</strong>
                            (<span id="stat_gps_pct">0</span>%)</span>
                        <span class="heat-stat text-danger">{{ __('Denied') }}: <strong id="stat_denied">0</strong></span>
                        <span class="heat-stat text-muted">{{ __('No location') }}: <strong id="stat_other">0</strong></span>
                    </div>

                    <div id="order_heatmap"></div>
                    <p class="text-muted mt-2 mb-0"><small>
                        {{ __('Only orders where the buyer allowed location appear as points. "With GPS %" shows how representative this map is.') }}
                    </small></p>
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
        // Centre on Bangladesh.
        var map = L.map('order_heatmap').setView([23.6850, 90.3563], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var heatLayer = null;
        var pointsUrl = "{{ route('admin.order.location.heatmap.points') }}";

        function loadHeatmap() {
            $('#apply_filter').prop('disabled', true).text('{{ __('Loading...') }}');
            $.get(pointsUrl, {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                source: $('#source').val()
            }, function (res) {
                // Refresh stats
                $('#stat_total').text(res.stats.total);
                $('#stat_gps').text(res.stats.gps);
                $('#stat_gps_pct').text(res.stats.gps_percent);
                $('#stat_denied').text(res.stats.denied);
                $('#stat_other').text(res.stats.other);

                // Refresh heat layer
                if (heatLayer) {
                    map.removeLayer(heatLayer);
                }
                heatLayer = L.heatLayer(res.points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 12
                }).addTo(map);
            }).fail(function () {
                alert('{{ __('Could not load heatmap data.') }}');
            }).always(function () {
                $('#apply_filter').prop('disabled', false).text('{{ __('Apply') }}');
            });
        }

        $('#apply_filter').on('click', loadHeatmap);
        $(document).ready(loadHeatmap);
    </script>
@endsection
