@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="card-body">

                        <!-- Flash messages -->
                        @if(session('status-success'))
                            <div class="alert alert-success">{{ session('status-success') }}</div>
                        @endif

                        @if(session('status-error'))
                            <div class="alert alert-danger">{{ session('status-error') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title pt-2">Product Subcategories</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.product_subcategories.create') }}" class="btn btn-primary">Add New</a>
                            </div>
                        </div>

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
                                                    <td>{{ $subcategory->id }}</td>
                                                    <td><img src="{{ asset('/' . $subcategory->image) }}" alt="image" width="60"></td>
                                                    <td>{{ $subcategory->name_en }}</td>
                                                    <td>{{ $subcategory->category->name_en ?? '—' }}</td>
                                                    <td>{!! Str::limit($subcategory->description_en, 100) !!}</td>
                                                    <td><span class="badge bg-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($subcategory->status) }}</span></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('admin.product_subcategories.edit', $subcategory->id) }}">Edit</a>
                                                        <form action="{{ route('admin.product_subcategories.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No subcategories found.</td>
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
                                                    <td>{{ $subcategory->id }}</td>
                                                    <td><img src="{{ asset('/' . $subcategory->image) }}" alt="image" width="60"></td>
                                                    <td>{{ $subcategory->name_ar }}</td>
                                                    <td>{{ $subcategory->category->name_ar ?? '—' }}</td>
                                                    <td>{!! Str::limit($subcategory->description_ar, 100) !!}</td>
                                                    <td><span class="badge bg-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($subcategory->status) }}</span></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('admin.product_subcategories.edit', $subcategory->id) }}">Edit</a>
                                                        <form action="{{ route('admin.product_subcategories.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No subcategories found.</td>
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
@endsection
