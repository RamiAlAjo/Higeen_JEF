@extends('admin.layouts.app')

@section('title', 'Edit Image')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Edit Image</h3>
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
                        <form id="image-edit-form" action="{{ route('admin.images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Current Image Preview -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Current Image</label>
                                @if ($image->image)
                                    <div class="card p-2" style="width: 150px;">
                                        <img src="{{ asset('storage/uploads/' . $image->image) }}" class="card-img-top" style="max-height: 100px; object-fit: cover;" alt="{{ $image->alt ?? 'Gallery Image' }}">
                                        <div class="card-body p-2">
                                            <small class="text-muted">{{ $image->image }}</small>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">No image uploaded.</p>
                                @endif
                            </div>

                            <!-- Album Selection -->
                            <div class="mb-4">
                                <label for="album_id" class="form-label fw-bold">Album <span class="text-danger">*</span></label>
                                <select name="album_id" id="album_id" class="form-select" required>
                                    <option value="">Select an Album</option>
                                    @foreach ($albums as $id => $title)
                                        <option value="{{ $id }}" {{ old('album_id', $image->album_id) == $id ? 'selected' : '' }}>
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
                                <label for="image" class="form-label fw-bold">Replace Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                                <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, WebP. Max size: 2MB. Leave blank to keep the current image.</small>
                                @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-3 d-flex flex-wrap gap-3"></div>
                            </div>

                            <!-- Alt Text -->
                            <div class="mb-4">
                                <label for="alt" class="form-label fw-bold">Alt Text</label>
                                <input type="text" name="alt" id="alt" class="form-control" value="{{ old('alt', $image->alt) }}" maxlength="255">
                                <small class="form-text text-muted">Alt text for accessibility (optional).</small>
                                @error('alt')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Title (English) -->
                            <div class="mb-4">
                                <label for="title_en" class="form-label fw-bold">Title (English)</label>
                                <input type="text" name="title_en" id="title_en" class="form-control" value="{{ old('title_en', $image->title_en) }}" maxlength="255">
                                @error('title_en')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Title (Arabic) -->
                            <div class="mb-4">
                                <label for="title_ar" class="form-label fw-bold">Title (Arabic)</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control" value="{{ old('title_ar', $image->title_ar) }}" maxlength="255" dir="rtl">
                                @error('title_ar')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description (English) -->
                            <div class="mb-4">
                                <label for="description_en" class="form-label fw-bold">Description (English)</label>
                                <textarea name="description_en" id="description_en" class="form-control" rows="4">{{ old('description_en', $image->description_en) }}</textarea>
                                @error('description_en')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description (Arabic) -->
                            <div class="mb-4">
                                <label for="description_ar" class="form-label fw-bold">Description (Arabic)</label>
                                <textarea name="description_ar" id="description_ar" class="form-control" rows="4" dir="rtl">{{ old('description_ar', $image->description_ar) }}</textarea>
                                @error('description_ar')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <div class="form-check">
                                    <input type="checkbox" name="status" id="status" class="form-check-input" value="1" {{ old('status', $image->status) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Visible</label>
                                    <small class="form-text text-muted d-block">Check to make the image visible in the gallery.</small>
                                </div>
                                @error('status')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div class="mb-4">
                                <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $image->sort_order) }}" min="0">
                                <small class="form-text text-muted">Higher numbers appear later in the gallery.</small>
                                @error('sort_order')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Form Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span id="submit-text">Update Image</span>
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
            // Image preview for new image
            document.getElementById('image').addEventListener('change', function (e) {
                const previewContainer = document.getElementById('image-preview');
                previewContainer.innerHTML = '';

                const file = e.target.files[0];
                if (file) {
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
                }
            });

            // Show loading spinner on submit
            document.getElementById('image-edit-form').addEventListener('submit', function () {
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
