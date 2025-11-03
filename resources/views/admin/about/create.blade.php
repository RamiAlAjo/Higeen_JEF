@extends('admin.layouts.app')

@section('title', 'Create About Us')

@section('content')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
        .form-control, .custom-file-input {
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus, .custom-file-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-radius: 8px 0 0 8px;
        }
        .btn-outline-success, .btn-outline-danger {
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .feature-input, .slider-card {
            animation-duration: 0.5s;
        }
        .form-label {
            color: #333;
            font-size: 0.9rem;
        }
        .btn-lg {
            padding: 10px 20px;
        }
        .slider-card {
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .slider-card .card-body {
            padding: 1.5rem;
        }
        .icon-select {
            max-width: 150px;
        }
        @media (max-width: 768px) {
            .input-group {
                flex-direction: column;
            }
            .input-group-text, .btn-outline-danger, .icon-select {
                width: 100%;
                margin-top: 5px;
            }
            .btn-outline-danger {
                border-radius: 8px;
            }
            .slider-card .row {
                margin-bottom: 0;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create About Us</h1>
            <a href="{{ route('admin.about.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to About Us
            </a>
        </div>

        <!-- Form Card -->
        <div class="card shadow-lg mb-4 border-0 rounded-lg">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">About Us Information</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Main Image -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="about_main_image" class="form-label fw-bold">Main Image <span class="text-danger">*</span></label>
                            <input type="file"
                                   class="form-control @error('about_main_image') is-invalid @enderror"
                                   id="about_main_image"
                                   name="about_main_image"
                                   accept="image/*"
                                   required>
                            <small class="form-text text-muted">Max 2MB. JPG, PNG, WEBP</small>
                            @error('about_main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- English Fields Row -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="about_us_title_en" class="form-label fw-bold">Title (English) <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('about_us_title_en') is-invalid @enderror"
                                   id="about_us_title_en"
                                   name="about_us_title_en"
                                   value="{{ old('about_us_title_en') }}"
                                   required>
                            @error('about_us_title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="about_us_description_en" class="form-label fw-bold">Description (English)</label>
                            <textarea class="form-control @error('about_us_description_en') is-invalid @enderror"
                                      id="about_us_description_en"
                                      name="about_us_description_en"
                                      rows="4">{{ old('about_us_description_en') }}</textarea>
                            @error('about_us_description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Arabic Fields Row -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="about_us_title_ar" class="form-label fw-bold">العنوان (العربية) <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('about_us_title_ar') is-invalid @enderror"
                                   id="about_us_title_ar"
                                   name="about_us_title_ar"
                                   value="{{ old('about_us_title_ar') }}"
                                   dir="rtl"
                                   required>
                            @error('about_us_title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="about_us_description_ar" class="form-label fw-bold">الوصف (العربية)</label>
                            <textarea class="form-control @error('about_us_description_ar') is-invalid @enderror"
                                      id="about_us_description_ar"
                                      name="about_us_description_ar"
                                      rows="4"
                                      dir="rtl">{{ old('about_us_description_ar') }}</textarea>
                            @error('about_us_description_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Features Fields (English) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Features (English)</label>
                            <div id="features_en_container">
                                @if (old('features_en'))
                                    @foreach (old('features_en') as $index => $feature)
                                        <div class="input-group mb-2 feature-input animate__animated animate__fadeIn">
                                            <span class="input-group-text"><i class="fas fa-list-ul"></i></span>
                                            <input type="text"
                                                   class="form-control @error('features_en.'.$index.'.text') is-invalid @enderror"
                                                   name="features_en[{{$index}}][text]"
                                                   value="{{ $feature['text'] ?? $feature }}"
                                                   placeholder="Enter feature text">
                                            <select class="form-control icon-select @error('features_en.'.$index.'.icon') is-invalid @enderror"
                                                    name="features_en[{{$index}}][icon]">
                                                <option value="bi bi-check2-circle" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-check2-circle') ? 'selected' : '' }}>Check Circle</option>
                                                <option value="bi bi-star-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-star-fill') ? 'selected' : '' }}>Star</option>
                                                <option value="bi bi-shield-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-shield-fill') ? 'selected' : '' }}>Shield</option>
                                                <option value="bi bi-lightbulb-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-lightbulb-fill') ? 'selected' : '' }}>Lightbulb</option>
                                                <option value="bi bi-headset" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-headset') ? 'selected' : '' }}>Headset</option>
                                            </select>
                                            <button type="button" class="btn btn-outline-danger remove-feature"><i class="fas fa-trash"></i></button>
                                            @error('features_en.'.$index.'.text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('features_en.'.$index.'.icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 feature-input animate__animated animate__fadeIn">
                                        <span class="input-group-text"><i class="fas fa-list-ul"></i></span>
                                        <input type="text"
                                               class="form-control @error('features_en.0.text') is-invalid @enderror"
                                               name="features_en[0][text]"
                                               placeholder="Enter feature text">
                                        <select class="form-control icon-select @error('features_en.0.icon') is-invalid @enderror"
                                                name="features_en[0][icon]">
                                            <option value="bi bi-check2-circle">Check Circle</option>
                                            <option value="bi bi-star-fill">Star</option>
                                            <option value="bi bi-shield-fill">Shield</option>
                                            <option value="bi bi-lightbulb-fill">Lightbulb</option>
                                            <option value="bi bi-headset">Headset</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-danger remove-feature"><i class="fas fa-trash"></i></button>
                                        @error('features_en.0.text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('features_en.0.icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2 add-feature" data-target="features_en_container">
                                <i class="fas fa-plus me-1"></i> Add Feature
                            </button>
                        </div>

                        <!-- Features Fields (Arabic) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">المميزات (العربية)</label>
                            <div id="features_ar_container">
                                @if (old('features_ar'))
                                    @foreach (old('features_ar') as $index => $feature)
                                        <div class="input-group mb-2 feature-input animate__animated animate__fadeIn">
                                            <span class="input-group-text"><i class="fas fa-list-ul"></i></span>
                                            <input type="text"
                                                   class="form-control @error('features_ar.'.$index.'.text') is-invalid @enderror"
                                                   name="features_ar[{{$index}}][text]"
                                                   value="{{ $feature['text'] ?? $feature }}"
                                                   dir="rtl"
                                                   placeholder="أدخل ميزة">
                                            <select class="form-control icon-select @error('features_ar.'.$index.'.icon') is-invalid @enderror"
                                                    name="features_ar[{{$index}}][icon]">
                                                <option value="bi bi-check2-circle" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-check2-circle') ? 'selected' : '' }}>دائرة التأكيد</option>
                                                <option value="bi bi-star-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-star-fill') ? 'selected' : '' }}>نجمة</option>
                                                <option value="bi bi-shield-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-shield-fill') ? 'selected' : '' }}>درع</option>
                                                <option value="bi bi-lightbulb-fill" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-lightbulb-fill') ? 'selected' : '' }}>مصباح</option>
                                                <option value="bi bi-headset" {{ (isset($feature['icon']) && $feature['icon'] == 'bi bi-headset') ? 'selected' : '' }}>سماعة</option>
                                            </select>
                                            <button type="button" class="btn btn-outline-danger remove-feature"><i class="fas fa-trash"></i></button>
                                            @error('features_ar.'.$index.'.text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('features_ar.'.$index.'.icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 feature-input animate__animated animate__fadeIn">
                                        <span class="input-group-text"><i class="fas fa-list-ul"></i></span>
                                        <input type="text"
                                               class="form-control @error('features_ar.0.text') is-invalid @enderror"
                                               name="features_ar[0][text]"
                                               dir="rtl"
                                               placeholder="أدخل ميزة">
                                        <select class="form-control icon-select @error('features_ar.0.icon') is-invalid @enderror"
                                                name="features_ar[0][icon]">
                                            <option value="bi bi-check2-circle">دائرة التأكيد</option>
                                            <option value="bi bi-star-fill">نجمة</option>
                                            <option value="bi bi-shield-fill">درع</option>
                                            <option value="bi bi-lightbulb-fill">مصباح</option>
                                            <option value="bi bi-headset">سماعة</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-danger remove-feature"><i class="fas fa-trash"></i></button>
                                        @error('features_ar.0.text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('features_ar.0.icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2 add-feature" data-target="features_ar_container">
                                <i class="fas fa-plus me-1"></i> إضافة ميزة
                            </button>
                        </div>
                    </div>

                    <!-- Sliders Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">Sliders</label>
                            <div id="sliders_container">
                                @if (old('sliders'))
                                    @foreach (old('sliders') as $index => $slider)
                                        <div class="card mb-3 slider-card animate__animated animate__fadeIn border-light shadow-sm">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Slider Icon/Image</label>
                                                        <input type="file"
                                                               class="form-control @error('sliders.'.$index.'.slider_icon') is-invalid @enderror"
                                                               name="sliders[{{$index}}][slider_icon]"
                                                               accept="image/*">
                                                        <small class="form-text text-muted">Max 2MB. JPG, PNG, WEBP</small>
                                                        @error('sliders.'.$index.'.slider_icon')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Slider Title (English)</label>
                                                        <input type="text"
                                                               class="form-control @error('sliders.'.$index.'.slider_title_en') is-invalid @enderror"
                                                               name="sliders[{{$index}}][slider_title_en]"
                                                               value="{{ $slider['slider_title_en'] ?? '' }}"
                                                               placeholder="Enter slider title">
                                                        @error('sliders.'.$index.'.slider_title_en')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Slider Description (English)</label>
                                                        <textarea class="form-control @error('sliders.'.$index.'.slider_description_en') is-invalid @enderror"
                                                                  name="sliders[{{$index}}][slider_description_en]"
                                                                  rows="3"
                                                                  placeholder="Enter slider description">{{ $slider['slider_description_en'] ?? '' }}</textarea>
                                                        @error('sliders.'.$index.'.slider_description_en')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">عنوان الشريحة (العربية)</label>
                                                        <input type="text"
                                                               class="form-control @error('sliders.'.$index.'.slider_title_ar') is-invalid @enderror"
                                                               name="sliders[{{$index}}][slider_title_ar]"
                                                               value="{{ $slider['slider_title_ar'] ?? '' }}"
                                                               dir="rtl"
                                                               placeholder="أدخل عنوان الشريحة">
                                                        @error('sliders.'.$index.'.slider_title_ar')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">وصف الشريحة (العربية)</label>
                                                        <textarea class="form-control @error('sliders.'.$index.'.slider_description_ar') is-invalid @enderror"
                                                                  name="sliders[{{$index}}][slider_description_ar]"
                                                                  rows="3"
                                                                  dir="rtl"
                                                                  placeholder="أدخل وصف الشريحة">{{ $slider['slider_description_ar'] ?? '' }}</textarea>
                                                        @error('sliders.'.$index.'.slider_description_ar')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-slider">
                                                    <i class="fas fa-trash me-1"></i> Remove Slider
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card mb-3 slider-card animate__animated animate__fadeIn border-light shadow-sm">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Slider Icon/Image</label>
                                                    <input type="file"
                                                           class="form-control @error('sliders.0.slider_icon') is-invalid @enderror"
                                                           name="sliders[0][slider_icon]"
                                                           accept="image/*">
                                                    <small class="form-text text-muted">Max 2MB. JPG, PNG, WEBP</small>
                                                    @error('sliders.0.slider_icon')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Slider Title (English)</label>
                                                    <input type="text"
                                                           class="form-control @error('sliders.0.slider_title_en') is-invalid @enderror"
                                                           name="sliders[0][slider_title_en]"
                                                           placeholder="Enter slider title">
                                                    @error('sliders.0.slider_title_en')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Slider Description (English)</label>
                                                    <textarea class="form-control @error('sliders.0.slider_description_en') is-invalid @enderror"
                                                              name="sliders[0][slider_description_en]"
                                                              rows="3"
                                                              placeholder="Enter slider description"></textarea>
                                                    @error('sliders.0.slider_description_en')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">عنوان الشريحة (العربية)</label>
                                                    <input type="text"
                                                           class="form-control @error('sliders.0.slider_title_ar') is-invalid @enderror"
                                                           name="sliders[0][slider_title_ar]"
                                                           dir="rtl"
                                                           placeholder="أدخل عنوان الشريحة">
                                                    @error('sliders.0.slider_title_ar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">وصف الشريحة (العربية)</label>
                                                    <textarea class="form-control @error('sliders.0.slider_description_ar') is-invalid @enderror"
                                                              name="sliders[0][slider_description_ar]"
                                                              rows="3"
                                                              dir="rtl"
                                                              placeholder="أدخل وصف الشريحة"></textarea>
                                                    @error('sliders.0.slider_description_ar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-slider">
                                                <i class="fas fa-trash me-1"></i> Remove Slider
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add_slider">
                                <i class="fas fa-plus me-1"></i> Add Slider
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-save me-1"></i> Create About Us
                            </button>
                            <a href="{{ route('admin.about.index') }}" class="btn btn-outline-secondary btn-lg ms-2 shadow-sm">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add feature input
        document.querySelectorAll('.add-feature').forEach(button => {
            button.addEventListener('click', function () {
                const containerId = this.getAttribute('data-target');
                const container = document.getElementById(containerId);
                const index = container.querySelectorAll('.feature-input').length;
                const inputGroup = document.createElement('div');
                inputGroup.className = 'input-group mb-2 feature-input animate__animated animate__fadeIn';
                inputGroup.innerHTML = `
                    <span class="input-group-text"><i class="fas fa-list-ul"></i></span>
                    <input type="text" class="form-control" name="${containerId.includes('en') ? 'features_en' : 'features_ar'}[${index}][text]"
                           ${containerId.includes('ar') ? 'dir="rtl" placeholder="أدخل ميزة"' : 'placeholder="Enter feature text"'}>
                    <select class="form-control icon-select" name="${containerId.includes('en') ? 'features_en' : 'features_ar'}[${index}][icon]">
                        <option value="bi bi-check2-circle">${containerId.includes('ar') ? 'دائرة التأكيد' : 'Check Circle'}</option>
                        <option value="bi bi-star-fill">${containerId.includes('ar') ? 'نجمة' : 'Star'}</option>
                        <option value="bi bi-shield-fill">${containerId.includes('ar') ? 'درع' : 'Shield'}</option>
                        <option value="bi bi-lightbulb-fill">${containerId.includes('ar') ? 'مصباح' : 'Lightbulb'}</option>
                        <option value="bi bi-headset">${containerId.includes('ar') ? 'سماعة' : 'Headset'}</option>
                    </select>
                    <button type="button" class="btn btn-outline-danger remove-feature"><i class="fas fa-trash"></i></button>
                `;
                container.appendChild(inputGroup);
            });
        });

        // Add slider
        document.getElementById('add_slider').addEventListener('click', function () {
            const container = document.getElementById('sliders_container');
            const index = container.children.length;
            const sliderCard = document.createElement('div');
            sliderCard.className = 'card mb-3 slider-card animate__animated animate__fadeIn border-light shadow-sm';
            sliderCard.innerHTML = `
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slider Icon/Image</label>
                            <input type="file" class="form-control" name="sliders[${index}][slider_icon]" accept="image/*">
                            <small class="form-text text-muted">Max 2MB. JPG, PNG, WEBP</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slider Title (English)</label>
                            <input type="text" class="form-control" name="sliders[${index}][slider_title_en]" placeholder="Enter slider title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slider Description (English)</label>
                            <textarea class="form-control" name="sliders[${index}][slider_description_en]" rows="3" placeholder="Enter slider description"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">عنوان الشريحة (العربية)</label>
                            <input type="text" class="form-control" name="sliders[${index}][slider_title_ar]" dir="rtl" placeholder="أدخل عنوان الشريحة">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">وصف الشريحة (العربية)</label>
                            <textarea class="form-control" name="sliders[${index}][slider_description_ar]" rows="3" dir="rtl" placeholder="أدخل وصف الشريحة"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-slider">
                        <i class="fas fa-trash me-1"></i> Remove Slider
                    </button>
                </div>
            `;
            container.appendChild(sliderCard);
        });

        // Remove feature or slider
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-feature') || e.target.closest('.remove-slider')) {
                const element = e.target.closest('.feature-input') || e.target.closest('.slider-card');
                const container = element.parentElement;
                if (container.children.length > 1) {
                    element.classList.add('animate__fadeOut');
                    setTimeout(() => element.remove(), 500);
                }
            }
        });
    </script>
@endsection
