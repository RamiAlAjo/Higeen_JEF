@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="gallery"/>

<h2 class="section-title">{{ __('gallery.title') }}</h2>

<div class="parent" role="list">
    @foreach ($albums as $album)
        <div class="album" role="listitem" tabindex="0" data-album="album{{ $album->id }}">
            <div class="album-inner">
                <img src="{{ $album->cover_image ? asset($album->cover_image) : asset('placeholder_image.png') }}"
                     alt="{{ app()->getLocale() === 'ar' ? ($album->album_name_ar ?? 'Album ' . $album->id) : ($album->album_name_en ?? 'Album ' . $album->id) }}"
                     class="clickable-image" loading="lazy" role="button" aria-haspopup="dialog" aria-label="{{ __('gallery.open_album', ['album' => app()->getLocale() === 'ar' ? ($album->album_name_ar ?? 'Album ' . $album->id) : ($album->album_name_en ?? 'Album ' . $album->id)]) }}">
                <div class="album-title">
                    {{ app()->getLocale() === 'ar' ? ($album->album_name_ar ?? 'Album ' . $album->id) : ($album->album_name_en ?? 'Album ' . $album->id) }}
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($albums->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $albums->links('pagination::bootstrap-5') }}
    </div>
@endif

<!-- Enhanced Modal Popup -->
<div id="imageModal" class="modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalAlbumTitle" aria-describedby="caption imageCounter">
    <div class="modal-inner" role="document">
        <button class="close" title="{{ __('gallery.close') }} [Esc]" aria-label="{{ __('gallery.close') }}">&times;</button>

        <div class="modal-header">
            <h3 id="modalAlbumTitle"></h3>
        </div>

        <img class="modal-content" id="modalImage" alt="" tabindex="0">

        <div class="modal-caption">
            <div id="caption" class="image-name"></div>
            <div id="imageCounter"></div>
        </div>

        <div class="modal-thumbnails">
            <div id="thumbnailContainer" class="thumbnail-container"></div>
        </div>

        <div class="modal-nav">
            <button id="prevBtn" class="nav-btn" title="{{ __('gallery.previous') }} [←]" aria-label="{{ __('gallery.previous') }}">&#10094;</button>
            <button id="nextBtn" class="nav-btn" title="{{ __('gallery.next') }} [→]" aria-label="{{ __('gallery.next') }}">&#10095;</button>
            <a id="downloadBtn" class="nav-btn download-btn" title="{{ __('gallery.download') }}" download aria-label="{{ __('gallery.download') }}">
                ⬇️ {{ __('gallery.download') }}
            </a>
        </div>
    </div>
</div>


<style>
    /* Page Title */
    .section-title {
        color: #8b3a2b;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        font-size: 2.5rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Gallery Grid */
    .parent {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 15px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        height: auto;
    }

    .album {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .album:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .album-inner {
        position: relative;
    }

    .clickable-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .album:hover .clickable-image {
        transform: scale(1.05);
    }

    .album-title {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 10px;
        text-align: center;
        font-size: 1rem;
        font-weight: 500;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .album:hover .album-title {
        opacity: 1;
    }

    /* Pagination (Bootstrap 5 Customization) */
    .pagination .page-item .page-link {
        background: #f8f9fa;
        color: #8b3a2b;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin: 0 3px;
        padding: 8px 14px;
        font-size: 1rem;
        transition: background-color 0.2s, color 0.2s;
    }

    .pagination .page-item.active .page-link {
        background: #8b3a2b;
        color: #fff;
        border-color: #8b3a2b;
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }

    .pagination .page-item .page-link:hover:not(.disabled) {
        background: #72301f;
        color: #fff;
        border-color: #72301f;
    }

    /* Modal Overlay */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease;
    }

    .modal.show {
        display: flex;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-inner {
        position: relative;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        width: 90%;
        max-width: 900px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: scaleIn 0.3s ease;
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Modal Header */
    .modal-header {
        margin-bottom: 15px;
    }

    #modalAlbumTitle {
        font-size: 1.5rem;
        color: #8b3a2b;
        font-weight: 600;
        margin: 0;
    }

    /* Modal Image */
    .modal-content {
        max-width: 100%;
        max-height: 60vh;
        border-radius: 8px;
        transition: transform 0.3s ease;
        cursor: zoom-in;
        outline: none;
    }

    @media (hover: hover) {
        .modal-content:hover {
            transform: scale(1.02);
        }
    }

    /* Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 30px;
        color: #666;
        cursor: pointer;
        background: none;
        border: none;
        transition: color 0.2s;
        padding: 0;
        line-height: 1;
    }

    .close:hover,
    .close:focus {
        color: #f44336;
        outline: none;
    }

    /* Caption and Counter */
    .modal-caption {
        margin-top: 15px;
        color: #333;
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-name {
        flex: 1;
        text-align: left;
        font-weight: 500;
        color: #8b3a2b;
    }

    #imageCounter {
        text-align: right;
    }

    /* Thumbnails */
    .modal-thumbnails {
        margin-top: 15px;
        max-height: 100px;
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px 0;
    }

    .thumbnail-container {
        display: inline-flex;
        gap: 10px;
    }

    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.2s ease;
    }

    .thumbnail.active {
        border: 2px solid #8b3a2b;
    }

    .thumbnail:hover {
        border: 2px solid #8b3a2b;
    }

    /* Navigation Buttons */
    .modal-nav {
        margin-top: 15px;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .nav-btn {
        padding: 10px 20px;
        font-size: 1rem;
        background: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .nav-btn:hover,
    .nav-btn:focus {
        background: #ddd;
        color: #000;
        outline: none;
    }

    .download-btn {
        text-decoration: none;
        background: #8b3a2b;
        color: #fff;
    }

    .download-btn:hover,
    .download-btn:focus {
        background: #72301f;
        outline: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }

        .modal-inner {
            padding: 15px;
            width: 95%;
        }

        .modal-content {
            max-height: 50vh;
        }

        .modal-caption {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .parent {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .album {
            height: auto;
        }

        .clickable-image {
            height: 200px;
        }
    }

    @media (max-width: 480px) {
        .modal-thumbnails {
            max-height: 60px;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
        }

        .nav-btn {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .pagination .page-item .page-link {
            padding: 6px 10px;
            font-size: 0.9rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const albums = @json($albumsData);
    const albumNames = @json($albums->mapWithKeys(function ($album) {
        return ['album' . $album->id => app()->getLocale() === 'ar' ? ($album->album_name_ar ?? 'Album ' . $album->id) : ($album->album_name_en ?? 'Album ' . $album->id)];
    })->toArray());

    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    const imageCounter = document.getElementById('imageCounter');
    const downloadBtn = document.getElementById('downloadBtn');
    const closeBtn = document.querySelector('.close');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const modalAlbumTitle = document.getElementById('modalAlbumTitle');
    const thumbnailContainer = document.getElementById('thumbnailContainer');

    let currentAlbum = null;
    let currentIndex = 0;
    let currentAlbumKey = null;

    function openModal(albumKey, index) {
        currentAlbumKey = albumKey;
        currentAlbum = albums[albumKey];
        currentIndex = index;
        const image = currentAlbum[currentIndex];

        // Update modal content
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        modalImg.src = image.src;
        modalImg.alt = image.alt;
        captionText.textContent = image.alt; // Displays image name (title_en/title_ar or alt)
        imageCounter.textContent = `${currentIndex + 1} of ${currentAlbum.length}`;
        downloadBtn.href = image.src;
        modalAlbumTitle.textContent = albumNames[albumKey];

        // Generate thumbnails
        thumbnailContainer.innerHTML = '';
        currentAlbum.forEach((img, i) => {
            const thumb = document.createElement('img');
            thumb.src = img.src;
            thumb.alt = img.alt;
            thumb.classList.add('thumbnail');
            if (i === currentIndex) {
                thumb.classList.add('active');
            }
            thumb.addEventListener('click', () => {
                openModal(albumKey, i);
            });
            thumbnailContainer.appendChild(thumb);
        });

        modalImg.focus();
    }

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % currentAlbum.length;
        openModal(currentAlbumKey, currentIndex);
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + currentAlbum.length) % currentAlbum.length;
        openModal(currentAlbumKey, currentIndex);
    }

    // Bind album click events
    document.querySelectorAll('.album').forEach(album => {
        album.addEventListener('click', () => {
            const albumKey = album.getAttribute('data-album');
            if (albums[albumKey] && albums[albumKey].length > 0) {
                openModal(albumKey, 0);
            }
        });
    });

    // Button handlers
    closeBtn.addEventListener('click', closeModal);
    nextBtn.addEventListener('click', showNext);
    prevBtn.addEventListener('click', showPrev);

    // Click outside modal-inner to close
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Keyboard navigation
    window.addEventListener('keydown', function (e) {
        if (modal.classList.contains('show')) {
            if (e.key === 'Escape') {
                closeModal();
            } else if (e.key === 'ArrowRight') {
                showNext();
            } else if (e.key === 'ArrowLeft') {
                showPrev();
            }
        }
    });
});
</script>

@endsection
