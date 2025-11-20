@extends('backend.app', ['title' => 'Edit Location'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Edit Location</h1>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $location->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $location->address) }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="map" style="height: 400px; width: 100%; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 0.375rem;"></div>
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                        value="{{ old('latitude', $location->latitude) }}">
                                    @error('latitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                        value="{{ old('longitude', $location->longitude) }}">
                                    @error('longitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="hidden" name="is_open" value="0">
                                    <input type="checkbox" name="is_open" class="form-check-input" id="is_open"
                                        value="1" {{ old('is_open', $location->is_open) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_open">Is Open</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Location</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Leaflet Control Geocoder (for search box) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    var map;
    var marker;

    function initMap() {
        // Default center (Bangladesh) or use location if available
        @if($location->latitude && $location->longitude)
            var center = [{{ $location->latitude }}, {{ $location->longitude }}];
            var zoom = 12;
        @else
            var center = [23.8103, 90.4125];
            var zoom = 7;
        @endif

        map = L.map('map').setView(center, zoom);

        // OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Initialize marker if location exists
        @if($location->latitude && $location->longitude)
            marker = L.marker(center, { draggable: true }).addTo(map);
        @endif

        // Add search control
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            var latlng = e.geocode.center;

            // Move marker and update inputs
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng, { draggable: true }).addTo(map);
            }

            map.setView(latlng, 12);

            document.getElementById('latitude').value = latlng.lat.toFixed(6);
            document.getElementById('longitude').value = latlng.lng.toFixed(6);
            document.getElementById('address').value = e.geocode.name;
        })
        .addTo(map);

        // On map click
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng, { draggable: true }).addTo(map);
            }
        });

        // Update form fields on marker drag end
        if (marker) {
            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                document.getElementById('latitude').value = pos.lat.toFixed(6);
                document.getElementById('longitude').value = pos.lng.toFixed(6);
            });
        }

        // Handle old values from validation
        @if(old('latitude') && old('longitude'))
            var oldLatLng = L.latLng({{ old('latitude') }}, {{ old('longitude') }});
            if (marker) {
                marker.setLatLng(oldLatLng);
            } else {
                marker = L.marker(oldLatLng, { draggable: true }).addTo(map);
            }
            map.setView(oldLatLng, 12);
            document.getElementById('latitude').value = {{ old('latitude') }};
            document.getElementById('longitude').value = {{ old('longitude') }};
        @endif
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>
@endsection
