@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="card-body">
                        <!-- Flash messages -->
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title pt-2">Products</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New</a>
                            </div>
                        </div>

                        <!-- Search and Filter Form -->
                        <form method="GET" action="{{ route('admin.products.index') }}" class="mt-3 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="category_id" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->product_name_en ?? $category->name ?? 'Category ' . $category->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs mt-3" id="languageTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="en-tab" data-bs-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ar-tab" data-bs-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">Arabic</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="languageTabsContent">
                            <!-- English Tab -->
                            <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Images</th>
                                                <th>Name (EN)</th>
                                                <th>Description (EN)</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>
                                                        @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                                                            @foreach($product->image as $image)
                                                                <img src="{{ Storage::url($image) }}" alt="Product Image" width="60" class="img-thumbnail me-2 mb-2">
                                                            @endforeach
                                                        @else
                                                            <span>No Images</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->product_name_en }}</td>
                                                    <td>{!! Str::limit($product->description_en ?? '', 100) !!}</td>
                                                    <td>{{ $product->category->product_name_en ?? $product->category->name ?? 'N/A' }}</td>
                                                    <td>{{ $product->price ? number_format($product->price, 2) : 'N/A' }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'secondary' : 'warning') }}">
                                                            {{ ucfirst($product->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalEN{{ $product->id }}">Delete</button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="deleteModalEN{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabelEN{{ $product->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabelEN{{ $product->id }}">Delete Confirmation</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete the product "{{ $product->product_name_en }}"?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No products found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Arabic Tab -->
                            <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Images</th>
                                                <th>Name (AR)</th>
                                                <th>Description (AR)</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>
                                                        @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                                                            @foreach($product->image as $image)
                                                                <img src="{{ Storage::url($image) }}" alt="Product Image" width="60" class="img-thumbnail me-2 mb-2">
                                                            @endforeach
                                                        @else
                                                            <span>No Images</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->product_name_ar }}</td>
                                                    <td>{!! Str::limit($product->description_ar ?? '', 100) !!}</td>
                                                    <td>{{ $product->category->product_name_ar ?? $product->category->name_ar ?? 'N/A' }}</td>
                                                    <td>{{ $product->price ? number_format($product->price, 2) : 'N/A' }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'secondary' : 'warning') }}">
                                                            {{ ucfirst($product->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalAR{{ $product->id }}">Delete</button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="deleteModalAR{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabelAR{{ $product->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabelAR{{ $product->id }}">Delete Confirmation</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete the product "{{ $product->product_name_ar }}"?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No products found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- End tab content -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script>
    // Enable tab functionality
    var myTabs = new bootstrap.Tab(document.querySelector('#ar-tab'));
</script>
@endsection
