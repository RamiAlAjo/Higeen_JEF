{{-- resources/views/admin/shipping_areas/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add Shipping Area')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        Add New Shipping Area
                    </h3>
                    <a href="{{ route('admin.shipping-areas.index') }}" class="btn btn-light btn-sm">
                        Back to List
                    </a>
                </div>
                <div class="card-body">

                    <!-- Success Message -->
                    @if (session('status-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.shipping-areas.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- English Name -->
                            <div class="col-md-6">
                                <label for="name_en" class="form-label">Name (English) <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name_en"
                                       id="name_en"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       value="{{ old('name_en') }}"
                                       placeholder="e.g. Amman"
                                       required>
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Arabic Name -->
                            <div class="col-md-6">
                                <label for="name_ar" class="form-label">Name (Arabic) <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name_ar"
                                       id="name_ar"
                                       class="form-control @error('name_ar') is-invalid @enderror"
                                       value="{{ old('name_ar') }}"
                                       placeholder="مثال: عمان"
                                       dir="rtl"
                                       required>
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cost -->
                            <div class="col-md-6">
                                <label for="cost" class="form-label">Shipping Cost (NIS) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">NIS</span>
                                    <input type="number"
                                           name="cost"
                                           id="cost"
                                           step="0.01"
                                           min="0"
                                           class="form-control @error('cost') is-invalid @enderror"
                                           value="{{ old('cost', '0.00') }}"
                                           required>
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Available in checkout)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-5 d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.shipping-areas.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save Area
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
