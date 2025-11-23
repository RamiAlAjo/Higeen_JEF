{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

{{-- Clean any leftover modal backdrop --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    });
</script>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h3 class="card-title mb-0 fw-bold">
                        <i class="fas fa-boxes me-2"></i> Products Management
                    </h3>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>

                        <button class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-download"></i> Import from Hesabate
                        </button>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- Success & Error Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Empty State --}}
                    @if ($products->isEmpty())
                        <div class="text-center py-5 my-5">
                            <i class="fas fa-box-open fa-5x text-muted mb-4"></i>
                            <h5 class="text-muted">No products found</h5>
                            <p class="text-muted mb-4">Start by adding your first product or importing from Hesabate.</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="fas fa-download"></i> Import from Hesabate
                                </button>
                            </div>
                        </div>

                    @else
                        {{-- Products Table --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">#</th>
                                        <th>Image</th>
                                        <th>Name (EN)</th>
                                        <th>Name (AR)</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Source</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-muted small">
                                                {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                            </td>

                                            {{-- Main Image --}}
                                            <td>
                                                <img src="{{ $product->main_image }}"
                                                     alt="{{ $product->product_name_en }}"
                                                     class="rounded shadow-sm"
                                                     style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #eee;">
                                            </td>

                                            <td class="fw-semibold">
                                                {{ Str::limit($product->product_name_en, 35) }}
                                            </td>

                                            <td dir="rtl" class="text-end text-muted">
                                                {{ Str::limit($product->product_name_ar, 35) }}
                                            </td>

                                            <td>
                                                <span class="text-primary small">
                                                    {{ $product->category->name_en ?? '—' }}
                                                </span>
                                            </td>

                                            <td>
                                                <strong class="text-success">
                                                    {{ number_format($product->price, 2) }} NIS
                                                </strong>
                                            </td>

                                            <td>
                                                @if($product->quantity > 0)
                                                    <span class="badge bg-success fs-6 px-3">{{ $product->quantity }}</span>
                                                @else
                                                    <span class="badge bg-danger fs-6 px-3">Out of Stock</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>

                                            {{-- SOURCE COLUMN - No migration needed! --}}
                                            <td>
                                                @if($product->hesabate_id)
                                                    <span class="badge bg-info text-white px-3 py-2">
                                                        <i class="fas fa-cloud me-1"></i> Hesabate
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">
                                                        <i class="fas fa-user-edit me-1"></i> Manual
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                       class="btn btn-warning btn-sm shadow-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this product permanently?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm shadow-sm"
                                                                title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ====================================================== --}}
{{-- ===================== IMPORT MODAL ===================== --}}
{{-- ====================================================== --}}

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-cloud-download-alt me-2"></i> Import Products from Hesabate
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted">
                    This will sync and import products directly from your Hesabate account.
                </p>

                <div class="mb-3">
                    <label for="proIdsInput" class="form-label fw-semibold">Specific Product IDs (optional)</label>
                    <input type="text"
                           id="proIdsInput"
                           class="form-control form-control-lg"
                           placeholder="e.g. 123, 456, 789"
                           aria-describedby="helpId">
                    <div id="helpId" class="form-text">Leave empty to import all updated products.</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" id="startImportBtn" class="btn btn-primary px-4">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                    <i class="fas fa-download"></i> Start Import
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ====================================================== --}}
{{-- ===================== IMPORT SCRIPT =================== --}}
{{-- ====================================================== --}}

<script>
document.getElementById('startImportBtn')?.addEventListener('click', function () {
    const btn = this;
    const spinner = btn.querySelector('.spinner-border');
    const input = document.getElementById('proIdsInput');
    const ids = input.value.trim();

    btn.disabled = true;
    spinner.classList.remove('d-none');

    fetch("{{ route('admin.products.import') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({ pro_id: ids || null })
    })
    .then(r => r.json())
    .then(data => {
        const msg = data.message || (data.success ? "Import completed successfully!" : "Import failed.");
        alert(msg);

        if (data.success) {
            setTimeout(() => location.reload(), 1200);
        }
    })
    .catch(err => {
        console.error("Import error:", err);
        alert("Connection error. Please try again or check server logs.");
    })
    .finally(() => {
        btn.disabled = false;
        spinner.classList.add('d-none');
        bootstrap.Modal.getInstance(document.getElementById('importModal'))?.hide();
    });
});
</script>

@endsection
