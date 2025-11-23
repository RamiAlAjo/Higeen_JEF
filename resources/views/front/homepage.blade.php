@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="home"/>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  :root {
    --brown: #8B3A2B;
    --navy: #1E2E4F;
    --muted: #4b4b4b;
    --dot: rgba(139, 58, 43, 0.18);
    --card-shadow: 0 10px 22px rgba(30, 46, 79, 0.06);
    --fade: all 0.3s ease;
  }

  body {
    font-family: "Roboto", sans-serif;
    color: var(--muted);
  }

  .ABOUT-section {
    padding: 80px 0;
    background: #fff;
  }

  .ABOUT-inner {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 2rem;
    align-items: center;
  }

  .ABOUT-left {
    grid-column: span 6;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 360px;
    animation: fadeInLeft 0.8s ease;
  }

  .ABOUT-img-main {
    width: 320px;
    border-radius: 26px 12px 26px 12px;
    object-fit: cover;
    box-shadow: var(--card-shadow);
    transition: transform .3s ease;
    z-index:1;
  }

  .ABOUT-img-main:hover {
    transform: translateY(-6px) scale(1.02);
  }

  .ABOUT-img-small {
    position: absolute;
    right: -6%;
    bottom: 18%;
    width: 160px;
    height: 150px;
    border-radius: 18px;
    object-fit: cover;
    box-shadow: var(--card-shadow);
    z-index: 1;

  }

  .ABOUT-img-small:hover {
    transform: scale(1.04) rotate(0deg);
  }

.ABOUT-dotted {
  position: absolute;
  right: calc(24% - 36px);
  top: 10%;
  width: 40px;
  height: 180px;
  border-radius: 8px;
  background-image: radial-gradient(circle at center, rgba(139, 58, 43, 0.2) 4.5px, transparent 4.5px);
  background-size: 13px 12px;
  background-position: 0 0, 5px 5px;
  opacity: 1;
}

  .ABOUT-right {
    grid-column: span 6;
    padding: 6px 20px;
    animation: fadeInRight 0.8s ease;
  }

  .ABOUT-heading {
    color: var(--brown);
    font-family: "Poppins", sans-serif;
    font-weight: 700;
    font-size: 34px;
    margin-bottom: .5rem;
  }

  .ABOUT-subtitle {
    font-weight: 700;
    color: var(--navy);
    font-size: 21px;
    line-height: 1.4;
    margin-bottom: 16px;
  }

  .ABOUT-subtitle .ABOUT-highlight {
    color: var(--brown);
  }

  .ABOUT-paragraph {
    color: #555;
    line-height: 1.75;
    font-size: 16px;
    margin-bottom: 28px;
    max-width: 620px;
  }

  .ABOUT-values {
    display: flex;
    gap: 36px;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 8px;
  }

  .ABOUT-value {
    display: flex;
    gap: 12px;
    align-items: center;
    min-width: 140px;
  }

  .ABOUT-value-icon {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    border: 2px solid #eee;
    display: grid;
    place-items: center;
    background: linear-gradient(180deg, #fff, #fdfdfd);
    box-shadow: var(--card-shadow);
    color: var(--navy);
    font-size: 24px;
    transition: var(--fade);
  }

  .ABOUT-value-icon:hover {
    background: var(--brown);
    color: #fff;
    transform: scale(1.08);
  }

  .ABOUT-value-label {
    font-weight: 600;
    color: var(--navy);
    font-family: "Poppins", sans-serif;
    font-size: 17px;
  }

  .ABOUT-value-description {
    font-size: 13px;
    color: #6b6b6b;
  }

  /* Animations */
  @keyframes fadeInLeft {
    0% { opacity: 0; transform: translateX(-40px); }
    100% { opacity: 1; transform: translateX(0); }
  }

  @keyframes fadeInRight {
    0% { opacity: 0; transform: translateX(40px); }
    100% { opacity: 1; transform: translateX(0); }
  }

  /* Responsive */
  @media (max-width: 991.98px) {
    .ABOUT-inner {
      grid-template-columns: 1fr;
    }

    .ABOUT-left, .ABOUT-right {
      grid-column: 1 / -1;
    }

    .ABOUT-img-main {
      width: 70%;
      max-width: 420px;
    }

    .ABOUT-img-small {
      right: 6%;
      bottom: -6%;
      width: 44%;
      transform: translateY(6%);
    }

    .ABOUT-dotted {
      display: none;
    }

    .ABOUT-right {
      text-align: center;
      padding-top: 24px;
    }
  }

  @media (max-width: 575.98px) {
    .ABOUT-img-main {
      width: 85%;
    }

    .ABOUT-img-small {
      width: 56%;
      right: 2%;
    }

    .ABOUT-heading {
      font-size: 26px;
    }

    .ABOUT-subtitle {
      font-size: 16px;
    }

    .ABOUT-value-icon {
      width: 56px;
      height: 56px;
      font-size: 20px;
    }

    .ABOUT-value-label {
      font-size: 15px;
    }
  }
</style>

@if ($about)
<section class="ABOUT-section" aria-label="{{ __('home.about_section_aria') }}">
  <div class="container">
    <div class="ABOUT-inner">

      <!-- Images -->
      <div class="ABOUT-left" aria-hidden="true">
        <img
          class="ABOUT-img-main"
          src="{{ asset($about->main_image ?? 'uploads/default-main.jpg') }}"
          alt="{{ $about->main_image_alt ?? __('home.about_main_image_alt') }}"
        >
        <img
          class="ABOUT-img-small"
          src="{{ asset($about->small_image ?? 'uploads/default-small.jpg') }}"
          alt="{{ $about->small_image_alt ?? __('home.about_small_image_alt') }}"
        >
        <div class="ABOUT-dotted"></div>
      </div>

      <!-- Content -->
      <div class="ABOUT-right">
        <h3 class="ABOUT-heading">
          {{ app()->getLocale() === 'ar' ? ($about->heading_ar ?? __('home.about_heading')) : ($about->heading_en ?? __('home.about_heading')) }}
        </h3>

        <div class="ABOUT-subtitle">
          {{ app()->getLocale() === 'ar' ? ($about->subtitle_ar ?? '') : ($about->subtitle_en ?? '') }}
          @if(app()->getLocale() === 'ar' ? !empty($about->highlight_word_ar) : !empty($about->highlight_word_en))
            <span class="ABOUT-highlight">
              {{ app()->getLocale() === 'ar' ? $about->highlight_word_ar : $about->highlight_word_en }}
            </span>
          @endif
        </div>

        <p class="ABOUT-paragraph">
          {{ app()->getLocale() === 'ar' ? ($about->paragraph_ar ?? '') : ($about->paragraph_en ?? '') }}
        </p>

        <div class="ABOUT-values" role="list">
          <div class="ABOUT-value" role="listitem">
            <div class="ABOUT-value-icon" aria-hidden="true">
              <img class="ABOUT-value-icon"
                src="{{ asset($about->icon_image ?? 'uploads/default-icon.png') }}"
                alt=""
              />
            </div>
            <div>
              <div class="ABOUT-value-label">
                {{ app()->getLocale() === 'ar' ? ($about->label_ar ?? '') : ($about->label_en ?? '') }}
              </div>
              <div class="ABOUT-value-description">
                {{ app()->getLocale() === 'ar' ? ($about->description_ar ?? '') : ($about->description_en ?? '') }}
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endif

<!-- 🛍️ Products Section -->
<section class="HOME-products py-5">
  <div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h2 class="HOME-title mb-0">{{ __('home.products_title') }}</h2>
      <a href="{{ route('front.product') }}" class="HOME-view-all text-decoration-none fw-semibold mt-3 mt-md-0">
        {{ __('home.view_all_products') }} &gt;&gt;
      </a>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
      @foreach ($products as $product)
        @php
          // Determine image
          $imagePath = 'uploads/default.jpg';
          if (!empty($product->image)) {
              if (is_array($product->image)) {
                  $imagePath = !empty($product->image[0]) ? '' . $product->image[0] : $imagePath;
              } else {
                  $imagePath = str_starts_with($product->image, '/uploads/')
                      ? ltrim($product->image, '/')
                      : 'uploads/products/' . $product->image;
              }
          }

          // Name
          $productName = app()->getLocale() === 'ar'
              ? ($product->product_name_ar ?? __('home.unnamed_product'))
              : ($product->product_name_en ?? __('home.unnamed_product'));

          // Slug
          $productSlug = is_array($product->slug) ? ($product->slug[0] ?? '') : ($product->slug ?? '');
        @endphp

        <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="HOME-product-card position-relative" tabindex="0">

            <img src="{{ asset($imagePath) }}" class="img-fluid" alt="{{ $productName }}" loading="lazy" />

            <div class="HOME-overlay" aria-hidden="true">
              <div class="HOME-overlay-icons">
                <a href="{{ route('front.product', $productSlug) }}">
                  <i class="bi bi-eye" role="button" aria-label="{{ __('home.view_product') }}" tabindex="0"></i>
                </a>
              </div>
            </div>

            <div class="mt-3 text-center HOME-product-details">
              <h6 class="HOME-product-name mb-1">{{ $productName }}</h6>
              <div class="d-flex justify-content-center">
                <span class="fw-bold">{{ number_format($product->price, 3) }} {{ __('home.currency') }}</span>
              </div>
            </div>

          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>

{{-- 🏷️ Categories Section (ENHANCED) --}}
<section class="HOME-categories py-5">
    <div class="container">
        <h2 class="HOME-title mb-4">{{ __('home.top_categories') }}</h2>

        <div class="row g-4 justify-content-center">
            @foreach ($categories as $category)
                @php
                    $catName = app()->isLocale('ar') ? $category->name_ar : $category->name_en;
                    $fallbackIcon = 'bi bi-tags';
                @endphp

                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('front.product', $category->slug) }}"
                       class="text-decoration-none text-dark d-block"
                       tabindex="0">

                        <div class="HOME-category-card position-relative overflow-hidden"
                             role="button"
                             aria-label="{{ $catName }} ({{ $category->products_count }} {{ __('home.items') }})">

                            {{-- Background Gradient (optional image overlay) --}}
                            <div class="HOME-cat-bg"></div>

                            {{-- Image / Icon --}}
                            <div class="HOME-cat-icon mb-3">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}"
                                         alt="{{ $catName }}"
                                         class="img-fluid rounded-circle"
                                         loading="lazy">
                                @else
                                    <i class="{{ $fallbackIcon }}"></i>
                                @endif
                            </div>

                            {{-- Text Content --}}
                            <h6 class="HOME-cat-title mb-1">{{ $catName }}</h6>
                            <div class="HOME-cat-count">
                                {{ $category->products_count }} <span class="ms-1">{{ __('home.items') }}</span>
                            </div>

                            {{-- Ripple effect on click (pure CSS) --}}
                            <span class="HOME-cat-ripple"></span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
  /* Base font scaling for headings and text */
  .HOME-title {
    color: #8B3A2B;
    font-weight: 700;
    font-size: clamp(1.5rem, 2vw + 1rem, 2.25rem);
  }

  .HOME-view-all {
    color: #8B3A2B;
    transition: color 0.3s ease;
    font-size: clamp(0.9rem, 1vw + 0.5rem, 1.1rem);
  }

  .HOME-view-all:hover {
    color: #5c241a;
    text-decoration: underline;
  }

  /* PRODUCT CARDS */
  .HOME-product-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 16px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
  }

  .HOME-product-card:hover,
  .HOME-product-card:focus-within {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    outline: none;
  }

  /* Maintain consistent image aspect ratio */
  .HOME-product-card img {
    width: 100%;
    max-width: 160px;
    height: auto;
    aspect-ratio: 1 / 1;
    object-fit: contain;
    border-radius: 8px;
  }

  /* Overlay */
  .HOME-overlay {
    position: absolute;
    inset: 0;
    background: rgba(30, 30, 50, 0.6);
    opacity: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    transition: opacity 0.3s ease;
  }

  .HOME-product-card:hover .HOME-overlay,
  .HOME-product-card:focus-within .HOME-overlay {
    opacity: 1;
  }

  .HOME-overlay-icons {
    display: flex;
    gap: 24px;
    font-size: 28px;
    color: #fff;
  }

  .HOME-overlay-icons i {
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .HOME-overlay-icons i:hover,
  .HOME-overlay-icons i:focus {
    color: #f8bbd0;
    outline: 2px solid #f8bbd0;
    outline-offset: 2px;
    border-radius: 4px;
  }

  .HOME-stars i {
    font-size: 18px;
  }

  /* Product details adjustments */
  .HOME-product-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

 /* ──────────────────────────────────────
   CATEGORY CARDS – ENHANCED DESIGN
   ────────────────────────────────────── */
.HOME-category-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 1.75rem 1rem;
    text-align: center;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(139, 58, 43, 0.1);
}

.HOME-category-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,
        rgba(139, 58, 43, 0.05) 0%,
        rgba(240, 190, 180, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.35s ease;
    pointer-events: none;
}

.HOME-category-card:hover::before,
.HOME-category-card:focus::before {
    opacity: 1;
}

/* Hover & Focus States */
.HOME-category-card:hover,
.HOME-category-card:focus-visible {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 28px rgba(139, 58, 43, 0.18);
    border-color: #8B3A2B;
}

.HOME-category-card:focus-visible {
    outline: 3px solid #8B3A2B;
    outline-offset: 2px;
}

/* Icon / Image Container */
.HOME-cat-icon {
    width: 150px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.HOME-category-card:hover .HOME-cat-icon {
    transform: scale(1.1);
}

.HOME-cat-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.HOME-cat-icon i {
    font-size: 2.2rem;
    color: #8B3A2B;
}

/* Title */
.HOME-cat-title {
    font-weight: 700;
    font-size: clamp(0.95rem, 1.8vw, 1.1rem);
    color: #333;
    margin: 0;
    line-height: 1.3;
    transition: color 0.3s ease;
}

.HOME-category-card:hover .HOME-cat-title {
    color: #8B3A2B;
}

/* Count */
.HOME-cat-count {
    font-size: 0.875rem;
    color: #666;
    font-weight: 500;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.HOME-category-card:hover .HOME-cat-count {
    color: #8B3A2B;
    opacity: 1;
    transform: translateY(-2px);
}

/* Background Gradient Layer */
.HOME-cat-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg,
        rgba(240, 190, 180, 0.15),
        rgba(255, 255, 255, 0.4));
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: -1;
}

.HOME-category-card:hover .HOME-cat-bg {
    opacity: 1;
}

/* Ripple Effect (click feedback) */
.HOME-cat-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(139, 58, 43, 0.25);
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
    opacity: 0;
    z-index: 1;
}

.HOME-category-card:active .HOME-cat-ripple {
    display: block;
    width: 200px;
    height: 200px;
    top: 50%;
    left: 50%;
    margin-left: -100px;
    margin-top: -100px;
}

@keyframes ripple {
    to {
        transform: scale(2.5);
        opacity: 0;
    }
}

/* ───── Responsive Adjustments ───── */
@media (max-width: 768px) {
    .HOME-category-card {
        min-height: 130px;
        padding: 1.25rem 0.75rem;
    }
    .HOME-cat-icon {
        width: 56px;
        height: 56px;
    }
    .HOME-cat-icon i {
        font-size: 1.9rem;
    }
}

@media (max-width: 576px) {
    .HOME-category-card {
        min-height: 115px;
    }
    .HOME-cat-title {
        font-size: 0.9rem;
    }
    .HOME-cat-count {
        font-size: 0.8rem;
    }
}
</style>

 <!-- 🏷️ Subcategories Section -->
<section class="HOME-subcategories container py-5">
  <div class="row g-4">
    @foreach($subcategories as $subcategory)
      <div class="col-md-4">
        <div class="subcategory-card text-center d-flex flex-column justify-content-center align-items-center"
             style="background-image: url('{{ $subcategory->image ? asset('/' . $subcategory->image) : asset('images/placeholder.png') }}'); background-size: cover; background-position: center; height: 250px;">

          <!-- Subcategory Name -->
          <h5 class="fw-bold mb-3 text-primary">
            {{ app()->getLocale() === 'ar' ? $subcategory->name_ar : $subcategory->name_en }}
          </h5>

          <!-- Button -->
          <a href="{{ route('front.product', $subcategory->slug) }}" class="btn btn-primary btn-sm">
            {{ __('home.shop_now') }}
          </a>
        </div>
      </div>
    @endforeach
  </div>
</section>

<!-- ⚙️ Features Section -->
<section class="HOME-features container-fluid py-5 mt-4">
  <div class="row text-center">
    <div class="col-md-3 feature-box">
      <i class="fa-solid fa-motorcycle fa-2x mb-2"></i>
      <h6 class="fw-bold">{{ __('home.feature_delivery_title') }}</h6>
      <p class="small mb-0">{{ __('home.feature_delivery_desc') }}</p>
    </div>

    <div class="col-md-3 feature-box">
      <i class="fa-solid fa-rotate-left fa-2x mb-2"></i>
      <h6 class="fw-bold">{{ __('home.feature_refund_title') }}</h6>
      <p class="small mb-0">{{ __('home.feature_refund_desc') }}</p>
    </div>

    <div class="col-md-3 feature-box">
      <i class="fa-solid fa-credit-card fa-2x mb-2"></i>
      <h6 class="fw-bold">{{ __('home.feature_payment_title') }}</h6>
      <p class="small mb-0">{{ __('home.feature_payment_desc') }}</p>
    </div>

    <div class="col-md-3 feature-box">
      <i class="fa-solid fa-headset fa-2x mb-2"></i>
      <h6 class="fw-bold">{{ __('home.feature_support_title') }}</h6>
      <p class="small mb-0">{{ __('home.feature_support_desc') }}</p>
    </div>
  </div>
</section>

  <style>
/* Subcategory Cards with Background Images */
.HOME-subcategories .subcategory-card {
  height: 250px;
  background-size: cover;
  background-position: center;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  padding: 1.5rem;
  position: relative;
  overflow: hidden;
}

.HOME-subcategories .subcategory-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.65); /* Light overlay to ensure dark blue text is readable */
  border-radius: 12px;
  z-index: 1;
}

.HOME-subcategories .subcategory-card * {
  position: relative;
  z-index: 2;
}

/* On hover */
.HOME-subcategories .subcategory-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Use Bootstrap’s primary blue text and buttons */
.HOME-subcategories .subcategory-card h5 {
  color: #0d3d91 !important; /* Custom dark blue (override Bootstrap primary if needed) */
}

.HOME-subcategories .subcategory-card .btn-primary {
  background-color: #0d3d91;
  border-color: #0d3d91;
}

.HOME-subcategories .subcategory-card .btn-primary:hover {
  background-color: #092c6d;
  border-color: #092c6d;
}


/* Features Section */
.HOME-features {
  background-color: #8B2F1F; /* same brown-red tone */
  border-radius: 30px;
  color: #fff;
}
.HOME-features .feature-box {
  padding: 20px;
  border-right: 1px solid rgba(255,255,255,0.2);
}
.HOME-features .feature-box:last-child {
  border-right: none;
}
.HOME-features i {
  color: #fff;
}
  </style>

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
     /* Gallery Section */
.HOME-gallery .text-brown {
  color: #8B2F1F;
}
.HOME-gallery .gallery-item {
  overflow: hidden;
  border-radius: 12px;
}
.HOME-gallery img {
  transition: transform 0.4s ease;
}
.HOME-gallery img:hover {
  transform: scale(1.05);
}

/* Banner Section */
.HOME-banner .banner-box {
  background-color: #8B2F1F; /* dark brown-red */
  border-radius: 20px;
  padding: 40px 20px;
}
.HOME-banner h2 {
  font-size: 1.8rem;
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

<!-- 🌟 Banner Section -->
<section class="HOME-banner container-fluid py-5 mt-4">
  <div class="banner-box text-center text-white">
    <h2 class="fw-bold">
      {{ __('home.banner_title') }}
    </h2>
  </div>
</section>


@endsection
