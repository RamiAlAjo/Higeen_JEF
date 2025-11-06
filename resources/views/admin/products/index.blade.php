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
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="card-body">

                        <!-- Success / Error Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Search & Filter Form -->
                        <form method="GET" action="{{ route('admin.products.index') }}" class="mt-3 mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="en-tab" data-bs-toggle="tab" href="#en" role="tab"
                                   aria-controls="en" aria-selected="true">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ar-tab" data-bs-toggle="tab" href="#ar" role="tab"
                                   aria-controls="ar" aria-selected="false">Arabic</a>
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
                                                <th>Images</th>
                                                <th>Name (EN)</th>
                                                <th>Description (EN)</th>
                                                <th>Category</th>
                                                <th>Subcategory</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $product)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                                                            @foreach(array_slice($product->image, 0, 3) as $image)
                                                                <img src="/uploads/products/{{ basename($image) }}"
                                                                     alt="Product Image"
                                                                     class="img-thumbnail me-1 mb-1"
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @endforeach
                                                            @if(count($product->image) > 3)
                                                                <span class="small text-muted">+{{ count($product->image) - 3 }}</span>
                                                            @endif
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="fw-semibold">{{ $product->product_name_en }}</td>
                                                    <td>{!! Str::limit($product->description_en ?? '', 80) !!}</td>
                                                    <td>{{ $product->category->name_en ?? '—' }}</td>
                                                    <td>{{ $product->subcategory->name_en ?? '—' }}</td>
                                                    <td>
                                                        @if($product->price)
                                                            <strong>{{ number_format($product->price, 2) }}</strong> JOD
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
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
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                               class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModalEN{{ $product->id }}"
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Delete Confirmation Modal (EN) -->
                                                        <div class="modal fade" id="deleteModalEN{{ $product->id }}" tabindex="-1"
                                                             aria-labelledby="deleteModalLabelEN{{ $product->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('admin.products.destroy', $product) }}"
                                                                      method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabelEN{{ $product->id }}">
                                                                                Delete Product
                                                                            </h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete "<strong>{{ $product->product_name_en }}</strong>"?
                                                                            <br><small>This action cannot be undone.</small>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted py-5">
                                                        <i class="fas fa-box-open fa-2x mb-3"></i><br>
                                                        No products found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if ($products->hasPages())
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                                                <th>Images</th>
                                                <th>Name (AR)</th>
                                                <th>Description (AR)</th>
                                                <th>Category</th>
                                                <th>Subcategory</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $product)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                                                            @foreach(array_slice($product->image, 0, 3) as $image)
                                                                <img src="/uploads/products/{{ basename($image) }}"
                                                                     alt="Product Image"
                                                                     class="img-thumbnail me-1 mb-1"
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @endforeach
                                                            @if(count($product->image) > 3)
                                                                <span class="small text-muted">+{{ count($product->image) - 3 }}</span>
                                                            @endif
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="fw-semibold" dir="rtl">{{ $product->product_name_ar }}</td>
                                                    <td dir="rtl">{!! Str::limit($product->description_ar ?? '', 80) !!}</td>
                                                    <td>{{ $product->category->name_ar ?? '—' }}</td>
                                                    <td>{{ $product->subcategory->name_ar ?? '—' }}</td>
                                                    <td>
                                                        @if($product->price)
                                                            <strong>{{ number_format($product->price, 2) }}</strong> JOD
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $product->quantity }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{
                                                            $product->status == 'active' ? 'success' :
                                                            ($product->status == 'inactive' ? 'danger' : 'warning')
                                                        }}">
                                                            {{ $product->status == 'active' ? 'فعّال' : ($product->status == 'inactive' ? 'معطل' : 'معلق') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                               class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModalAR{{ $product->id }}"
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Delete Confirmation Modal (AR) -->
                                                        <div class="modal fade" id="deleteModalAR{{ $product->id }}" tabindex="-1"
                                                             aria-labelledby="deleteModalLabelAR{{ $product->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('admin.products.destroy', $product) }}"
                                                                      method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabelAR{{ $product->id }}">
                                                                                Delete Product
                                                                            </h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body" dir="rtl">
                                                                            هل أنت متأكد من حذف المنتج "<strong>{{ $product->product_name_ar }}</strong>"؟
                                                                            <br><small>لا يمكن التراجع عن هذا الإجراء.</small>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                                            <button type="submit" class="btn btn-danger">نعم، احذف</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted py-5">
                                                        <i class="fas fa-box-open fa-2x mb-3"></i><br>
                                                        لا توجد منتجات.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination (Shared) -->
                                @if ($products->hasPages())
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
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
