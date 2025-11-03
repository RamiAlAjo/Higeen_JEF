@extends('admin.layouts.app')

@section('title', 'Edit Gallery')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Album</h1>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Albums
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Album Information</h6>
        </div>
        <div class="card-body">
       <form action="{{ route('admin.gallery.update', $album->id) }}" method="POST">
    @csrf
    @method('PUT')

                <!-- Current Cover Image Preview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Current Cover Image</label>
                        <div class="border rounded p-3 text-center bg-light">
                            <img src="{{ asset($album->cover_image) }}"
                                 alt="{{ $album->album_name_en }}"
                                 class="img-fluid rounded"
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            <p class="mb-0 mt-2 text-muted small">{{ basename($album->cover_image) }}</p>
                        </div>
                    </div>
                </div>

                <!-- New Cover Image Upload -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cover_image" class="form-label">New Cover Image (Optional)</label>
                        <input type="file"
                               class="form-control @error('cover_image') is-invalid @enderror"
                               id="cover_image"
                               name="cover_image"
                               accept="image/*">
                        <small class="form-text text-muted">Max 2MB. JPG, PNG, GIF, WEBP (Leave empty to keep current)</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- English Fields Row -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="album_name_en" class="form-label">Album Name (English) <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('album_name_en') is-invalid @enderror"
                               id="album_name_en"
                               name="album_name_en"
                               value="{{ old('album_name_en', $album->album_name_en) }}"
                               required>
                        @error('album_name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="album_description_en" class="form-label">Description (English)</label>
                        <textarea class="form-control @error('album_description_en') is-invalid @enderror"
                                  id="album_description_en"
                                  name="album_description_en"
                                  rows="3">{{ old('album_description_en', $album->album_description_en) }}</textarea>
                        @error('album_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Arabic Fields Row -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="album_name_ar" class="form-label">اسم الألبوم (العربية) <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('album_name_ar') is-invalid @enderror"
                               id="album_name_ar"
                               name="album_name_ar"
                               value="{{ old('album_name_ar', $album->album_name_ar) }}"
                               dir="rtl"
                               required>
                        @error('album_name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="album_description_ar" class="form-label">الوصف (العربية)</label>
                        <textarea class="form-control @error('album_description_ar') is-invalid @enderror"
                                  id="album_description_ar"
                                  name="album_description_ar"
                                  rows="3"
                                  dir="rtl">{{ old('album_description_ar', $album->album_description_ar) }}</textarea>
                        @error('album_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Album
                        </button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
