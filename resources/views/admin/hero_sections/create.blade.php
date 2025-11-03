@extends('admin.layouts.app')

@section('title', 'Create Hero Section')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Create Hero Section</h2>
        <a href="{{ route('admin.hero_section.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger shadow-sm rounded">
            <strong>There were some problems:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.hero_section.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="mb-4">
            <label for="page" class="form-label fw-semibold">Page Name (Identifier)</label>
            <select name="page" id="page" class="form-select @error('page') is-invalid @enderror">
                <option value="">-- Select Page --</option>
                @foreach($pages as $key => $label)
                    <option value="{{ $key }}" {{ old('page') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('page')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Select the page where this hero section will appear.</small>
        </div>

        <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab" aria-controls="en" aria-selected="true">English</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar" type="button" role="tab" aria-controls="ar" aria-selected="false">Arabic</button>
            </li>
        </ul>

        <div class="tab-content" id="langTabsContent">
            <!-- English Tab -->
            <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <h5 class="mb-4 text-primary fw-bold">Hero Section (English)</h5>

                    <div class="mb-3">
                        <label for="title_en" class="form-label fw-semibold">Title</label>
                        <input
                            type="text"
                            name="title_en"
                            id="title_en"
                            class="form-control @error('title_en') is-invalid @enderror"
                            placeholder="Enter Title in English"
                            value="{{ old('title_en') }}">
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label fw-semibold">Description</label>
                        <textarea
                            name="description_en"
                            id="description_en"
                            class="form-control summernote @error('description_en') is-invalid @enderror"
                            placeholder="Enter Description in English">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="button_text_en" class="form-label fw-semibold">Button Text</label>
                        <input
                            type="text"
                            name="button_text_en"
                            id="button_text_en"
                            class="form-control @error('button_text_en') is-invalid @enderror"
                            placeholder="Enter Button Text in English"
                            value="{{ old('button_text_en') }}">
                        @error('button_text_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Arabic Tab -->
            <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                <div class="card shadow-sm rounded-3 p-4 mb-4" dir="rtl">
                    <h5 class="mb-4 text-primary fw-bold">قسم البطل (العربية)</h5>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label fw-semibold text-end d-block">العنوان</label>
                        <input
                            type="text"
                            name="title_ar"
                            id="title_ar"
                            class="form-control text-end @error('title_ar') is-invalid @enderror"
                            placeholder="أدخل العنوان بالعربية"
                            value="{{ old('title_ar') }}">
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label fw-semibold text-end d-block">الوصف</label>
                        <textarea
                            name="description_ar"
                            id="description_ar"
                            class="form-control summernote text-end @error('description_ar') is-invalid @enderror"
                            placeholder="أدخل الوصف بالعربية">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="button_text_ar" class="form-label fw-semibold text-end d-block">نص الزر</label>
                        <input
                            type="text"
                            name="button_text_ar"
                            id="button_text_ar"
                            class="form-control text-end @error('button_text_ar') is-invalid @enderror"
                            placeholder="أدخل نص الزر بالعربية"
                            value="{{ old('button_text_ar') }}">
                        @error('button_text_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-3 p-4 mb-5">
            <h5 class="mb-4 text-primary fw-bold">Upload Hero Image</h5>
            <div class="mb-3">
                <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control @error('image') is-invalid @enderror"
                    accept="image/*"
                    onchange="previewImage(event, 'imagePreview')">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <img id="imagePreview" src="{{ asset('uploads/default.jpg') }}" alt="Hero Image Preview" class="img-fluid mt-3 rounded border shadow-sm" style="max-height: 300px; object-fit: contain;">
            </div>
        </div>

        <div class="mb-4">
            <label for="button_link" class="form-label fw-semibold">Button Link URL</label>
            <input
                type="url"
                name="button_link"
                id="button_link"
                class="form-control @error('button_link') is-invalid @enderror"
                placeholder="https://example.com"
                value="{{ old('button_link') }}">
            @error('button_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success btn-lg px-5 fw-semibold shadow-sm">
                <i class="fas fa-save me-2"></i> Save
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event, previewId) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    input.form-control, textarea.form-control {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input.form-control:focus, textarea.form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        outline: none;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
            lang: 'en-US',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#description_ar').summernote({
            height: 150,
            lang: 'ar-AR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            direction: 'rtl'
        });
    });
</script>
@endsection
