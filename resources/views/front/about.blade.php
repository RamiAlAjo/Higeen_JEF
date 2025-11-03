@extends('front.layouts.app')

@section('content')

<x-hero-section-component page="about"/>


  {{-- About Section --}}
   <style>
    .ABOUT-section {
      padding: 60px 0;
    }

    /* Title */
    .ABOUT-title {
      color: #1E2E4F; /* Navy */
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    /* Description */
    .ABOUT-desc {
      color: #8B3F2F; /* Brown */
      font-style: italic;
      font-size: 1.1rem;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    /* Features */
    .ABOUT-features {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .ABOUT-features li {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      font-size: 1rem;
      color: #5a3d30;
      flex: 1 1 50%;
    }
    .ABOUT-features i {
      color: #8B3F2F;
      margin-right: 10px;
    }

    /* Right side main image */
    .ABOUT-image-container {
      position: relative;
      display: inline-block;
    }
    .ABOUT-image {
      border-radius: 15px;
      max-width: 100%;
      max-height: 500px;
    }

    /* Overlapping slider card */
    .ABOUT-slider {
      position: absolute;
      bottom: -20px;
      right: -20px;
      background-color: #8B3F2F;
      color: #fff;
      border-radius: 12px;
      padding: 20px;
      width: 200px;
      font-size: 0.9rem;
    }
    .ABOUT-slider i {
      font-size: 1.2rem;
      margin-right: 8px;
    }
    .ABOUT-slider-text {
      font-size: 0.85rem;
      margin-top: 10px;
    }

    /* Slider dots */
    .ABOUT-dots {
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }
    .ABOUT-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #fff;
      margin: 0 3px;
      opacity: 0.6;
      transition: 0.3s;
    }
    .ABOUT-dot.active {
      opacity: 1;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
      .ABOUT-slider {
        position: static;
        margin-top: 20px;
        width: 100%;
      }
    }

    /* Fade animation for text */
.ABOUT-slider-text {
  transition: opacity 0.5s ease;
  opacity: 1;
}

.ABOUT-slider-text.fade-out {
  opacity: 0;
}

 /* Base styles */
.ABOUT-why {
  background-color: #8B3C2B;
  border-radius: 25px;
  padding: 3rem 1rem;
}

.ABOUT-why h2 {
  color: #fff;
  font-size: 2rem;
}

.ABOUT-why p {
  color: #f8f9fa;
  max-width: 900px;
  margin: 0 auto 3rem;
  font-size: 1.1rem;
  line-height: 1.5;
}

.custom-card {
  height: 100%;
  min-height: 350px;
  max-width: 240px;
  margin: 0 auto;
  border: none;
  border-radius: 12px;
  padding: 15px;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  background-color: #fff;
}

.custom-card .card-body {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  height: 100%;
  position: relative;
  padding-bottom: 50px; /* more space for read more + hover */
}

.card-title {
  font-weight: 600;
  color: #1f2c45;
  font-size: 1.25rem;
}

.custom-card .card-text {
  color: #000000;
  font-size: 0.9rem;
  margin-bottom: 0.75rem;
}

.btn-read-more {
  font-weight: 500;
  color: #0d6efd;
  text-decoration: none;
  padding: 0;
  display: inline-block;
  margin-top: 10px;
  position: relative;
  z-index: 10;
  font-size: 0.95rem;
  cursor: pointer;
}

.btn-read-more i {
  margin-right: 6px;
  font-size: 1.1rem;
}

.hover-image {
  opacity: 0;
  visibility: hidden;
  transform: scale(0.95);
  transition: opacity 0.4s ease, transform 0.4s ease;
  margin-top: 10px;
  text-align: left;
  position: relative;
  z-index: 1;
}

.hover-image img {
  width: 100%;
  /* max-width: 180px; */
  max-width: 100%;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease;
}

.btn-read-more:hover + .hover-image,
.btn-read-more:focus + .hover-image {
  opacity: 1;
  visibility: visible;
  transform: scale(1);
}

.hover-image:hover {
  opacity: 1;
  visibility: visible;
  transform: scale(1.02);
}

.carousel-fade .carousel-item {
  opacity: 0;
  transform: translateX(50px) scale(0.95);
  transition: opacity 1s ease, transform 1s ease;
  display: block;
  position: absolute;
  width: 100%;
  will-change: opacity, transform;
  pointer-events: none;
}

.carousel-fade .carousel-item.active {
  opacity: 1;
  transform: translateX(0) scale(1);
  position: relative;
  z-index: 2;
  pointer-events: auto;
  transition-delay: 0.1s;
}

.carousel-fade .carousel-item.active .custom-card {
  transform: scale(1.03);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.carousel-indicators {
  position: static;
  margin-top: 1rem;
  display: flex;
  justify-content: center;
  gap: 12px;
}

.carousel-indicators [data-bs-target] {
  background-color: #ffffff;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  opacity: 0.6;
  transition: opacity 0.3s ease;
  border: 2px solid transparent;
}

.carousel-indicators .active {
  opacity: 1;
  border-color: #0d6efd;
}

/* Responsive tweaks */

@media (max-width: 991.98px) {
  .custom-card {
    max-width: 280px;
  }
}

@media (max-width: 767.98px) {
  .ABOUT-why {
    padding: 2rem 1rem;
  }

  .ABOUT-why h2 {
    font-size: 1.75rem;
  }

  .ABOUT-why p {
    font-size: 1rem;
    max-width: 100%;
    padding: 0 10px;
  }

  .custom-card {
    max-width: 100% !important;
    min-height: auto;
    margin-bottom: 2rem;
    padding: 20px;
  }

  /* Always show hover image on mobile */
  .hover-image {
    opacity: 1 !important;
    visibility: visible !important;
    transform: scale(1) !important;
    margin-top: 15px;
  }

  /* Cards stack vertically */
  .carousel-inner .row {
    flex-direction: column !important;
  }
}

@media (hover: none) {
  /* On touch devices, show hover images */
  .hover-image {
    opacity: 1 !important;
    visibility: visible !important;
    transform: scale(1) !important;
  }
}

  </style>

 @php
    $locale = app()->getLocale(); // 'en' or 'ar'
    $isRtl = $locale === 'ar';

    // Localized Content
    $aboutTitle = $aboutUs->{'about_us_title_' . $locale} ?? __('about.default_title');
    $aboutDesc = $aboutUs->{'about_us_description_' . $locale} ?? __('about.default_description');

    // Features (JSON or fallback to string)
    $rawFeatures = $aboutUs->{'features_' . $locale} ?? '';
    $features = is_array($rawFeatures) ? $rawFeatures : json_decode($rawFeatures, true);
    if (!is_array($features)) $features = array_filter(explode('|', $rawFeatures));

    // Slider Content
    $sliderTitle = $aboutUs->{'slider_title_' . $locale} ?? __('about.slider_title_default');
    $rawSliderDesc = $aboutUs->{'slider_description_' . $locale} ?? '';
    $sliderTexts = is_array($rawSliderDesc) ? $rawSliderDesc : json_decode($rawSliderDesc, true);
    if (!is_array($sliderTexts)) $sliderTexts = [$rawSliderDesc ?: __('about.slider_text_default')];

    // Slider Icon (Bootstrap or image)
    $sliderIcon = $aboutUs->slider_icon ?? 'bi bi-gear-fill';
@endphp

<section class="ABOUT-section container py-5" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="row align-items-center">
        <!-- Left: Text content -->
        <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
            <h2 class="ABOUT-title fw-bold mb-3">{{ $aboutTitle }}</h2>
            <div class="ABOUT-desc mb-4">
                {!! $aboutDesc !!}
            </div>

            @if(!empty($features))
                <ul class="row ABOUT-features list-unstyled">
                    @foreach ($features as $index => $feature)
                        <li class="col-md-6 mb-3 d-flex align-items-start">
                            <i class="{{ isset($feature['icon']) ? $feature['icon'] : 'bi bi-check2-circle' }} text-primary me-2"></i>
                            <span>{{ is_array($feature) ? $feature['text'] : $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Right: Image & Slider -->
        <div class="col-lg-6 col-md-12 text-center">
            <div class="ABOUT-image-container position-relative d-inline-block">
                <img
                    src="{{ $aboutUs->about_main_image ? asset('' . $aboutUs->about_main_image) : asset('images/placeholder.png') }}"
                    alt="{{ __('about.main_image_alt') }}"
                    class="ABOUT-image img-fluid rounded shadow-sm"
                >
                <!-- Overlay Slider Card -->
                <div class="ABOUT-slider position-absolute shadow-sm rounded">
                    <div class="d-flex align-items-center mb-2">
                        @if(Str::startsWith($sliderIcon, 'bi '))
                            <i class="{{ $sliderIcon }} me-2 text-primary"></i>
                        @else
                            <img src="{{ asset('' . $sliderIcon) }}" alt="Slider Icon" class="me-2" width="24" height="24">
                        @endif
                        <span class="fw-semibold">{{ $sliderTitle }}</span>
                    </div>
                    <p class="ABOUT-slider-text fade-in mb-2" id="aboutSliderText">
                        {{ $sliderTexts[0] ?? '' }}
                    </p>
                    <div class="ABOUT-dots mt-2">
                        @foreach ($sliderTexts as $index => $text)
                            <div class="ABOUT-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS to rotate slider texts -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const textElement = document.getElementById("aboutSliderText");
    const dots = document.querySelectorAll(".ABOUT-dot");
    const slideTexts = @json($sliderTexts);

    let currentIndex = 0;
    let autoSlideInterval;

    function showSlide(index) {
      textElement.classList.add("fade-out");
      setTimeout(() => {
        textElement.textContent = slideTexts[index];
        textElement.classList.remove("fade-out");
      }, 300);

      dots.forEach(dot => dot.classList.remove("active"));
      dots[index].classList.add("active");
      currentIndex = index;
    }

    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        let nextIndex = (currentIndex + 1) % slideTexts.length;
        showSlide(nextIndex);
      }, 5000);
    }

    dots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        showSlide(index);
        clearInterval(autoSlideInterval);
        startAutoSlide();
      });
    });

    startAutoSlide();
  });
</script>

<style>
  .fade-in { opacity: 1; transition: opacity 0.3s ease; }
  .fade-out { opacity: 0; }
  [dir="rtl"] .ABOUT-features li { text-align: right; }
  [dir="rtl"] .btn-read-more i { margin-left: 0.5rem; margin-right: 0; transform: scaleX(-1); }
</style>

<!-- Why Us Section -->
<section class="ABOUT-why py-5 text-white">
  <div class="container text-center">

    <!-- Section Title -->
    <h2 class="fw-bold fst-italic mb-3">Why Homeowners Like Us?</h2>

    <!-- Section Description -->
    <p class="lead mb-5">
      Homeowners appreciate that Higeen uses proven hygiene practices to reduce germs,
      allergens, and other harmful agents—helping protect family health and breathing quality.
    </p>

       @php
        $cards = $aboutUs->whyUsSections ?? collect();
        $slides = $cards->chunk(4);
    @endphp

    <!-- Carousel -->
    <div id="whyCarousel" class="carousel slide carousel-fade"
         data-bs-ride="carousel" data-bs-interval="7000" data-bs-pause="hover">
      <div class="carousel-inner">

        @forelse($slides as $slideIndex => $slideCards)
          <div class="carousel-item {{ $slideIndex === 0 ? 'active' : '' }}">
            <div class="row justify-content-center g-4 g-xl-5">

              @foreach($slideCards as $card)
                @php
                  $title = $locale === 'ar' ? $card->why_us_page_title_ar : $card->why_us_page_title_en;
                  $desc  = strip_tags($locale === 'ar' ? $card->why_us_page_description_ar : $card->why_us_page_description_en);
                  $image = $card->why_us_page_images[0] ?? null;
                @endphp

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="enhanced-card h-100 position-relative overflow-hidden rounded-3 shadow-lg"
                       style="background: rgba(255,255,255,0.98); min-height: 360px;
                              transition: all 0.4s cubic-bezier(0.25,0.8,0.25,1);"
                       onmouseenter="this.style.transform='translateY(-12px)';
                                    this.querySelector('.card-glow').style.opacity='1';"
                       onmouseleave="this.style.transform='translateY(0)';
                                    this.querySelector('.card-glow').style.opacity='0';">

                    <!-- Glow Effect -->
                    <div class="card-glow position-absolute top-50 start-50 translate-middle rounded-circle opacity-0"
                         style="width:300px;height:300px;
                                background:radial-gradient(circle,rgba(13,110,253,0.15) 0%,transparent 70%);
                                pointer-events:none;transition:opacity .5s;"></div>

                    <div class="card-body p-4 d-flex flex-column">

                      <!-- Title -->
                      <h5 class="card-title fw-bold text-dark mb-3"
                          style="font-size:1.22rem;line-height:1.4;">
                        {{ $title }}
                      </h5>

                      <!-- Description -->
                      <p class="card-text text-muted small flex-grow-1"
                         style="line-height:1.6;">
                        {{ Str::limit($desc, 110) }}
                      </p>

                      <!-- Read More Button -->
                      <a href="{{ route('whyus.show', $card->id) }}"
                         class="btn-read-more mt-3 align-self-start d-flex align-items-center text-primary fw-semibold position-relative overflow-hidden"
                         style="font-size:0.95rem;z-index:2;">
                        <span class="me-2">{{ __('Read More') }}</span>
                        <i class="bi bi-arrow-right"></i>
                        <span class="position-absolute start-0 bottom-0 w-100 h-100 bg-primary opacity-0"
                              style="transform:translateX(-100%);transition:transform .35s;"></span>
                      </a>

                      <!-- Hover Image -->
                      @if($image)
                        <div class="hover-image mt-3 opacity-0 invisible scale-95 transition-all duration-500"
                             style="transform-origin:bottom left;">
                          <img src="{{ asset($image) }}"
                               alt="{{ $title }}"
                               class="img-fluid rounded-3 shadow-sm w-100"
                               style="max-height:120px;object-fit:cover;border:3px solid #fff;">
                        </div>
                      @endif

                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        @empty
          <div class="carousel-item active py-5">
            <p class="text-white-50">{{ __('No Why Us cards added yet.') }}</p>
          </div>
        @endforelse

      </div>

      <!-- Custom Indicators -->
      @if($slides->count() > 1)
        <div class="carousel-indicators mt-5">
          @foreach($slides as $i => $slide)
            <button type="button"
                    data-bs-target="#whyCarousel"
                    data-bs-slide-to="{{ $i }}"
                    class="{{ $i === 0 ? 'active' : '' }}"
                    aria-label="Slide {{ $i + 1 }}"
                    style="width:14px;height:14px;border-radius:50%;
                           background:rgba(255,255,255,.5);border:2px solid transparent;
                           transition:all .3s;"
                    onmouseenter="this.style.background='white';this.style.borderColor='#0d6efd';"
                    onmouseleave="this.style.background=this.classList.contains('active')?'white':'rgba(255,255,255,.5)';
                                 this.style.borderColor='transparent';">
            </button>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
<style>
  /* Enhanced Card (no icons) */
  .enhanced-card {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.2);
    cursor: default;
  }

  .enhanced-card:hover {
    transform: translateY(-12px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,.15) !important;
  }

  .enhanced-card:hover .hover-image {
    opacity: 1 !important;
    visibility: visible !important;
    transform: scale(1) !important;
  }

  .enhanced-card:hover .btn-read-more span:last-child {
    transform: translateX(0) !important;
    opacity: .15 !important;
  }

  .btn-read-more { transition: color .3s; }
  .btn-read-more:hover { color: #0d6efd !important; }

  .btn-read-more i { transition: transform .3s; }
  .btn-read-more:hover i { transform: translateX(4px); }

  /* Carousel Fade + Pop */
  .carousel-fade .carousel-item {
    transition: opacity 1.2s ease, transform 1.2s ease;
  }

  .carousel-fade .carousel-item.active .enhanced-card {
    animation: cardPop .6s ease forwards;
  }

  @keyframes cardPop {
    from { transform: scale(.95); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
  }

  /* Mobile – always show image */
  @media (max-width: 767.98px) {
    .hover-image { opacity:1 !important; visibility:visible !important; transform:scale(1)!important; margin-top:1rem!important; }
    .enhanced-card { min-height:auto !important; }
  }

  @media (hover: none) {
    .hover-image { opacity:1 !important; visibility:visible !important; transform:scale(1)!important; }
  }

  /* RTL */
  [dir="rtl"] .btn-read-more i { margin-right:0; margin-left:.5rem; transform:scaleX(-1); }
  [dir="rtl"] .btn-read-more:hover i { transform:translateX(-4px) scaleX(-1); }
</style>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const textElement = document.getElementById("aboutSliderText");
    const dots = document.querySelectorAll(".ABOUT-dot");

  AboutUs::create([
    'slider_description_en' => json_encode([
        "Slide 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        "Slide 2: Quisque sit amet justo eget nunc bibendum pulvinar.",
        "Slide 3: Praesent viverra nunc a mauris accumsan, at pretium lacus fermentum."
    ]),
    // other fields...
]);


    let currentIndex = 0;
    let autoSlideInterval;

    function showSlide(index) {
      // Fade out
      textElement.classList.add("fade-out");

      // After fade-out, switch text and fade back in
      setTimeout(() => {
        textElement.textContent = slideTexts[index];
        textElement.classList.remove("fade-out");
      }, 300);

      // Update active dot
      dots.forEach(dot => dot.classList.remove("active"));
      dots[index].classList.add("active");

      currentIndex = index;
    }

    // Dot click handlers
    dots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        showSlide(index);
        resetAutoSlide();
      });
    });

    // Auto-slide every 5 seconds
    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        let nextIndex = (currentIndex + 1) % slideTexts.length;
        showSlide(nextIndex);
      }, 5000);
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      startAutoSlide();
    }

    // Initial start
    startAutoSlide();
  });
</script>
@endsection
