@extends('backend.app', ['title' => 'Add Location'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Add Location</h1>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.locations.store') }}" method="POST">
                                @csrf

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Map -->
                                <div class="mb-3">
                                    <label class="form-label">Select Location on Map</label>
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                </div>

                                <!-- Latitude -->
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                        value="{{ old('latitude') }}">
                                    @error('latitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Longitude -->
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                        value="{{ old('longitude') }}">
                                    @error('longitude')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Is Open -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="is_open" class="form-check-input" id="is_open"
                                        value="1" {{ old('is_open') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_open">Is Open</label>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Location</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Leaflet JS & CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Leaflet Control Geocoder (for search box) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    // Default center (Bangladesh)
    var map = L.map('map').setView([23.8103, 90.4125], 7);

    // OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;

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
            marker = L.marker(latlng).addTo(map);
        }

        map.setView(latlng, 12);

        document.getElementById('latitude').value = latlng.lat.toFixed(7);
        document.getElementById('longitude').value = latlng.lng.toFixed(7);
    })
    .addTo(map);

    // On map click
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });

    // If old latitude & longitude exist, show marker
    @if(old('latitude') && old('longitude'))
        var oldLatLng = L.latLng({{ old('latitude') }}, {{ old('longitude') }});
        marker = L.marker(oldLatLng).addTo(map);
        map.setView(oldLatLng, 12);
    @endif
</script>
@endsection
