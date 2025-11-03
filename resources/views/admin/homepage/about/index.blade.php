@extends('admin.layouts.app')

@section('content')

<style>
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

    .image-dropzone {
        border: 2px dashed #ced4da;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .image-dropzone:hover, .image-dropzone.dragover {
        border-color: var(--primary-color);
        background-color: rgba(158, 109, 224, 0.1);
    }

    .image-preview img {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 8px;
        background-color: #fff;
        max-width: 200px;
        transition: opacity 0.3s ease;
    }

    .image-preview img.icon-preview {
        max-width: 100px;
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

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
            gap: 1rem;
        }
        .btn-pill {
            width: 100%;
        }
        .image-preview img {
            max-width: 100%;
        }
        .form-section {
            padding: 1rem;
        }
    }

    .form-control:focus, .accordion-button:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

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
                <i class="fas fa-info-circle me-2" aria-hidden="true"></i>
                <span class="icon-fallback">About</span>
                <h4 class="mb-0">About Section Settings</h4>
            </div>
            <div class="card-body position-relative">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loading-overlay">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

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

                <form action="{{ route('admin.about-sections.store') }}" method="POST" enctype="multipart/form-data" id="about-form" aria-describedby="form-description">
                    @csrf
                    <p id="form-description" class="visually-hidden">Form to update about section settings including headings, subtitles, paragraphs, images, and additional information in English and Arabic.</p>

                    <!-- Content Section -->
                    <div class="form-section accordion" id="aboutAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="contentHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#contentCollapse" aria-expanded="true" aria-controls="contentCollapse">
                                    <i class="fas fa-text-height me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Content</span> Content
                                </button>
                            </h2>
                            <div id="contentCollapse" class="accordion-collapse collapse show" aria-labelledby="contentHeading" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="heading_en" data-bs-toggle="tooltip" title="Main heading in English">Heading (English)</label>
                                            <input type="text" class="form-control @error('heading_en') is-invalid @enderror" name="heading_en" id="heading_en" placeholder="About Us" value="{{ old('heading_en', $aboutSection->heading_en ?? '') }}" aria-describedby="heading_en-error" required>
                                            @error('heading_en')
                                                <div class="invalid-feedback" id="heading_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="heading_ar" data-bs-toggle="tooltip" title="Main heading in Arabic">Heading (Arabic)</label>
                                            <input type="text" class="form-control @error('heading_ar') is-invalid @enderror" name="heading_ar" id="heading_ar" placeholder="عنّا" value="{{ old('heading_ar', $aboutSection->heading_ar ?? '') }}" aria-describedby="heading_ar-error" required dir="rtl">
                                            @error('heading_ar')
                                                <div class="invalid-feedback" id="heading_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="subtitle_en" data-bs-toggle="tooltip" title="Subtitle in English">Subtitle (English)</label>
                                            <input type="text" class="form-control @error('subtitle_en') is-invalid @enderror" name="subtitle_en" id="subtitle_en" placeholder="Our Story" value="{{ old('subtitle_en', $aboutSection->subtitle_en ?? '') }}" aria-describedby="subtitle_en-error">
                                            @error('subtitle_en')
                                                <div class="invalid-feedback" id="subtitle_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="subtitle_ar" data-bs-toggle="tooltip" title="Subtitle in Arabic">Subtitle (Arabic)</label>
                                            <input type="text" class="form-control @error('subtitle_ar') is-invalid @enderror" name="subtitle_ar" id="subtitle_ar" placeholder="قصتنا" value="{{ old('subtitle_ar', $aboutSection->subtitle_ar ?? '') }}" aria-describedby="subtitle_ar-error" dir="rtl">
                                            @error('subtitle_ar')
                                                <div class="invalid-feedback" id="subtitle_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="highlight_word_en" data-bs-toggle="tooltip" title="Highlighted word in English">Highlight Word (English)</label>
                                            <input type="text" class="form-control @error('highlight_word_en') is-invalid @enderror" name="highlight_word_en" id="highlight_word_en" placeholder="Excellence" value="{{ old('highlight_word_en', $aboutSection->highlight_word_en ?? '') }}" aria-describedby="highlight_word_en-error">
                                            @error('highlight_word_en')
                                                <div class="invalid-feedback" id="highlight_word_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="highlight_word_ar" data-bs-toggle="tooltip" title="Highlighted word in Arabic">Highlight Word (Arabic)</label>
                                            <input type="text" class="form-control @error('highlight_word_ar') is-invalid @enderror" name="highlight_word_ar" id="highlight_word_ar" placeholder="التميز" value="{{ old('highlight_word_ar', $aboutSection->highlight_word_ar ?? '') }}" aria-describedby="highlight_word_ar-error" dir="rtl">
                                            @error('highlight_word_ar')
                                                <div class="invalid-feedback" id="highlight_word_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="paragraph_en" data-bs-toggle="tooltip" title="Description paragraph in English">Paragraph (English)</label>
                                            <textarea class="form-control @error('paragraph_en') is-invalid @enderror" name="paragraph_en" id="paragraph_en" rows="4" placeholder="Describe your company..." aria-describedby="paragraph_en-error">{{ old('paragraph_en', $aboutSection->paragraph_en ?? '') }}</textarea>
                                            @error('paragraph_en')
                                                <div class="invalid-feedback" id="paragraph_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="paragraph_ar" data-bs-toggle="tooltip" title="Description paragraph in Arabic">Paragraph (Arabic)</label>
                                            <textarea class="form-control @error('paragraph_ar') is-invalid @enderror" name="paragraph_ar" id="paragraph_ar" rows="4" placeholder="وصف شركتك..." aria-describedby="paragraph_ar-error" dir="rtl">{{ old('paragraph_ar', $aboutSection->paragraph_ar ?? '') }}</textarea>
                                            @error('paragraph_ar')
                                                <div class="invalid-feedback" id="paragraph_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="imagesHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#imagesCollapse" aria-expanded="false" aria-controls="imagesCollapse">
                                    <i class="fas fa-image me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Images</span> Images
                                </button>
                            </h2>
                            <div id="imagesCollapse" class="accordion-collapse collapse" aria-labelledby="imagesHeading" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="main_image" data-bs-toggle="tooltip" title="Upload main image (max 2MB, PNG/JPG)">Main Image</label>
                                            <div class="image-dropzone" id="main-image-dropzone">
                                                <p class="mb-0">Drag & Drop your main image here or click to upload</p>
                                                <input type="file" class="form-control-file @error('main_image') is-invalid @enderror" name="main_image" id="main_image" accept="image/png,image/jpeg" aria-describedby="main_image-error" hidden>
                                            </div>
                                            @error('main_image')
                                                <div class="invalid-feedback d-block" id="main_image-error">{{ $message }}</div>
                                            @enderror
                                            <div class="image-preview mt-3" id="main-image-preview">
                                                @if($aboutSection && $aboutSection->main_image)
                                                    <img src="{{ asset($aboutSection->main_image) }}" alt="{{ $aboutSection->main_image_alt ?? 'Main image' }}" width="200">
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" name="remove_main_image" id="remove_main_image" value="1" aria-label="Remove main image">
                                                        <label class="form-check-label" for="remove_main_image">Remove Main Image</label>
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="main_image_alt" data-bs-toggle="tooltip" title="Alt text for main image accessibility">Main Image Alt Text</label>
                                            <input type="text" class="form-control @error('main_image_alt') is-invalid @enderror" name="main_image_alt" id="main_image_alt" placeholder="Main image description" value="{{ old('main_image_alt', $aboutSection->main_image_alt ?? '') }}" aria-describedby="main_image_alt-error">
                                            @error('main_image_alt')
                                                <div class="invalid-feedback" id="main_image_alt-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="small_image" data-bs-toggle="tooltip" title="Upload small image (max 2MB, PNG/JPG)">Small Image</label>
                                            <div class="image-dropzone" id="small-image-dropzone">
                                                <p class="mb-0">Drag & Drop your small image here or click to upload</p>
                                                <input type="file" class="form-control-file @error('small_image') is-invalid @enderror" name="small_image" id="small_image" accept="image/png,image/jpeg" aria-describedby="small_image-error" hidden>
                                            </div>
                                            @error('small_image')
                                                <div class="invalid-feedback d-block" id="small_image-error">{{ $message }}</div>
                                            @enderror
                                            <div class="image-preview mt-3" id="small-image-preview">
                                                @if($aboutSection && $aboutSection->small_image)
                                                    <img src="{{ asset($aboutSection->small_image) }}" alt="{{ $aboutSection->small_image_alt ?? 'Small image' }}" width="200">
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" name="remove_small_image" id="remove_small_image" value="1" aria-label="Remove small image">
                                                        <label class="form-check-label" for="remove_small_image">Remove Small Image</label>
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="small_image_alt" data-bs-toggle="tooltip" title="Alt text for small image accessibility">Small Image Alt Text</label>
                                            <input type="text" class="form-control @error('small_image_alt') is-invalid @enderror" name="small_image_alt" id="small_image_alt" placeholder="Small image description" value="{{ old('small_image_alt', $aboutSection->small_image_alt ?? '') }}" aria-describedby="small_image_alt-error">
                                            @error('small_image_alt')
                                                <div class="invalid-feedback" id="small_image_alt-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="icon_image" data-bs-toggle="tooltip" title="Upload icon image (max 2MB, PNG/JPG)">Icon Image</label>
                                            <div class="image-dropzone" id="icon-image-dropzone">
                                                <p class="mb-0">Drag & Drop your icon image here or click to upload</p>
                                                <input type="file" class="form-control-file @error('icon_image') is-invalid @enderror" name="icon_image" id="icon_image" accept="image/png,image/jpeg" aria-describedby="icon_image-error" hidden>
                                            </div>
                                            @error('icon_image')
                                                <div class="invalid-feedback d-block" id="icon_image-error">{{ $message }}</div>
                                            @enderror
                                            <div class="image-preview mt-3" id="icon-image-preview">
                                                @if($aboutSection && $aboutSection->icon_image)
                                                    <img src="{{ asset($aboutSection->icon_image) }}" alt="Icon image" class="icon-preview" width="100">
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" name="remove_icon_image" id="remove_icon_image" value="1" aria-label="Remove icon image">
                                                        <label class="form-check-label" for="remove_icon_image">Remove Icon Image</label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="infoHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#infoCollapse" aria-expanded="false" aria-controls="infoCollapse">
                                    <i class="fas fa-info me-2" aria-hidden="true"></i>
                                    <span class="icon-fallback">Info</span> Additional Information
                                </button>
                            </h2>
                            <div id="infoCollapse" class="accordion-collapse collapse" aria-labelledby="infoHeading" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="label_en" data-bs-toggle="tooltip" title="Label in English">Label (English)</label>
                                            <input type="text" class="form-control @error('label_en') is-invalid @enderror" name="label_en" id="label_en" placeholder="Our Mission" value="{{ old('label_en', $aboutSection->label_en ?? '') }}" aria-describedby="label_en-error">
                                            @error('label_en')
                                                <div class="invalid-feedback" id="label_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="label_ar" data-bs-toggle="tooltip" title="Label in Arabic">Label (Arabic)</label>
                                            <input type="text" class="form-control @error('label_ar') is-invalid @enderror" name="label_ar" id="label_ar" placeholder="مهمتنا" value="{{ old('label_ar', $aboutSection->label_ar ?? '') }}" aria-describedby="label_ar-error" dir="rtl">
                                            @error('label_ar')
                                                <div class="invalid-feedback" id="label_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="description_en" data-bs-toggle="tooltip" title="Description in English">Description (English)</label>
                                            <textarea class="form-control @error('description_en') is-invalid @enderror" name="description_en" id="description_en" rows="4" placeholder="Our mission statement..." aria-describedby="description_en-error">{{ old('description_en', $aboutSection->description_en ?? '') }}</textarea>
                                            @error('description_en')
                                                <div class="invalid-feedback" id="description_en-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="description_ar" data-bs-toggle="tooltip" title="Description in Arabic">Description (Arabic)</label>
                                            <textarea class="form-control @error('description_ar') is-invalid @enderror" name="description_ar" id="description_ar" rows="4" placeholder="بيان مهمتنا..." aria-describedby="description_ar-error" dir="rtl">{{ old('description_ar', $aboutSection->description_ar ?? '') }}</textarea>
                                            @error('description_ar')
                                                <div class="invalid-feedback" id="description_ar-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-pill" aria-label="Save about section"><i class="fas fa-save me-2" aria-hidden="true"></i><span class="icon-fallback">Save</span> Save Settings</button>
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
        const form = document.getElementById("about-form");
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

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, {
            placement: 'top',
            customClass: 'custom-tooltip'
        }));

        // Show loading overlay on form submit
        form.addEventListener("submit", function() {
            document.getElementById("loading-overlay").style.display = "flex";
        });

        // Client-side validation for text inputs
        const textInputs = document.querySelectorAll('input[type="text"], textarea');
        textInputs.forEach(input => {
            input.addEventListener("input", function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.textContent = 'This field is required';
                } else {
                    this.classList.remove('is-invalid');
                    if (this.value.trim()) this.classList.add('is-valid');
                }
            });
        });

        // Image preview and drag-and-drop for main image
        const mainImageInput = document.getElementById("main_image");
        const mainImageDropzone = document.getElementById("main-image-dropzone");
        const mainImagePreview = document.getElementById("main-image-preview");

        mainImageDropzone.addEventListener("click", () => mainImageInput.click());

        mainImageDropzone.addEventListener("dragover", (e) => {
            e.preventDefault();
            mainImageDropzone.classList.add("dragover");
        });

        mainImageDropzone.addEventListener("dragleave", () => {
            mainImageDropzone.classList.remove("dragover");
        });

        mainImageDropzone.addEventListener("drop", (e) => {
            e.preventDefault();
            mainImageDropzone.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            if (file && (file.type === "image/png" || file.type === "image/jpeg")) {
                mainImageInput.files = e.dataTransfer.files;
                updateImagePreview(file, mainImagePreview, 'main');
            } else {
                alert("Please upload a PNG or JPEG image.");
            }
        });

        mainImageInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                updateImagePreview(file, mainImagePreview, 'main');
            }
        });

        // Image preview and drag-and-drop for small image
        const smallImageInput = document.getElementById("small_image");
        const smallImageDropzone = document.getElementById("small-image-dropzone");
        const smallImagePreview = document.getElementById("small-image-preview");

        smallImageDropzone.addEventListener("click", () => smallImageInput.click());

        smallImageDropzone.addEventListener("dragover", (e) => {
            e.preventDefault();
            smallImageDropzone.classList.add("dragover");
        });

        smallImageDropzone.addEventListener("dragleave", () => {
            smallImageDropzone.classList.remove("dragover");
        });

        smallImageDropzone.addEventListener("drop", (e) => {
            e.preventDefault();
            smallImageDropzone.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            if (file && (file.type === "image/png" || file.type === "image/jpeg")) {
                smallImageInput.files = e.dataTransfer.files;
                updateImagePreview(file, smallImagePreview, 'small');
            } else {
                alert("Please upload a PNG or JPEG image.");
            }
        });

        smallImageInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                updateImagePreview(file, smallImagePreview, 'small');
            }
        });

        // Image preview and drag-and-drop for icon image
        const iconImageInput = document.getElementById("icon_image");
        const iconImageDropzone = document.getElementById("icon-image-dropzone");
        const iconImagePreview = document.getElementById("icon-image-preview");

        iconImageDropzone.addEventListener("click", () => iconImageInput.click());

        iconImageDropzone.addEventListener("dragover", (e) => {
            e.preventDefault();
            iconImageDropzone.classList.add("dragover");
        });

        iconImageDropzone.addEventListener("dragleave", () => {
            iconImageDropzone.classList.remove("dragover");
        });

        iconImageDropzone.addEventListener("drop", (e) => {
            e.preventDefault();
            iconImageDropzone.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            if (file && (file.type === "image/png" || file.type === "image/jpeg")) {
                iconImageInput.files = e.dataTransfer.files;
                updateImagePreview(file, iconImagePreview, 'icon');
            } else {
                alert("Please upload a PNG or JPEG image.");
            }
        });

        iconImageInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                updateImagePreview(file, iconImagePreview, 'icon');
            }
        });

        function updateImagePreview(file, previewElement, prefix) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Image preview";
                img.className = prefix === 'icon' ? 'icon-preview' : '';
                img.width = prefix === 'icon' ? 100 : 200;
                previewElement.innerHTML = '';
                previewElement.appendChild(img);
                previewElement.innerHTML += `
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="remove_${prefix}_image" id="remove_${prefix}_image" value="1" aria-label="Remove ${prefix} image">
                        <label class="form-check-label" for="remove_${prefix}_image">Remove ${prefix.charAt(0).toUpperCase() + prefix.slice(1)} Image</label>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }

        // Confirm cancel action
        window.confirmCancel = function() {
            if (confirm("Are you sure you want to reset the form? All unsaved changes will be lost.")) {
                form.reset();
                document.getElementById("main-image-preview").innerHTML = `
                    @if($aboutSection && $aboutSection->main_image)
                        <img src="{{ asset($aboutSection->main_image) }}" alt="{{ $aboutSection->main_image_alt ?? 'Main image' }}" width="200">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="remove_main_image" id="remove_main_image" value="1" aria-label="Remove main image">
                            <label class="form-check-label" for="remove_main_image">Remove Main Image</label>
                        </div>
                    @endif
                `;
                document.getElementById("small-image-preview").innerHTML = `
                    @if($aboutSection && $aboutSection->small_image)
                        <img src="{{ asset($aboutSection->small_image) }}" alt="{{ $aboutSection->small_image_alt ?? 'Small image' }}" width="200">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="remove_small_image" id="remove_small_image" value="1" aria-label="Remove small image">
                            <label class="form-check-label" for="remove_small_image">Remove Small Image</label>
                        </div>
                    @endif
                `;
                document.getElementById("icon-image-preview").innerHTML = `
                    @if($aboutSection && $aboutSection->icon_image)
                        <img src="{{ asset($aboutSection->icon_image) }}" alt="Icon image" class="icon-preview" width="100">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="remove_icon_image" id="remove_icon_image" value="1" aria-label="Remove icon image">
                            <label class="form-check-label" for="remove_icon_image">Remove Icon Image</label>
                        </div>
                    @endif
                `;
            }
        };
    });
</script>
@endsection
