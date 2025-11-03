@extends('front.layouts.app')

@section('title', $locale === 'ar' ? $card->why_us_page_title_ar : $card->why_us_page_title_en)

@section('content')
<x-hero-section-component page="about"/>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">

            <!-- Breadcrumb & Back Button -->
            <div class="d-flex align-items-center mb-4" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
                <a href="{{ url()->previous() }}"
                   class="btn btn-outline-brown btn-sm d-flex align-items-center me-3">
                    <i class="bi bi-arrow-left me-2"></i>
                    {{ __('Back') }}
                </a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" >
                        <li class="breadcrumb-item"><a href="{{ route('front.homepage') }}" style="color:#A13A28; text-decoration:none;">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.about') }} " style="color:#A13A28; text-decoration:none;">{{ __('About Us') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Str::limit($locale === 'ar' ? $card->why_us_page_title_ar : $card->why_us_page_title_en, 30) }}
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Main Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5 p-md-6">

                    <!-- Title -->
                    <h1 class="display-5 fw-bold mb-4" style="color: #A13A28;"
                        dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ $locale === 'ar' ? $card->why_us_page_title_ar : $card->why_us_page_title_en }}
                    </h1>

                    <!-- Description -->
                    <div class="content lead text-muted lh-lg mb-5"
                         dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
                        {!! $locale === 'ar' ? $card->why_us_page_description_ar : $card->why_us_page_description_en !!}
                    </div>

                    <!-- Image Slider -->
                    @if($card->why_us_page_images && count($card->why_us_page_images) > 0)
                        <div class="swiper whyus-slider mb-5">
                            <div class="swiper-wrapper">
                                @foreach($card->why_us_page_images as $img)
                                    <div class="swiper-slide">
                                        <a href="{{ asset($img) }}"
                                           data-lightbox="whyus-gallery"
                                           class="d-block rounded-3 overflow-hidden shadow-sm hover-scale">
                                            <img src="{{ asset($img) }}"
                                                 class="img-fluid w-100"
                                                 style="height: 300px; object-fit: cover;"
                                                 alt="{{ __('Gallery image') }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-next text-brown"></div>
                            <div class="swiper-button-prev text-brown"></div>

                            <!-- Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Bottom CTA -->
            <div class="text-center mt-5">
                <a href="{{ route('front.about') }}"
                   class="btn btn-brown px-5 py-3 rounded-pill shadow-sm hover-lift">
                    <i class="bi bi-arrow-left me-2"></i>
                    {{ __('Back to Why Us') }}
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --brown: #A13A28;
        --brown-light: #c95c4a;
        --brown-dark: #8b2e1e;
    }

    .btn-brown {
        background-color: var(--brown);
        border-color: var(--brown);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-brown:hover {
        background-color: var(--brown-dark);
        border-color: var(--brown-dark);
        transform: translateY(-2px);
    }

    .btn-outline-brown {
        color: var(--brown);
        border-color: var(--brown);
    }
    .btn-outline-brown:hover {
        background-color: var(--brown);
        color: white;
    }

    .text-brown { color: var(--brown) !important; }

    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 30px rgba(161, 58, 40, 0.2) !important;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.18);
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: var(--brown) !important;
        background: rgba(255,255,255,0.9);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: white;
        transform: scale(1.1);
    }
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .swiper-pagination-bullet {
        background: #ddd;
        opacity: 1;
    }
    .swiper-pagination-bullet-active {
        background: var(--brown);
    }

    .card {
        background: #fff;
        border: 1px solid rgba(161,58,40,0.1);
    }

    @media (max-width: 768px) {
        .swiper-button-next,
        .swiper-button-prev {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.whyus-slider', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            speed: 800,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });

        lightbox.option({
            resizeDuration: 200,
            wrapAround: true,
            albumLabel: "{{ __('Image %1 of %2') }}"
        });
    });
</script>

@endsection
