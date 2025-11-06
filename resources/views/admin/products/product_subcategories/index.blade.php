{{-- resources/views/admin/products/product_subcategories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Product Subcategories')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Product Subcategories</h3>
                        <a href="{{ route('admin.product_subcategories.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Add New Subcategory
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

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs mt-3" id="languageTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="en-tab" data-bs-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">
                                    English
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ar-tab" data-bs-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">
                                    Arabic
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="languageTabsContent">

                            <!-- English Tab -->
                            <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name (EN)</th>
                                                <th>Category</th>
                                                <th>Description (EN)</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($subcategories as $subcategory)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration + ($subcategories->currentPage() - 1) * $subcategories->perPage() }}
                                                    </td>
                                                    <td>
                                                        @if ($subcategory->image)
                                                            <img src="{{ asset($subcategory->image) }}"
                                                                 alt="{{ $subcategory->name_en }}"
                                                                 class="img-thumbnail"
                                                                 style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $subcategory->name_en }}</td>
                                                    <td>{{ $subcategory->category->name_en ?? '—' }}</td>
                                                    <td>{!! Str::limit($subcategory->description_en, 80) !!}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($subcategory->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.product_subcategories.edit', $subcategory) }}"
                                                               class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.product_subcategories.destroy', $subcategory) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">No subcategories found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if ($subcategories->hasPages())
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $subcategories->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Arabic Tab -->
                            <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name (AR)</th>
                                                <th>Category</th>
                                                <th>Description (AR)</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($subcategories as $subcategory)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration + ($subcategories->currentPage() - 1) * $subcategories->perPage() }}
                                                    </td>
                                                    <td>
                                                        @if ($subcategory->image)
                                                            <img src="{{ asset($subcategory->image) }}"
                                                                 alt="{{ $subcategory->name_ar }}"
                                                                 class="img-thumbnail"
                                                                 style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $subcategory->name_ar }}</td>
                                                    <td>{{ $subcategory->category->name_ar ?? '—' }}</td>
                                                    <td>{!! Str::limit($subcategory->description_ar, 80) !!}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($subcategory->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.product_subcategories.edit', $subcategory) }}"
                                                               class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.product_subcategories.destroy', $subcategory) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">No subcategories found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination (Shared) -->
                                @if ($subcategories->hasPages())
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $subcategories->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
