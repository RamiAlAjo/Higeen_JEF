@extends('admin.layouts.app')

@section('content')

<style>
    /* Enhanced Design */
    :root {
        --primary-color: #9e6de0;
        --primary-dark: #7b52b3;
        --text-color: #1a1a1a;
        --background-light: #f8f9fa;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--background-light);
    }

    .settings-card {
        border-radius: 16px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        background: linear-gradient(145deg, #ffffff, #f9fafb);
        margin-bottom: 2rem;
        position: relative;
    }

    .settings-card .card-header {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section {
        margin-bottom: 2.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .accordion-button {
        font-weight: 600;
        color: var(--text-color);
        background-color: #f1f3f5;
        border-radius: 10px !important;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: white;
    }

    .accordion-button::after {
        font-family: 'Font Awesome 6 Free';
        content: '\f078';
        font-weight: 900;
    }

    .accordion-button:not(.collapsed)::after {
        content: '\f077';
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-color);
    }

    .form-control, .form-control-file {
        border-radius: 10px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 8px rgba(158, 109, 224, 0.3);
    }

    .form-control.is-valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: 1rem;
    }

    .btn-pill {
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-pill:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .input-group-text {
        background-color: #e9ecef;
        border-radius: 10px 0 0 10px;
        color: var(--text-color);
    }

    .logo-preview img {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 8px;
        background-color: #fff;
        max-width: 200px;
        transition: opacity 0.3s ease;
    }

    .logo-dropzone {
        border: 2px dashed #ced4da;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .logo-dropzone:hover, .logo-dropzone.dragover {
        border-color: var(--primary-color);
        background-color: rgba(158, 109, 224, 0.1);
    }

    .form-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: flex-end;
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 16px 16px;
    }

    .loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        align-items: center;
        justify-content: center;
        z-index: 1000;
        border-radius: 16px;
    }

    .loading-overlay .spinner-border {
        width: 4rem;
        height: 4rem;
        border-width: 0.4em;
        color: var(--primary-color);
    }

    .alert {
        border-radius: 10px;
        margin-bottom: 1.5rem;
        animation: fadeIn 0.5s ease;
    }

    .icon-fallback {
        display: none;
        font-size: 0.9rem;
        color: #6c757d;
    }

    :root:not([data-fontawesome-loaded]) .icon-fallback {
        display: inline-block !important;
    }

    :root:not([data-fontawesome-loaded]) .fa, :root:not([data-fontawesome-loaded]) .fas, :root:not([data-fontawesome-loaded]) .fab {
        display: none !important;
    }

    /* Progress Indicator */
    .progress-container {
        margin-bottom: 1.5rem;
    }

    .progress-bar {
        background-color: var(--primary-color);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
            gap: 1rem;
        }
        .btn-pill {
            width: 100%;
        }
        .logo-preview img {
            max-width: 100%;
        }
        .form-section {
            padding: 1rem;
        }
    }

    /* Accessibility */
    .form-control:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    .accordion-button:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Custom Tooltip */
    .custom-tooltip .tooltip-inner {
        background-color: var(--primary-dark);
        color: white;
        border-radius: 8px;
        padding: 0.75rem 1rem;
    }

    .custom-tooltip .tooltip-arrow::before {
        border-bottom-color: var(--primary-dark);
    }
</style>

<div class="row">
    <div class="col-xl-10 col-lg-12 mx-auto">
        <div class="card settings-card mb-5">
            <div class="card-header">
                <i class="fas fa-cog me-2" aria-hidden="true"></i>
                <span class="icon-fallback">Settings</span>
                <h4 class="mb-0">Website Settings</h4>
            </div>
            <div class="card-body position-relative">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loading-overlay">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Progress Indicator -->
                {{-- <div class="progress-container">
                    <div class="progress" role="progressbar" aria-label="Form completion progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%" id="progress-bar"></div>
                    </div>
                    <small class="text-muted">Form Completion: <span id="progress-text">0%</span></small>
                </div> --}}

                <!-- Success Message -->
                @if(session('status-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" aria-labelledby="success-alert">
                        <strong id="success-alert">Success:</strong> {{ session('status-success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('status-error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" aria-labelledby="error-alert">
                        <strong id="error-alert">Error:</strong> {{ session('status-error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" aria-labelledby="validation-alert">
                        <strong id="validation-alert">Validation Errors:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.setting.store') }}" method="POST" enctype="multipart/form-data" id="settings-form" aria-describedby="form-description">
                    @csrf
                    <p id="form-description" class="visually-hidden">Form to update website settings including social media links, metadata, contact information, and logo.</p>

                    <!-- Social Media Links Section -->
                    <div class="form-section accordion" id="settingsAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="socialMediaHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#socialMediaCollapse" aria-expanded="true" aria-controls="socialMediaCollapse">
                                    <i class="fas fa-share-alt me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Social</span> Social Media Links
                                </button>
                            </h2>
                            <div id="socialMediaCollapse" class="accordion-collapse collapse show" aria-labelledby="socialMediaHeading" data-bs-parent="#settingsAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="facebook" data-bs-toggle="tooltip" title="Enter the full URL to your Facebook page">Facebook Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-facebook-f" aria-hidden="true"></i><span class="icon-fallback">FB</span></span>
                                                <input type="url" class="form-control @error('facebook') is-invalid @enderror" name="facebook" id="facebook" placeholder="https://facebook.com/yourpage" value="{{ old('facebook', $settings->facebook ?? '') }}" aria-describedby="facebook-error">
                                                @error('facebook')
                                                    <div class="invalid-feedback" id="facebook-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="instagram" data-bs-toggle="tooltip" title="Enter the full URL to your Instagram profile">Instagram Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-instagram" aria-hidden="true"></i><span class="icon-fallback">IG</span></span>
                                                <input type="url" class="form-control @error('instagram') is-invalid @enderror" name="instagram" id="instagram" placeholder="https://instagram.com/yourprofile" value="{{ old('instagram', $settings->instagram ?? '') }}" aria-describedby="instagram-error">
                                                @error('instagram')
                                                    <div class="invalid-feedback" id="instagram-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="twitter" data-bs-toggle="tooltip" title="Enter the full URL to your Twitter profile">Twitter Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-twitter" aria-hidden="true"></i><span class="icon-fallback">TW</span></span>
                                                <input type="url" class="form-control @error('twitter') is-invalid @enderror" name="twitter" id="twitter" placeholder="https://twitter.com/yourprofile" value="{{ old('twitter', $settings->twitter ?? '') }}" aria-describedby="twitter-error">
                                                @error('twitter')
                                                    <div class="invalid-feedback" id="twitter-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="youtube" data-bs-toggle="tooltip" title="Enter the full URL to your YouTube channel">YouTube Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-youtube" aria-hidden="true"></i><span class="icon-fallback">YT</span></span>
                                                <input type="url" class="form-control @error('youtube') is-invalid @enderror" name="youtube" id="youtube" placeholder="https://youtube.com/yourchannel" value="{{ old('youtube', $settings->youtube ?? '') }}" aria-describedby="youtube-error">
                                                @error('youtube')
                                                    <div class="invalid-feedback" id="youtube-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="linkedin" data-bs-toggle="tooltip" title="Enter the full URL to your LinkedIn page">LinkedIn Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-linkedin-in" aria-hidden="true"></i><span class="icon-fallback">LI</span></span>
                                                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" id="linkedin" placeholder="https://linkedin.com/yourpage" value="{{ old('linkedin', $settings->linkedin ?? '') }}" aria-describedby="linkedin-error">
                                                @error('linkedin')
                                                    <div class="invalid-feedback" id="linkedin-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="pinterest" data-bs-toggle="tooltip" title="Enter the full URL to your Pinterest profile">Pinterest Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-pinterest-p" aria-hidden="true"></i><span class="icon-fallback">PT</span></span>
                                                <input type="url" class="form-control @error('pinterest') is-invalid @enderror" name="pinterest" id="pinterest" placeholder="https://pinterest.com/yourprofile" value="{{ old('pinterest', $settings->pinterest ?? '') }}" aria-describedby="pinterest-error">
                                                @error('pinterest')
                                                    <div class="invalid-feedback" id="pinterest-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="tiktok" data-bs-toggle="tooltip" title="Enter the full URL to your TikTok profile">TikTok Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-tiktok" aria-hidden="true"></i><span class="icon-fallback">TT</span></span>
                                                <input type="url" class="form-control @error('tiktok') is-invalid @enderror" name="tiktok" id="tiktok" placeholder="https://tiktok.com/yourprofile" value="{{ old('tiktok', $settings->tiktok ?? '') }}" aria-describedby="tiktok-error">
                                                @error('tiktok')
                                                    <div class="invalid-feedback" id="tiktok-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Website Metadata Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="metadataHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#metadataCollapse" aria-expanded="false" aria-controls="metadataCollapse">
                                    <i class="fas fa-info-circle me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Metadata</span> Website Metadata
                                </button>
                            </h2>
                            <div id="metadataCollapse" class="accordion-collapse collapse" aria-labelledby="metadataHeading" data-bs-parent="#settingsAccordion">
                                <div class="accordion-body">
                                    <div class="form-group mb-3">
                                        <label for="title" data-bs-toggle="tooltip" title="The title displayed in the browser tab and search results">Website Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="My Website" value="{{ old('title', $settings->title ?? '') }}" aria-describedby="title-error">
                                        @error('title')
                                            <div class="invalid-feedback" id="title-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="website_description" data-bs-toggle="tooltip" title="A brief description of your website for SEO">Website Description</label>
                                        <textarea class="form-control @error('website_description') is-invalid @enderror" name="website_description" id="website_description" rows="4" placeholder="Describe your website..." aria-describedby="website_description-error">{{ old('website_description', $settings->website_description ?? '') }}</textarea>
                                        @error('website_description')
                                            <div class="invalid-feedback" id="website_description-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="key_words" data-bs-toggle="tooltip" title="Comma-separated keywords for SEO">Keywords</label>
                                        <input type="text" class="form-control @error('key_words') is-invalid @enderror" name="key_words" id="key_words" placeholder="keyword1, keyword2, keyword3" value="{{ old('key_words', $settings->key_words ?? '') }}" aria-describedby="key_words-error">
                                        @error('key_words')
                                            <div class="invalid-feedback" id="key_words-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="contactHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactCollapse" aria-expanded="false" aria-controls="contactCollapse">
                                    <i class="fas fa-address-book me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Contact</span> Contact Information
                                </button>
                            </h2>
                            <div id="contactCollapse" class="accordion-collapse collapse" aria-labelledby="contactHeading" data-bs-parent="#settingsAccordion">
                                <div class="accordion-body">
                                    <div class="form-group mb-3">
                                        <label for="phone1" data-bs-toggle="tooltip" title="Primary phone number for contact">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone.0') is-invalid @enderror" name="phone[]" id="phone1" placeholder="123-456-7890" value="{{ old('phone.0', $phones[0] ?? '') }}" aria-describedby="phone1-error">
                                        @error('phone.0')
                                            <div class="invalid-feedback" id="phone1-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="additional-phones">
                                        @foreach($phones as $index => $phone)
                                            @if ($index > 0)
                                                <div class="form-group mb-3" id="phone{{ $index + 1 }}-container">
                                                    <label for="phone{{ $index + 1 }}">Phone {{ $index + 1 }}</label>
                                                    <div class="input-group">
                                                        <input type="tel" class="form-control @error('phone.' . $index) is-invalid @enderror" name="phone[]" id="phone{{ $index + 1 }}" placeholder="Phone Number" value="{{ old('phone.' . $index, $phone) }}" aria-describedby="phone{{ $index + 1 }}-error">
                                                        <button type="button" class="btn btn-danger" onclick="removePhoneField({{ $index + 1 }})" aria-label="Remove phone number"><i class="fas fa-trash" aria-hidden="true"></i><span class="icon-fallback">Remove</span></button>
                                                        @error('phone.' . $index)
                                                            <div class="invalid-feedback" id="phone{{ $index + 1 }}-error">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-phone-btn" aria-label="Add another phone number"><i class="fas fa-plus me-1" aria-hidden="true"></i><span class="icon-fallback">Add</span> Add Another Phone Number</button>
                                    <div class="form-group mb-3">
                                        <label for="fax" data-bs-toggle="tooltip" title="Fax number for business communication">Fax</label>
                                        <input type="tel" class="form-control @error('fax') is-invalid @enderror" name="fax" id="fax" placeholder="123-456-7890" value="{{ old('fax', $settings->fax ?? '') }}" aria-describedby="fax-error">
                                        @error('fax')
                                            <div class="invalid-feedback" id="fax-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" data-bs-toggle="tooltip" title="Primary email for general inquiries">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope" aria-hidden="true"></i><span class="icon-fallback">Email</span></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="info@example.com" value="{{ old('email', $settings->email ?? '') }}" aria-describedby="email-error">
                                            @error('email')
                                                <div class="invalid-feedback" id="email-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_email" data-bs-toggle="tooltip" title="Email for contact form submissions">Contact Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope" aria-hidden="true"></i><span class="icon-fallback">Contact</span></span>
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" id="contact_email" placeholder="contact@example.com" value="{{ old('contact_email', $settings->contact_email ?? '') }}" aria-describedby="contact_email-error">
                                            @error('contact_email')
                                                <div class="invalid-feedback" id="contact_email-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="carrers_email" data-bs-toggle="tooltip" title="Email for job applications">Careers Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope" aria-hidden="true"></i><span class="icon-fallback">Careers</span></span>
                                            <input type="email" class="form-control @error('carrers_email') is-invalid @enderror" name="carrers_email" id="carrers_email" placeholder="careers@example.com" value="{{ old('carrers_email', $settings->carrers_email ?? '') }}" aria-describedby="carrers_email-error">
                                            @error('carrers_email')
                                                <div class="invalid-feedback" id="carrers_email-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address" data-bs-toggle="tooltip" title="Physical address of the business">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="123 Main St, City, Country" value="{{ old('address', $settings->address ?? '') }}" aria-describedby="address-error">
                                        @error('address')
                                            <div class="invalid-feedback" id="address-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="location" data-bs-toggle="tooltip" title="Geographic location or branch name">Location</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location" placeholder="Main Office" value="{{ old('location', $settings->location ?? '') }}" aria-describedby="location-error">
                                        @error('location')
                                            <div class="invalid-feedback" id="location-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="url" data-bs-toggle="tooltip" title="Primary URL of the website">Site URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe" aria-hidden="true"></i><span class="icon-fallback">URL</span></span>
                                            <input type="url" class="form-control @error('url') is-invalid @enderror" name="url" id="url" placeholder="https://example.com" value="{{ old('url', $settings->url ?? '') }}" aria-describedby="url-error">
                                            @error('url')
                                                <div class="invalid-feedback" id="url-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Logo Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="logoHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#logoCollapse" aria-expanded="false" aria-controls="logoCollapse">
                                    <i class="fas fa-image me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Logo</span> Logo
                                </button>
                            </h2>
                            <div id="logoCollapse" class="accordion-collapse collapse" aria-labelledby="logoHeading" data-bs-parent="#settingsAccordion">
                                <div class="accordion-body">
                                    <div class="form-group mb-3">
                                        <label for="logo" data-bs-toggle="tooltip" title="Upload a logo image (max 2MB, PNG/JPG)">Logo</label>
                                        <div class="logo-dropzone" id="logo-dropzone">
                                            <p class="mb-0">Drag & Drop your logo here or click to upload</p>
                                            <input type="file" class="form-control-file @error('logo') is-invalid @enderror" name="logo" id="logo" accept="image/png,image/jpeg" aria-describedby="logo-error" hidden>
                                        </div>
                                        @error('logo')
                                            <div class="invalid-feedback d-block" id="logo-error">{{ $message }}</div>
                                        @enderror
                                        <div class="logo-preview mt-3" id="logo-preview">
                                            @if($settings && $settings->logo)
                                                <img src="{{ asset($settings->logo) }}" alt="Current logo" width="200">
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" class="form-check-input" name="remove_logo" id="remove_logo" value="1" aria-label="Remove current logo">
                                                    <label class="form-check-label" for="remove_logo">Remove Logo</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-pill" aria-label="Save settings"><i class="fas fa-save me-2" aria-hidden="true"></i><span class="icon-fallback">Save</span> Save Settings</button>
                        <button type="button" class="btn btn-outline-secondary btn-pill" onclick="confirmCancel()" aria-label="Cancel and reset form"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="icon-fallback">Cancel</span> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Debug form submission
        const form = document.getElementById("settings-form");
        form.addEventListener("submit", function(event) {
            console.log("Form submitted");
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
        });

        // Check Font Awesome loading
        if (!window.FontAwesome) {
            console.warn("Font Awesome not loaded. Using fallback text.");
            document.documentElement.setAttribute('data-fontawesome-loaded', 'false');
        } else {
            document.documentElement.setAttribute('data-fontawesome-loaded', 'true');
        }

        let phoneCount = {{ count($phones) }}; // Initial count of phone fields
        const maxPhones = 3; // Maximum number of phone fields allowed

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, {
            placement: 'top',
            customClass: 'custom-tooltip'
        }));

        // Add phone number field
        document.getElementById("add-phone-btn").addEventListener("click", function() {
            if (phoneCount < maxPhones) {
                phoneCount++;
                let phoneFieldHTML = `
                    <div class="form-group mb-3" id="phone${phoneCount}-container">
                        <label for="phone${phoneCount}">Phone ${phoneCount}</label>
                        <div class="input-group">
                            <input type="tel" class="form-control" name="phone[]" id="phone${phoneCount}" placeholder="Phone Number" aria-describedby="phone${phoneCount}-error">
                            <button type="button" class="btn btn-danger" onclick="removePhoneField(${phoneCount})" aria-label="Remove phone number"><i class="fas fa-trash" aria-hidden="true"></i><span class="icon-fallback">Remove</span></button>
                        </div>
                    </div>
                `;
                document.getElementById("additional-phones").insertAdjacentHTML('beforeend', phoneFieldHTML);
            } else {
                alert('You can add a maximum of 3 phone numbers.');
            }
        });

        // Remove phone number field
        window.removePhoneField = function(phoneIndex) {
            document.getElementById(`phone${phoneIndex}-container`).remove();
            phoneCount--;
            updateProgress();
        };

        // Show loading overlay on form submit
        form.addEventListener("submit", function() {
            document.getElementById("loading-overlay").style.display = "flex";
        });

        // Client-side validation for URLs, emails, and phones
        const urlInputs = document.querySelectorAll('input[type="url"]');
        const emailInputs = document.querySelectorAll('input[type="email"]');
        const phoneInputs = document.querySelectorAll('input[type="tel"]');

        urlInputs.forEach(input => {
            input.addEventListener("input", function() {
                const urlPattern = /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w- ./?%&=]*)?$/i;
                if (this.value && !urlPattern.test(this.value)) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = 'Please enter a valid URL (e.g., https://example.com)';
                } else {
                    this.classList.remove('is-invalid');
                    if (this.value) this.classList.add('is-valid');
                }
                updateProgress();
            });
        });

        emailInputs.forEach(input => {
            input.addEventListener("input", function() {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailPattern.test(this.value)) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = 'Please enter a valid email address';
                } else {
                    this.classList.remove('is-invalid');
                    if (this.value) this.classList.add('is-valid');
                }
                updateProgress();
            });
        });

        phoneInputs.forEach(input => {
            input.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9-+\s]/g, '');
                if (this.value && this.value.length < 7) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = 'Phone number must be at least 7 characters';
                } else {
                    this.classList.remove('is-invalid');
                    if (this.value) this.classList.add('is-valid');
                }
                updateProgress();
            });
        });

        // Logo preview and drag-and-drop
        const logoInput = document.getElementById("logo");
        const logoDropzone = document.getElementById("logo-dropzone");
        const logoPreview = document.getElementById("logo-preview");

        logoDropzone.addEventListener("click", () => logoInput.click());

        logoDropzone.addEventListener("dragover", (e) => {
            e.preventDefault();
            logoDropzone.classList.add("dragover");
        });

        logoDropzone.addEventListener("dragleave", () => {
            logoDropzone.classList.remove("dragover");
        });

        logoDropzone.addEventListener("drop", (e) => {
            e.preventDefault();
            logoDropzone.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            if (file && (file.type === "image/png" || file.type === "image/jpeg")) {
                logoInput.files = e.dataTransfer.files;
                updateLogoPreview(file);
            } else {
                alert("Please upload a PNG or JPEG image.");
            }
        });

        logoInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                updateLogoPreview(file);
            }
        });

        function updateLogoPreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Logo preview";
                img.width = 200;
                logoPreview.innerHTML = '';
                logoPreview.appendChild(img);
                logoPreview.innerHTML += `
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="remove_logo" id="remove_logo" value="1" aria-label="Remove current logo">
                        <label class="form-check-label" for="remove_logo">Remove Logo</label>
                    </div>
                `;
                updateProgress();
            };
            reader.readAsDataURL(file);
        }

        // Confirm cancel action
        window.confirmCancel = function() {
            if (confirm("Are you sure you want to reset the form? All unsaved changes will be lost.")) {
                form.reset();
                document.getElementById("logo-preview").innerHTML = `
                    @if($settings && $settings->logo)
                        <img src="{{ asset($settings->logo) }}" alt="Current logo" width="200">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="remove_logo" id="remove_logo" value="1" aria-label="Remove current logo">
                            <label class="form-check-label" for="remove_logo">Remove Logo</label>
                        </div>
                    @endif
                `;
                updateProgress();
            }
        };

        // Update progress bar
        function updateProgress() {
            const inputs = form.querySelectorAll('input:not([type="checkbox"]), textarea');
            let filledInputs = 0;
            inputs.forEach(input => {
                if (input.value.trim()) filledInputs++;
            });
            const progress = (filledInputs / inputs.length) * 100;
            document.getElementById("progress-bar").style.width = `${progress}%`;
            document.getElementById("progress-text").textContent = `${Math.round(progress)}%`;
            document.getElementById("progress-bar").setAttribute("aria-valuenow", Math.round(progress));
        }

        // Initial progress update
        updateProgress();
    });
</script>
@endsection
