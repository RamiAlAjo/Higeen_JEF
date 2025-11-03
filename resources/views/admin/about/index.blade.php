@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">About Us</h5>
                    @if($aboutUs)
                        <span class="badge bg-success d-flex align-items-center gap-1 py-2 px-3 fs-6">
                            <i class="bi bi-check-circle-fill"></i> Entry Exists
                        </span>
                    @else
                        <a href="{{ route('admin.about.create') }}" class="btn btn-light btn-sm d-flex align-items-center gap-1 fw-semibold shadow-sm">
                            <i class="bi bi-plus-lg"></i> Add New
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    {{-- Alerts --}}
                    @if(session('status-success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                            {{ session('status-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('status-error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
                            {{ session('status-error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Language Tabs --}}
                    <ul class="nav nav-tabs fw-semibold mb-4" id="langTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab" aria-controls="en" aria-selected="true">
                                English
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar" type="button" role="tab" aria-controls="ar" aria-selected="false">
                                العربية
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="langTabsContent">
                        {{-- ENGLISH TAB --}}
                        <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                            @if(!$aboutUs)
                                <div class="text-center text-muted py-5 bg-light rounded shadow-sm">
                                    <i class="bi bi-info-circle fs-1 mb-3"></i>
                                    <p class="fs-5">No About Us data found.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle shadow-sm">
                                        <tbody>
                                            <tr>
                                                <th class="w-25">Title</th>
                                                <td>{{ $aboutUs->about_us_title_en }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <td>{!! $aboutUs->about_us_description_en !!}</td>
                                            </tr>
                                            <tr>
                                                <th>Features</th>
                                                <td>
                                                    @php
                                                        $featuresEn = is_string($aboutUs->features_en) ? json_decode($aboutUs->features_en, true) : $aboutUs->features_en;
                                                    @endphp
                                                    @if(is_array($featuresEn) && count($featuresEn))
                                                        <ul class="list-unstyled mb-0 ps-3">
                                                            @foreach($featuresEn as $feature)
                                                                <li class="mb-1 d-flex align-items-center">
                                                                    <i class="{{ $feature['icon'] ?? 'bi bi-check-circle-fill' }} text-success me-2"></i>
                                                                    <span>{{ $feature['text'] ?? $feature }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <em class="text-muted">No features added.</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Slider Title</th>
                                                <td>{{ $aboutUs->slider_title_en }}</td>
                                            </tr>
                                            <tr>
                                                <th>Slider Description</th>
                                                <td>
                                                    @php
                                                        $sliderDescEn = is_string($aboutUs->slider_description_en) ? json_decode($aboutUs->slider_description_en, true) : $aboutUs->slider_description_en;
                                                    @endphp
                                                    @if(is_array($sliderDescEn) && count($sliderDescEn))
                                                        <ul class="list-unstyled mb-0 ps-3">
                                                            @foreach($sliderDescEn as $desc)
                                                                <li class="mb-1">{!! $desc !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <em class="text-muted">No slider descriptions added.</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Slider Icon</th>
                                                <td>
                                                    @if($aboutUs->slider_icon)
                                                        @if(Str::startsWith($aboutUs->slider_icon, 'bi '))
                                                            <i class="{{ $aboutUs->slider_icon }} fs-4 me-2"></i>
                                                            <code class="bg-light p-1 rounded">{{ $aboutUs->slider_icon }}</code>
                                                        @else
                                                            <img src="{{ asset('' . $aboutUs->slider_icon) }}" alt="Slider Icon" class="img-thumbnail rounded shadow-sm" style="max-width: 50px;">
                                                        @endif
                                                    @else
                                                        <em class="text-muted">No icon set</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Main Image</th>
                                                <td>
                                                    @if($aboutUs->about_main_image)
                                                        <img src="{{ asset('' . $aboutUs->about_main_image) }}" alt="Main Image" class="img-thumbnail rounded shadow-sm" style="max-width: 150px;">
                                                    @else
                                                        <em class="text-muted">No image uploaded</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="bg-light">
                                                <td colspan="2" class="text-end">
                                                    <a href="{{ route('admin.about.edit', $aboutUs->id) }}" class="btn btn-info btn-sm me-2">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.about.destroy', $aboutUs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        {{-- ARABIC TAB --}}
                        <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab" dir="rtl">
                            @if(!$aboutUs)
                                <div class="text-center text-muted py-5 bg-light rounded shadow-sm">
                                    <i class="bi bi-info-circle fs-1 mb-3"></i>
                                    <p class="fs-5">لم يتم العثور على بيانات من نحن.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle text-end shadow-sm">
                                        <tbody>
                                            <tr>
                                                <th class="w-25">العنوان</th>
                                                <td>{{ $aboutUs->about_us_title_ar }}</td>
                                            </tr>
                                            <tr>
                                                <th>الوصف</th>
                                                <td>{!! $aboutUs->about_us_description_ar !!}</td>
                                            </tr>
                                            <tr>
                                                <th>الميزات</th>
                                                <td>
                                                    @php
                                                        $featuresAr = is_string($aboutUs->features_ar) ? json_decode($aboutUs->features_ar, true) : $aboutUs->features_ar;
                                                    @endphp
                                                    @if(is_array($featuresAr) && count($featuresAr))
                                                        <ul class="list-unstyled mb-0 pe-3">
                                                            @foreach($featuresAr as $feature)
                                                                <li class="mb-1 d-flex align-items-center">
                                                                    <i class="{{ $feature['icon'] ?? 'bi bi-check-circle-fill' }} text-success ms-2"></i>
                                                                    <span>{{ $feature['text'] ?? $feature }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <em class="text-muted">لم تتم إضافة ميزات.</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>عنوان السلايدر</th>
                                                <td>{{ $aboutUs->slider_title_ar }}</td>
                                            </tr>
                                            <tr>
                                                <th>وصف السلايدر</th>
                                                <td>
                                                    @php
                                                        $sliderDescAr = is_string($aboutUs->slider_description_ar) ? json_decode($aboutUs->slider_description_ar, true) : $aboutUs->slider_description_ar;
                                                    @endphp
                                                    @if(is_array($sliderDescAr) && count($sliderDescAr))
                                                        <ul class="list-unstyled mb-0 pe-3">
                                                            @foreach($sliderDescAr as $desc)
                                                                <li class="mb-1">{!! $desc !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <em class="text-muted">لم تتم إضافة وصف للسلايدر.</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>أيقونة السلايدر</th>
                                                <td>
                                                    @if($aboutUs->slider_icon)
                                                        @if(Str::startsWith($aboutUs->slider_icon, 'bi '))
                                                            <i class="{{ $aboutUs->slider_icon }} fs-4 ms-2"></i>
                                                            <code class="bg-light p-1 rounded">{{ $aboutUs->slider_icon }}</code>
                                                        @else
                                                            <img src="{{ asset('' . $aboutUs->slider_icon) }}" alt="Slider Icon" class="img-thumbnail rounded shadow-sm" style="max-width: 50px;">
                                                        @endif
                                                    @else
                                                        <em class="text-muted">لم يتم تعيين أيقونة</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>الصورة الرئيسية</th>
                                                <td>
                                                    @if($aboutUs->about_main_image)
                                                        <img src="{{ asset('' . $aboutUs->about_main_image) }}" alt="الصورة الرئيسية" class="img-thumbnail rounded shadow-sm" style="max-width: 150px;">
                                                    @else
                                                        <em class="text-muted">لم يتم تحميل صورة</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="bg-light">
                                                <td colspan="2" class="text-end">
                                                    <a href="{{ route('admin.about.edit', $aboutUs->id) }}" class="btn btn-info btn-sm me-2">
                                                        <i class="bi bi-pencil-square"></i> تعديل
                                                    </a>
                                                    <form action="{{ route('admin.about.destroy', $aboutUs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العنصر؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i> حذف
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div> {{-- tab-content --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-unstyled li i {
        font-size: 1.1rem;
        vertical-align: middle;
    }
    [dir="rtl"] .list-unstyled li i {
        margin-left: 8px;
        margin-right: 0;
    }
    .table th {
        background-color: #f8f9fa;
        color: #333;
    }
    .table td {
        vertical-align: middle;
    }
    .img-thumbnail {
        border-radius: 8px;
    }
</style>
@endsection
