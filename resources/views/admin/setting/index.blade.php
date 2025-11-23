{{-- resources/views/admin/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
<style>
    :root {
        --primary: #9e6de0;
        --primary-dark: #7b52b3;
        --brown: #8B3A2B;
        --text: #1a1a1a;
        --light: #f8f9fa;
        --border: #dee2e6;
    }

    .settings-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        background: #fff;
        max-width: 1200px;
        margin: 2rem auto;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 2rem;
        font-size: 1.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .accordion-button {
        font-weight: 600;
        background: #f8f9fa;
        border-radius: 14px !important;
        padding: 1.3rem 1.6rem;
        font-size: 1.1rem;
    }
    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 10px 30px rgba(158,109,224,0.35);
    }

    /* Perfect Social Icons — Always Visible */
    .social-input {
        position: relative;
        margin-bottom: 1.4rem;
    }
    .social-icon {
        position: absolute;
        left: 0; top: 0;
        width: 56px; height: 56px;
        border-radius: 14px 0 0 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        z-index: 10;
    }
    .social-icon.facebook   { background: #1877f2; }
    .social-icon.instagram  { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .social-icon.twitter    { background: #000000; }
    .social-icon.youtube    { background: #ff0000; }
    .social-icon.linkedin   { background: #0a66c2; }
    .social-icon.pinterest  { background: #e60023; }
    .social-icon.tiktok     { background: #000000; }

    .social-input input {
        padding-left: 74px !important;
        height: 56px;
        border-radius: 14px;
        border: 1.5px solid var(--border);
    }
    .social-input input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(158,109,224,0.25);
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: 50px;
        padding: 1rem 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
    }
    .btn-save:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(158,109,224,0.45); }

    .loading-overlay {
        display: none;
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.98);
        z-index: 9999;
        border-radius: 20px;
        backdrop-filter: blur(8px);
    }
    .loading-overlay.show { display: flex !important; }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card settings-card">
                <div class="card-header">
                    <i class="bi bi-gear-wide-connected"></i>
                    Website Settings
                </div>

                <div class="card-body position-relative p-4">
                    <div class="loading-overlay justify-content-center align-items-center" id="loading">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;">
                            <span class="visually-hidden">Saving...</span>
                        </div>
                    </div>

                    @if(session('status-success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
                            <ul class="mb-0 ps-4">
                                @foreach($errors->all() as $error)<li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>@endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.setting.store') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                        @csrf

                        <div class="accordion" id="settingsAccordion">

                            <!-- 1. Social Media Links -->
                            <div class="accordion-item border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#socialCollapse">
                                        <i class="bi bi-share-fill me-3"></i> Social Media Links
                                    </button>
                                </h2>
                                <div id="socialCollapse" class="accordion-collapse collapse show" data-bs-parent="#settingsAccordion">
                                    <div class="accordion-body pt-4">
                                        <div class="row g-4">
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon facebook"><i class="bi bi-facebook"></i></div><input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ old('facebook', $settings->facebook ?? '') }}"></div></div>
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon instagram"><i class="bi bi-instagram"></i></div><input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/yourprofile" value="{{ old('instagram', $settings->instagram ?? '') }}"></div></div>
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon twitter"><i class="bi bi-twitter-x"></i></div><input type="url" name="twitter" class="form-control" placeholder="https://twitter.com/yourhandle" value="{{ old('twitter', $settings->twitter ?? '') }}"></div></div>
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon youtube"><i class="bi bi-youtube"></i></div><input type="url" name="youtube" class="form-control" placeholder="https://youtube.com/yourchannel" value="{{ old('youtube', $settings->youtube ?? '') }}"></div></div>
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon linkedin"><i class="bi bi-linkedin"></i></div><input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/company" value="{{ old('linkedin', $settings->linkedin ?? '') }}"></div></div>
                                            <div class="col-md-6"><div class="social-input"><div class="social-icon tiktok"><i class="bi bi-tiktok"></i></div><input type="url" name="tiktok" class="form-control" placeholder="https://tiktok.com/@yourprofile" value="{{ old('tiktok', $settings->tiktok ?? '') }}"></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Website Metadata -->
                            <div class="accordion-item border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#metaCollapse">
                                        <i class="bi bi-file-earmark-text-fill me-3"></i> Website Metadata (SEO)
                                    </button>
                                </h2>
                                <div id="metaCollapse" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-4">
                                            <div class="col-12"><label class="form-label fw-semibold">Website Title</label><input type="text" name="title" class="form-control" value="{{ old('title', $settings->title ?? '') }}"></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Description</label><textarea name="website_description" class="form-control" rows="4">{{ old('website_description', $settings->website_description ?? '') }}</textarea></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Keywords (comma separated)</label><input type="text" name="key_words" class="form-control" value="{{ old('key_words', $settings->key_words ?? '') }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Contact Information + Phones + Locations -->
                            <div class="accordion-item border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#contactCollapse">
                                        <i class="bi bi-telephone-fill me-3"></i> Contact Information
                                    </button>
                                </h2>
                                <div id="contactCollapse" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                                    <div class="accordion-body">

                                        <!-- Phones -->
                                        <div class="mb-5">
                                            <label class="form-label fw-semibold d-block">Phone Numbers</label>
                                            <div class="mb-3"><input type="tel" name="phone[]" class="form-control" placeholder="Main phone" value="{{ old('phone.0', $phones[0] ?? '') }}"></div>
                                            <div id="additional-phones">
                                                @foreach($phones as $i => $phone)
                                                    @if($i > 0)
                                                        <div class="input-group mb-3 phone-item">
                                                            <input type="tel" name="phone[]" class="form-control" value="{{ old("phone.$i", $phone) }}">
                                                            <button type="button" class="btn btn-outline-danger remove-phone">Remove</button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="add-phone"><i class="bi bi-plus-circle"></i> Add Phone</button>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $settings->email ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Fax</label><input type="tel" name="fax" class="form-control" value="{{ old('fax', $settings->fax ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Contact Form Email</label><input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings->contact_email ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Careers Email</label><input type="email" name="carrers_email" class="form-control" value="{{ old('carrers_email', $settings->carrers_email ?? '') }}"></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Address (for SEO)</label><input type="text" name="address" class="form-control" value="{{ old('address', $settings->address ?? '') }}"></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Site URL</label><input type="url" name="url" class="form-control" value="{{ old('url', $settings->url ?? '') }}"></div>
                                        </div>

                                        <hr class="my-5">
                                        <h5 class="mb-4">Branches / Locations</h5>
                                        <div id="locations-container">
                                            @foreach($settings->locations ?? [] as $index => $loc)
                                            <div class="card mb-3 location-item">
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4"><label>Name</label><input type="text" name="locations[{{ $index }}][name]" class="form-control" value="{{ old("locations.$index.name", $loc['name'] ?? '') }}" required></div>
                                                        <div class="col-md-5"><label>Address</label><input type="text" name="locations[{{ $index }}][address]" class="form-control" value="{{ old("locations.$index.address", $loc['address'] ?? '') }}"></div>
                                                        <div class="col-md-2"><label>Lat</label><input type="text" name="locations[{{ $index }}][lat]" class="form-control" value="{{ old("locations.$index.lat", $loc['lat'] ?? '') }}" placeholder="31.9787532"></div>
                                                        <div class="col-md-2"><label>Lng</label><input type="text" name="locations[{{ $index }}][lng]" class="form-control" value="{{ old("locations.$index.lng", $loc['lng'] ?? '') }}" placeholder="35.9004003"></div>
                                                        <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm remove-location w-100">Remove</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-location"><i class="bi bi-plus-circle"></i> Add Location</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Logo Upload -->
                            <div class="accordion-item border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#logoCollapse">
                                        <i class="bi bi-image-fill me-3"></i> Logo
                                    </button>
                                </h2>
                                <div id="logoCollapse" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                                    <div class="accordion-body text-center">
                                        <div class="border-3 border-dashed border-primary rounded-4 p-5 mb-4" id="dropzone" style="cursor:pointer;">
                                            <i class="bi bi-cloud-upload display-1 text-primary"></i>
                                            <p class="mt-3 fw-semibold">Drop your logo here or click to upload</p>
                                            <input type="file" name="logo" id="logoInput" accept="image/*" hidden>
                                        </div>
                                        <div id="logo-preview">
                                            @if($settings->logo ?? false)
                                                <img src="{{ asset($settings->logo) }}" alt="Current Logo" class="img-thumbnail rounded-4" style="max-height: 160px;">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox" name="remove_logo" id="remove_logo">
                                                    <label class="form-check-label" for="remove_logo">Remove current logo</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-end p-4 bg-light border-top mt-4 rounded-bottom">
                            <button type="submit" class="btn btn-save px-5 shadow-lg">
                                <i class="bi bi-check2-all me-2"></i> Save All Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('settingsForm');
    const loading = document.getElementById('loading');
    form.addEventListener('submit', () => loading.classList.add('show'));

    // Add/Remove Phones
    document.getElementById('add-phone')?.addEventListener('click', () => {
        document.getElementById('additional-phones').insertAdjacentHTML('beforeend', `
            <div class="input-group mb-3 phone-item">
                <input type="tel" name="phone[]" class="form-control" placeholder="Additional phone">
                <button type="button" class="btn btn-outline-danger remove-phone">Remove</button>
            </div>`);
    });

    // Add Location
    document.getElementById('add-location')?.addEventListener('click', () => {
        const index = document.querySelectorAll('.location-item').length;
        document.getElementById('locations-container').insertAdjacentHTML('beforeend', `
            <div class="card mb-3 location-item">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label>Name</label><input type="text" name="locations[${index}][name]" class="form-control" required></div>
                        <div class="col-md-5"><label>Address</label><input type="text" name="locations[${index}][address]" class="form-control"></div>
                        <div class="col-md-2"><label>Lat</label><input type="text" name="locations[${index}][lat]" class="form-control" placeholder="31.9787532"></div>
                        <div class="col-md-2"><label>Lng</label><input type="text" name="locations[${index}][lng]" class="form-control" placeholder="35.9004003"></div>
                        <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm remove-location w-100">Remove</button></div>
                    </div>
                </div>
            </div>`);
    });

    // Remove any item
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-phone') || e.target.classList.contains('remove-location')) {
            e.target.closest('.phone-item, .location-item').remove();
        }
    });

    // Logo Dropzone & Preview
    const dropzone = document.getElementById('dropzone');
    const logoInput = document.getElementById('logoInput');
    const preview = document.getElementById('logo-preview');

    dropzone.addEventListener('click', () => logoInput.click());
    ['dragover', 'dragenter'].forEach(evt => dropzone.addEventListener(evt, e => { e.preventDefault(); dropzone.style.background = '#f0e8ff'; }));
    ['dragleave', 'dragend'].forEach(evt => dropzone.addEventListener(evt, () => dropzone.style.background = ''));
    dropzone.addEventListener('drop', e => {
        e.preventDefault(); dropzone.style.background = '';
        if (e.dataTransfer.files[0]) { logoInput.files = e.dataTransfer.files; previewFile(e.dataTransfer.files[0]); }
    });
    logoInput.addEventListener('change', e => e.target.files[0] && previewFile(e.target.files[0]));

    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail rounded-4" style="max-height:160px;">`;
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
