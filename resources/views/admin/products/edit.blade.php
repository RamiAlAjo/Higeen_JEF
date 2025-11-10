@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title">Edit Product</h5>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Custom Error -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Edit Form -->
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Language Tabs -->
                    <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="en-tab" data-bs-toggle="tab" href="#en" role="tab">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ar-tab" data-bs-toggle="tab" href="#ar" role="tab">Arabic</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="languageTabsContent">

                        <!-- English Tab -->
                        <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                            <div class="mb-3">
                                <label for="product_name_en" class="form-label">Product Name (EN) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('product_name_en') is-invalid @enderror"
                                       name="product_name_en"
                                       value="{{ old('product_name_en', $product->product_name_en) }}" required>
                                @error('product_name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description_en" class="form-label">Description (EN)</label>
                                <textarea class="form-control @error('description_en') is-invalid @enderror"
                                          name="description_en" rows="4">{{ old('description_en', $product->description_en) }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Arabic Tab -->
                        <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                            <div class="mb-3">
                                <label for="product_name_ar" class="form-label">Product Name (AR) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('product_name_ar') is-invalid @enderror"
                                       name="product_name_ar"
                                       value="{{ old('product_name_ar', $product->product_name_ar) }}" >
                                @error('product_name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description_ar" class="form-label">Description (AR)</label>
                                <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                          name="description_ar" rows="4">{{ old('description_ar', $product->description_ar) }}</textarea>
                                @error('description_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Existing Images -->
                    @if($product->images && $product->images->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Current Images</label>
                            <div class="row g-3">
                                @foreach($product->images as $image)
                                    <div class="col-md-3 position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Product image"
                                             class="img-thumbnail"
                                             style="width: 100%; height: 150px; object-fit: cover;">
                                        <a href="{{ route('admin.products.images.destroy', [$product, $image]) }}"
                                           class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                           onclick="return confirm('Delete this image?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- New Image Upload -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Add More Images</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror"
                               name="images[]" accept="image/*" multiple>
                        <small class="form-text text-muted">Max 50MB each. Leave empty to keep current images.</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" >
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en ?? $category->product_name_en ?? 'Unnamed' }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subcategory -->
                    <div class="mb-3">
                        <label for="subcategory_id" class="form-label">Subcategory</label>
                        <select class="form-control @error('subcategory_id') is-invalid @enderror" name="subcategory_id">
                            <option value="">-- Optional --</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                    {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name_en ?? $subcategory->product_name_en ?? 'Unnamed' }}
                                </option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('status', $product->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                               name="slug" value="{{ old('slug', $product->slug) }}">
                        <small class="form-text text-muted">Leave blank to auto-generate from English name.</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (N) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                               name="price" value="{{ old('price', $product->price) }}" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                               name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
