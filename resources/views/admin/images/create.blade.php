@extends('admin.layouts.app')

@section('title', 'Create Images')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Add New Images</h3>
                        <a href="{{ route('admin.images.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Gallery
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Success/Error Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Form -->
                        <form id="image-upload-form" action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Album Selection -->
                            <div class="mb-4">
                                <label for="album_id" class="form-label fw-bold">Album <span class="text-danger">*</span></label>
                                <select name="album_id" id="album_id" class="form-select" required>
                                    <option value="">Select an Album</option>
                                    @foreach ($albums as $id => $title)
                                        <option value="{{ $id }}" {{ old('album_id') == $id ? 'selected' : '' }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('album_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label for="images" class="form-label fw-bold">Images <span class="text-danger">*</span></label>
                                <input type="file" name="images[]" id="images" class="form-control" accept="image/jpeg,image/png,image/webp" multiple required>
                                <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, WebP. Max size per image: 2MB. Select multiple images.</small>
                                @error('images.*')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-3 d-flex flex-wrap gap-3"></div>
                            </div>

                            <!-- Shared Fields -->
                            <div class="mb-4">
                                <h5 class="fw-bold">Shared Settings for All Images</h5>
                                <!-- Status -->
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="status" id="status" class="form-check-input" value="1" {{ old('status') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Visible</label>
                                    <small class="form-text text-muted d-block">Check to make all images visible in the gallery.</small>
                                    @error('status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Sort Order -->
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Base Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                                    <small class="form-text text-muted">Higher numbers appear later. Incremented for each image (e.g., 10, 11, 12...).</small>
                                    @error('sort_order')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dynamic Image Fields -->
                            <div id="image-fields" class="mb-4">
                                <h5 class="fw-bold">Individual Image Details</h5>
                                <!-- Fields will be dynamically added here via JavaScript -->
                            </div>

                            <!-- Form Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span id="submit-text">Save Images</span>
                                    <span id="submit-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                                <a href="{{ route('admin.images.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('images').addEventListener('change', function (e) {
                const previewContainer = document.getElementById('image-preview');
                const fieldsContainer = document.getElementById('image-fields');
                previewContainer.innerHTML = '';
                fieldsContainer.innerHTML = '<h5 class="fw-bold">Individual Image Details</h5>';

                const files = e.target.files;
                if (files.length > 0) {
                    Array.from(files).forEach((file, index) => {
                        // Image Preview
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const preview = document.createElement('div');
                            preview.className = 'card p-2';
                            preview.style.width = '150px';
                            preview.innerHTML = `
                                <img src="${e.target.result}" class="card-img-top" style="max-height: 100px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            `;
                            previewContainer.appendChild(preview);
                        };
                        reader.readAsDataURL(file);

                        // Dynamic Fields for Each Image
                        const fieldSet = document.createElement('div');
                        fieldSet.className = 'card mb-3';
                        fieldSet.innerHTML = `
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Image ${index + 1}: ${file.name}</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="alt_${index}" class="form-label">Alt Text</label>
                                    <input type="text" name="images_data[${index}][alt]" id="alt_${index}" class="form-control" maxlength="255" value="${document.getElementById('alt')?.value || ''}">
                                </div>
                                <div class="mb-3">
                                    <label for="title_en_${index}" class="form-label">Title (English)</label>
                                    <input type="text" name="images_data[${index}][title_en]" id="title_en_${index}" class="form-control" maxlength="255" value="${document.getElementById('title_en')?.value || ''}">
                                </div>
                                <div class="mb-3">
                                    <label for="title_ar_${index}" class="form-label">Title (Arabic)</label>
                                    <input type="text" name="images_data[${index}][title_ar]" id="title_ar_${index}" class="form-control" maxlength="255" dir="rtl" value="${document.getElementById('title_ar')?.value || ''}">
                                </div>
                                <div class="mb-3">
                                    <label for="description_en_${index}" class="form-label">Description (English)</label>
                                    <textarea name="images_data[${index}][description_en]" id="description_en_${index}" class="form-control" rows="3">${document.getElementById('description_en')?.value || ''}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description_ar_${index}" class="form-label">Description (Arabic)</label>
                                    <textarea name="images_data[${index}][description_ar]" id="description_ar_${index}" class="form-control" rows="3" dir="rtl">${document.getElementById('description_ar')?.value || ''}</textarea>
                                </div>
                            </div>
                        `;
                        fieldsContainer.appendChild(fieldSet);
                    });
                }
            });

            // Show loading spinner on submit
            document.getElementById('image-upload-form').addEventListener('submit', function () {
                const submitBtn = document.getElementById('submit-btn');
                const submitText = document.getElementById('submit-text');
                const submitSpinner = document.getElementById('submit-spinner');
                submitBtn.disabled = true;
                submitText.classList.add('d-none');
                submitSpinner.classList.remove('d-none');
            });
        </script>
    @endpush
@endsection
