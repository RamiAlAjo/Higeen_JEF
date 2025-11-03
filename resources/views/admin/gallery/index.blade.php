@extends('admin.layouts.app')

@section('title', 'Gallery Albums')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gallery Albums</h1>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Album
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Albums Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">All Albums</h6>
            <small class="text-muted">{{ $albums->total() }} album{{ $albums->total() !== 1 ? 's' : '' }}</small>
        </div>

        <div class="card-body">
            @if($albums->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="80">Cover</th>
                                <th scope="col">Album Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" width="130">Created</th>
                                <th scope="col" width="110" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($albums as $album)
                                <tr>
                                    <!-- Cover Image -->
                                    <td>
                                        <img src="{{ $album->cover_image
                                            ? asset($album->cover_image)
                                            : asset('images/default-placeholder.png') }}"
                                             alt="{{ $album->album_name_en }}"
                                             class="rounded img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             loading="lazy">
                                    </td>

                                    <!-- Album Name -->
                                    <td>
                                        <div class="fw-bold">{{ $album->album_name_en }}</div>
                                        <small class="text-muted d-block text-end" dir="rtl">
                                            {{ $album->album_name_ar }}
                                        </small>
                                    </td>

                                    <!-- Description -->
                                    <td>
                                        <div>{{ Str::limit($album->album_description_en ?? '—', 60) }}</div>
                                        <small class="text-muted d-block text-end" dir="rtl">
                                            {{ Str::limit($album->album_description_ar ?? '—', 60) }}
                                        </small>
                                    </td>

                                    <!-- Created At -->
                                    <td>
                                        <div class="small text-nowrap">
                                            {{ $album->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $album->created_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Album actions">
                                            <a href="{{ route('admin.gallery.edit', $album) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Edit Album">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.gallery.destroy', $album) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirmDelete(event, this)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete Album">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $albums->links('pagination::bootstrap-5') }}
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-4"></i>
                    <h5 class="text-muted">No albums found</h5>
                    <p class="text-muted mb-4">Start building your gallery by adding your first album.</p>
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary px-4">
                        <i class="fas fa-plus"></i> Create First Album
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(e, form) {
    e.preventDefault();

    Swal.fire({
        title: 'Delete Album?',
        text: "This will permanently delete the album and its cover image.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });

    return false;
}
</script>
@endsection
