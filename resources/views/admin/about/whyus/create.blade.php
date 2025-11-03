{{-- resources/views/admin/about/whyus/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Create Why Us Section')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Create Why Us Section</h2>
        <a href="{{ route('admin.whyus.index') }}" class="btn btn-outline-secondary">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Whoops!</strong> Please fix the errors below.
        </div>
    @endif

    <form action="{{ route('admin.whyus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="about_us_id" value="{{ $aboutUs->id ?? 1 }}">

        <div class="card p-4 shadow-sm mb-5">
            <h5 class="text-primary fw-bold mb-3">Why Us Pages</h5>
            <div id="whyUsPagesContainer"></div>
            <button type="button" class="btn btn-outline-primary mt-3" onclick="addWhyUsPage()">
                + Add Page
            </button>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-5 fw-semibold">Save</button>
        </div>
    </form>
</div>

{{-- CKEditor 5 CDN + Styles --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.4.2/build/ckeditor.css">
<style>
    :root { --brand: #A13A28; }
    .invalid-feedback { display: none; color: #dc3545; font-size: .875rem; }
    .is-invalid ~ .invalid-feedback { display: block; }
    .ck.ck-editor__editable { min-height: 160px; }
    .ck.ck-button:not(.ck-disabled):hover,
    .ck.ck-button.ck-on { background: var(--brand) !important; color: white !important; }
    .ck.ck-toolbar { background: #f8f9fa; border-color: #dee2e6; }
</style>

<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.4.2/build/ckeditor.js"></script>

<script>
    let pageIndex = 0;
    const oldPages = @json(old('pages', []));
    const validationErrors = @json($errors->messages());
    const editors = {};

    function addWhyUsPage(pageData = {}) {
        const container = document.getElementById('whyUsPagesContainer');
        const idx = pageIndex++;

        const enId = `desc-en-${idx}`;
        const arId = `desc-ar-${idx}`;

        const html = `
        <div class="border p-4 mb-4 rounded bg-light position-relative page-group" data-index="${idx}">
            <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                    onclick="removePage(${idx})"></button>

            <!-- Title EN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Title (EN)</label>
                <input type="text" name="pages[${idx}][title_en]" class="form-control"
                       value="${escapeHtml(pageData.title_en || '')}" required>
                <div class="invalid-feedback" data-field="title_en"></div>
            </div>

            <!-- Title AR -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Title (AR)</label>
                <input type="text" name="pages[${idx}][title_ar]" class="form-control text-end"
                       value="${escapeHtml(pageData.title_ar || '')}" required>
                <div class="invalid-feedback" data-field="title_ar"></div>
            </div>

            <!-- Description EN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Description (EN)</label>
                <div id="${enId}">${escapeHtml(pageData.description_en || '')}</div>
                <textarea name="pages[${idx}][description_en]" id="${enId}-hidden" style="display:none;"></textarea>
                <div class="invalid-feedback" data-field="description_en"></div>
            </div>

            <!-- Description AR -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Description (AR)</label>
                <div id="${arId}" dir="rtl">${escapeHtml(pageData.description_ar || '')}</div>
                <textarea name="pages[${idx}][description_ar]" id="${arId}-hidden" style="display:none;"></textarea>
                <div class="invalid-feedback" data-field="description_ar"></div>
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Images (multiple)</label>
                <input type="file" name="pages[${idx}][images][]" class="form-control" multiple accept="image/*">
                <div class="invalid-feedback" data-field="images"></div>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', html);

        // Initialize Editors
        initEditor(enId, 'en', 'ltr', pageData.description_en || '');
        initEditor(arId, 'ar', 'rtl', pageData.description_ar || '');

        showErrorsForIndex(idx);
    }

    function initEditor(elementId, lang, dir, initialData) {
        ClassicEditor
            .create(document.getElementById(elementId), {
                toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList', '|', 'link', 'insertImage', '|', 'undo', 'redo'],
                language: lang,
                direction: dir,
                initialData: initialData
            })
            .then(editor => {
                editors[elementId] = editor;

                // Sync on every change
                editor.model.document.on('change:data', () => {
                    const hidden = document.getElementById(elementId + '-hidden');
                    if (hidden) hidden.value = editor.getData();
                });

                // Also sync on blur (safe fallback)
                editor.editing.view.document.on('blur', () => {
                    const hidden = document.getElementById(elementId + '-hidden');
                    if (hidden) hidden.value = editor.getData();
                });
            })
            .catch(err => console.error('CKEditor Error:', err));
    }

    function removePage(idx) {
        const page = document.querySelector(`.page-group[data-index="${idx}"]`);
        if (page) {
            const enId = `desc-en-${idx}`;
            const arId = `desc-ar-${idx}`;
            if (editors[enId]) editors[enId].destroy().catch(() => {});
            if (editors[arId]) editors[arId].destroy().catch(() => {});
            delete editors[enId];
            delete editors[arId];
            page.remove();
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showErrorsForIndex(idx) {
        const page = document.querySelector(`.page-group[data-index="${idx}"]`);
        if (!page) return;
        const prefix = `pages.${idx}.`;
        Object.keys(validationErrors).forEach(key => {
            if (key.startsWith(prefix)) {
                const field = key.replace(prefix, '');
                const feedback = page.querySelector(`[data-field="${field}"]`);
                if (feedback) {
                    feedback.textContent = validationErrors[key][0];
                    const input = feedback.previousElementSibling;
                    if (input && input.tagName !== 'DIV') input.classList.add('is-invalid');
                    feedback.style.display = 'block';
                }
            }
        });
    }

    // On load
    document.addEventListener('DOMContentLoaded', () => {
        if (oldPages.length > 0) {
            oldPages.forEach(page => addWhyUsPage(page));
        } else {
            addWhyUsPage();
        }
    });

    // FORCE SYNC ALL EDITORS ON FORM SUBMIT
    document.querySelector('form').addEventListener('submit', function (e) {
        Object.keys(editors).forEach(id => {
            const editor = editors[id];
            const hidden = document.getElementById(id + '-hidden');
            if (editor && hidden) {
                hidden.value = editor.getData();
            }
        });
    });
</script>
@endsection
