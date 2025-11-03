@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title">Edit Product Subcategory</h5>

                <!-- Flash messages -->
                @if(session('status-success'))
                    <div class="alert alert-success">{{ session('status-success') }}</div>
                @endif

                @if(session('status-error'))
                    <div class="alert alert-danger">{{ session('status-error') }}</div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.product_subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="subcategoryEditTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="edit-tab-en" data-bs-toggle="tab" data-bs-target="#edit-en" type="button" role="tab" aria-controls="edit-en" aria-selected="true">English</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-tab-ar" data-bs-toggle="tab" data-bs-target="#edit-ar" type="button" role="tab" aria-controls="edit-ar" aria-selected="false">Arabic</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-tab-category" data-bs-toggle="tab" data-bs-target="#edit-category" type="button" role="tab" aria-controls="edit-category" aria-selected="false">Category</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-tab-image" data-bs-toggle="tab" data-bs-target="#edit-image" type="button" role="tab" aria-controls="edit-image" aria-selected="false">Image</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-tab-status" data-bs-toggle="tab" data-bs-target="#edit-status" type="button" role="tab" aria-controls="edit-status" aria-selected="false">Status</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="subcategoryEditTabsContent">
                        <!-- English Tab -->
                        <div class="tab-pane fade show active" id="edit-en" role="tabpanel" aria-labelledby="edit-tab-en">
                            <div class="form-group mb-3">
                                <label for="name_en">Name (EN)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $subcategory->name_en) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_en">Description (EN)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en', $subcategory->description_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Arabic Tab -->
                        <div class="tab-pane fade" id="edit-ar" role="tabpanel" aria-labelledby="edit-tab-ar">
                            <div class="form-group mb-3">
                                <label for="name_ar">Name (AR)</label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $subcategory->name_ar) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_ar">Description (AR)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar', $subcategory->description_ar) }}</textarea>
                            </div>
                        </div>

                        <!-- Category Tab -->
                        <div class="tab-pane fade" id="edit-category" role="tabpanel" aria-labelledby="edit-tab-category">
                            <div class="form-group mb-3">
                                <label for="category_id">Parent Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Image Tab -->
                        <div class="tab-pane fade" id="edit-image" role="tabpanel" aria-labelledby="edit-tab-image">
                            <div class="form-group mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control-file">
                                @if($subcategory->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $subcategory->image) }}" alt="Image" width="100">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Tab -->
                        <div class="tab-pane fade" id="edit-status" role="tabpanel" aria-labelledby="edit-tab-status">
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ old('status', $subcategory->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $subcategory->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="pending" {{ old('status', $subcategory->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-group text-end">
                        <a href="{{ route('admin.product_subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Subcategory</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Show default tab on load
    var firstTabEl = document.querySelector('#edit-tab-en');
    if (firstTabEl) {
        var tab = new bootstrap.Tab(firstTabEl);
        tab.show();
    }
</script>
@endsection
