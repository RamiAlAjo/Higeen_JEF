@extends('front.layouts.app')

@section('content')

<x-hero-section-component page="contact"/>

<section class="contact-wrapper" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  <!-- 🌍 Map -->
  <div class="contact-map">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18..."
      width="100%" height="100%" style="border:0;"
      allowfullscreen="" loading="lazy">
    </iframe>
  </div>

  <!-- 💬 Floating Card -->
  <div class="container">
    <div class="contact-card shadow-lg">
      <div class="row g-4 align-items-start">

        <!-- Left: Form -->
        <div class="col-md-8">
          <h3 class="contact-title">{{ __('contact.title') }}</h3>
          <p class="contact-sub">{{ __('contact.subtitle') }}</p>

          <form id="contactForm" method="POST" action="#">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control contact-input" placeholder="{{ __('contact.placeholder_name') }}" required>
              </div>
              <div class="col-md-6">
                <input type="text" name="phone" class="form-control contact-input" placeholder="{{ __('contact.placeholder_number') }}" required>
              </div>
              <div class="col-12">
                <input type="email" name="email" class="form-control contact-input" placeholder="{{ __('contact.placeholder_email') }}" required>
              </div>
              <div class="col-12">
                <textarea name="message" rows="4" class="form-control contact-input" placeholder="{{ __('contact.placeholder_message') }}" required></textarea>
              </div>
              <div class="col-12 text-end">
                <button type="submit" class="send-btn btn btn-primary">
                  {{ __('contact.send_button') }} <i class="bi bi-arrow-right"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Right: Info -->
        <div class="col-md-4">
          <div class="contact-info-box">
            <h5>{{ __('contact.info_title') }}</h5>
            <p>{{ __('contact.info_description') }}</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-telephone-fill"></i> {{ $settings->phone ?? '+962 79112559' }}</li>
              <li><i class="bi bi-geo-alt-fill"></i> {{ $settings->address ?? __('contact.default_address') }}</li>
              <li><i class="bi bi-clock-fill"></i> {{ __('contact.working_hours') }}</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>

</section>

<style>
/* Contact Section */
.contact-wrapper {
  position: relative;
  width: 100%;
  margin: 0;
  padding: 0;
}

/* Map */
.contact-map {
  height: 450px;
  overflow: hidden;
  position: relative;
  z-index: 1;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Floating Card */
.contact-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 40px;
  max-width: 1100px;
  margin: -120px auto 60px auto;
  position: relative;
  z-index: 2;
  box-shadow: 0 12px 30px rgba(0,0,0,0.15);
  transition: transform 0.3s ease;
}
.contact-card:hover {
  transform: translateY(-5px);
}

/* Titles */
.contact-title {
  font-weight: 700;
  font-size: 28px;
  color: #843c24;
  margin-bottom: 10px;
}
.contact-sub {
  font-size: 16px;
  color: #666;
  margin-bottom: 25px;
}

/* Form Inputs */
.contact-input {
  border-radius: 10px;
  border: 1px solid #ddd;
  padding: 12px 15px;
  font-size: 15px;
  transition: border 0.3s, box-shadow 0.3s;
}
.contact-input:focus {
  border-color: #843c24;
  box-shadow: 0 0 8px rgba(132, 60, 36, 0.3);
}

/* Send Button */
.send-btn {
  background: linear-gradient(135deg, #843c24, #a0522d);
  color: #fff;
  border: none;
  padding: 12px 24px;
  border-radius: 50px;
  font-weight: 600;
  transition: all 0.3s;
}
.send-btn:hover {
  background: linear-gradient(135deg, #5a2d1d, #843c24);
  transform: translateY(-2px);
}

/* Info Box */
.contact-info-box {
  background: linear-gradient(135deg, #a0522d, #843c24);
  color: #fff;
  border-radius: 15px;
  padding: 30px;
  height: 100%;
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.contact-info-box h5 {
  font-size: 20px;
  margin-bottom: 12px;
  font-weight: 700;
}
.contact-info-box p {
  font-size: 15px;
  line-height: 1.6;
}
.contact-info-box li {
  margin-bottom: 12px;
  font-size: 15px;
}
.contact-info-box i {
  margin-right: 10px;
  color: #ffd9b3;
}

/* Responsive */
@media (max-width: 991px) {
  .contact-card {
    margin-top: -80px;
    padding: 30px;
  }
  .contact-title {
    font-size: 24px;
  }
  .contact-sub {
    font-size: 14px;
  }
}
</style>

@endsection
