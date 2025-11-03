@extends('admin.layouts.app')

@section('title', 'Why Us Sections')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Why Us Sections</h2>
        <a href="{{ route('admin.whyus.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Create New Section
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    @if($sections->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle shadow-sm">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Page Title (EN)</th>
                        <th>Page Title (AR)</th>
                        <th>Page Description (EN)</th>
                        <th>Page Description (AR)</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $index => $section)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ Str::limit($section->why_us_page_title_en ?? '-', 50) }}</td>
                            <td>{{ Str::limit($section->why_us_page_title_ar ?? '-', 50) }}</td>
                            <td>{!! Str::limit($section->why_us_page_description_en ?? '-', 100) !!}</td>
                            <td>{!! Str::limit($section->why_us_page_description_ar ?? '-', 100) !!}</td>
                            <td class="text-center">
    @if($section->why_us_page_images)
        @foreach($section->why_us_page_images as $img)
            <img src="{{ asset(path: '' . $img) }}" alt="Page Image" class="img-thumbnail me-1 mb-1" style="height: 40px;">
        @endforeach
    @else
        <span class="text-muted">No images</span>
    @endif
</td>

                            <td class="text-center">
                                <a href="{{ route('admin.whyus.edit', $section->id) }}" class="btn btn-sm btn-primary mb-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.whyus.destroy', $section->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sections->links() }}
        </div>
    @else
        <div class="alert alert-info shadow-sm">No Why Us Sections found.</div>
    @endif
</div>
@endsection
