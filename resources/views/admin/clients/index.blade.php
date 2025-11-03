@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Clients Management</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search by name or email" id="searchInput" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-light" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="genderFilter">
                                    <option value="">All Genders</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" id="areaFilter" placeholder="Filter by area" value="{{ request('area') }}">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm w-100" onclick="applyFilters()">Apply Filters</button>
                            </div>
                        </div>
                    </div>

                    <!-- Clients Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Area</th>
                                    <th>Gender</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->phone_number ?? 'N/A' }}</td>
                                        <td>{{ $client->area ?? 'N/A' }}</td>
                                        <td>{{ $client->gender ? ucfirst($client->gender) : 'N/A' }}</td>
                                        <td>{{ $client->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No clients found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .table th {
        font-weight: 500;
    }
    .alert {
        border-radius: 0.5rem;
    }
</style>

<script>
    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const gender = document.getElementById('genderFilter').value;
        const area = document.getElementById('areaFilter').value;

        let url = '{{ route("admin.clients.index") }}?';
        if (search) url += `search=${encodeURIComponent(search)}&`;
        if (gender) url += `gender=${gender}&`;
        if (area) url += `area=${encodeURIComponent(area)}&`;

        window.location.href = url;
    }

    // Search on enter
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
</script>
@endsection
