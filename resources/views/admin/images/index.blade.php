@extends('admin.layouts.app')

@section('title', 'Gallery Images')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Gallery Images</h3>
                        <a href="{{ route('admin.images.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Add New Images
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

                        <!-- Images Table -->
                        @if ($images->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">No images found.</p>
                                <a href="{{ route('admin.images.create') }}" class="btn btn-primary">Add Images Now</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Album</th>
                                            <th scope="col">Title (EN)</th>
                                            <th scope="col">Title (AR)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Sort Order</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($images as $image)
                                            <tr>
                                                <td>{{ $loop->iteration + ($images->currentPage() - 1) * $images->perPage() }}</td>
                                                <td>
                                                    @if ($image->image)
                                                        <img src="{{ asset('' . $image->image) }}" alt="{{ $image->alt ?? 'Gallery Image' }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $image->album->album_name_en ?? $image->album->album_name_ar ?? $image->album_id }}</td>
                                                <td>{{ $image->title_en ?? '-' }}</td>
                                                <td>{{ $image->title_ar ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $image->status ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $image->status ? 'Visible' : 'Hidden' }}
                                                    </span>
                                                </td>
                                                <td>{{ $image->sort_order }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.images.edit', $image->id) }}" class="btn btn-warning btn-sm" title="Edit Image">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Image">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $images->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
