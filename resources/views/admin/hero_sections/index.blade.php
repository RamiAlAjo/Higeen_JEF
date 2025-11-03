@extends('admin.layouts.app')

@section('title', 'Create About Us')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Hero Sections</h1>
        <a href="{{ route('admin.hero_section.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Hero Section
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    @if($heroSections->count())
        <table class="table table-hover shadow-sm rounded">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Page</th>
                    <th>Title (EN)</th>
                    <th>Title (AR)</th>
                    <th>Button Text (EN)</th>
                    <th>Button Text (AR)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($heroSections as $section)
                <tr>
                    <td>{{ $section->id }}</td>
                    <td>{{ $section->page }}</td>
                    <td>{{ Str::limit($section->title_en, 30) }}</td>
                    <td>{{ Str::limit($section->title_ar, 30) }}</td>
                    <td>{{ $section->button_text_en }}</td>
                    <td>{{ $section->button_text_ar }}</td>
                    <td>
                        @if($section->image)
                            <img src="{{ asset('' . $section->image) }}" alt="Image" style="max-height: 50px; max-width: 80px; object-fit: contain;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.hero_section.edit', $section) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.hero_section.destroy', $section) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this hero section?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $heroSections->links() }}
        </div>
    @else
        <p class="text-muted">No hero sections found. <a href="{{ route('admin.hero_section.create') }}">Create one now.</a></p>
    @endif
</div>
@endsection
