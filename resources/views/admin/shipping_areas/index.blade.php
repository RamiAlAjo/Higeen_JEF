@extends('admin.layouts.app')

@section('title', 'Shipping Areas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Shipping Areas</h3>
                    <a href="{{ route('admin.shipping-areas.create') }}" class="btn btn-light btn-sm">
                        Add Area
                    </a>
                </div>
                <div class="card-body">

                    @if (session('status-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('status-error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('status-error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name (EN)</th>
                                    <th>Name (AR)</th>
                                    <th>Cost (JOD)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($areas as $area)
                                    <tr>
                                        <td>{{ $loop->iteration + ($areas->currentPage() - 1) * $areas->perPage() }}</td>
                                        <td>{{ $area->name_en }}</td>
                                        <td>{{ $area->name_ar }}</td>
                                        <td><strong>{{ number_format($area->cost, 2) }}</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $area->is_active ? 'success' : 'secondary' }}">
                                                {{ $area->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.shipping-areas.edit', $area) }}"
                                                   class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.shipping-areas.destroy', $area) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this area?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No shipping areas found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($areas->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $areas->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
