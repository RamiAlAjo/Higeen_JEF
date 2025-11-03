@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="card-body">

                <h5 class="card-title">Add New Product Category</h5>

                <!-- Flash messages -->
                @if(session('status-success'))
                    <div class="alert alert-success">{{ session('status-success') }}</div>
                @endif

                @if(session('status-error'))
                    <div class="alert alert-danger">{{ session('status-error') }}</div>
                @endif

                <!-- Validation errors -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.product_categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="langTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-en" data-bs-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-ar" data-bs-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">Arabic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-image" data-bs-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">Image</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-status" data-bs-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">Status</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="langTabsContent">
                        <!-- English Tab -->
                        <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="tab-en">
                            <div class="form-group mb-3">
                                <label for="name_en">Name (EN)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_en">Description (EN)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en') }}</textarea>
                            </div>
                        </div>

                        <!-- Arabic Tab -->
                        <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="tab-ar">
                            <div class="form-group mb-3">
                                <label for="name_ar">Name (AR)</label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description_ar">Description (AR)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar') }}</textarea>
                            </div>
                        </div>

                        <!-- Image Tab -->
                        <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="tab-image">
                            <div class="form-group mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                        </div>

                        <!-- Status Tab -->
                        <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="tab-status">
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-group text-end mt-3">
                        <a href="{{ route('admin.product_categories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Show default tab (English) on page load
    const enTab = document.querySelector('#tab-en');
    if (enTab) new bootstrap.Tab(enTab).show();
</script>
@endsection
