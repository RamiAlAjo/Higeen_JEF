@extends('admin.layouts.app')

@section('title', 'Edit About Section')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Edit About Section</h2>
        <a href="{{ route('admin.about-sections.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('status-success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('status-success') }}</div>
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

    <form action="{{ route('admin.about-sections.update', $aboutSection) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab" aria-controls="en" aria-selected="true">English</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar" type="button" role="tab" aria-controls="ar" aria-selected="false">Arabic</button>
            </li>
        </ul>

        <div class="tab-content" id="langTabsContent">
            {{-- English Tab --}}
            <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <h5 class="mb-4 text-primary fw-bold">About Section (EN)</h5>

                    <div class="mb-3">
                        <label for="heading_en" class="form-label fw-semibold">Heading</label>
                        <input
                            type="text"
                            name="heading_en"
                            class="form-control @error('heading_en') is-invalid @enderror"
                            id="heading_en"
                            placeholder="Enter Heading"
                            value="{{ old('heading_en', $aboutSection->heading_en) }}">
                        @error('heading_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle_en" class="form-label fw-semibold">Subtitle</label>
                        <input
                            type="text"
                            name="subtitle_en"
                            class="form-control @error('subtitle_en') is-invalid @enderror"
                            id="subtitle_en"
                            placeholder="Enter Subtitle"
                            value="{{ old('subtitle_en', $aboutSection->subtitle_en) }}">
                        @error('subtitle_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="highlight_word_en" class="form-label fw-semibold">Highlight Word</label>
                        <input
                            type="text"
                            name="highlight_word_en"
                            class="form-control @error('highlight_word_en') is-invalid @enderror"
                            id="highlight_word_en"
                            placeholder="Enter Highlight Word"
                            value="{{ old('highlight_word_en', $aboutSection->highlight_word_en) }}">
                        @error('highlight_word_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="paragraph_en" class="form-label fw-semibold">Paragraph</label>
                        <textarea
                            name="paragraph_en"
                            class="form-control summernote @error('paragraph_en') is-invalid @enderror"
                            id="paragraph_en"
                            placeholder="Enter Paragraph">{{ old('paragraph_en', $aboutSection->paragraph_en) }}</textarea>
                        @error('paragraph_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Arabic Tab --}}
            <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                <div class="card shadow-sm rounded-3 p-4 mb-4" dir="rtl">
                    <h5 class="mb-4 text-primary fw-bold">قسم من نحن</h5>

                    <div class="mb-3">
                        <label for="heading_ar" class="form-label fw-semibold text-end d-block">العنوان</label>
                        <input
                            type="text"
                            name="heading_ar"
                            class="form-control text-end @error('heading_ar') is-invalid @enderror"
                            id="heading_ar"
                            placeholder="أدخل العنوان"
                            value="{{ old('heading_ar', $aboutSection->heading_ar) }}">
                        @error('heading_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle_ar" class="form-label fw-semibold text-end d-block">العنوان الفرعي</label>
                        <input
                            type="text"
                            name="subtitle_ar"
                            class="form-control text-end @error('subtitle_ar') is-invalid @enderror"
                            id="subtitle_ar"
                            placeholder="أدخل العنوان الفرعي"
                            value="{{ old('subtitle_ar', $aboutSection->subtitle_ar) }}">
                        @error('subtitle_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="highlight_word_ar" class="form-label fw-semibold text-end d-block">الكلمة المميزة</label>
                        <input
                            type="text"
                            name="highlight_word_ar"
                            class="form-control text-end @error('highlight_word_ar') is-invalid @enderror"
                            id="highlight_word_ar"
                            placeholder="أدخل الكلمة المميزة"
                            value="{{ old('highlight_word_ar', $aboutSection->highlight_word_ar) }}">
                        @error('highlight_word_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="paragraph_ar" class="form-label fw-semibold text-end d-block">الفقرة</label>
                        <textarea
                            name="paragraph_ar"
                            class="form-control summernote text-end @error('paragraph_ar') is-invalid @enderror"
                            id="paragraph_ar"
                            placeholder="أدخل الفقرة">{{ old('paragraph_ar', $aboutSection->paragraph_ar) }}</textarea>
                        @error('paragraph_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-3 p-4 mb-5">
            <h5 class="mb-4 text-primary fw-bold">Upload Images</h5>
            <div class="row gy-4">
                <div class="col-md-6">
                    <label for="main_image" class="form-label fw-semibold">Main Image</label>
                    <input
                        type="file"
                        name="main_image"
                        class="form-control @error('main_image') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(event, 'mainImagePreview')">
                    <img id="mainImagePreview" src="{{ $aboutSection->main_image ? asset($aboutSection->main_image) : 'https://via.placeholder.com/300x150?text=Main+Image' }}" alt="{{ $aboutSection->main_image_alt ?? 'Main Image' }}" class="img-fluid mt-3 rounded border shadow-sm" style="max-height: 150px; object-fit: contain;">
                    <div class="mt-2">
                        <label for="main_image_alt" class="form-label fw-semibold">Main Image Alt Text</label>
                        <input
                            type="text"
                            name="main_image_alt"
                            class="form-control @error('main_image_alt') is-invalid @enderror"
                            id="main_image_alt"
                            placeholder="Enter Main Image Alt Text"
                            value="{{ old('main_image_alt', $aboutSection->main_image_alt) }}">
                        @error('main_image_alt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @error('main_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="small_image" class="form-label fw-semibold">Small Image</label>
                    <input
                        type="file"
                        name="small_image"
                        class="form-control @error('small_image') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(event, 'smallImagePreview')">
                    <img id="smallImagePreview" src="{{ $aboutSection->small_image ? asset($aboutSection->small_image) : 'https://via.placeholder.com/150?text=Small+Image' }}" alt="{{ $aboutSection->small_image_alt ?? 'Small Image' }}" class="img-fluid mt-3 rounded border shadow-sm" style="max-height: 150px; object-fit: contain;">
                    <div class="mt-2">
                        <label for="small_image_alt" class="form-label fw-semibold">Small Image Alt Text</label>
                        <input
                            type="text"
                            name="small_image_alt"
                            class="form-control @error('small_image_alt') is-invalid @enderror"
                            id="small_image_alt"
                            placeholder="Enter Small Image Alt Text"
                            value="{{ old('small_image_alt', $aboutSection->small_image_alt) }}">
                        @error('small_image_alt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @error('small_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success btn-lg px-5 fw-semibold shadow-sm">
                <i class="fas fa-save me-2"></i> Update
            </button>
        </div>
    </form>
</div>

<style>
    /* Smooth input focus effect */
    input.form-control, textarea.form-control {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input.form-control:focus, textarea.form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        outline: none;
    }

    /* Button hover */
    .btn-outline-primary:hover {
        background-color: #0d6efd;
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

        // Reinitialize Arabic Summernote with RTL and Arabic language support
        $('#paragraph_ar').summernote('destroy').summernote({
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

    function previewImage(event, id) {
        if (event.target.files.length === 0) return;
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById(id).src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
