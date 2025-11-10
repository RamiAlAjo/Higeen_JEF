@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="contact"/>

<section class="contact-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Leaflet Map -->
    <div class="contact-map" id="leafletMap"></div>

    <!-- Floating Card -->
    <div class="container">
        <div class="contact-card shadow-lg">
            <div class="row g-4 align-items-start">

                <!-- Left: Contact Form -->
                <div class="col-md-8">
                    <h3 class="contact-title">{{ __('contact.title') }}</h3>
                    <p class="contact-sub">{{ __('contact.subtitle') }}</p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="contactForm" method="POST" action="{{ route('front.contact') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control contact-input @error('name') is-invalid @enderror"
                                       placeholder="{{ __('contact.placeholder_name') }}" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control contact-input @error('phone') is-invalid @enderror"
                                       placeholder="{{ __('contact.placeholder_number') }}" value="{{ old('phone') }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <input type="email" name="email" class="form-control contact-input @error('email') is-invalid @enderror"
                                       placeholder="{{ __('contact.placeholder_email') }}" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <textarea name="message" rows="4" class="form-control contact-input @error('message') is-invalid @enderror"
                                          placeholder="{{ __('contact.placeholder_message') }}" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="send-btn btn btn-primary">
                                    {{ __('contact.send_button') }} <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right: Enhanced Info Box with Long URLs -->
                <div class="col-md-4">
                    <div class="contact-info-box">
                        <h5>{{ __('contact.info_title') }}</h5>
                        <p>{{ __('contact.info_description') }}</p>

                        <ul class="list-unstyled mt-4">
                            <li class="mb-3 text-white">
                                <i class="bi bi-telephone-fill"></i>
                                <span class="ms-2">{{ implode(' | ', $settings->phone) }}</span>
                            </li>

                            <!-- Clickable Locations with Directions URL -->
                            <div id="locations-list" class="mt-4">
                                @foreach($settings->locations as $index => $loc)
                                    @if(!empty($loc['lat']) && !empty($loc['lng']))
                                        <div class="location-item mb-3 p-3 rounded border bg-white text-dark cursor-pointer shadow-sm"
                                             data-index="{{ $index }}"
                                             style="transition: all 0.3s ease; border-left: 5px solid #843c24;">
                                            <div class="d-flex align-items-start">
                                                <div class="me-3 flex-shrink-0">
                                                    <div class="location-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width: 32px; height: 32px; font-size: 15px; font-weight: bold;">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <strong class="d-block mb-1">{{ $loc['name'] }}</strong>
                                                    {{-- <small class="text-muted d-block mb-2">{{ $loc['address'] }}</small> --}}

                                                    <!-- Long Directions URL Button -->
                                                    @if(!empty($loc['directions_url']))
                                                        <a href="{{ $loc['directions_url'] }}" target="_blank" rel="noopener noreferrer"
                                                           class="btn btn-sm btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-2">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                            {{ __('contact.get_directions') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <li class="mt-3 text-white">
                                <i class="bi bi-clock-fill"></i>
                                <span class="ms-2">{{ __('contact.working_hours') }}</span>
                            </li>
                        </ul>

                        <div class="mt-4">
                            <button id="show-all-locations" class="btn btn-light btn-sm w-100 border">
                                <i class="bi bi-geo-alt-fill"></i> {{ __('contact.view_all_locations') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    .contact-wrapper { position: relative; width: 100%; margin: 0; padding: 0; }
    .contact-map {
        height: 500px; overflow: hidden; position: relative; z-index: 1;
        border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }
    .contact-card {
        background: #fff; border-radius: 24px; padding: 45px; max-width: 1160px;
        margin: -140px auto 80px; position: relative; z-index: 2;
        box-shadow: 0 15px 40px rgba(0,0,0,0.18); transition: transform .4s ease;
    }
    .contact-card:hover { transform: translateY(-8px); }

    .contact-title { font-weight: 800; font-size: 30px; color: #843c24; }
    .contact-sub   { font-size: 16px; color: #555; }

    .contact-input { border-radius: 12px; padding: 14px 18px; font-size: 15px; }
    .contact-input:focus { border-color: #843c24; box-shadow: 0 0 12px rgba(132,60,36,.25); }

    .send-btn {
        background: linear-gradient(135deg, #843c24, #a0522d);
        padding: 14px 32px; border-radius: 50px; font-weight: 700;
    }
    .send-btn:hover {
        background: linear-gradient(135deg, #6b2e1b, #843c24);
        transform: translateY(-3px);
    }

    .contact-info-box {
        background: linear-gradient(135deg, #a0522d, #843c24);
        color: #fff; border-radius: 18px; padding: 35px; height: 100%;
    }

    /* Enhanced Location Items */
    .location-item {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .location-item:hover {
        background: #fff9f5 !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(132, 60, 36, 0.15) !important;
        border-left-color: #a0522d;
    }
    .location-item.active {
        background: #843c24 !important;
        color: white !important;
        border-left-color: #fff;
    }
    .location-item.active strong,
    .location-item.active small,
    .location-item.active .btn-outline-primary {
        color: white !important;
    }
    .location-item.active .btn-outline-primary {
        background: rgba(255,255,255,0.2);
        border-color: white;
    }
    .location-item .btn-outline-primary:hover {
        background: #843c24;
        color: white !important;
        border-color: #843c24;
    }

    .location-number {
        font-weight: bold;
        background: #843c24;
    }

    @media (max-width: 991px) {
        .contact-card { margin-top: -90px; padding: 30px; }
        .contact-map { height: 400px; }
        .location-item .btn-outline-primary {
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rawLocations = @json($settings->locations);
    const locations = Array.isArray(rawLocations)
        ? rawLocations.filter(loc => loc.lat && loc.lng)
        : [];

    if (locations.length === 0) return;

    const map = L.map('leafletMap').setView([locations[0].lat, locations[0].lng], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    const createIcon = (number, isActive = false) => L.divIcon({
        html: `<div style="background:${isActive ? '#a0522d' : '#843c24'};color:white;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:17px;border:4px solid white;box-shadow:0 6px 20px rgba(0,0,0,0.3);">
                 ${number}
               </div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40],
        className: 'custom-marker'
    });

    const bounds = L.latLngBounds();
    const markers = [];
    const locationItems = document.querySelectorAll('.location-item');

    locations.forEach((loc, index) => {
        const marker = L.marker([loc.lat, loc.lng], {
            icon: createIcon(index + 1),
            riseOnHover: true
        }).addTo(map);

        // Enhanced Popup with Full Address Styling
        const popupContent = `
            <div style="font-family:system-ui,sans-serif; min-width:240px; max-width:300px;">
                <h6 style="margin:0 0 8px 0; color:#843c24; font-weight:800; font-size:17px;">
                    ${loc.name || 'Location'}
                </h6>

                ${loc.address ? `
                <div style="margin-bottom:12px; line-height:1.5;">
                    <div style="display:flex; align-items:flex-start; gap:8px;">
                        <i class="bi bi-geo-alt-fill" style="color:#843c24; font-size:14px; margin-top:2px;"></i>
                        <div>
                            <small style="color:#444; font-weight:500;">${loc.address}</small>
                        </div>
                    </div>
                </div>` : ''}

                ${loc.phone ? `
                <div style="margin-bottom:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-telephone-fill" style="color:#843c24; font-size:14px;"></i>
                        <small style="color:#555;">
                            <a href="tel:${loc.phone}" style="color:inherit; text-decoration:none;">${loc.phone}</a>
                        </small>
                    </div>
                </div>` : ''}

                ${loc.working_hours ? `
                <div style="margin-bottom:14px;">
                    <div style="display:flex; align-items:flex-start; gap:8px;">
                        <i class="bi bi-clock-fill" style="color:#843c24; font-size:14px; margin-top:2px;"></i>
                        <small style="color:#555; line-height:1.4;">${loc.working_hours}</small>
                    </div>
                </div>` : ''}

                <div style="margin-top:14px; padding-top:12px; border-top:1px solid #eee;">
                    ${loc.directions_url ? `
                    <a href="${loc.directions_url}" target="_blank" rel="noopener"
                       style="display:inline-flex; align-items:center; gap:6px; background:#843c24; color:white; padding:8px 14px; border-radius:50px; font-size:13px; font-weight:600; text-decoration:none; transition:all .3s;">
                        <i class="bi bi-compass"></i> Get Directions
                    </a>` : `
                    <a href="https://www.google.com/maps/search/?api=1&query=${loc.lat},${loc.lng}" target="_blank" rel="noopener"
                       style="display:inline-flex; align-items:center; gap:6px; background:#843c24; color:white; padding:8px 14px; border-radius:50px; font-size:13px; font-weight:600; text-decoration:none; transition:all .3s;">
                        <i class="bi bi-compass"></i> Open in Maps
                    </a>`}
                </div>
            </div>`;

        marker.bindPopup(popupContent, {
            maxWidth: 320,
            minWidth: 240,
            className: 'custom-popup'
        });

        markers.push(marker);
        bounds.extend([loc.lat, loc.lng]);

        // Click list item → focus map
        locationItems[index]?.addEventListener('click', () => {
            map.setView([loc.lat, loc.lng], 17, { animate: true });
            marker.openPopup();

            document.querySelectorAll('.location-item').forEach(el => el.classList.remove('active'));
            locationItems[index].classList.add('active');

            markers.forEach((m, i) => m.setIcon(createIcon(i + 1, i === index)));
        });

        // Hover effects
        locationItems[index]?.addEventListener('mouseenter', () => {
            if (!locationItems[index].classList.contains('active')) {
                marker.setIcon(createIcon(index + 1));
                marker.getElement().style.transform = 'scale(1.4)';
                marker.getElement().style.zIndexOffset = 1000;
            }
        });
        locationItems[index]?.addEventListener('mouseleave', () => {
            if (!locationItems[index].classList.contains('active')) {
                marker.setIcon(createIcon(index + 1));
                marker.getElement().style.transform = 'scale(1)';
                marker.getElement().style.zIndexOffset = 0;
            }
        });
    });

    // Show All Locations Button
    document.getElementById('show-all-locations')?.addEventListener('click', () => {
        map.fitBounds(bounds, { padding: [100, 100], maxZoom: 14 });
        document.querySelectorAll('.location-item').forEach(el => el.classList.remove('active'));
        markers.forEach((m, i) => m.setIcon(createIcon(i + 1)));
    });

    // Initial map view
    if (locations.length > 1) {
        map.fitBounds(bounds, { padding: [100, 100], maxZoom: 14 });
    } else {
        map.setZoom(16);
    }

    setTimeout(() => map.invalidateSize(), 600);
});
</script>

@endsection
