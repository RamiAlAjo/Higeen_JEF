{{-- resources/views/admin/about/whyus/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Why Us Section')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Edit Why Us Section</h2>
        <a href="{{ route('admin.whyus.index') }}" class="btn btn-outline-secondary">
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Whoops!</strong> Please fix the errors below.
        </div>
    @endif

    <form action="{{ route('admin.whyus.update', $aboutUs->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="about_us_id" value="{{ $aboutUs->id }}">

        <div class="card p-4 shadow-sm mb-5">
            <h5 class="text-primary fw-bold mb-3">Why Us Pages</h5>
            <div id="whyUsPagesContainer">
                {{-- Pages injected by JS --}}
            </div>
            <button type="button" class="btn btn-outline-primary mt-3" onclick="addWhyUsPage()">
                + Add New Page
            </button>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-5 fw-semibold">Update</button>
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
    .existing-image { position: relative; display: inline-block; margin: 5px; }
    .existing-image img { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; }
    .existing-image .btn-delete { position: absolute; top: -8px; right: -8px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.4.2/build/ckeditor.js"></script>

<script>
    let pageIndex = 0;
    const existingPages = @json($whyUsSections ?? []);
    const oldPages = @json(old('pages', []));
    const validationErrors = @json($errors->messages());
    const editors = {};

    function addWhyUsPage(pageData = {}, isExisting = false) {
        const container = document.getElementById('whyUsPagesContainer');
        const idx = pageIndex++;

        const enId = `desc-en-${idx}`;
        const arId = `desc-ar-${idx}`;

        const html = `
        <div class="border p-4 mb-4 rounded bg-light position-relative page-group" data-index="${idx}" data-id="${isExisting ? pageData.id : ''}">
            <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                    onclick="removePage(${idx})"></button>

            ${isExisting ? `<input type="hidden" name="pages[${idx}][id]" value="${pageData.id}">` : ''}

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

            <!-- Existing Images -->
            ${pageData.images ? `
            <div class="mb-3">
                <label class="form-label fw-semibold">Current Images</label>
                <div class="d-flex flex-wrap gap-2">
                    ${pageData.images.map((img, i) => `
                        <div class="existing-image">
                            <img src="${asset(img)}" alt="Image ${i+1}">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle btn-delete"
                                    onclick="deleteImage(this, '${idx}', '${img}')">×</button>
                            <input type="hidden" name="pages[${idx}][existing_images][]" value="${img}">
                        </div>
                    `).join('')}
                </div>
            </div>` : ''}

            <!-- New Images -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Add New Images</label>
                <input type="file" name="pages[${idx}][images][]" class="form-control" multiple accept="image/*">
                <div class="invalid-feedback" data-field="images"></div>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', html);

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
                const sync = () => {
                    const hidden = document.getElementById(elementId + '-hidden');
                    if (hidden) hidden.value = editor.getData();
                };
                editor.model.document.on('change:data', sync);
                editor.editing.view.document.on('blur', sync);
            })
            .catch(err => console.error(err));
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

    function deleteImage(btn, pageIdx, imagePath) {
        btn.parentElement.remove();
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

    document.addEventListener('DOMContentLoaded', () => {
        const pagesToLoad = oldPages.length > 0 ? oldPages : existingPages.map(sec => ({
            id: sec.id,
            title_en: sec.why_us_page_title_en,
            title_ar: sec.why_us_page_title_ar,
            description_en: sec.why_us_page_description_en,
            description_ar: sec.why_us_page_description_ar,
            images: sec.why_us_page_images
        }));

        pagesToLoad.forEach((page, i) => addWhyUsPage(page, oldPages.length === 0));
        if (pagesToLoad.length === 0) addWhyUsPage();
    });

    document.querySelector('form').addEventListener('submit', () => {
        Object.keys(editors).forEach(id => {
            const editor = editors[id];
            const hidden = document.getElementById(id + '-hidden');
            if (editor && hidden) hidden.value = editor.getData();
        });
    });
</script>
@endsection
