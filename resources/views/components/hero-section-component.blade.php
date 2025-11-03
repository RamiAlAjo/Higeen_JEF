<style>
.HERO-section {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #8B3F2F;
  color: #fff;
  padding: 80px 0;
  position: relative;
  overflow: visible;
}

.HERO-image {
  width: 100%;
  max-width: 400px;
  max-height: 400px;
  border-radius: 8px;
}

.image-wrapper {
  position: relative;
  z-index: 1;
}

.HERO-content {
  position: relative;
  z-index: 2;
  padding: 20px;
  color: #fff;
}

.HERO-card {
  background-color: #1E2E4F;
  padding: 20px;
  text-align: center;
  margin-bottom: 20px;
  position: absolute;
  top: 20%;
  left: -20%;
  transform: translateY(-50%);
  width: 80%;
  z-index: 3;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.HERO-card h2 {
  font-style: italic;
  font-size: 1.8rem;
  margin: 0;
}

.HERO-text {
  margin-top: 100px; /* Push content below the card */
  font-size: 1rem;
  line-height: 1.6;
  color: #f5f5f5;
}

.HERO-btn {
  background-color: #1E2E4F;
  border: none;
  padding: 10px 25px;
  font-size: 1rem;
  font-weight: bold;
  color: #fff;
  transition: background-color 0.3s ease;
}

.HERO-btn:hover {
  background-color: #2c3e70;
}

/* Responsive fix for small screens */
@media (max-width: 768px) {
  .HERO-card {
    position: static;
    transform: none;
    left: 0;
    width: 100%;
    margin-bottom: 20px;
  }
  .HERO-text {
    margin-top: 20px;
  }

  /* Adjust image for small screens */
  .HERO-image {
    max-width: 100%;  /* Allow image to be full-width on small screens */
  }
}

</style>

@props(['page' => 'home'])

<section class="HERO-section container-fluid mb-4 {{ 'hero-' . $page }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
  <div class="container">
    <div class="row align-items-center">
      <!-- Left Image -->
      <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 text-center">
        @if($hero['image'])
          <img
            src="{{ $hero['image'] }}"
            alt="{{ $hero['title'] ?? 'Hero image' }}"
            class="HERO-image img-fluid"
            loading="lazy"
          />
        @else
          <div class="HERO-placeholder bg-light p-4 rounded">
            No image available
          </div>
        @endif
      </div>

      <!-- Right Content -->
      <div class="col-lg-6 col-md-12 HERO-content">
        <div class="HERO-card">
          <h2 class="fw-bold">{{ $hero['title'] }}</h2>
        </div>

        <p class="HERO-text">
          {!! nl2br(e($hero['description'])) !!}
        </p>

        @if($hero['button_link'] && $hero['button_text'])
          <a
            href="{{ $hero['button_link'] }}"
            class="HERO-btn btn btn-primary mt-3"
          >
            {{ $hero['button_text'] }}
          </a>
        @endif
      </div>
    </div>
  </div>
</section>
