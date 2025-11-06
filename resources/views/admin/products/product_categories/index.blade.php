{{-- resources/views/admin/products/product_categories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Product Categories')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Product Categories</h3>
                        <a href="{{ route('admin.product_categories.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Add New Category
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Success Message -->
                        @if (session('status-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Validation Errors -->
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

                        <!-- Categories Table -->
                        @if ($categories->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">No product categories found.</p>
                                <a href="{{ route('admin.product_categories.create') }}" class="btn btn-primary">Add Category Now</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name (EN)</th>
                                            <th scope="col">Name (AR)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Slug</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                                </td>
                                                <td>
                                                    @if ($category->image)
                                                        <img src="{{ asset($category->image) }}"
                                                             alt="{{ $category->name_en }}"
                                                             class="img-thumbnail"
                                                             style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-image text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $category->name_en }}</td>
                                                <td>{{ $category->name_ar }}</td>
                                                <td>
                                                    <span class="badge bg-{{
                                                        $category->status == 'active' ? 'success' :
                                                        ($category->status == 'inactive' ? 'danger' : 'warning')
                                                    }}">
                                                        {{ ucfirst($category->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <code class="small">{{ Str::limit($category->slug, 25) }}</code>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.product_categories.edit', $category) }}"
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.product_categories.destroy', $category) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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

                            <!-- Bootstrap 5 Pagination -->
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
