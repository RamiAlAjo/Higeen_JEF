{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Products</h3>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-sm">
                            Add New Product
                        </a>
                    </div>
                    <div class="card-body">

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Search & Filter -->
                        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-5">
                                    <select name="category_id" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Products Table -->
                        @if ($products->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <p class="text-muted h5">No products found.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    Add Your First Product
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Images</th>
                                            <th>Name (EN)</th>
                                            <th>Name (AR)</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                                </td>
                                                <td>
                                                    @if($product->image && count($product->image) > 0)
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach(array_slice($product->image, 0, 3) as $image)
                                                                <img src="{{ asset($image) }}"
                                                                     alt="Product"
                                                                     class="img-thumbnail"
                                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                            @endforeach
                                                            @if(count($product->image) > 3)
                                                                <div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded"
                                                                     style="width: 60px; height: 60px; font-size: 0.85rem;">
                                                                    +{{ count($product->image) - 3 }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-image text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold">{{ $product->product_name_en }}</td>
                                                <td dir="rtl">{{ $product->product_name_ar }}</td>
                                                <td>{{ $product->category->name_en ?? '—' }}</td>
                                                <td>
                                                    <strong>{{ number_format($product->price ?? 0, 2) }}</strong> NIS
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $product->quantity }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{
                                                        $product->status == 'active' ? 'success' :
                                                        ($product->status == 'inactive' ? 'danger' : 'warning')
                                                    }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.products.edit', $product) }}"
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this product?\nThis action cannot be undone.');"
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm"
                                                                    title="Delete">
                                                                Delete
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
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
